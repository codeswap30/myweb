<?php

if(!defined('BASE'))exit("direct access not allow");

class log
{

  private $threshold=1;
  private $log_date='Y-m-d H:i:s';
  private $log_path;
  private $enable=TRUE;
  private $level=array('ERROR' => 1, 'DEBUG' => 2, 'INFO' => 3, 'ALL' => 4);

     function __construct()
     {

          $config=load_config();

          $this->log_path=($config['log_path'] !='') ? $config['log_path'] : APP.'log/';

          if(!is_dir($this->log_path) || not_writable($this->log_path)===FALSE)
          {

               $this->enable=FALSE;

          }

          if(is_numeric($config['threshold']))
          {

               $this->threshold=$config['threshold'];

          }

          if($config['date_format'] !='')
          {

               $this->date_fmt=$config['date_format'];

          }
     }

     function inbox_log($level='error', $msg)
     {

          if($this->enable===FALSE)
          {
     
               return FALSE;

          }

          $level=strtoupper($level);

          if(!isset($this->level[$level]) OR $this->level[$level] < $this-> threshold)
          {

               return FALSE;

          }

          $file=$this->log_path.date('Y-m-d ').'.txt';

          $message=$level.' '.(($level == 'INFO') ? ' - ' : ' - ').date($this->date_fmt).' ---> @ --->'.$msg."\n";

          if(!$fp=fopen($file, 'a'))
          {
               
               return FALSE;               
          }


          flock($fp, LOCK_EX);
          fwrite($fp, $message);
          flock($fp, LOCK_UN);
          fclose($fp);
          chmod($file, 0666);
          return TRUE;

     }

}
?>