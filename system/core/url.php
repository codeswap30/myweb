<?php
if(!defined('BASE'))exit("direct access not allow");


class url
{


  var $url_string;
  var $config;
  var $segment=array();
  var $rsegment=array();




    function __construct()
    {
        $this->config=class_loader('config', 'core');
        text_log('debug', "url class is intialize");
    }

    
    function set_url_string($url)
    {
        $url=remove_invalid_char($url, FALSE);
        $this->url_string=($url=='/') ? '' : $url;
    }



    function detect_url()
    {

        if(!isset($_SERVER['REQUEST_URI']) || !isset($_SERVER['SCRIPT_NAME']))
        {
            return '';
        }
        
        $url=$_SERVER['REQUEST_URI'];
        if(strpos($url, $_SERVER['SCRIPT_NAME']) === 0)
        {
            $url=substr($url, strlen($_SERVER['SCRIPT_NAME']));

        }
        elseif(strpos($url, dirname($_SERVER['SCRIPT_NAME'])) === 0)
        {

            $url=substr($url, strlen(dirname($_SERVER['SCRIPT_NAME'])));
        }

        if(strncmp($url,'?/', 2) === 0)
        {
            $url=substr($url, 2);
        }

        $pref=preg_split('#\?#i', $url,  2);
        $url=$pref[0];
        
        if(isset($pref[1]))
        {
            $_SERVER['QUERY_STRING']=$pref[1];
            parse_str($_SERVER['QUERY_STRING'], $_GET);
        }
        else
        {
           $_SERVER['QUERY_STRING']='';
            $_GET=array();
        }

        if($url=='/' || empty($url))
        {
            return '/';

        }
        $url=parse_url($url, PHP_URL_PATH);

        return str_replace(array('//', '../'), '/', trim($url, '/'));
   }




    function url_command_args()
    {
        $str=array_slice($_SERVER['argv'], 1);   
        return $str ? '/' .implode('/', $str) : '';
    }

    function fetch_url()
    {

       
        if(strtoupper($this->config->fetch_item('url_protocol'))=='AUTO')
        {

           if(php_sapi_name() =='cli'|| defined('STDIN'))
           {
                $this->set_url_string($this->url_command_args());
                return;

           }

          if(($url=$this->detect_url()))
          {
               $this->set_url_string($url);
               return;
          }



           $url=(isset($_SERVER['QUERY_STRING'])) ? $_SERVER['QUERY_STRING'] : @getenv('QUERY_STRING');
           
           if($url!='')
           {
               $this->set_url_string($url);
               return;
           }
       
           $url=(isset($_SERVER['PATH_INFO'])) ? $_SERVER['PATH_INFO'] : @getenv('PATH_INFO');


           if(trim($url, '/') !='' &&  $url !='/'.SELF)
           {
             $this->set_url_string($url);
             return;

           }



           if(is_array($_GET) && count($_GET) == 1 && trim(key($_GET), '/') !='')
           {
                $this->set_url_string(key($_GET));
                return;
           }
           $this->url_string="";
        }




        $path=strtoupper($this->config->fetch_item('url_protocol'));



        if($path=='CLI')

        {

            $this->set_url_string($this->cli_command_args);

            return;

        }
        elseif($path=='REQUEST_URI')

        {

            $this->set_url_string($this->detect_url());

            return;

        }

        $info=(isset($_SERVER[$path])) ? $_SERVER[$path] : @getenv($path);


        $this->set_url_string($info);


  
    }



    function filter_url($str='')
    {
        if($str !='' && $this->config->fetch_item('url_permit') !='' && $this->config->fetch_item('query_string') == FALSE)
        {
            if( !preg_match("|^[".str_replace(array('\\-', '\-'), '-', preg_quote($this->config->fetch_item('url_permit'), '-'))."]+$|i", $str))
            {
                display_error("the url submited disable character", 400);
            }

        }

        $bad=array('$',   '(',    ')',  '%28',   '%29');
        $good=array('&#38',  '&#40',  '&#41',  '&#40',  '&#41');

        return str_replace($bad, $good, $str);
    }


    function remove_url_suffix()
    {

        if($this->config->fetch_item('url_suffix') !='')
        {

            $this->url_string=preg_replace("|".preg_quote($this->config->fetch_item('url_suffix'))."$|", "", $this->url_string);

        }

    }

    function explode_segment()
    {

        foreach(explode('/', preg_replace("|/*(.+?)/*$|", "\\1", $this->url_string)) as $value)
        {

            $value=trim($this->filter_url($value));

            if($value !='')
            {

                $this->segment[]=$value;

            }
        }

    }

    function reindex_segment()
    {
        array_unshift($this->segment, NULL);
        array_unshift($this->rsegment, NULL);
        unset($this->segment[0]);
        unset($this->rsegment[0]);
    }

    function segments($n, $result=FALSE)
    {
        return $this->segment[$n]=(isset($this->segment[$n])) ? $this->segment[$n] : $result;
    }

    function rsegments($n, $result=FALSE)
    {
        return $this->rsegment[$n]=(isset($this->rsegment[$n])) ? $this->rsegment[$n] : $result;
    }

    function assoc_url($item)
    {

        $tem=array();

        foreach((array)$item as $k => $v)
        {

            $tem[]=$k;
            $tem[]=$v;

        }

        return implode('/', $tem);
    }

    function segment_array()
    {
        return $this->segment;
    }

    function rsegment_array()
    {
        return $this->rsegment;

    }

    function total_segment()
    {
        return count($this->segment);
    }

    function total_rsegment()
    {
        return count($this->rsegment);
    }

    function url_strings()
    {
        return $this->url_string;
    }
    
    function url_rstring(){
        return implode("/", $this->rsegment);
    }

    function slash_segment($n, $w='trailing')
    {

        return $this->_slash_segments($n, $w, $x='segments');
    }

    function slash_rsegment($n, $w='trailing')
    {

        return $this->_slash_segments($n, $w, $x='rsegments');
    }

    function _slash_segment($n, $w, $x)
    {
    
        $trailing='/';
        $leading='/';

        if($w=='trailing')
        {
            $leading='';
        }
        elseif($w=='leading')
        {
            $trailing='';
        }

        return $leading.$this->$x($n).$trailing;

    }

    function url_assoc($n, $default, $which)
    {

        if($which=='segment')
        {

            $total_segment='total_segment';
            $segment_array='segment_array';
        }
        else
        {

            $total_segment='total_rsegment';
            $segment_array='rsegment_array';

        }

        if(!is_numeric($n))
        {
            return $default;
        }

        if(isset($this->keyval[$n]))
        {
            return $this->keyval[$n];
        }

        if($this->$total_segment < $n)
        {

            if(count($default) == 0)
            {
                return array();
            }

            $retval=array();
            foreach($default as $val)
            {
                $retval[$val]=FALSE;
            }

            return $retval;

        }

        $segment=array_slice($this->$segment_array(), $n-1);
        
        $i=0;
        $lastval='';
        $retval=array();
        foreach($segment as $seg)
        {

            if($i%2)
            {
                $retval[$lastval]=$seg;
            }
            else
            {
                $retval[$sep]=FALSE;
                $lastval=$seg;
            }

            $i++;
        }

        if(count($default) > 0)
        {

            foreach($default as $key)
            {

                if(!array_key_exists($key, $retval))
                {
                    $retval[$key]=FALSE;
                }

            }

        }

        $this->keyval[$n]=$retval;

        return $retval;

    }

    function segment_url($no, $default=array())
    {
        $this->url_assoc($no, $default, 'segment');
    }

    function rsegment_url($no, $default=array())
    {
        $this->url_assoc($no, $default, 'rsegment');
    }

}
?>