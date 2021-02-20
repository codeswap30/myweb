class user_agent
{

   var $agent=NULL;

   var $is_browser=FALSE;
   var $is_mobile=FALSE;
   var $is_robot=FALSE;


   var $language=array();
   var $charset=array();
 
   var $platforms=array();
   var $browsers=array();
   var $mobiles=array();
   var $robots=array();

   var $platform='';
   var $browser='';
   var $version='';
   var $robot='';
   var $mobile='';

   public function __construct()
   {

      if(isset($_SERVER['HTTP_USER_AGENT']))
      {
         $this->agent=trim($_SERVER['HTTP_USER_AGENT']);
      }

      if(!is_null($this->agent))
      {

         if($this->load_agent()===TRUE)
         {
           $this->compile_data();
         }
      }

      text_log('debug',"USER AGENT is intialize");

   }


   function load_agent()
   {

      if(defined('ENVIRONMENT') && file_exists(APP.'config/'.ENVIRONMENT.'/user_agent.php'))
      {

          include(APP.'config/'.ENVIRONMENT.'/user_agent.php');
      }
      elseif(file_exists(APP.'config/user_agent.php'))
      {

          include(APP.'config/user_agent.php');
      }
      else
      {

          return FALSE;
      }

      $return=FALSE;

      if(isset($browser))
      {
         $this->browsers=$browsers;
         unset($browsers);
         $return=TRUE;
      }

      if(isset($platforms))
      {
         $this->platforms=$platforms;
         unset($platforms);
         $return=TRUE;
      }

      if(isset($mobiles))
      {
         $this->mobiles=$mobiles;
         unset($mobiles);
         $return=TRUE;
      }

      if(isset($robots))
      {
         $this->robots=$robots;
         unset($robots);
         $return=TRUE;
      }

      return $return;     
   }


   function compile_data()
   {
  
     $this->set_platform();
 
      foreach(array('set_robot','set_mobile','set_browser') as $application)
      {

           if($this->$application()===TRUE)
           {
               break;
           }

       }

   }

   function set_platform()
   {

      if(is_array($this->platforms) AND count($this->platforms)>0)
      {

         foreach($this->platforms as $key=>$value)
         {

            if(preg_match("|".preg_quote($key)."|i",$this->agent))
            {

               $this->platform=$val;
               return TRUE;
            }
         }
       }

       $this->platform='Unknown Platform';
    }


   function set_browser()
   {

     if(is_array($this->browsers) AND count($this->browser)>0)
     {

        foreach($this->browsers as $key=>$val)
        {

            if(preg_match("|".preg_quote($key).".*?([0-9\.]+)|i", $this->agent, $match))
             {
                $this->is_browser=TRUE;  
                $this->browser=$val;
                $this->version=$match[1];
                $this->set_mobile();
                return TRUE;
             }
         }
      }

      return FALSE;

   }


   function set_robot()
   {

      if(is_array($this->robots) AND count($this->robots)>0)
      {

         foreach($this->robots as $key=>$value)
         {

            if(preg_match("|".preg_quote($key)."|i",$this->agent))
            {
               $this->robot=TRUE;
               $this->robot=$val;
               return TRUE;
            }
         }
       }

       return FALSE;
    }


   function set_mobile()
   {
  
     if(is_array($this->mobiles) AND count($this->mobiles)>0)
     {

        foreach($this->mobiles as $key=>$val)
        {

          if(preg_match("|".preg_match($)."|"))
   }   
}