<?php
if(!defined('BASE'))exit("direct access not allow");
class exceptions
{

  var $ob_level;
  var $severity=array('E_ERROR' =>'error occur', 'E_WARNING' => 'warning', 'E_NOTICE' => 'notice', 'E_CORE_ERROR' => 'core error', 'E_CORE_WARNING' => 'warning', 'E_COMPILE_ERROR' => 'compile error', 'E_COMPILE_WARNING' => 'compile warninp', 'E_USER_ERROR' => 'user error', 'E_USER_WARNING' => 'user warning', 'E_USER_NOTICE' => 'user notice', 'E_STRICT' => 'timeout');

     function __construct()
     {
          $this->ob_level=ob_get_contents();

     }

     function log_exceptions($severity, $message, $file, $line)
     {

          $severity=(isset($this->severity[$severity])) ? $this->severity[$severity] : $severity;

          text_log('error', 'severity :'.$severity.' '.$file.' --> '.$line);

     }

     function error_404($page='')
     {

          $heading='404 error page';
          $message='page can not be found '.$page;
          
          text_log('error', $heading.' '.$message.'--> '.$page);

          echo $this->general_error($heading, $message, '404_page', 404);

          exit;
     }

     function general_error($title, $message, $page='general_page', $status=500)
     {

          status_header_code($status);

          $message='<p>'.implode('</p><p>', (!is_array($message)) ? array($message) : $message).'</p>';

          if($this->ob_level > ob_get_contents() + 1)
          {

               ob_end_flush();

          }

          ob_start();
          include(APP.'error/'.$page.'.html');
          $buf=ob_get_contents();
          ob_end_clean();

          return $buf;

     }

     function custom_error($severity, $message, $file, $line)
     {

          $severity=(isset($this->severity[$severity])) ? $this->severity[$severity] : $severity;

          $file=str_replace("\\", "/", $file);

          if(strpos($file, '/') !== FALSE)
          {

               $m=explode('/', $file);
               $file=$m[count($m) - 2].'/'.end($m);

          }

          if($this->ob_level > ob_get_contents() + 1)
          {

               ob_end_flush();

          }

          ob_start();
          include(APP.'error/php_error.html');
          $buff=ob_get_contents();
          ob_end_clean();
          echo $buff;
    }
}
