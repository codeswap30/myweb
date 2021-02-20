<?php
if(!defined("BASE"))exit("direct access not allow");
class upload
{

    public $max_size=0;
    public $max_width=0;
    public $max_height=0;
    public $max_filename=0;
    public $image_height;
    public $image_width;
    public $image_size_str;
    public $image_type="";
    public $allow_type="";
    public $temp_name="";
    public $file_name="";
    public $file_size="";
    public $file_type="";
    public $file_ext="";
    public $mines=array();
    public $error_msg=array();
    public $upload_path="";
     public $xss_clean=FALSE;
    private $file_name_overwrite='';
    public $client_name='';
    public $encrypt_name=FALSE;
    public $overwrite=FALSE;
    public $is_image=FALSE;
    public $file_orig="";
    public $remove_space=TRUE;

    function __construct($data=array())
    {

        if(count($data)>0)
        {

            $this->initialize($data);
        }

        text_log("debug", "upload class initialize");
    }

    function initialize($data)
    {

        $default=array(
                'max_size' => 0, 
                'max_width' => 0, 
                'max_height' => 0, 
                'max_filename' => 0, 
                'allow_type' => '*',
                'upload_path' => '', 
                'temp_name' => '', 
                'file_name' => '', 
                'file_type' => '', 
                'file_ext' =>'', 
                'xss_clean'=>FALSE,
                'file_size' =>'', 
                'image_width' => '', 
                'image_height' => '', 
                'image_size_str' => '', 
                'encrypt_name' => FALSE
                );

        foreach($default as $key => $value)
        {

            if(isset($data[$key]))
            {

                $method='set_'.$key;

                if(method_exists($this, $method))
                {
                    $this->$method($data[$key]);
                }
                else
                {

                    $this->$key = $data[$key];
                }
            }
            else
            {

                $this->$key=$value;
            }

        }

        $this->file_name_overwrite=$this->file_name;
    }

    function upload_data()
    {

        $data=array(
                    'file_name'=> str_replace($this->file_ext, '', $this->file_name), 
                    'file_type'=> $this->file_type, 
                    'file_size'=> $this->file_size, 
                    'temp_name'=> $this->temp_name, 
                    'file_path'=> $this->upload_path.$this->file_name,
                    'file_ext'=> $this->file_ext
                );

        return $data;
    }

    function valid_path()
    {

        if($this->upload_path=='')
        {

            $this->set_error('upload_no_path');
            return FALSE;
        }

        if(function_exists('realpath') && realpath($this->upload_path)!==FALSE)
        {

                $this->upload_path=str_replace("\\", "/", realpath($this->upload_path));
        }


        if(!is_dir($this->upload_path))
        {

            $this->set_error("upload_invalid_path");
            return FALSE;
        }

        $this->upload_path=preg_replace("/(.+?)\/*$/", "\\1/", $this->upload_path);
        return TRUE;
    }

    function get_extension($filename)
    {

        $ext=explode('.', $filename);
        return '.'.end($ext);
    }

    function set_upload($field='file')
    {

        if(!isset($_FILES[$field]))
        {
			

            $this->set_error("upload_no_file_selected");
            return FALSE;
        }

        if(!$this->valid_path())
        {

            return FALSE;
        }

        if(!is_uploaded_file($_FILES[$field]['tmp_name']))
        {

           $error=(!isset($_FILES[$field]['error'])) ? 4 : $_FILES[$field]['error'];

            switch($error)
            {

                case 1:
                        $this->set_error("upload_file_exceed_limit");
                break;
                case 2:
                        $this->set_error("upload_file_exceed_form_limit");
                break;
                case 3:
                        $this->set_error("upload_file_partial");
                break;
                case 4:
                        $this->set_error("upload_no_file_selected");
                break;
                case 6:
                        $this->set_error("upload_no_temp_directory");
                break;
                case 7:
                        $this->set_error("upload_unable_to_write_file");
                break;
                case 8:
                        $this->set_error("upload_stopped_by_extension");
                break;
                default:
                        $this->set_error("upload_no_file_selected");
            }
             return FALSE;
        }

      $this->temp_name=$_FILES[$field]['tmp_name'];
      $this->file_size=$_FILES[$field]['size'];
       $this->file_mime_type($_FILES[$field]);
        $this->file_type=preg_replace("/^(.+?);.*$/", "\\1", $this->file_type);
        $this->file_type=strtolower(trim(stripslashes($this->file_type), '"'));
      $this->file_name=$this->prep_filename($_FILES[$field]['name']); 
      $this->file_ext=$this->get_extension($this->file_name);
      $this->client_name=$this->file_name;

        if(!$this->allow_filetype())
        {

            $this->set_error('upload_invalid_filetype');
            return FALSE;
        }

        if($this->file_name_overwrite!='')
        {

            $this->file_name=$this->prep_filename($this->file_name_overwrite);

            if(strpos($this->file_name_overwrite, '.')===FALSE)
            {
                $this->file_name.=$this->file_ext;
            }
            else
            {

                $this->file_ext=prep_filename($this->file_name_overwrite);
            }
        }

        if(!$this->allow_filetype(FALSE))
        {
              $this->set_error('upload_invalid_filetype');
              return FALSE;
        }

        if($this->file_size>0)
        {
            $this->file_size=round($this->file_size/1024, 2);
        }

        if(!$this->allow_filesize())
        {

            $this->set_error('upload_invalid_filesize');
            return FALSE;
        }

        if(!$this->image_allow_dimension())
        {

            $this->set_error('upload_invalid_dimension');
            return FALSE;
        }

        $this->file_name=$this->clean_filename($this->file_name);

        if($this->max_size>0)
        {

            $this->filename=$this->limit_filename_length($this->file_name, $this->max_size);
        }

        if($this->remove_space==TRUE)
        {

            $this->file_name=preg_replace("/\s+/","_", $this->file_name);
        }

        $this->original_name=$this->file_name;

        if($this->overwrite==FALSE)
        {

            $this->file_name=$this->set_filename($this->upload_path, $this->file_name);

            if($this->file_name==FALSE)
            {
                return FALSE;
            }
        }

        if(!@copy($this->temp_name, $this->upload_path.$this->file_name))
        {
            if(!@move_uploaded_file($this->temp_name, $this->upload_path.$this->file_name))
            {

                $this->set_error('upload_destination_error '.$this->upload_path.$this->file_name);
                return FALSE;
            }
        }

        $this->set_image_property($this->file_name);

        return TRUE;
   }

    function set_filename($path, $filename)
    {

        if(!file_exists($path.$filename))
        {
            return $filename;
        }

        if($this->encrypt_name==TRUE)
        {

            mt_srand();
            $filename=md5(uniqid(mt_rand())).$this->file_ext;
        }

        $filename=str_replace($this->file_ext, '', $filename);

        $new_filename='';
        $i=1;
        while($i<1000)
        {

            if(!file_exists($path.$filename.$i.$this->file_ext))
            {

                $new_filename=$filename.$i.$this->file_ext;
                break;
            }
            $i++;
        }

        if($new_filename=='')
        {

            $this->set_error("upload_bad_filename");
            return FALSE;
        }
        else
        {
            return $new_filename;
        }
    }

    function set_upload_path($path)
    {

        if($path=='' || empty($path))
        {
            $this->set_error('upload_no_path');
            return FALSE;
        }

        $this->upload_path=ltrim($path, '/').'/';
    }

    function mime_types($mime)
    {

        global $mimes;

        if(file_exists(APP.'config/mimes'.EXE))
        {

            include(APP.'config/mimes'.EXE);
        }
        else
        {

            return FALSE;
        }

        $this->mimes=$mimes;
        unset($mimes);

        return (isset($this->mimes[$mime])) ? $this->mimes[$mime] : FALSE;
    }

    function prep_filename($filename)
    {

        if(strpos($filename, '.')===FALSE || $this->allow_type=='*')
        {

            return $filename;
        }

        $parts=explode('.', $filename);

        $ext=array_pop($parts);
        $filename=array_shift($parts);

        foreach($parts as $part)
        {

            if(!in_array(strtolower($part), $this->allow_type) || $this->mime_type($part)===FALSE)
            {

                $filename.='.'.$part.'_';
            }
            else
            {

                $filename.='.'.$part;
            }

        }

        $filename.='.'.$ext;

        return $filename;
    }

    function file_mime_type($file)
    {

        $reg="/^([a-z\-]+\/[a-z0-9\-\.\+]+)(;\s.+)?$/";

        if(function_exists('finfo_file'))
        {

            $finfo=finfo_open(FILEINFO_MIME);
            if(is_resource($finfo))
            {

                $mime=finfo_file($finfo, $file['tmp_name']);
                finfo_close($finfo);

                if(is_string($mime) && preg_match($reg, $mime, $matches))
                {

                    $this->file_type=$matches[1];
                    return;
                }

            }
    
        }

        if(DIRECTORY_SEPARATOR=='\\')
        {

            $cmd='file --brief --mime ' . escapeshellarg($file['tmp_name']) . '2>&1';

            if(function_exists('exec'))
            {

                $mime=@exec($cmd, $mime, $status);
                if($status===0 && is_string($mime) && preg_match($reg, $mime, $matches))
                {

                    $this->file_type=$matches[1];
                    return;
                }
            }

            if((bool)@ini_get('safe_mode')===FALSE && function_exists('shell_exec'))
            {

                $mime=@shell_exec($cmd);

                if(strlen($mime) >0)
                {

                    $m=explode("\n", trim($mime));
                    if(preg_match($reg, $m[count($m)-1], $matches))
                    {

                        $this->file_type=$matches[1];
                        return;
                    }

                }
            }

            if(function_exists('popen'))
            {

                $pro=@popen($cmd, 'r');
                if(is_resource($pro))
                {

                    $mime=fread($pro, 512);
                    pclose($pro);

                    if($mime!==FALSE)
                    {

                        $mime=explode("\n", $mime);
                        if(preg_match($reg, $mime[count($mime)-1], $matches))
                        {

                            $this->file_type=$matches[1];
                            return;
                        }

                    }
                }
            }
        }

       if(function_exists('mime_content_type'))
        {

            $mime=@mime_content_type($file['tmp_name']);
            if(strlen($mime)>0)
            {

                $this->file_type=$mime;
                return;
            }

        }

        $this->file_type=$file['type'];
    }

    function set_max_size($num)
    {

        $this->max_size=((int)$num < 0) ? 0 : (int)$num;
    }

    function set_max_filename($num)
    {

        $this->max_filename=((int)$num < 0) ? 0 : (int)$num;
    }

    function set_max_height($num)
    {

        $this->max_height=((int)$num < 0) ? 0 : (int)$num;
    }

    function set_max_width($num)
    {

        $this->max_width=((int)$num < 0) ? 0 : (int)$num;
    }

    function set_allow_type($file)
    {

        if(!is_array($file) && $file=='*')
        {

            $this->allow_type="*";
            return;
        }

        $this->allow_type=explode('|', $file);
    }

    function set_xss_clean($flag=FALSE)
    {

        $this->xss_clean=($flag===FALSE) ? FALSE : TRUE;
    }

    function is_image()
    {

        $png=array('image/x-png');
        $jpg=array('image/jpg','image/jpe','image/jpeg','image/pjpeg');
        $img=array('gif','png','jpeg');

        if(in_array($this->file_type, $png))
        {
            $this->file_type='image/x-png';
        }

        if(in_array($this->file_type, $jpg))
        {
            $this->file_type='image/jpeg';
        }

        return (in_array($this->file_type, $img, TRUE)) ? TRUE : FALSE;
    }

    function set_image_property($path)
    {

        if(!$this->is_image())
        {
            return;
        }

        if(function_exists('getimagesize'))
        {

            if(FALSE!==($detail=getimagesize($path)))
            {

                $type=array(1=>'gif', 2=>'png', 3=>'jpeg');

                $this->image_height=$detail[1];
                $this->image_width=$detail[0];
                $this->image_type=(!isset($type[$detail[2]])) ? 'known' : $type[$detail[2]];
                $this->image_size_str=$detail[3];
            }
        }
    }

    function allow_filetype($no_mime=FALSE)
    {

        if($this->allow_type=='*')
        {
            return TRUE;
        }

        if(count($this->allow_type)==0 || !is_array($this->allow_type))
        {
            $this->set_error('upload_no_allow_type');
            return FALSE;
        }

        $ext=strtolower(ltrim($this->file_ext, '.'));
        
        if(!in_array($ext, $this->allow_type))
        {
            return FALSE;
        }

        $image_ext=array('gif', 'jpg', 'jpeg', 'jpe', 'png');

        if(in_array($ext, $image_ext))
        {

            if(getimagesize($this->temp_name)===FALSE)
            {

                return FALSE;
            }
        }

        if($no_mime==FALSE)
        {
            return TRUE;
        }

        $mime=$this->mime_types($ext);

        if(is_array($mime))
        {
            if(in_array($this->file_type, $mime, TRUE))
            {

                return TRUE;
            }
        }
        else
        {

            if($this->file_type==$mime)
            {
                return TRUE;
            }
        }

        return FALSE;
    }

    function allow_filesize()
    {

        if($this->max_size !=0 AND $this->max_size< $this->file_size)
        {

            return FALSE;
        }

        return TRUE;
    }

    function clean_filename($filename)
    {

        $bad=array("<!--", "-->", "'", ">", "<", '"', '&', '?', '=', '/', '$', ';', "%20", "%22", "%3c", "%253c", "%3e", "%0e", "%28", "%29", "%2528", "%26", "%24", "%3f", "%3b", "%3d");

        $filename=str_replace($bad, '', $filename);

        return stripslashes($filename);
    }

    function image_allow_dimension()
    {

        if(!$this->is_image())
        {
            return TRUE;
        }

        if(function_exists('getimagesize'))
        {
    
            $f=getimagesize($this->temp_name);
            if($this->max_width>0 AND $f[0]>$this->max_width)
            {

                return FALSE;
            }

            if($this->max_height>0 AND $f[1] > $this->max_height)
            {
                return FALSE;
            }

            return TRUE;
        }

        return TRUE;
    }

    function limit_filename_length($filename, $length)
    {

        if(strlen($filename)<$length)
        {
            return $filename;
        }

        $ext='';
        if(strpos($filename, '.')!==FALSE)
        {

            $parts=explode('.', $filename);
            $ext='.'.array_pop($parts);
            $filename=implode('.',$parts);
         }

        return substr($filename, 0, ($length - strlen($ext))).$ext;
    }

    function set_error($error)
    {

        $object=object_controller();
        $object->language->load('upload');

        if(is_array($error))
        {

            foreach($error as $err)
            {

                $msg=($object->language->line($err)===FALSE) ? $error : $object->language->line($err);
                $this->error_msg[]=$msg;
                text_log("error", $msg);
            }
        }
        else
        {

            $msg=($object->language->line($error)===FALSE)? $error : $object->language->line($error);
            $this->error_msg[]=$msg;
            text_log("error", $msg);
        }
    }

    function display_error($open_tag="<p>", $close_tag="</p>")
    {

        $str="";
        foreach($this->error_msg as $error)
        {
            $str.=$open_tag.$error.$close_tag;
        }

        return $str;
    }
}
?>