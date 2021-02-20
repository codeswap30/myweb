<?php


if(!defined('BASE'))exit("direct access not allow");


class db_mysqli_result extends driver_result

{



    function num_rows()

    {



        return @mysqli_num_rows($this->result_id);

    }



    function num_fields()

    {



        return @mysqli_num_fields($this->result_id);

    }



    function list_field()

    {



        $field_names=array();

        while($field=mysqli_fetch_field($this->result_id))

        {



            $field_names[]=$field->name;

        }



        return $field_names;

    }



    function field_data()

    {



        $data=array();

        while($field=mysqli_fetch_object($this->result_id))

        {



            preg_match("/([a-zA-Z]+)(\(\d+\))?/", $field->Type, $match);


            $type=(array_key_exists($match, 1)) ? $match[1] : NULL;

            $length=(array_key_exists($match, 2)) ? preg_replace("/[^\d]/", '', $match[2]) : NULL;



            $f=new stdClass();


            $f->name=$field->Field;

            $f->type=$type;

            $f->default=$field->Default;


            $f->max_length=$length;

            $f->primary_key=($field->Key=='PRI') ? 1 : 0;



            $data[]=$f;


        }



        return $data;


    }



    function free_resource()

    {



        if(is_resource($this->result_id))

        {



            mysql_fress_resource($this->result_id);

            $this->result_id=FALSE;

        }


    }



    function data_seek($n)

    {


        return mysqli_data_seek($this->result_id, $n);

    }



    function fetch_object()

    {


        return @mysqli_fetch_object($this->result_id);

    }



    function fetch_assoc()

    {


        return @mysqli_fetch_assoc($this->result_id);

    }

}

?>