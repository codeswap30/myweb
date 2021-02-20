<?php
if(!defined('BASE'))exit('direct access not allow');

if(function_exists('find_path'))
{

   function find_path($path)
   {

      if(preg_match("#^(http:\/\/|https:\/\/|www\.|ftp|[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})#i", $path))
      {

         display_error("the path must be from local server path not URL path");
      }

      if(!dir($path))
      {
         display_error("undefined path or the path does not exists ".$path);
      }

      if(function_exists('realpath') AND @realpath($path)!==FALSE)
      {

         $path=realpath($path).'/';
      }

      $path=preg_replace("#([^/])/*$#", "\\1/", $path);

      return $path;
   }
}
?>