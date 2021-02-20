<?php
if(!defined('BASE'))exit("direct access not allow");
class route
{

   var $url;
   var $config;
   var$default_controller;
   var $routes=array();
   var $class;
   var $directory;
   var $methods;


   function __construct()
   {

      $this->config=class_loader('config', 'core');
      $this->url=class_loader('url', 'core');

      text_log('debug', 'routes class load');

   }

   function set_router()
   {

      $segment=array();

      if($this->config->fetch_item('enable_query')===TRUE AND isset($_GET[$this->config->fetch_item('controller_trigger')]))
      {

         if(isset($_GET[$this->config->fetch_item('directory_trigger')]))
         {

            $segment[]=trim($this->url->filter_url($_GET[$this->config->fetch_item('directory_trigger')]));

         }

         if(isset($_GET[$this->config->fetch_item('controller_trigger')]))
         {

            $segment[]=trim($this->url->filter_url($_GET[$this->config->fetch_item('controller_trigger')]));

         }

         if(isset($_GET[$this->config->fetch_item('method_trigger')]))
         {

            $segment[]=trim($this->url->filter_url($_GET[$this->config->fetch_item('method_trigger')]));

         }

      }

      if(file_exists(APP.'config/routes.php'))
      {
         include(APP.'config/routes.php');
      }

      if(!isset($route) OR !is_array($route))
      {
         display_error("routes file not in right format unable to load the file");
      }

      $this->routes=$route;
      unset($route);
      $this->default_controller=(isset($this->routes['default_controller']) && $this->routes['default_controller'] !='') ? $this->routes['default_controller'] : FALSE;
      if(count($segment) > 0)
      {
         return valid_request($segment);
      }

      $this->url->fetch_url();

      if($this->url->url_string =='')
      {

         return $this->set_default_controller();

      }

        $this->url->remove_url_suffix();
      $this->url->explode_segment();

      $this->parse_segment();

      $this->url->reindex_segment();
   }

   function set_class($class)
   {
      $this->class=$class;
      $this->class=str_replace(array('/','.'), '', $this->class);
    
   }

   function call_class()
   {
    
      return $this->class;
   }

   function set_method($method)
   {
      $this->methods=$method;
   }

   function call_method()
   {

      if($this->methods==$this->call_class())
      {
         return 'index';
      }

      return $this->methods;
   }

   function set_directory($dir)
   {
      $this->directory=$dir;
      $this->directory=str_replace(array('/','.'), '', $this->directory).'/';

   }

   function call_directory()
   {

      return $this->directory;

   }

   function set_default_controller()
   {

      if($this->default_controller===FALSE)
      {

         display_error('unable to locate the default controller');

      }

      if(strpos($this->default_controller, '/') !== FALSE)
      {

          $m=explode('/', $this->default_controller);
         
         $this->set_class($m[0]);
         $this->set_method($m[1]);
         $this->set_request($m);

      }
      else
      {
         $this->set_class($this->default_controller);
         $this->set_method('index');
         $this->set_request(explode('/', $this->default_controller.'/index'));

      }
   }

   function set_request($segment=array())
   {

      $segment=$this->valid_request($segment);

      if(count($segment)==0)
      {
         $this->set_default_controller();

      }

      $this->set_class($segment[0]);
      if(isset($segment[1]))
      {

         $this->set_method($segment[1]);

      }
      else
      {
         $this->set_method('index');

       }

      $this->url->rsegment=$this->url->segment;
   }

   function valid_request($segment)
   {

      if(count($segment)==0)
      {
         return $segment;
      }

      if(file_exists(APP.'controller/'.$segment[0].EXE))
      {

         return $segment;
      }

      if(is_dir(APP.'controller/'.$segment[0]))
      {

         $this->set_directory($segment[0]);
         $segment=array_slice($segment, 1);

         if(count($segment) >0)
         {

            if(!file_exists(APP.'controller/'.$this->call_directory().$segment[0].EXE))
            {

               if(!empty($this->routes['404_override']))
               {

                  $x=explode('/', $this->routes['404_override']);

                  $this->set_class($x[0]);
                  $this->set_method(isset($x[1]) ? $x[1] : 'index');

               }
               else
               {

                  display_404("{$this->call_directory()}{$this->call_class()}");

               }

               return $x;
            }

            return $segment;
        }

      }
      else
      {

         if(!empty($this->routes['404_override']))
         {

               $x=explode('/', $this->routes['404_override']);

               $this->set_class($x[0]);
              $this->set_method(isset($x[1]) ? $x[1] : 'index');

          }
          else
          {

             display_404("{$this->call_directory()}{$this->call_class()}");

         }

        return $x;

      }

       display_404($segment);

   }

   function parse_segment()
   {

      $url=implode('/', $this->url->segment);

      if(isset($this->routes[$url]))
      {

         return  $this->set_request(explode('/', $url));

      }

      foreach($this->routes as $key =>$value)
      {

         $key=str_replace(':any', '.+', str_replace(':num', '[0-9]+', $key));

         if(preg_match("#^".$key."$#", $url))
         {

            if(strpos($key, "$") !==FALSE AND strpos($value, "%") !==FALSE)
            {

               $value=preg_replace("#^".$key."$#", $value, $url);

            }
           return $this->set_request(explode('/', $value));
         }

      }      

      $this->set_request($this->url->segment);
   }
}
?>