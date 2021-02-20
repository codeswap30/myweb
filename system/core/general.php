<?php

if(!defined('BASE'))exit("direct access not allow");


//check the version of php

/*
@param string

@return bool

@access public
*/


if(!function_exists('is_php'))

{



     function is_php($version='5.0')

     {

          static $_is_php;



          $version=(string)$version;



          if(!isset($_is_php[$version]))

          {


               $_is_php[$version]=(version_compare(PHP_VERSION, $version) <0 ) ? FALSE : TRUE;


          }


          return $_is_php[$version];

     }

 }





/*function to search for directory 

@access public

@param string

@return array

*/




if(!function_exists('class_loader'))

{

    function class_loader($class, $directory='library')

    {

        static $_loader=array();



        if(isset($_loader[$class]))

        {

            return $_loader[$class];

        }


        $name=NULL;



        foreach(array(APP, BASE) as $dir)

        {


            if(file_exists($dir.$directory.'/'.$class.EXE))
            {


                $name=$class;


                if(!class_exists($name))

                {

                    include($dir.$directory.'/'.$class.EXE);


                     break;

                }

            }

 

        }

        
if($name==NULL)

        {

            exit("unable to locate this class ".$class.EXE);


        }


        is_class_loader($class);



        $_loader[$class]=new $name;



        return $_loader[$class];

    }

}



function is_class_loader($class='')

{

    
    static $_loader=array();


    if($class !='')

    {


         $_loader[strtolower($class)]=$class;


    }


   return $_loader;


}




if(!function_exists('not_writable'))

{
    
    function not_writable($file)

    {


        if(DIRECTORY_SEPARATOR=='/' && ini_get("save_mode")==FALSE)

        {


            return is_writable($file);


        }



        if(is_dir($file))

        {


            $file=rtrim($file, '/').'/'.md5(mt_rand(1,100)).mt_rand(1,100);


            if(!$fp=fopen($file, 'ab'))

            {


                return FALSE;

            }


            fclose($fp);

            chmod($file, 0755);

            unlink($file);

            return TRUE;

        }

        elseif(!is_file($file) || !$fp=fopen($file, 'ab'))

        {

            return FALSE;

        }


        fclose($fp);

        return TRUE;

    }

}



//load config file



if(!function_exists('load_config'))

{


    function load_config($item=array())

    {


        static $_configs=array();



        if(isset($_configs[0]))

        {


            return $_configs[0];


        }



        if(!defined('ENVIRONMENT') || !file_exists($file=APP.'config/'.ENVIRONMENT.'/config.php'))
        {
           $file=APP.'config/config.php';


        }     







        if(!file_exists($file))

        {


            exit("conguration file does not exists file can not be load");


        }



         require($file);



        if(!isset($config) || !is_array($config))

        {


            exit("configuration not in format");


        }




        foreach($item as $key => $value)

        {


            if(isset($config[$key]))

            {


                $config[$key] = $value;


            }


        }



        return $_configs[0]=$config;


    }


}




if(!function_exists('get_item'))

{


     function get_item($item='')

     {


          static $_item;



          if($item !='')

          {


               $config=load_config();



               if(isset($config[$item]))

               {


                    $_item[$item]=$config[$item];


               }



             return $_item[$item];


          }


          
     }

}



/*----------------------------------------------------------------------

    ERROR PAGES HANDLES
----------------------------------------------------------------------*/



if(!function_exists('text_log'))

{


     function text_log($level='error', $message)

     {


          $error=class_loader('log');

          $error->inbox_log($level, $message);

     }


}


if(!function_exists('display_404'))

{


     function display_404($page='')

     {


          $error=class_loader('exceptions', 'core');

          $error->error_404($page);

          exit;


     }


}


if(!function_exists('display_error'))

{


     function display_error($message, $head="error occur", $status=500)

     {


          $error=class_loader('exceptions', 'core');

          echo $error->general_error($head, $message, 'general_page', $status);
          exit;


     }


}



if(!function_exists('custom_handler'))

{


     function custom_handler($severity, $message, $file, $line)

     {


          if($severity == E_STRICT)

          {

               return;

          }


          $error=class_loader('exceptions','core');

     

          if(($severity&error_reporting()) == $severity)

          {


               $error->log_exceptions($severity, $message, $file, $line);


          }


          $error->custom_error($severity, $message, $file, $line);


     }


}



if(!function_exists('status_header_code'))

{


    function status_header_code($code=200, $text='')

    {


        		$level = array(

							200	=> 'OK',

							201	=> 'Created',

							202	=> 'Accepted',


							203	=> 'Non-Authoritative Information',

							204	=> 'No Content',

							205	=> 'Reset Content',

							206	=> 'Partial Content',


							300	=> 'Multiple Choices',

							301	=> 'Moved Permanently',

							302	=> 'Found',

							304	=> 'Not Modified',

							305	=> 'Use Proxy',

							307	=> 'Temporary Redirect',


							400	=> 'Bad Request',

							401	=> 'Unauthorized',

							403	=> 'Forbidden',

							404	=> 'Not Found',

							405	=> 'Method Not Allowed',

							406	=> 'Not Acceptable',

							407	=> 'Proxy Authentication Required',

							408	=> 'Request Timeout',

							409	=> 'Conflict',

							410	=> 'Gone',

							411	=> 'Length Required',

							412	=> 'Precondition Failed',

							413	=> 'Request Entity Too Large',


							414	=> 'Request-URI Too Long',

							415	=> 'Unsupported Media Type',

							416	=> 'Requested Range Not Satisfiable',

							417	=> 'Expectation Failed',


							500	=> 'Internal Server Error',


							501	=> 'Not Implemented',


							502	=> 'Bad Gateway',


							503	=> 'Service Unavailable',

							504	=> 'Gateway Timeout',


							505	=> 'HTTP Version Not Supported'


						);


        if(!isset($code) || !is_numeric($code))

        {


            return FALSE;


        }


        if(isset($level[$code]))

        {


            $text=$level[$code];

    
    }


        if($text=='')

        {


            display_error("no available text for the code you select you can set your own text", 500);


        }




        $server=(isset($_SERVER['SERVER_PROTOCOL'])) ? $_SERVER['SERVER_PROTOCOL'] : FALSE;


        if(strpos(php_sapi_name(), 0, 3) =='cgi')

        {


            header("status: {$text} {$code}", TRUE);


        }

        elseif($server=='HTTP/1.0' OR $server=='HTTP/1.1')
        {

            header($server." {$text} {$code}", TRUE, $code);


        }

        else

        {


            header("HTTP/1.1 {$text} {$code}", TRUE, $code);


        }


    }

}



if(!function_exists('remove_invalid_char'))

{


    function remove_invalid_char($string='', $url_encode=TRUE)

    {
 

         $invisible=array();

 

         if($url_encode)
 
         {


              $invisible[]='/%0[0-8bcef]/';

              $invisible[]='/%1[0-9a-f]/';


          }



          $invisible[]='/[\x00\x08\x0B\x0C\x0E-\x1F\x7F]+S/';



         do

          {


              $string=preg_replace($invisible,'',$string, -1, $count);


          }
 
         while($count);


          return  $string;

    }


}



if(!function_exists('html_escape'))

{


      function html_escape($str)

      {


            if(is_array($str))

            {


                  return array_map('html_escape', $str);

  
          }

            else

            {

                  return  htmlspecialchars($str, 'ENT_QUOTES', 'UTF-8');


            }


        }

}




?>