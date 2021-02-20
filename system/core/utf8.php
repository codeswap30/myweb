<?php
class utf8
{

     function __construct()
     {

          global $con;

          text_log('debug', "utf8 class initialize");

          if( preg_match('/./u', 'é')===1 && function_exists('iconv') && ini_get('mbstring.func_overload')!=1 && $con->fetch_item('charset')=='UTF' )
          {

               text_log('debug', "UTF-8 support enable");

               define('UTF8_ENABLE', TRUE);

               if(extension_loaded('mbstring'))
               {

                    define('MB_ENABLE', TRUE);
                    mb_internal_encoding('UTF-8');

               }
               else
               {

                    define('MB_ENABLE', FALSE);
               }

          }
          else
          {

               text_log('error', "UTF-8 support not enable");
               define('UTF8', FALSE);
          }
     }

     function clean_string($char)
     {

          if($this->is_ascii($char)===FALSE)
          {

               $char=@iconv('UTF-8', 'UTF-8', $char);
          }

          return $char;
     }

               
     function safe_xml($str)
     {

          return remove_invalid_char($str, FALSE);
     }

     function convert_to_utf8($str, $encode)
     {

          if(function_exists('mb_convert_encoding'))
          {

               $str=@mb_convert_encoding($str, 'UTF-8', $encode);
          }
          elseif(function_exists('iconv'))
          {

               $str=@iconv($encode, 'UTF-8', $str);
          }
          else
          {

               return FALSE;
          }

          return $str;
     }

     function is_ascii($char)
     {

          return (preg_match('/[^\x00-\x7F]/S', $char) == 0);
     }
}
?>