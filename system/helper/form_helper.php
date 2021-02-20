<?php
if(!defined('BASE'))exit("direct access not allow");

if(!function_exists('get_objected'))
{

     function get_objected()
     {

          $object=object_controller();

          $obj=FALSE;

          if(FALSE !==$obj=$object->load->is_loaded('validations'))
          {

               if(!isset($object->$obj) || !is_object($object->$obj))
               {
                  return FALSE;
               }
          }

          return $object->$obj;
     }
}

if(!function_exists('error_data'))
{
     function error_data()
     {

          $object=get_objected();

          if(!is_object($object))
          {
               return FALSE;
          }

          return $object->error_strings();

     }

}

if(!function_exists('error_form'))
{
     function error_form($field, $pre, $suf)
     {

          $object=get_objected();

          if(!is_object($object))
          {
               return FALSE;
          }

          return $object->errors($field, $pre, $suf);

     }
 
}

?>