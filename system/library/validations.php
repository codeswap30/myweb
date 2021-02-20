<?php
if(!defined('BASE'))exit("direct access not allow");

class validations
{


 
    var $object;
    var $field_data=array();
    var $rules=array();
    var $error_message=array();
    var $error_array=array();
    var $safe_form_data=FALSE;
    var $prefix="<p>";
    var $suffix="</p>";




    function __construct($rule=array())
    {

        $this->object=object_controller();
        $this->rules=$rule;

        if(function_exists('mb_internal_encoding'))
        {
            mb_internal_encoding("UTF-8");
        }

    }



    function set_data($field, $label='', $rules='')
    {

        if(count($_POST)==0)
        {
            return $this;
        }

        if(is_array($field))
        {


            foreach($field as $key)

            {



                if(!isset($key['field']) OR !isset($key['rule']))
                {

                    continue;
                }

                $label=($key['label'] == '' ) ? $key['field'] : $key['label'];
                $this->set_data($key['field'], $label, $key['rule']);


            }



            return $this;

        }



        if(!is_string($field) || !is_string($rules) || $field=='')

        {


            return $this;


        }



        $label=($label=='') ? $field : $label;



        $this->field_data[$field]=array('field' => $field, 'label' => $label, 'rule' => $rules, 'error' =>'', 'postdata' => NULL);



        return $this;

    }



    function get_postdata($field)

    {



        if(isset($this->field_data[$field]))

        {



            return $this->field_data[$field]['postdata'];

        }

    }



    function set_error($language, $value='')

    {



        if(!is_array($language))

        {



            $language=array($value);

        }



        $this->error_message=merge_array($this->error_message, $language);



        return $this;

    }



    function set_delimeter($prefix, $suffix)

    {



        $this->prefix=$prefix;

        $this->suffix=$suffix;



        return $this;

    }



    /*

    * @access public

    * @param string

    * @param string

    * @param string

    * return void

    */

 

   function errors($field, $prefix='', $suffix='')

    {



        if(!isset($this->field_data[$field]['error']) || $this->field_data[$field]['error'] =='')
        {



            return FALSE;

        }



        if($prefix=='')

        {



            $prefix=$this->prefix;

        }



        if($suffix=='')

        {



            $suffix=$this->suffix;

        }



        return $prefix.$this->field_data[$field]['error'].$suffix;

    }



    function error_strings()

    {



        if(count($this->error_array) ==0)

        {


            return '';

        }



        $str='';

        foreach($this->error_array as $key)

        {



            if($key!='')

            {


                $str.=$this->prefix.$key.$this->suffix."\n";


            }



        }



        return $str;

    }



    function run_form($group='')

    {



        if(count($this->field_data)==0)

        {



            if(count($this->rules)==0)

            {


                return FALSE;

            }




            $url=($group=='') ? trim($this->object->url->url_strings(), '/') : $group;



            if(isset($this->rules[$url]))

            {



                $this->set_data($this->rules[$url]);

            }

            else

            {



                $this->set_data($this->rules);

            }



            if(count($this->field_data)==0)

            {



                return FALSE;

            }



        }



        $this->object->language->load('validation_lang');



        foreach($this->field_data as $field => $row)

        {


             if(isset($_POST[$field]) && $_POST[$field] !='')

             {



                $this->field_data[$field]['postdata']=$_POST[$field];


             }

 

            $this->execute_data($row, $this->field_data[$field]['postdata'], explode('|', $row['rule']));



        }



        $total=count($this->error_array);



        if($total > 0)

        {



            $this->safe_form_data=TRUE;

        }



        //$this->reset_post_array();



        if($total==0)

        {


            return TRUE;

        }



        return FALSE;

    }

    function xxs_clean($str)
    {
       return $this->object->security->xss_clean($str);
    }



    function execute_data($row, $post, $rule, $i=0)

    {



        if(is_array($post))

        {



            foreach($post as $key => $value)

            {



                $this->execute_data($row, $value, $rule, $i);

                $i++;



            }



            return '';

        }



         $call=FALSE;



        if(!in_array('required', $rule) && is_null($post))

        {



            if(preg_match("/(call\w+(\{.*?\}))/i", implode(' ', $rule), $match))

            {



                $rule=array('1'=>$match[1]);

                $call=TRUE;

            }

            else

            {



                return '';

            }


        }



        if(is_null($post) && $call===FALSE)

        {


            if(in_array('isset', $rule) || in_array('required', $rule))

            {



                $type=(isset($rule['required'])) ? 'required' : 'isset';



                if(!isset($this->error_message[$type]))

                {



                    if(($line=$this->object->language->line($type)) ===FALSE)

                    {



                        $line="field name is not set";

                    }

                }

                else

                {



                    $line=$this->error_message[$type];


                }



                $message=sprintf($line, $this->translate_field($row['label']));


                $this->field_data[$row['field']]['error']=$message;



                if(!isset($this->error_array[$row['field']]))

                {



                    $this->error_array[$row['field']]=$message;

                }


            }



            return;


        }



        $_array=FALSE;


        foreach($rule as $rul)

        {



            $post=$this->field_data[$row['field']]['postdata'];



            if(substr($rul, 0, 5)=='call_')

            {

                 $rul=substr($rul, 5);

                  $call=TRUE;

            }



            $param=FALSE;



            if(preg_match("/(.*?)\{(.*)\}/", $rul, $match))

            {



                $rul=$match[1];

                $param=$match[2];

            }


            
if($call==TRUE)

            {



                if(method_exists($object, $rul))

                {



                    $result=$object->$rul($post, $param);


                    if($_array==TRUE)

                    {



                        $this->field_data[$row['field']]['postdata']['$i']=(is_bool($result)) ? $post : $result;


                    }

                    else

                    {


                        $this->field_data[$row['field']]['postdata']=(is_bool($result)) ? $post : $result;


                    }



                }



                if(!in_array('required', $rule, TRUE) AND $result !==FALSE)

                {



                    continue;

                }


            }

            else

            {


                if(!method_exists($this, $rul))

                {



                    if(function_exists($rul))

                    {



                        $result=$rul($post);




                        if($_array===TRUE)

                        {



                            $this->field_data[$row['field']]['postdata'][$i]=(is_bool($result)) ? $post : $result;

                        }
                        else

                        {



                            $this->field_data[$row['field']]['postdata']=(is_bool($result)) ? $post : $result;



                        }



                    }

                    else

                    {



                         text_log("error", "Unable to find the validation ".$rul);


                    }



                    continue;


                }



                $result=$this->$rul($post, $param);


                if($_array==TRUE)

                {

                    $this->field_data[$row['field']]['postdata'][$j]=(is_bool($result)) ? $post : $result;
                }
                else
                {

                    $this->field_data[$row['field']]['postdata']=(is_bool($result)) ? $post : $result;

                }

            }

            if($result===FALSE)
            {

                if(!isset($this->error_message[$rul]))
                {

                     if(($line=$this->object->language->line($rul)) === FALSE)
                       {


                         $line="Unable to load this message ".$rul;

                     }

                }
                else
                {

                    $line=$this->error_message[$rul];

                }

               if(isset($this->field_data[$param]) && isset($this->field_data[$param]['label']))
               {

                   $param=$this->translate_field($this->field_data[$param]['label']);

                }

                $message=sprintf($line, $this->translate_field($row['label']), $param);
                //$message=$line;
                $this->field_data[$row['field']]['error']=$message;

                if(!isset($this->error_array[$row['field']]))
                {

                   $this->error_array[$row['field']]=$message;

               }

               return '';               
 
            }

        }
    }

    function translate_field($fieldname)
    {

        if(substr($fieldname, 0, 5)=='lang:')
        {

            $line=substr($fieldname, 5);

            if(($this->object->language->line($line))===FALSE)
            {

                return $line;

            }

        }

        return $fieldname;

    }


    function set_value($field, $value)
    {

        if(!isset($this->field_data[$field]))
        {

            return $value;
        }

        if(isset($this->field_data[$field]['postdata']))
        {

            return array_shift($this->field_data[$field]['postdata']);
        }

        return $this->field_data['$field']['postdata'];

    }

    function required($str)
    {

        if(!is_array($str))
        {

            return (trim($str)=='') ? FALSE : TRUE;
        }
        else
        {

            return (!empty($str));
        }

    }


    function regs_match($str, $regular)
    {

        if(preg_match($str, $regular))
        {

            return TRUE;
        }

        return FALSE;

    }

    function matche($field, $str)
    {

        if(!isset($_POST[$str]))
        {

            return FALSE;
        }

        return ($field ==$_POST[$str]) ? TRUE : FALSE;
    }


    function min_len($field, $num)
    {

        if(!preg_match("/^[0-9]$/i", $num))
        {
            return FALSE;
        }

        if(!function_exists('mb_strlen'))
        {
            return (mb_strlen($field) < $num) ? FALSE : TRUE;

        }

        return (strlen($field) < $num) ? FALSE : TRUE;

    }

    function max_len($field, $num)
    {

        if(!preg_match("/^[0-9]$/i", $num))
        {
            return FALSE;
        }

        if(!function_exists('mb_strlen'))
        {
            return (mb_strlen($field) > $num) ? FALSE : TRUE;

        }

        return (strlen($field) > $num) ? FALSE : TRUE;

    }

    function exact_len($field, $num)
    {

        if(!preg_match("/^[0-9]$/i", $num))
        {
            return FALSE;
        }
		
		$field = (string)$field;
		
		
        if(!function_exists('mb_strlen'))
        {
            return (mb_strlen($field) != $num) ? FALSE : TRUE;

        }
        return (strlen($field) != $num) ? FALSE : TRUE;

    }

    function valid_email($email)
    {
        return (preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9+\_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/xi", $email)) ? TRUE : FALSE;
    }

    function valid_emails($emails)
    {

        if(strpos($emails, ',') ===FALSE)
        {

            return $this->valid_email($emails);
        }

        foreach($emails as $email)
        {

            if(trim($email)!='' && $this->valid_email(trim($email)) ===FALSE)
            {
                return FALSE;
            }

            return TRUE;

        }

    }

    function alphabet($str)
    {

        return (preg_match("/^([a-z])+$/i", $str)) ? TRUE : FALSE;
    }

    function num($str)
    {

        return (preg_match("/^([0-9])+$/i", $str)) ? TRUE : FALSE;
    }

    function alphnum($str)
    {
        return (preg_match("/^([a-z0-9])+$/i", $str)) ? TRUE : FALSE;
    }

    function alphnum_dash($str)
    {
        return (preg_match("/^([-a-z0-9_-])+$/i", $str)) ? TRUE : FALSE;
    }

    function numeric($num)
    {

        return (bool)preg_match("/^[\-+]?[0-9]*\.?[0-9]+$/", $num);
    }

    function integer($num)
    {

        return (bool)preg_match("/^[\-+]?[0-9]+$/", $num);
    }

    function decimal($num)
    {

        return (bool)preg_match("/[\-+]?[0-9]*\.?[0-9]+/", $num);
    }

    function not_match($post, $str)
    {

        if(!isset($_POST[$str]))
        {
            return FALSE;
        }

        return ($post==$_POST[$str]) ? FALSE : TRUE;
    }

    function is_numeric($num)
    {

        return (is_numeric($num)) ? TRUE : FALSE;
    }

    function greater_than($num, $num1)
    {

        if(!is_numeric($num)) return FALSE;

        return ($num > $num1 ) ? TRUE : FALSE;
    }

    function less_than($num, $num1)
    {

        if(!is_numeric($num)) return FALSE;

        return ($num < $num1 ) ? TRUE : FALSE;
    }

    function natural_number($num)
    {

        return (preg_match("/^[0-9]$/", $num)) ? TRUE : FALSE;
    }

    function natural_without_zero($num)
    {

        if(!preg_match("/^[0-9]$/", $num)) return FALSE;

        if($num==0) return FALSE;

        return TRUE;
    }

    function base64($num)
    {

        return (bool)!preg_match("/[^a-zA-Z0-9\/\+=]/", $num);

    }

    function prep_for_form($str)
    {
    
        if(is_array($str))
        {

            foreach($str as $key => $value)
            {

                $str[$key]=$this->prep_for_form($value);
            }

            return $str;

        }

        if($this->safe_form_data===FALSE && $str=='')
        {

            return $str;
        }

        return str_replace(array("'", '"', "<", ">"), array("&#39", "&quot", "&lt;", "&gt;"), stripslashes($str));
    }

    function prep_for_url($url='')
    {

        if($url=='http' || $url=='')
        {

            return FALSE;
        }

        if(substr($url, 0, 7) !='http://' || substr($url, 0, 8) !='https://')
        {

            $str="http://".$str;
        }

        return $str;
    }

    function encode_tags($str)
    {
        return str_replace(array("<?php", "<?PHP", "<?", "?>"), array("&lt;?php", "&lt;?PHP", "&lt;?", "?&gt;"), $str);
    }

    function xss_clean($post)
    {
        $this->object->security->xss_clean($post);
    }

    /*function reset_post_array()
    {

        foreach($this->field_data as $key => $value)
        {

            if(!is_null($value['postdata']))
            {
                 if(is_array($value['postdata']))
                {

                     $arr=array();
                     foreach($value['postdata'] as $k => $v)
                     {

                         $arr[$k]=$this->prep_for_form($v);

                       }

                       $post=$post[$arr];

                 }
                 else
                {

                       $post=$this->prep_for_form($value['postdata']);

                }
          } 
    }*/

}
?>