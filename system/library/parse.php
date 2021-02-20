<?php
class parse
{

    var $l_per='{';
    var $r_per='}';
//[update]
    var $object;

    function __construct()
    {

        $this->object=object_controller();
    }

    function parse_page($page, $data, $return=FALSE)
    {

        $page=$this->object->load->views($page, $data, TRUE);

        return $this->parses($page, $data, $return);

    }

    function parse_string($page, $data, $return=FALSE)
    {

        return $this->parses($page, $data, $return);

    }

    function parses($page, $data, $return)
    {

        if($page=='')
        {

            return FALSE;
        }

        foreach($data as $key => $value)
        {

            if(is_array($value))
            {
                $page=$this->pair_parse($key, $value, $page);

            }
            else
            {

                $page=str_replace($this->l_per.$key.$this->r_per, (string)$value, $page);
            }

        }

        if($return==FALSE)
        {

            $this->object->send_output->append_output($page);

        }


        return $page;

    }


    function pair_parse($key, $value, $page)
    {

        if(!$match=$this->parse_match($key, $page))
        {

            return $key;
        }

        $str='';
        foreach($value as $row)
        {

            $temp=$match['1'];

            foreach($row as $k => $v)
            {

                if(!is_array($v))
                {

                    $page=preg_replace("/(".$this->l_per.$k.$this->r_per.")+/i",  $v,  $page);
                }
                else
                {

                    $page=str_replace($this->l_per.$k.$this->r_per, $v, $page);

                }

            }

        }

        $str.=$temp;

        return str_replace($match[0], $str, $page);

    }

    function parse_match($variable, $page)
    {

        if(!preg_match("|".preg_quote($this->l_per).$variable. preg_quote($this->r_per)."(.+?)".preg_quote($this->l_per)."/".$variable.preg_quote($this->r_per)."|s", $page, $match) )
        {

            return FALSE;

        }

        return $match;
    }

    function set_delimiter($per1, $per2)
    {

        $this->l_per=$per1;
        $this->r_per=$per2;
    }
}
?>