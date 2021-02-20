<?php
if(!defined('BASE'))exit("direct access not allow");

class  config

{


    var $config=array();

    var $is_loaded=array();
    var $path=array(APP);



    function __construct()

    {


         $this->config=load_config();


   
      if($this->config['base_url'] =='')

         {

              if(isset($_SERVER['HTTP_HOST']))

              {

  
                $url=(isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !=='off') ? 'https' : 'http';

                  $url.='://'.$_SERVER['HTTP_HOST'];
   
               $url.=str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

    
          }
    
          else
     
         {
      

             $url='http://localhost/';
      

        }



              $this->set_item('base_url', $url);


         }

         text_log('debug', "config file and base url have set up");
    
}


 
    function set_item($index, $value)

     {


         return  $this->config[$index] = $value;


    }



    function assign_item($item=array())
    {


          foreach($item as $key => $value)

          {


               $this->config[$key] = $value;


           }


     }




     function load_config($file='', $use=TRUE, $fail=TRUE)

     {



         $file=($file=='') ? 'config' : str_replace('.php', '', $file);

         $check_location=(defined('ENVIRONMENT'))
         ? array(ENVIRONMENT.'/'.$file,$file) : array($file);

         $found=FALSE;
         $load=FALSE;



         foreach($check_location as $location)

         {


              foreach($this->path as $path)

              {
              


                  $path_file=$path.'config/'.$location .EXE;



                  if(in_array($path_file, $this->is_loaded, TRUE))

                  {
                        $load=TRUE;


                        continue 2;


                  }



                 if(file_exists($path_file))

                 {


                     $found=TRUE;

                      break;


                 }


   
           }


  
            if($found===FALSE)

              {


                continue;


              }



              include($path_file);



             if(!isset($config) || !is_array($config))

              {



                if($fail===TRUE)

                {



                  return FALSE;



                }



                display_error('configuration file not a right format');


              }




             if($use===TRUE)

             {



                if(isset($this->config[$file]))

                 {


                    $this->config[$file]=array_merge($this->config, $config);


                }

                else

               {


                    $this->config[$file]=$config;


               }
 

          }

           else

           {

   
             $this->config=array_merge($this->config, $config);


           }


 


          $this->is_loaded[]=$path_file;


           unset($config);


          text_log('debug', 'configuration file load complete');
 
         $load=TRUE;

          break;

     }



     if($load===FALSE)
     {



          if($fail===TRUE)
          {


             return FALSE;
 
         }



          display_error('unable to locate this file'.$path_file);


     }



     return TRUE;


    }




   function fetch_item($item, $index='')
   {

       if($index=='')

       {


           if(!isset($this->config[$item]))

           {


                return FALSE;

           }



           $pref=$this->config[$item];


        }

        else

        {



             if(!isset($this->config[$index]))

             {

 
                 return FALSE;


             }

             if(!isset($this->config[$index][$item]))

             {

 
                 return FALSE;


             }



              $pref=$this->config[$index][$item];

 
        }


       return $pref;


   }




    function slash_item($item)
 
    {


        if(!isset($this->config[$item]))

        {


            return FALSE;


        }



        if(trim($this->config[$item])=='')

        {

            return '';

        }


        return rtrim($this->config[$item], '/').'/';


    }



    function url_string($url)
    {

        
       if($this->fetch_item('enable_query') == FALSE)
       {

            if(is_array($url))
            {

                $url=implode('/', '$url');
             }

            $url=trim($url, '/');

        }
        else
        {
            if(is_array($url))
            {
                $j=0;
                $str='';
                foreach($url as $key => $value)
                {
                    $pref=($j == 0) ? '' : '&';
                    $str.=$pref.$k.'='.$value;
                   $j++;
                }
                $url=$str;
            }
        }

        return $url;
    }



    function site_url($url='')
    {

        if($url=='')
        {
            return $this->slash_item('base_url').$this->fetch_item('index_page');

        }
        else
        {
            if($this->fetch_item('enable_query') == FALSE)
            {
                $suf=($this->fetch_item('url_extension') =='') ? '' : $this->fetch_item('url_extension');
                return $this->slash_item('base_url').$this->slash_item('index_page').$this->url_string($url).$suf;
            }
            else
            {
                return $this->slash_item('base_url').$this->fetch_item('index_page').'?'.$this->url_string($url);
            }


        }

    }




    function base_url($url)
    {
        return $this->slash_item('base_url').ltrim($this->url_string($url), '/');
    }




    function system_url()
    {
      $x=explode("/", preg_replace("|/*(.+?)/*$|", "\\1", BASE));
        return $this->slash_item('base_url').end($x).'/';
    }

}

?>