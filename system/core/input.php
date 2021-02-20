<?php

if(!defined('BASE'))exit("direct access not allow");


class input

{



     var $ip_address=FALSE;

     var $user_agent=FALSE;

     var $newline=TRUE;

     var $allow_get=TRUE;

     var $enable_xss=FALSE;

     var $enable_csrf=FALSE;

     protected $header=array();



     function __construct()

     {



          $this->enable_xss=(get_item('filter_xss')===TRUE);

          $this->enable_csrf=(get_item('csrf_protected')===TRUE);

          $this->allow_get=(get_item('allow_get')===TRUE);


          global $sec;


          $this->security=$sec;


          if(defined('UTF8_ENABLED') && UTF8_ENABLED===TRUE)

          {


               global $utf8;

               $this->utf8=$utf8;

          }



          $this->filter_global();

     }



     function fetch_from_array($array, $index='', $enable_xss=FALSE)

     {



          if(!isset($array[$index]))

          {

               return FALSE;

          }



          if($enable_xss===TRUE)

          {


               $this->security->xss_clean($array[$index]);

          }



          return $array[$index];

     }



     function get($index=NULL, $xss=FALSE)

     {



          if($index==NULL && !empty($_GET))

          {



               $get=array();

               foreach(array_keys($_GET) as $key)

               {



                    $get[$key]=$this->fetch_from_array($_GET, $key, $xss);

               }


               return $get;

          }



          return $this->fetch_from_array($_GET, $index, $xss);

     }



     function post($index=NULL, $xss=FALSE)

     {



          if($index==NULL && !empty($_POST))

          {



               $post=array();

               foreach(array_keys($_POST) as $key)

               {



                    $post[$key]=$this->fetch_from_array($_POST, $key, $xss);

               }



               return $post;

          }



          return $this->fetch_from_array($_POST, $index, $xss);

     }



     function get_post($index, $xss=FALSE)

     {



          if(!isset($_POST))

          {



               return $this->post($index, $xss);

          }

          else

          {



               return $this->get($index, $xss);

          }


     }



     function cookie($index, $xss=FALSE)

     {



          return $this->fetch_from_array($_COOKIE, $index, $xss);

     }



     function set_cookie($name='', $value='', $expire='', $domain='', $path='/', $security='')

     {



          if(is_array($name))

          {



               foreach(array('name','value','expire','domain','path','security') as $key)

               {


                    if(isset($name[$key]))

                    {

                         $$key=$name[$key];

                    }

               }

          }



          if($name=='' AND get_item('cookie_name')!='')

          {


               $name=get_item('cookie_name');

          }



          if($value=='' AND get_item('cookie_value')!='')

          {

               $value=get_item('cookie_value');

          }



          if($path=='/' AND get_item('cookie_path')!='/')

          {

               $path=get_item('cookie_path');

          }



          if($expire=='' AND get_item('cookie_expire')!='')

          {

               $expire=get_item('cookie_expire');

          }



          if($domain=='' AND get_item('cookie_domain')!='')

          {


               $domain=get_item('cookie_domain');

          }



          if($security=='' AND get_item('cookie_security'))

          {

               $security=get_item('cookie_security');

          }



          if(!is_numeric($expire))

          {


               $expire=time() + 86500;

          }

          else

          {


               $expire=($expire>0) ? $expire : 0;

          }



          setcookie($name, $value, $expire, $domain, $path, $security);

     }


     function server($index, $xss=FALSE)
     {

          return $this->fetch_from_array($_SERVER, $index, $xss);
     }

     function user_agent()
     {

          if($this->user_agent!==FALSE)
          {
               return $this->user_agent;
          }

          if(isset($_SERVER['HTTP_USER_AGENT']))
          {
               $this->user_agent=$this->server('HTTP_USER_AGENT', FALSE);
          }
          
          return $this->user_agent;
     }

     function ip_address()
     {

          if($this->ip_address!==FALSE)
          {
               return $this->ip_address;
          }

          //get the proxy ip from config item
          $proxy_ip=get_item('proxy_id');
          if(!empty($proxy_ip))
          {

               $proxy_ip=explode(',', $proxy_ip);
               foreach(array('HTTP_X_FORWARD_FOR', 'HTTP_CLIENT_IP', 'HTTP_X_CLIENT_IP', 'HTTP_X_CLUSTER_CLIENT_IP') as $header)
               {

                    if(($pro=$this->server($header))!==FALSE)
                    {
                         if(strpos($pro, ',')!==FALSE)
                         {

                               $pro=explode(',', $pro, 2);
                              $pro=$pro[0];
                         }

                         if(!$this->valid_ip($pro))
                         {

                              $pro=FALSE;
                         }
                         else
                         {
                              break;
                         }

                    }
               }

               $this->ip_address=($pro!==FALSE && in_array($_SERVER['REMOTE_ADDR'], $proxy_ip, TRUE)) ? $pro : $_SERVER['REMOTE_ADDR'];
          }
          else
          {

               if(!$this->valid_ip($_SERVER['REMOTE_ADDR']))
               {
                    $this->ip_address='0.0. 0.0';
               }
               else
               {
                    $this->ip_address=$_SERVER['REMOTE_ADDR'];
               }
          }

          return $this->ip_address;
     }

     function valid_ip($ip, $select='')
     {

          $select=strtolower($select);

          if(is_callable('filter_var'))
          {          
               if($select=='ipv4')
               {
                    $flag=FILTER_FLAG_IPV4;
               }
               elseif($select=='ipv6')
               {

                    $flag=FILTER_FLAG_IPV6;
               }
               else
               {
                    $flag='';
               }

               return (bool)filter_var($ip, FILTER_VALIDATE_IP, $flag);
          }

          if($select!='ipv4' && $select!='ipv6')
          {

               if(strpos($ip, '.')!==FALSE)
               {
                    $select='ipv4';
               }
               elseif(strpos($ip, ':')!==FALSE)
               {
                    $select='ipv6';
               }
               else
               {

                    return FALSE;
               }
          }

          $method='valid_'.$select;
          return $this->$method($ip);
     }

     function valid_ipv4($ip)
     {

          if(strpos($ip, '.')===FALSE)
          {
               return FALSE;
          }

          $ip=explode('.', $ip);

          if($ip[0][0]=='0' || count($ip)!==4)
          {
               return FALSE;
          }

          foreach($ip as $segment)
          {
               if($segment==''||preg_match("/[^0-9]/", $segment)||$segment>255||strlen($segmet)>3)
               {
                    return FALSE;
               }

          }
     
          return TRUE;
     }

     function valid_ipv6($ip)
     {

          $group=8;
          $collate=FALSE;

          $chunk=array_filter(preg_split("/(:{1,2})/"));

          if(current($chunk)==':' || end($chunk)==':')
          {
               return FALSE;
          }

          if(strpos($chunk, '.')!==FALSE)
          {

               $ip=array_pop($chunk);

               if(!$this->valid_ip($ip))
               {
                    return FALSE;
               }

               --$group;
          }

          while($ip=array_pop($chunk))
          {

               if($ip[0]==':')
               {

                    if(--$group==0)
                    {

                         return FALSE;
                    }

                    if(strlen($ip)>2)
                    {
                         return FALSE;
                    }

                    if($ip=='::')
                    {

                         if($collate)
                         {
                              return FALSE;
                         }

                         $collate=TRUE;
                    }
               }
               elseif(preg_match("/[^0-9a-f]/i", $ip) || strlen($ip)>4)
               {
                    return FALSE;
               }

          }

          return $collate || $group==1;
     }

     function filter_global()
     {

          $protected=array('_GET', '_POST', '_SERVER', '_REQUEST','_FILES', '_SESSION', '__ENV', 'HTTP_RAW_POST_DATA', 'GLOBALS', 'system','application','EXT','TM','con','URL','RT','in','UT');

          foreach(array($_POST,$_GET,$_COOKIE) as $global)
          {

               if(!is_array($global))
               {
                    if(!in_array($global, $protected))
                    {

                         global $$global;
                         $$global=NULL;
                    }
               }
               else
               {

                    foreach($global as $key=>$value)
                    {

                         if(!in_array($key, $protected))
                         {

                              global $$key;
                              $$key=NULL;
                         }
                    }
               }
          }

          if($this->allow_get===TRUE)
          {

               if(is_array($_GET) && count($_GET)>0)
               {

                    foreach($_GET as $key=>$val)
                    {

                         $_GET[$this->clean_input_key($key)]=$this->clean_input_data($val);
                    }
               }
          }

          if(is_array($_POST) && count($_POST)>0)
          {

               foreach($_POST as $key=>$val)
               {

                    $_POST[$this->clean_input_key($key)]=$this->clean_input_data($val);
               }
          }

          if(is_array($_COOKIE) && count($_COOKIE)>0)
          {

               unset($_COOKIE['$version']);
               unset($_COOKIE['$path']);
               unset($_COOKIE['$domain']);

               foreach($_COOKIE as $key=>$val)
               {

                    $_COOKIE[$this->clean_input_key($key)]=$this->clean_input_data($val);
               }
          }

          $_SERVER['PHP_SELF']=strip_tags($_SERVER['PHP_SELF']);

          if($this->enable_xss===TRUE && !$this->is_cli_request())
          {

               $this->security->csrf_verify();

          }

          text_log('debug', "global such as GET, POST COOKIE are filter");
     }

     function clean_input_key($str)
     {

          if(!preg_match("/^[a-z0-9:_\/-]+$/i", $str))
          {
               die("Disallowable key characters");
          }

          if(defined('UTF8_ENABLED') && UTF8_ENABLED===TRUE)
          {

               $str=$this->utf8->clean_string($str);
          }

          return $str;
     }

     function clean_input_data($str)
     {

          if(is_array($str))
          {

               $new_str=array();
               foreach($str as $key=>$val)
               {

                    $new_str[$key]=$this->clean_input_data($val);
               }
          }

          if(!is_php('5.4') && get_magic_quotes_gpc())
          {

               $str=striplashes($str);
          }

          if(defined('UTF8_ENABLED') && UTF8_ENABLED===TRUE)
          {

               $str=$this->utf8->clean_string($str);
          }

          $str=remove_invalid_char($str);

          if($this->enable_xss===TRUE)
          {

               $str=$this->security->xss_clean($str);
          }

          if($this->newline===TRUE)
          {
				if(is_array($str)){
					foreach($str as $st){
						if(strpos($st, "\r")!==FALSE )
						{

							$str=str_replace(array("\r\n","\r","\r\n\n"), PHP_EOL, $st);
						}
					}
				}else{
					if(strpos($str, "\r")!==FALSE )
					{

						$str=str_replace(array("\r\n","\r","\r\n\n"), PHP_EOL, $str);
					}
			   }
          }

          return $str;
     }

     public function is_cli_request()
     {

          return (php_sapi_name()==='cli' || defined('STDIN'));
     }

     function is_ajax_request()
     {

          return ($this->server('HTTP_X_REQUESTED_WITH')==='XMLHttpRequest');
     }

     function request_header($xss=FALSE)
     {

          if(function_exists('apache_request_header'))
          {

               $header=apache_request_header();
          }
          else
          {

               $header['Content_Type']=(isset($_SERVER['CONTENT_TYPE'])) ? $_SERVER['CONTENT_TYPE'] : getenv('CONTENT_TYPE');

               foreach($_SERVER as $key=>$value)
               {

                    if(strncmp($key, 'HTTP_', 5)==0)
                    {

                         $header[substr($key, 5)]=$this->fetch_from_array($_SERVER, $key, $xss);
                    }
               }
          }

          foreach($header as $key => $value)
          {

               $key=str_replace('_', ' ', strtolower($key));
               $key=str_replace(' ', '-', ucwords($key));

               $this->header[$key]=$value;
          }

          return $this->header;
     }

     function get_header($index, $xss=FALSE)
     {

          if(empty($this->header))
          {

               return $this->request_header();
          }

          if(!isset($this->header[$index]))
          {
               return FALSE;
          }

          if($xss===TRUE)
          {
               return $this->security->xss_clean($this->header[$index]);
          }

          return $this->header[$index];
          
     }
}
?>