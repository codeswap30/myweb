<?php

if(!defined('BASE'))exit("direct access not allow");


class loader

{


   var $cache=array();

   var $view_path;

   var $is_loaded;

   var $library_path;

   var $helper_path;

   var $helper=array();

   var $level;

   var $model_path;

   var $models;

   var $classes;

   var $base_classes=array();



   function __construct()

   {



      $this->level=ob_get_level();

      $this->view_path=array(APP.'views/');

      $this->helper_path=array(BASE,APP);

      $this->model_path=array(APP);

      $this->library_path=array(BASE, APP);


      text_log('error', "intialize loader");


   }



   function initialize()

   {



      $this->is_loaded=array();

      $this->classes=array();

      $this->base_classes=is_class_loader();

      $this->models=array();


      
return $this;

   }



     function is_loaded($class='')

     {



          if(isset($this->classes[$class]))

          {

               return $this->classes[$class];

          }



          return FALSE;

     }



   function views($views, $data='', $return=FALSE)

   {



     return $this->load(array('views' =>$views, 'data' =>$data, 'return' => $return));


   }


   
function load($data)

   {



      foreach(array('views','data','return', 'file') as $value)

      {



         $$value=(isset($data[$value])) ? $data[$value] : FALSE;


     }



      $find=FALSE;

      $path='';



      if($file !='')

      {



         $m=explode('/', $file);

         $path=end($m);



      }

      else

      {



         $ext=pathinfo($views, PATHINFO_EXTENSION);

         $path=($ext=='') ? $views.EXE : $views;


      }




      foreach($this->view_path as $pat)

      {


            if(file_exists($pat.$path))

            {


               $find=TRUE;

         
   }



            $paths=$pat.$path;


      }



     if($find===FALSE)

     {

        display_404("unable to load this ".$paths);

     }



      $cl=object_controller();



      foreach(get_object_vars($cl) as $key =>$value)

      {



         if(!isset($key))

         {



            $cl->$key=$value;


         }


      }



      if(is_array($data))

      {



            $this->cache=array_merge($this->cache, $data);


      }


      extract($this->cache);


      ob_start();



      if(ini_get('short_open_tag')===FALSE && get_item('short_write_tag') ===TRUE)

      {



         eval('?>'.preg_replace("/;*\s*\>", "; ?>", str_replace("<?=", "<?php echo", get_file_contents($paths))));


      }

      else

      {



         include($paths);

       }



      if($return === TRUE)

      {



         //copy the output to butter

         $buffer=ob_get_contents();

         ob_end_clean();

         return $buffer;


      }

      else

      {


         if(ob_get_level() > $this->level + 1)

         {



            ob_end_flush();


         }

         else

         {


            $cl->send_output->append_output(ob_get_contents());

            ob_end_clean();


         }


      }


   }




   function object_variable($object)

   {



      if(object_exists($object))

      {



         foreach(get_object_vars($object) as $key => $value)

         {


            return $key=$value;


         }


      }


   }



   function library($lib, $param='', $object_name='')

   {



      if(is_array($lib))

      {



         foreach($lib as $value)

         {



            $this->library($value, $param, $object_name);


         }



         return '';
      
 }



      if($lib=='' || isset($this->base_classes[$lib]))

      {


         return FALSE;

      }



      if(!is_null($param) && !is_array($param))

      {



         $param=NULL;

      }



      return $this->load_class($lib, $param, $object_name);


   }



   function load_class($class, $param=NULL, $object_name=NULL)

   {



      $class=str_replace('.php', '', trim($class, '/'));


        $subdir='';



      if($slash=strpos($class, '/') !==FALSE)

      {



         $subdir=substr($class, 0, $slash + 1);

         $class=substr($class, $slash + 1);


      }



      foreach(array(ucfirst($class), strtolower($class)) as $class)

      {



         $subclass=APP.'library/'.$subdir.$class.EXE;

         if(file_exists($subclass))

         {



              $baseclass=BASE.'library/'.$class.EXE;


              if(!file_exists($baseclass))

              {



               text_log("error", "unable to load this ".$class);

               display_error("unable to load this ".$class);


              }



              if(in_array($subclass, $this->is_loaded))

              {



                  if(!is_null($object_name))

                   {



                        $cl=object_controller();


                        if(!isset($cl->$object_name))

                        {



                               return $this->ini_class($class, $param, $object_name);


                         }


                    }



                    text_log("debug", $class." class already exists second attempt ignore");

                    $duplicate=TRUE;

               }

 

               $duplicate=FALSE;

               include($baseclass);

               include($subclass);


               $this->is_loaded[]=$file;


               return $this->ini_class($class, $param, $object_name);


            }


         }



         foreach($this->library_path as $path)

         {



            $sub=$path.'library/'.$class.EXE;



            if(!file_exists($sub))

            {



               continue;


            }



            if(in_array($sub, $this->is_loaded))

            {



                  $cl=object_controller();

                  if(!is_null($object_name))

                  {



                        if(!isset($cl->$object_name))

                        {



                              return $this->ini_class($class, $param, $object_name);


                        }

                  }



                  $duplicate=TRUE;

                  text_log("debug", $class." is already load second attempt ignore");


            }



            include($sub);

            $this->is_loaded[]=$sub;

             return $this->ini_class($class, $param, $object_name);


         }


      


   $path=$class.'/'.$class;


         $this->load_class($path);



         if($duplicate==FALSE)

         {



            display_error("unable to load specific class ".$class);


         }



   }



   function config($file, $user=FALSE, $fail=TRUE)

   {


      
      $Cl=object_controller();

      return $Cl->config->load_config($class, $user, $fail);


   }



   function component($object)

   {



      $Cl=object_controller();

      return $Cl->$object;


    }



    function prep_filename($filename, $extension)

    {



        if(!is_array($filename))

        {



            return array(strtolower(str_replace('.php', '', str_replace($extension, '', $filename)).$extension));


        }

        else

        {



            foreach($filename as $key => $value)

            {



                $filename[$key] =strtolower( str_replace('.php', '', str_replace($extension, '', $value)).$extension);


            }


            return $filename;


        }


    }



   function helpers($filename=array())

   {



      foreach($this->prep_filename($filename, '_helper') as $files)

      {



         $file_path=APP.'helper/'.$files.EXE;

         if(file_exists($file_path))

         {



              $base_file=BASE.'helper/'.$files.EXE;


              if(!file_exists($base_file))

              {



                 display_error("Unable to load this file ".$file_path. " it can be found in the  ".$base_file);


               }



 
              if(!isset($this->helper[$files]))

               {


                  continue;

               }



                $this->helper[$files]=TRUE;



               require($file_path);

               require($base_file);


            }




            foreach($this->helper_path as $key)
            {


               $file=$key.'helper/'.$files.EXE;

              if(file_exists($file))

               {


                   require($file);

                  $this->helper[$files]=TRUE;



               }


            }



            if(!isset($this->helper[$files]))

            {



               display_error("unable to load this file ".$files.EXE);

            }

      }

   }



   function get_help($filename)

   {



      return $this->helpers($filename);


   }



   function ini_class($class, $param=NULL, $object_name=NULL)

   {



      if(!class_exists($class))

      {



         display_error("calling undefine class ".$class." which does not exists");


      }



      $Cl=object_controller();


      $class=(isset($this->classes[$class]))? $this->classes[$class] : $class;



      if($object_name==NULL)

      {



            $object_name=$class;

       }



       $this->classes[$class]=$object_name;


      if($param !=NULL)
      {


          $Cl->$object_name=new $class($param);


      }

      elseif($param ==NULL)

      {



         $Cl->$object_name=new $class;


      }



   }




   function model($model, $name='', $conn=FALSE)

   {



      if(is_array($model))

      {



         foreach($model as $mod)

         {



            return $this->model($mod);


         }


      }



      if($model=='')

      {


         return '';

      }



       $path='';



      if($slash=strpos($model, '/') !== FALSE)

      {



         $path=substr($model, 0, $slash + 1);

         $model=substr($model, $slash + 1);


      }



      if($name=='')

      {



         $name=$model;


      }



      if(in_array($name, $this->models, TRUE))

      {



         return '';


      }




      $cl=object_controller();



      if(isset($cl->$name))

      {



         display_error("the model loading is one of the resource that be exists ".$models);


      }



      $found=FALSE;




      foreach($this->model_path as $base_path)

      {



         $file=$base_path.'model/'.$path.$model.EXE;



         if(file_exists($file))

         {



            $found=TRUE;


         }


      }



      if($found==TRUE)

      {


         if($conn !==FALSE)

         {



            if($conn ===TRUE)

            {



               $conn='';


            }



            return $cl->load->database($conn, FALSE, TRUE);


         }



         if(!class_exists('model'))

         {


            class_loader('model', 'core');


         }



         require($file);



         $cl->$name=new $model();



         $this->models[]=$model;



      }

      else

      {


            display_error("unable to locate this model ".$model);

      }


   }



   function database($param='', $return=FALSE, $active=NULL)

   {



          $cl=object_controller();



      if($return==FALSE  && $active==NULL && class_exists('db') && isset($cl->db) && is_object($cl->db))

      {



         return FALSE;


      }



      require(BASE.'database/db'.EXE);


      if($return==TRUE)

      {


         return Db($param, $active);


      }




     $cl->db=Db($param);


   }


   function add_path($path)
   {
      array_unshift($this->library,$path);
      array_unshift($this->model,$path);
      array_unshift($this->view,$path);
 
      $con=$this->conponent("config");

      array_unshift($con->config->config,$path);
   }

   function get_path($bool=FALSE)
   {

      return ($bool===TRUE) ? $this->library_path : $this->model_path;
   }

   function remove_path($path="")
   {

       $config=$this->component('config');

       if($path=="")
       {
 
          $void=array_shift($this->library_path);
          $void=array_shift($this->model_path);
          $void=array_shift($this->view_path);
       }
       else
       {

           foreach(array('library_path','model_path','view_path') as $paths)
           {

             if(($file=array_search($this->$paths,$path)))
             {
                unset($this->$paths[$file]);
             }
           }

           if(isset($config->config[$path]))
           {
              unset($config->config[$path]);
           }  
       }

       array_unque(array_merge($this->view_path, array(APP)));
       array_unque(array_merge($this->library_path, array(BASE,APP)));      
       array_unque(array_merge($this->moedl_path, array(BASE,APP)));
       array_merge($config->config->config, $path);
    }


   function drive($path,$param,$object)
   {

       if(!class_exists('library_class'))
       {
           require BASE.'library/library_driver.php';
       }
 
       if(!strpos($path,'/'))
       {
 
            $path=BASE.'library/'.Ucfirst($path).'/'.$path.EXE;
      }

      return $this->library($path,$param,$object);
   } 
  

}


?>