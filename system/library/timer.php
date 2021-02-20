<?php
if(!defined('BASE'))exit("direct access not allow");
class timer
{

   var $buffer=array();

   function __construct()
   {

      text_log('debug', "timer function is set up");

   }

   function times($name)
   {

      $this->buffer[$name]=microtime();

   }

   function time_elapse($point1='', $point2='', $decimal=4)
   {

      if($point1=='')
      {

         return '{time_elapse}';

      }

      if(!isset($this->buffer[$point1]))
      {

         return FALSE;

      }

      if(!isset($this->buffer[$point2]))
      {

         $this->buffer[$point2]=microtime();

      }

      list($a, $b)=explode(' ', $this->buffer[$point1]);
      list($c, $d)=explode(' ', $this->buffer[$point2]);

      return number_format(($c+$d) - ($a+$b), $decimal);

   }

   function memory_usage()
   {

      return '{memory_usage}';
   }

}
?>