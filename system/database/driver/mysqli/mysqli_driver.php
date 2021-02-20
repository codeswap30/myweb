<?php


if(!defined("BASE"))exit("direct access not allow");



class db_mysqli_driver extends Db

{



   var $hacke=TRUE;

   var $escape_char='`';



   //connection to mysqli database

   /*
   @access public


   @param null

   @return void

   */



   function connect()

   {



      if($this->post!='')

      {



         return @mysqli_connect($this->hostname, $this->username, $this->password, $this->database, $this->post);

      }

      else
      {
  
       return @mysqli_connect($this->hostname, $this->username, $this->password,$this->database);
      }

    }



  //persist connection to mysql database

   /*
   @access public

   @param null
   @return void

   */



   function pconnect()

   {



      


      return $this->connect();

   }



   //select database


   /*

   @access public

   @param null

   @return void

   */



   function db_select()

   {



      return @mysqli_select_db($this->connect,$this->database);

   }



   function _set_charset($charset, $collation)

   {



      $this->use_name=(version_compare(PHP_VERSION, '5.2.3', '>=') && version_compare(mysqli_get_server_info(), '5.0.7', '>=')) ? FALSE : TRUE;


      if($this->use_name===TRUE)

      {



         return @mysqli_query("SET NAMES '".$this->escape_str(charset)."' COLLATE '".$this->escape_str($collate)."'", $this->connect);

      }

      else

      {



         return @mysqli_set_charset($charset, $this->connect);

      }


   }



   function execut($sql)

   {



      $sql=$this->remove_hacke($sql);

      return @mysqli_query($this->connect, $sql);

   }



   function remove_hacke($str)

   {


      if($this->hacke===TRUE)

      {



         if(preg_match("/^\s*DELETE\s+FROM\s+(\S+)\s*$/i", $str))

         {



            $str=preg_replace("/\s*DELETE\s+FROM\s+(\S+)\s*s/i", "DELETE FROM \\1 WHERE 1=1", $str);

         }


      }



      return $str;

   }



   function escape_str($str, $escape=FALSE)

   {



        if(is_array($str))

        {



            $val=array();


            foreach($str as $key => $value)

            {



                $val[$key]=$this->escape_identifier($value);

            }



            return $val;

        }



       if(function_exists('mysqli_escape_real_string'))

       {



         $str=@mysqli_escape_real_string($str);

       }

       elseif(function_exists('mysqil_escape_string'))

       {



         $str=mysqli_escape_string($str);

       }

       else

       {


         $str=addslashes($str);

       }



       if($escape==TRUE)

       {



         $str=str_replace(array('%', '_'), array('\\%', '\\_'), $str);

       }



      return $str;

   }



   function version()

   {


      return "SELECT version() as ver";

   }



   function affected_rows()

   {



      return @mysqli_affected_rows($this->connect);

   }



   function insert_id()

   {



      return @mysqli_insert_id($this->connect);

   }



   function show_table()

   {


      return "SHOW TABLES FROM ".$this->escape_identifier($this->database);

   }



   function show_column($table)

   {



      "SHOW COLUMNS FROM ".$this->_protect_identifier($table);

   }



   function _fields_data($table)

   {


      return "DESCRIBE ".$table;


   }



   function _insert($table, $column, $row)

   {



      return "INSERT INTO ".$table."(".implode(" , ", $column).") VALUES(".implode(" , ", $row).")";

   }



   function _truncate($table)

   {



      return "TRUNCATE ".$table;

   }



   function _update($table, $column, $where=array(), $orderby='', $limit=0)

   {



      $strval=array();


      foreach($column as $key => $value)

      {


         $strval[]=$key."=".$value;

      }



      $where=($where!='' || count($where)>=0) ? ' WHERE '.$where : " ";


      $orderby=($orderby !='') ? ", ORDER BY ".$orderby : "";



      //$limit=', LIMIT ';

      $limit.=($limit!=0 || is_numeric($limit)) ? $limit : 0;



      return "UPDATE ".$table." SET ".implode(",", $strval).$where.$orderby;

   }
   
   function _select($table, $column='*', $where='', $orderby='', $limit='',$start=0){
	  
      $where=(!empty($where)) ? ' WHERE '.$where : " ";
	  
	  if(is_array($column)){
		  $column = implode(",",$column);
	  }

      $orderby=($orderby !='') ? " ORDER BY ".$orderby : "";

        $start = ($start == 0 || !is_numeric($start)) ? 0 : $start;
        
      $lmt=($limit!=0 || is_numeric($limit)) ? ' LIMIT '.$start.','.$limit : " ";

        

      return "SELECT ".$column." FROM ".$table.$where.$orderby.$lmt;
   }
   
   function _delete($table, $where=array(), $like=array(), $limit=0)

   {


     
 if(count($where)>0 || count($like)>0)

      {

         $condition="\n WHERE ";

         $condition=implode("\n", $where);


         if(count($where)>0 && count($like)>0)

         {


            $condition.="AND";


         }



         $condition.=implode("\n", $like);

      }



      $limit=" LIMIT ";

      $limit=($limit==0 || !is_numeric($limit)) ? 0  :  $limit;



      return "DELETE FROM ".$table.$condition.$limit;

   }



   function _table($tables)

   {



      if(!is_array($tables))

      {



         $tables=array($tables);

      }



      return implode(" , ", $tables);

   }




   function _limits($off=0, $lmt='')

   {



      if($off!=0)

      {



         $off.=", ";

      }



      if(!is_numeric($lmt))

      {


         $lmt="";

      }


      return "LIMIT ".$off.$lmt;

   }



   function escape_identifier($string)

   {


      foreach($this->reservered_identifier as $item)

      {



        if(strpos($string, '.'.$item)!==FALSE)

        {



            $string=$this->escape_char.str_replace('.'.$item, $this->escape_char.'.'.$item, $string);


            return preg_replace("/[".$this->escape_char."]/", $this->escape_char, $string);

         }



      }



      if(strpos($string, '.')!==FALSE)

      {



         $string=$this->escape_char.str_replace('.', $this->escape_char.'.', $string).$this->escape_char;

      }

      else

      {


         $string=$this->escape_char.$string.$this->escape_char;


      }



      return preg_replace("/[".$this->escape_char."]/", $this->escape_char, $string);

   }



   function error_message()

   {


      return mysqli_error($this->connect);

   }



   function error_number()

   {


      return mysqli_errno($this->connect);

   }



   function _close($connect)

   {


      return @mysqli_close($connect);

   }


}
?>