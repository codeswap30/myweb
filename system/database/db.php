<?php


if(!defined('BASE'))exit("direct access not allow");




function db($param='')

{

   
  if($param=='')

     {


         if(!file_exists(APP.'/config/database'.EXE))

          {


               display_error("the database file can not be found in the server");

          }


          include(APP.'/config/database'.EXE);


          
if(!isset($db) || !is_array($db))

          {


               display_error("database configuration appear to be not in right format");

          }


          $param=$db;


      }



      if(!is_array($param))

      {



               return FALSE;

      }



      if(!file_exists(BASE.'database/driver'.EXE))

      {


               display_error("database driver can not be found in the system");


      }



      include(BASE."database/driver".EXE);



      if(!class_exists('Db'))

      {


           eval('class Db extends db_driver{ }');

      }


     if(!isset($param['driver']) && !file_exists(BASE.'database/driver/'.$param['driver'].'/'.$param['driver'].'_driver'.EXE))

     {



         display_error("you have not specific the data driver you want to use");

     }




      include(BASE."database/driver/".$param['driver'].'/'.$param['driver'].'_driver'.EXE);


         
      $class='db_'.$param['driver'].'_driver';



      $Db=new $class($param);



      if($param['autostart']===TRUE)

      {


        
         $Db->autoinit();

      }



     return $Db;


}

?>