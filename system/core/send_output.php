<?php
if(!defined('BASE'))exit("direct access not allow");
class send_output
{

     var $final_output;
     var $header=array();
     var $zlib;
     var $output;
     var $expire;
     var $profile_enable;
     var $profile=array();


     function __construct()
     {

          $this->zlib=ini_get('zlib.output_compression');

          if(file_exists(APP.'config/mimes'.EXE))
          {

              include(APP.'config/mimes'.EXE);

          }

          if(!isset($mime) || !is_array($mime))
          {

               return FALSE;

          }

          $this->mime=$mime;
          unset($mime);

          text_log('debug', "send_output initialize");

     }

     function output()
     {

          return $this->output;

     }

     function set_output($output)
     {

          $this->output=$output;

          return $this;

     }

     function append_output($output='')
     {

          if($this->output=='')
          {

               $this->output=$output;

          }
          else
          {

               $this->output.=$output;

          }

          return $this;

     }

     function set_header($header, $return=TRUE)
     {

          if($this->zlib && strncasecmp($header, 'content-length', 14) ==0)
          {
               return '';
          }

          $this->header=array($header, $return);

          return $this;

     }

     function set_content_type($mime, $code=TRUE)
     {

          if(strpos($mine, '/') ===FALSE)
          {

               if(isset($this->mine[ltrim($mime, '.')]))
               {

                    $mime=$this->mime[ltrim($mime, '.')];

                    if(is_array($mime))
                    {
                         $mime=current($mime);
                    }

               }

          }

          $header='Content-type: '.$mime;
          $this->header=array($header, TRUE);

          return $this;
     }

     function set_status_header($code=200, $text='')
     {

          status_header_code($code, $text);
          return $this;

     }

     function enable_profile($enable=TRUE)
     {

          $this->profile_enable=(!is_bool($enable)) ? TRUE : $enable;

          return $this;
     }

     function set_profile($section)
     {

          foreach($section as $k => $v)
          {

               $this->profile[$k]=($v !==FALSE) ? TRUE : FALSE;

          }

          return $this;
     }

     function expire_time($time)
     {

          $this->expire=(is_numeric($time)) ? $time : 0;
          return $this;
     }

     function display_output($out='')
     {

          global $TM, $cl;

               $cl=object_controller();


          if($out=='')
          {
               $out=$this->output;
          }

          if($this->expire > 0 && isset($cl) && ! method_exists($cl, 'send_output'))
          {

               $this->text_cache($out);

          }

            $elapse=$TM->time_elapse('start_execution', 'end_execution');

          $memory=(function_exists('memory_get_usage')) ? round(memory_get_usage()/1024/1024).'MB' : FALSE;

          $this->output=str_replace('{elapse_time}', $elapse, $out);
          $this->output=(str_replace('{memory_usage}', $memory, $out));
           text_log("debug", "the amount of memory use and total time execution is ".$memory." and time: ".$elapse);

          if($this->zlib=FALSE)
          {
               if(extension_loaded('zlib'))
               {

                    if(isset($_SERVER['HTTP_ACCEPT_ENCODING']) && strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !==FALSE)
                    {
                         ob_start('ob_gzhandler');
                    }

               }
     
          }

          if(count($this->header) > 0);
          {

               foreach($this->header as $header => $return)
               {
                    header($header[0], $return[1]);
               }

          }

          if(!isset($cl))
          {

               echo $out;
               text_log("debug", "final output send to browser");
               text_log("debug", "total time is ".$elapse." total memory use is ".$memory);
          }

          if($this->profile_enable==TRUE)
          {

               if(count($this->profile)!=0)
               {

                    
               }

          }

          if(method_exists($cl, 'send_output'))
          {

               $cl->_send_output($out);

          }
          else
          {

               echo $out;

          }
     
          text_log('debug', "final output send to browser");
          text_log('debug', "final time and memory use space send to browser");
     }

     function text_cache($text)
     {

          global $cl;

          $path=$cl->config->fetch_item('cache_path');

          $realpath=($path=='') ? APP.'cache/' : $path;

          if(!is_dir($realpath))
          {

               text_log('error', "unable to write this cache file ".$realpath); 
               return '';

          }


          $url=$cl->config->slash_item('base_url').$cl->config->slash_item('index_page').$cl->url->url_string;

          $realpath=$realpath.md5($url);

          if(!$fp=fopen($realpath, 'w'))
          {
               return FALSE;
          }

          if(flock($fp, LOCK_EX))
          {

               fwrite($fp, time() + ($this->expire*60).'TS-->'.$text);
               flock($fp, LOCK_UN);

          }
          else
          {

               text_log('error', "unable to write this file ".$url);
          }
          fclose($fp);

          text_log('debug', "file cache is catch ".$url);
          return TRUE;

     }

     function display_cache($con, $URI)
     {

          $path=($con->fetch_item('cache_path') =='') ? APP.'cache/' : $con->fetch_item('cache');

          $file=$con->slash_item('base_url').$con->slash_item('index_url').$URI->url_strings();

          $url=$path.md5($file);

          if(!file_exists($url))
          {

               return FALSE;
          }

          if(!$fp=fopen($url, 'r'))
          {

               return FALSE;

          }

          flock($fp, LOCK_SH);
          if(filesize($url) > 0)
          {
          
               $cache=fread($fp, filesize($url));
               flock($fp, LOCK_UN);

          }
          fclose($fp);

          if(!preg_match("/(\d)+TS-->/", $cache, $match))
          {
               return FALSE;
          }

          if(time() >=str_replace('TS-->', '', $match['1']))
          {
               unlink($url);

               text_log('debug', "cache delete file expire");

          }

          $this->display_output(str_replace($match['0'], '', $cache));
          text_log('debug', "cache file send to browser");
          return TRUE;

     }
} 
?>