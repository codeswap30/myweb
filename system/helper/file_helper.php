<?php
if(!defined('BASE'))exit("direct access not allow");

if(!function_exists('ReadFile'))
{

    function ReadFile($filename)
    {

        if(!file_exists($filename))
        {

            return FALSE;
        }

        if(function_exists('file_get_contents'))
        {
            return file_get_contents($filename);

        }

        if(!$file=@fopen($filename, 'r'))
        {
            return FALSE;
        }

        flock($file, LOCK_SH);

        if(filesize($filename)>0)
            $data=fread($file, filesize($filename));

        flock($file, LOCK_UN);

        fclose($file);

        return $data;
    }
}

if(!function_exists('WriteFile'))
{

    function WriteFile($filename, $data, $mode='w')
    {

        if(!$file=fopen($filename, $mode))
        {
            return FALSE;
        }

        flock($file, LOCK_EX);

        fwrite($file, $data);

        flock($file, LOCK_UN);
        fclose($file);

        return TRUE;
    }
}

if(!function_exists('DeleteFile'))
{

    function DeleteFile($file, $empty=FALSE)
    {

        $path=rtrim($file, DIRECTORY_SEPARATOR);

        if($f=opendir($path)===FALSE)
        {
            return FALSE;
        }

        while($filename=readdir($f) !==FALSE)
        {

            if($filename!='.' || $filename !='..')
            {
            
                if(is_dir($path.DIRECTORY_SEPARATOR.$filename))
                {

                    if(substr($path.DIRECTORY_SEPARATOR.$filename, 0, 1) !='.')
                    {

                        DeleteFile($path.DIRECTORY_SEPARATOR.$filename, $empty);

                    }

                }
                else
                {

                    unlink($path.DIRECTORY_SEPARATOR.$filename);

                }

            }

        }

        closedir($f);

        if($empty===TRUE)
        {

            return rmdir($path);

          }

        return TRUE;

    }
}
?>