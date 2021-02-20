<?php
if(!defined('BASE'))exit("direct access not allow");


class db_driver

{



    var $hostname='localhost';

    var $username='';

    var $password='';

    var $driver='mysql';

    var $database='mysql';

    var $post='';

    var $result_id=FALSE;

    var $connect=FALSE;

    var $pconnect=FALSE;

    var $db_debug=TRUE;

    var $db_charset='UTF-8';

    var $db_collation='general_utf8';

    var $count_query=0;

    var $total_time=0;

    var $bind_mark='?';



    //reserve identifier

    var $reservered_identifier=array("*");

   var $_protect_identifier=TRUE;



    function __construct($param)

    {



        if(is_array($param))

        {

            foreach($param as $key => $value)

            {



                $this->$key=$value;


            }

        }



        text_log('debug', "database class initialize");

    }



    function autoinit()

    {



        $this->connect=($this->pconnect===FALSE) ? $this->connect() : $this->pconnect();



        if($this->connect===FALSE)

        {



            text_log('error', "error in database connection string");



            if($this->db_debug===TRUE)

            {



                $this->display_error('db_invalid_connection_string');

            }



            return FALSE;

        }

 

       if($this->database !='')

        {


            if(!$this->db_select())

            {


                text_log('error', "db invalid select in the database");



                if($this->db_debug===TRUE)

                {



                    $this->display_error("db_invalid_select", $this->database);

                }



                return FALSE;


            }

        }

        else

        {


            if(!$this->set_charset())

            {



                return FALSE;

            }


            return FALSE;

        }



        return TRUE;

    }



    function set_charset()

    {

        if(!$this->_set_charset($this->db_charset, $this->collation))

        {


            if($db_debug===TRUE)

            {



                $this->display_error('db_invalid_charset', $this->db_charset);

            }


            return FALSE;


        }



        return TRUE;

    }



    function platform()

    {


        return $this->driver;

    }



   function real_string($string)

   {



      if(is_string($string))

      {



         $string= "'".$this->escape_str($string)."'";

      }
      elseif(is_bool($string))

      {



         $string=($string==TRUE ) ? 1 : 0;

      }

      elseif(is_null($string))

      {



         $string='NULL';

      }



      return $string;

   }



   function like_real_string($string)

   {


       return $this->escape_str($string, TRUE);

   }



   function insert($table, $field, $value='')

   {



        if(!is_array($field))

        {


            $field=array($value);

        }



        $column=array();


        $row=array();


        foreach($field as $key => $val)

        {



            $column[]=$this->_protect_identifier($key);

            $row[]=$this->real_string($val);

       }


 
      return $this->_insert($this->_protect_identifier($table), $column, $row);

   }



    function update($table, $data, $where)

    {



        $field=array();


        foreach($data as $key => $value)

        {



            $field[$this->_protect_identifier($key)]=$this->real_string($value);

        }



        if(!is_array($where))

        {


            $where=array($where);

        }



        $x=0;


        foreach($where as $k => $v)
        {

            $con=($x==0) ? '' : ' AND ';
            $where=$con.$this->_protect_identifier($k).'='.$this->real_string($v);
			
        }



        return $this->_update($this->_protect_identifier($table), $field, $where);

    }
	
	
	function select($table, $column='*', $where='', $orderby='', $limit='', $condition='',$start=0){
		
        $field=array();
        
        if($where != "" && !empty($where) && count($where)>0){
        
            if(!is_array($where))
            {
                $where=array($where);
            }
        }
        
        if(!is_array($condition) && $condition!=""){
            $condition = array($condition);
        }


        if($where != "" && !empty($where) && count($where)>0){
            $x=0;

            foreach($where as $k => $v)
            {
			    if($x==0){
				    $con = '';
			    }else{
			        
			        $con = ($condition[$x]=="") ? '' : $condition[$x];
				    
			    }
			    if($x==0){
                    $where=$con.$this->_protect_identifier($k).'='.$this->real_string($v);
			    }else{
			        $where.=$con.$this->_protect_identifier($k).'='.$this->real_string($v);
			    }
			    $x++;
            }
            //$check = true;
        
        }
        
        return $this->_select($this->_protect_identifier($table),$column,$where,$orderby,$limit,$start);
        
	}


    function has_operator($str)

    {



        if(!preg_match("/\s|<|>|!|=|is null|is not null/i", $str))

        {


            return FALSE;

        }


        return TRUE;

    }



   function simple_query($string)

   {

      return $this->execut($string);


   }



   function query($sql='', $bind='')

   {



        if($sql=='')

        {


           
 if($this->db_debug===TRUE)

            {


                $this->display_error("db_invalid_string");

            }



            return FALSE;

        }



        $sql=$this->query_bind($sql, $bind);



        $driver=$this->load_rdriver();



        $this->count_query=0;


        $timer1=microtime();



        if(FALSE===($this->result_id=$this->simple_query($sql)))

        {



            $error=$this->error_message();

            $number=$this->error_number();



            text_log('error', "error in query ".$error);




            if($this->db_debug===TRUE)

            {

                $this->display_error(array("Error Message ".$error, "Error Message ".$number, $sql));


            }



            return FALSE;

        }



        $res=new $driver();

        $res->connect_id=$this->connect;

        $res->result_id=$this->result_id;


        $timer2=microtime();


        list($x, $y)=explode(' ', $timer1);

        list($x1, $y1)=explode(' ', $timer2);


        $this->total_time=($y1+$x1) - ($y + $x);


        $this->count_query++;



        return $res;

    }



    function load_rdriver()

    {



        $driver='db_'.$this->driver.'_result';



        if(!class_exists($driver))

        {



            include_once(BASE.'database/driver_result'.EXE);

            include_once(BASE.'database/driver/'.$this->driver.'/'.$this->driver.'_result'.EXE);

       }



        return $driver;

    }



    function query_bind($str, $bind='')

    {


        if($bind=='')

        {

            return $str;

        }



        if(strpos($str, $bind)===FALSE)

        {



            return $str;

        }



        if(!is_array($bind))

        {

            $bind=array($bind);

        }



        $seg=explode($this->bind_mark, $sql);



        if(count($bind)>=$seg)

        {



            $bind=array_slice($bind, 0, count($seg)-1);

        }



        $result=$segment[0];

        $i=0;



        foreach($bind as $key)

        {



            $result=$this->clean_string($bind);

            $result=$seg[++$i];


       }



      return $result;


    }



    function write_type($sql)

    {



       if ( ! preg_match('/^\s*"?(SET|INSERT|UPDATE|DELETE|REPLACE|CREATE|DROP|TRUNCATE|LOAD DATA|COPY|ALTER|GRANT|REVOKE|LOCK|UNLOCK)\s+/i', $sql))

        {


            return FALSE;

        }



        return TRUE;

    }



    function total_query()

    {


        return $this->count_query;

    }



    function time_query()

    {


        return number_format($this->total_time, 4);

    }



    function close_db()

    {



        return $this->_close($this->connect);

    }



    function display_error($error, $swap='', $native=TRUE)

    {



        $lang=class_loader('language','library');


        $lang->load('db');



        $heading=$lang->line('db_error_occur');



        if($native===FALSE)

        {



            $message=$error;

        }

        else

        {



            $message=(is_array($error)) ? $error : array(str_replace("%s", $swap, $lang->line($error)));

        }



        $file=debug_backtrace();



        foreach($file as $fil)

        {



            if(isset($fil['file']) && strpos($fil['file'], BASE.'database')===FALSE)

            {



                $message[]="<br/> File: ".str_replace(array(BASE, APP), '', $fil['file'])."<br/>";
                $message[]="Line: ".$fil['line']."<br/>";


                break;

            }

        }



        $err=class_loader('exceptions','core');


        echo $err->general_error($heading, $message, 'db_error');

        exit;


    }



    function _protect_identifier($item, $protect=NULL)

    {



        $protect=(!is_bool($protect)) ? $this->_protect_identifier : $protect;



        if(is_array($item))

        {


            $escape_array=array();


            foreach($item as $k => $v)

            {



                $escape_array[$this->_protect_identifier($k)]=$this->_protect_identifier($v);

            }



            return $escape_array;

        }



        $item=preg_replace("/[\t]+/", " ", $item);



        if(strpos($item, " ")!==FALSE)

        {



            $alias=strstr($item, " ");

            $item=substr($item, 0, -strlen($alias));

        }

        else

        {


            $alias="";

        }



        if(strpos($item, '(')!==FALSE)

        {



            return $item.$alias;

        }



        if(strpos($item, '.')!==FALSE)

        {


            $parts=explode('.', $item);



            if($protect===TRUE)

            {



                foreach($parts as $key => $value)

                {



                    if(!in_array($value, $this->reservered_identifier))

                    {


                        $parts[$key]=$this->escape_identifier($value);

                    }



                 }



             }



             $item=implode('.',$parts);


             return $item.$alias;


        }




        if($protect===TRUE)

        {



            $item=$this->escape_identifier($item);

        }



        return $item.$alias;

     }

}

?>