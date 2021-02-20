<?php


if(!defined('BASE'))exit("direct access not allow");


class driver_result

{


    var $result_id;

    var $connect_id;

    var $result_array=array();

    var $result_object=array();

    var $custom_result_object=array();

    var $current_row;

    var $num_row;

    var $row_data;



    function result($object='array')

    {



        if($object=='array')

        {

            return $this->result_array();

        }

        elseif($object=='object')

        {

            return $this->result_object();

        }

        else

        {

            return $this->custom_result_object($object);

        }


    }



    function custom_result_object($class)

    {


        if(array_key_exists($class, $this->custom_result_object))

        {



            return $this->custom_result_object[$class];

        }



        if($this->result_id==FALSE || $this->num_row()==0)

        {

            return array();

        }



        $this->data_seek(0);


        $data=array();

        while($row=$this->fetch_object())

        {


            $object=new $class();

            foreach($row as $key=>$value)

            {



                $object->$key=$value;

            }



            $data[]=$object;

        }



        return $this->custom_result_object[$class]=$data;

    }




    function result_array()

    {



        if(count($this->result_array)>0)

        {



            return $this->result_array;

        }



        if($this->result_id===FALSE || $this->num_rows()==0)

        {


            return array();

        }


        $this->data_seek(0);


        while($row=$this->fetch_assoc())

        {



            $this->result_array[]=$row;

        }



        return $this->result_array;

    }



    function result_object()
 
    {



        if(count($this->result_object)>0)

        {



            return $this->result_object;

        }


        if($this->result_id===FALSE || $this->num_rows()==0)

        {

            return array();

        }



        $this->data_seek(0);

        while($row=$this->fetch_object())

        {



            $this->result_object[]=$row;

        }


        return $this->result_object;


    }


}
?>