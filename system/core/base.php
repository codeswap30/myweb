<?php

if(!defined('BASE'))exit("direct access not allow");

include(BASE.'core/general.php');

set_error_handler('custom_handler');

//php version


if(is_php('5.3'))

{

     if(get_magic_quotes_gpc())

     {


          set_magic_quotes_runtime(false);


     }

}





if(function_exists('set_time_limit'))

{


   set_time_limit(300);

}





$TM=class_loader('timer');



$TM->times('start_execution');



$TM->times("start_executime:_class");


$con=class_loader('config', 'core');
$URL=class_loader('url', 'core');
//require(BASE.'helper/url_helper.php');


$RT=class_loader('route', 'core');



$utf8=class_loader('utf8', 'core');


$sec=class_loader('security', 'core');


$in=class_loader('input', 'core');


$lang=class_loader('language', 'library');


$RT->set_router();


if(isset($override))

{
    $RT->set_override($override);


}


require(BASE.'core/controller'.EXE);


function object_controller()

{


     return controller::get_object();


}


if(file_exists(APP.'controller/controller'.EXE))
{

     require(APP.'controller/controller'.EXE);

}


$UT=class_loader('send_output', 'core');


$TM->times('end_execution:_class');


if(!file_exists(APP.'controller/'.$RT->call_directory().$RT->call_class().EXE))
{
   display_error("unable to locate the default controller ".$RT->call_directory().$RT->call_class().EXE);
}

$TM->times('start_mvc_execution');


require(APP.'controller/'.$RT->call_directory().$RT->call_class().EXE);


$class=$RT->call_class();

$method=$RT->call_method();


if(!isset($class) || strncmp($method, '_', 1)==0 || in_array($method, array_map('strtolower', get_class_methods('controller'))))

{


   if(isset($RT->routes['404_override']))

   {




     if(!empty($RT->routes['404_override']))
      {


         $x=explode('/', $RT->routes['404_override']);

         $class=new $x[0];

         $method=(isset($x[1]) ? $x[1] : 'index');


         if(!class_exists($class))

         {


            if(!file_exists(APP.$class.EXE))

            {


               display_404("$class/$method");

            }


            include(APP.$class.EXE);


         }
      
}


   }

   else

   {

      display_404("{$class}/{$method}");

   }

}

$cl=new $class;

if(!in_array($method, array_map('strtolower', get_class_methods($cl))))
{

   if(isset($RT->routes['404_override']))
   {

     if(!empty($RT->routes['404_override']))
      {

         $x=explode('/', $RT->routes['404_override']);
         $class=$x[0];
         $method=(isset($x[1]) ? $x[1] : 'index');

         if(file_exists(APP.'controller/'.$class.EXE))
         {

            if(class_exists($class))
            {
              display_404("$class/$method");
            }

            include(APP.'controller/'.$class.EXE);

           unset($cl);
            $cl=new $class;
            $cl->$method();
         }
        else
        {

            display_404("{$class}/{$method}");

        }
      
      }

   }

}
else
{
   call_user_func_array(array($cl, $method), array_slice($URL->rsegment, 2));
}

$TM->times('end_mvc_execution');


$UT->display_output();


$TM->times('end_execution');

if(class_exists('db') && isset($cl->db))
{
     $cl->db->close_db();
}


?>

