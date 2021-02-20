<?php
class model
{


   function __construct()
   {

      text_log('debug', "model class initialize");
   }

   function __get($value)
   {
      $con=object_controller();
      return $con->$value;

   }
}
?>