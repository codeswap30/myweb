<?php
if(!defined('BASE'))exit("direct access not allow");

//get load image

if(!function_exists("image_html"))
{

     function image_html($data, $index=FALSE)
     {

          if(is_array($data))
          {

               foreach(array('src', 'alt', 'width', 'height') as $value)
               {

                    $$value=(isset($data[$value])) ? $data[$value] : FALSE;
               }


          }

          $img="<img";
         if($src==FALSE)
          {
               return FALSE;
          }

          $object=object_controller();

          if($index==TRUE)
          {

               $img.=' src='.$object->config->site_url($src);
          }
          else
          {

               $img.=' src='.$object->config->base_url($src);

          }

          $img.=($alt!=FALSE)? ' alt='.$alt : FALSE;

          $img.=($height!=FALSE || $width!=FALSE) ? ' width='.$width.' height='.$height : FALSE;

          $img.="/>";

          return $img;
          
     }
}
?>