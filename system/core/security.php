<?php
if(!defined('BASE'))exit("direct access not allow");

class security
{

     /*
     random hash url for protecting url
     @access protect
     @string
     */

     protected $_xss_hash='';
     protected $_csrf_hash='';
     protected $_csrf_expire=7200;
     protected $_csrf_token_name='user_names';
     protected $_csrf_cookie_name='user_names'; 
     protected $never_allow_str=array('document.cookie'=>'[removed]', 'document.write'=>'[removed]', 'parentNode'=>'[removed]', '.innerHTML'=>'[removed]', 'window.location'=>'[removed]', '-moz-binding'=>'[removed]', '<!--'=>'&lt;!--', '--!>'=>'--!&gt;',  '<![CDATA['=>'&lt;![CDATA[', '<comment>'=>'&lt;comment&gt;');
     protected $never_allow_reg=array('javascript\s*:', 'expression\s*(\(|&\#40;)', 'vbscript\s*:', 'Redirect\s+302', "([\"'])?data\s*:[^\\1]*?base64[^\\1]*?,[^\\1]*?\\1");

     function __construct()
     {

          if(get_item('csrf_protected')===TRUE)
          {

               foreach(array('csrf_expire', 'csrf_token_name', 'csrf_cookie_name') as $key)
               {

                    if(($val=get_item($key))!==FALSE)
                    {

                         $this->{'_'.$key}=$val;
                    }
               }

               $this->csrf_set_hash();
          }

          text_log("debug", "security class initialize at last");
     } 

     function csrf_verify()
     {

          if(strtoupper($_SERVER['REQUEST_METHOD'])!=='POST')
          {

               return $this->csrf_set_cookie();
          }

          if(!isset($_POST[$this->_csrf_token_name], $_COOKIE[$this->_csrf_cookie_name]))
          {

               return $this->csrf_display_error();
          }

          if($_POST[$this->_csrf_token_name]!=$_COOKIE[$this->_csrf_cookie_name])
          {

               return $this->csrf_display_error();
          }

          unset($_POST[$this->_csrf_token_name]);
          unset($_COOKIE[$this->_csrf_cookie_name]);

          $this->csrf_set_cookie();
          $this->csrf_set_hash();

          text_log("debug", "CSRF verify");

          return $this;
     }

     function csrf_set_cookie()
     {

          $expire=time() + $this->_csrf_expire;

          $security_cookie=(get_item('cookie_security')===TRUE)? 1 : 0;

          if($security_cookie && (empty($_SERVER['HTTP']) || strtolower($_SERVER['HTTPS'])=='off'))
          {

               return FALSE;
          } 

          setcookie($this->_csrf_cookie_name, $this->_csrf_hash, $expire, get_item('cookie_path'), get_item('cookie_domain'), $security_cookie);

          text_log('debug', "CSRF cookie set");

          return $this;
     }

     function csrf_display_error()
     {

          display_error("the action you are trying to request is not allow");
     }

     function get_csrf_hash()
     {

          return $this->_csrf_hash;
     }

     function get_csrf_name()
     {

          return $this->_csrf_token_name;
     }

     public function xss_hash()
     {

          if($this->_xss_hash=='')
          {
               mt_srand();
               $this->_xss_hash=md5(time()+mt_rand(0, 999999));
          }

          return $this->_xss_hash;
     }

     protected function csrf_set_hash()
     {
     
          if($this->_csrf_hash=='')
          {

               if(isset($_COOKIE[$this->_csrf_cookie_name]) && preg_match("#^[0-9a-f]{32}$#iS", $_COOKIE[$this->_csrf_cookie_name]))
               {

                    return $_COOKIE[$this->_csrf_cookie_name];
               }

               return $this->_csrf_hash=md5(uniqid(rand(),TRUE));
          }
          return $this->_csrf_hash;
     }

     protected function do_never_allow($str)
     {

          $str=str_replace(array_keys($this->never_allow_str), $this->never_allow_str, $str);

          foreach($this->never_allow_reg as $reg)
          {

               $str=preg_replace("#".$reg."#is", "[removed]", $str);
          }

          return $str;
     }

     protected function validate_entities($str)
     {

          $str=preg_replace('|\&([a-z\_0-9\-]+)\=([a-z\_0-9\-]+)|i', $this->xss_hash()."\\1=\\2",  $str);

          $str=preg_replace('#(&\#[0-9a-z]{2,})([\x00-\x20])*;?#i',"\\1;\\2", $str);

          $str=preg_replace('#(&\#x?)([0-9A-F]+);?#i', "\\1\\2;", $str);

          $str=str_replace($this->xss_hash(), '&', $str);

          return $str;
     }

     function filter_attribute($str)
     {

          $f='';
          if(preg_match_all('#\s*[a-z\-]+\s*=\s*(\042|\047)([^\\1]*?)\\1#is', $str, $match))
          {

               foreach($match[0] as $val)
               {
                    $f=preg_replace("#/\*.*?\*/#s", '', $val);
               }

          }

          return $f;
     }

     function convert_attribute($match)
     {

          return str_replace(array('>','<','\\'), array('&gt;','&lt;','\\\\'), $match[0]);
    }

     function js_img_remove($match)
     {

          return str_replace($match[1], preg_replace('#src=.*?(alert\(|alert&\#40;|javascript\:|livescript\:|mocha\:|charset\=|window\.|document\.|\.cookie|<script|<xss|base64\s*,)#si', '', $this->filter_attribute(str_replace(array('>','<'), '', $match[1]))), $match[0]);
     }

     function js_href_remove($match)
     {

          return str_replace($match[1],
                     preg_replace('#href=.*?(alert\(|alert&\#40;|javascript\:|livescript\:|mocha\:|charset\=|window\.|document\.|\.cookie|<script|<xss|data\s*:)#si', 
                    '', 
                    $this->filter_attribute(str_replace(array('>','<',), '', $match[1]))), 
                    $match[0]);
     }

     protected function filter_html($matche)
     {

          $str="&lt;".$matche[1].$matche[2].$matche[3];
          $str.=str_replace(array('>','<'), array('&lt;','&gt;'), $matche[4]);

          return $str;
     }

     protected function remove_evil_attribute($str, $is_image=FALSE)
     {

          $evil_attribute=array('on\w*','style','xmlns','formaction');

          if($is_image===TRUE)
          {
               unset($evil_attribute[array_search('xmlns', $evil_attribute)]);
          }

          do
          {

               $count=0;
               $attribs=array();

               preg_match_all('/('.implode('|', $evil_attribute).')\s*=\s*(\042|\047)([^\\2]*?)(\\2)/is', $str, $matche, PREG_SET_ORDER);

               foreach($matche as $match)
               {

                    $attribs[]=preg_quote($match[0], '/');
               }

               preg_match_all('/('.implode('|', $evil_attribute).')\s*=\s*([^\s>]*)/is', $str, $matche, PREG_SET_ORDER);

               foreach($matche as $match)
               {

                    $attribs[]=preg_quote($match[0], '/');
               }

               if(count($attribs)>0)
               {

                    $str=preg_replace('/(<?)(\/?[^><]+?)([^A-Za-z<>\-])(.*?)('.implode('|', $attribs).')(.*?)([\s><]?)([><]*)/i', '$1$2$4$6$7$8', $str, -1, $count);
               }

          }while($count);

          return $str;
     }

     protected function compact_explode_word($match)
     {

          return preg_replace('/\s+/s', '', $matche[1]).$matche[2];
     }

     function filter_filename($filename)
     {

          $bad=array('../','<!--','-->','<','>','"',"'",'&','$','{','}','[',']','=','#',';','?',"%20","%22","%3c","%253c","%3e","%0e","%28","%29","%2528","%26","%24","%3f","%3b","%3d");

          if(!$relative_path)
          {
               $bad[]='./';
               $bad[]='/';
          }

          $filename=remove_invalid_char($filename, FALSE);
          return stripslashes(str_replace($bad, '', $filename));
     }

     public function entity_decode($str, $charset='UTF-8')
     {

          if(stristr($str, '&')===FALSE)
          {

               return $str;
          }

          $str=html_entity_decoded($str, ENT_COMPAT, $charset);
          $str=preg_replace('/~&#x(0*[0-9a-f]{2,5)~ei/', 'chr(hexdex("\\1"))', $str);
          return preg_replace('/~&#([0-9]{2,4})~e/', 'char(\\1)', $str);
     }

     function decode_entity($match)
     {
          return $this->entity_decode($match[0], strtoupper(get_item('charset')));
     }

     function xss_clean($str, $is_image=FALSE)
     {

          if(is_array($str))
          {

               while(list($key)=each($str))
               {

                    $str[$key]=$this->xss_clean($str[$key]);
               } 
               return $str;
          }

          $str=remove_invalid_char($str);

          $str=$this->validate_entities($str);

          $str=rawurldecode($str);

          $str=preg_replace_callback("/[a-z]+=([\'\"]).*?\\1/si", array($this, 'convert_attribute'), $str);

          $str=preg_replace_callback("/>\w+.*?(?=>|<|$)/si", array($this, 'decode_entity'), $str);

          $str=remove_invalid_char($str);

          if(strpos($str, "\t")!==FALSE)
          {

               $str=str_replace("\t", ' ', $str);
          }

          $converted_str=$str;
          $str=$this->do_never_allow($str);

          if($is_image===TRUE)
          {

               $str=preg_replace("/<\?(php)/", '&lt;?\\1', $str);

          }
          else
          {

               $str=str_replace(array('<?', '?'.'>'), array('&lt;?', '?&gl;'), $str);
          }

          $words=array('javascript','vbscript','script','expression','base64','alert','applet','document','write','cookie','window');

          foreach($words as $word)
          {

               $tem='';
               for($i=0, $worldlen=strlen($word);$i<$worldlen;$i++)
               {

                    $tem.=substr($word, $i, 1)."\s*";
               }

               $str=preg_replace_callback('#('.substr($tem, 0, 3).')(\W)#is', array($this, 'compact_explode_word'), $str);
          }

          do
          {

               $original=$str;
               if(preg_match('/<a+?/', $str))
               {

                    $str=preg_match_callback('#<a\s+([^>])(>|$)#si', array($this, 'js_href_remove'), $str);
               }

               if(preg_match('/<img+?/', $str))
               {

                    $str=preg_match_callback('#<img\s+([^>])(\s?/?|>)#si', array($this, 'js_img_remove'), $str);
               }

               if(preg_match("/script/", $str) || preg_match("/xss/", $str))
               {

                    $str=preg_match_callback("#<(/*)(script|xss)(.*?)#si", '[removed]', $str);
               }

          }while($original!=$str);

          unset($original);

          $str=$this->remove_evil_attribute($str, $is_image);

          $bads = 'alert|applet|audio|basefont|base|behavior|bgsound|blink|body|embed|expression|form|frameset|frame|head|html|ilayer|iframe|input|isindex|layer|link|meta|object|plaintext|style|script|textarea|title|video|xml|xss';
		$str=preg_replace_callback("#<(/*\s*)(".$bads.")([^><]*)([><]*)#is", array($this, 'filter_html'), $str);

          $str=preg_replace('#(alert|cmd|passthru|eval|exec|expression|system|fopen|fsockopen|file|file_get_content|readfile|unlink)(\s*)(.*?)#si', "\\1\\2&#40;\\3&#41;", $str);

          $str=$this->do_never_allow($str);

          if($is_image===TRUE)
          {
               return ($converted_str==$str) ? TRUE : FALSE;
          }

          text_log('debug', "xss clean filter complete");
          return $str;
     }
}
?>