<?php
if(!defined('BASE'))exit("direct access not allow");
class controller
{

   private static $instance;

   function __construct()
   {

      self::$instance=$this;

      foreach(is_class_loader() as $key => $value)
      {

          $this->$key=class_loader($value);

      }


      
      $this->load=class_loader('loader','core');

      $this->load->initialize();


   }

   public static function get_object()
   {

      return self::$instance;
   }

}
?>