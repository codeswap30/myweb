<?php
if(!defined("BASE"))exit("direct access not allow");

class db_mysql_driver extends Db
{

   var $hacke=TRUE;
   var $escape_char='`';

   //connection to mysql database
   /*
   @access public
   @param null
   @return void
   */

   function connect()
   {

      if($this->post!='')
      {

         $this->hostname.=':'.$this->post;
      }

      return @mysql_connect($this->hostname, $this->username, $this->password);
   }

  //persist connection to mysql database
   /*
   @access public
   @param null
   @return void
   */

   function pconnect()
   {

      if($this->post!='')
      {

         $this->hostname.=':'.$this->post;
      }

      return @mysql_pconnect($this->hostname, $this->username, $this->password);
   }

   //select database

   /*
   @access public
   @param null
   @return void
   */

   function db_select()
   {

      return @mysql_select_db($this->database, $this->connect);
   }

   function _set_charset($charset, $collation)
   {

      $this->use_name=(version_compare(PHP_VERSION, '5.2.3', '>=') && version_compare(mysql_get_server_info(), '5.0.7', '>=')) ? FALSE : TRUE;

      if($this->use_name===TRUE)
      {

         return @mysql_query("SET NAMES '".$this->escape_str(charset)."' COLLATE '".$this->escape_str($collate)."'", $this->connect);
      }
      else
      {

         return @mysql_set_charset($charset, $this->connect);
      }

   }

   function execut($sql)
   {

      $sql=$this->remove_hacke($sql);
      return @mysql_query($sql, $this->connect);
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

      if(function_exists('mysql_escape_real_string'))
      {

         $str=@mysql_escape_real_string($str);
      }
      elseif(function_exists('mysql_escape_string'))
      {

         $str=mysql_escape_string($str);
      }
      else
      {

         $str=addlashes($str);
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

      return @mysql_affected_rows($this->connect);
   }

   function insert_id()
   {

      return @mysql_insert_id($this->connect);
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

      $where=($where!='' || count($where)>=0) ? 'WHERE '.implode("\n", $where) : "";

      $orderby=($orderby !='') ? " ORDER BY ".$orderby : "";

      $limit=' LIMIT ';
      $limit.=($limit!=0 || is_numeric($limit)) ? $limit : 0;

      return "UPDATE ".$table." SET ".implode("\n", $strval).$where.$orderby.$limit;
   }

   function _delete($table, $where=array(), $like=array(), $limit=0)
   {
     
      if(count($where)>0 || count($like)>0)
      {
         $condition="\nWHERE";
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
      return mysql_error($this->connect);
   }

   function error_number()
   {
      return mysql_errno($this->connect);
   }

   function _close($connect)
   {
      return @mysql_close($connect);
   }
}
?>