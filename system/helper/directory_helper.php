<?php
if(!defined('BASE'))exit('direct access not allow');

if(!function_exists('directory'))
{

   function directory($path, $depth=1, $hidden=FALSE)
   {


      if($fp=@opendir($path))
      {

         $filedata=array();
         $new_depth=$depth-1;
         $path=ltrim($path, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

         while(FALSE!==$file=@readdir($fp))
         {

            if(!trim($file, '.') || ($hidden==FALSE && $file[0]=='.'))
            {
               continue;
            }

            if(($depth<1 ||$new_depth>0) && is_dir($path))
            {

               $filedata[$file]=directory($file.DIRECTORY_SEPARATOR, $new_depth, $hidden);
            }
            else
            {

               $filedata[]=$file;
            }   
         }

         closedir($fp);

         return $filedata;
      }

      return FALSE;
   }
}
?>