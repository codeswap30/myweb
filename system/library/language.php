<?php
class language
{

    var $language=array();
    var $is_language=array();

    function __construct()
    {

        text_log('debug', "language class initialize");

    }

    function load($filename, $lang_suffix=TRUE, $idiom='', $return=FALSE)
    {

        $filename=str_replace('.php', '', $filename);

        if($lang_suffix===TRUE)
        {

            $filename=str_replace('_lang', '', $filename).'_lang';
        }

        if(in_array($filename, $this->is_language))
        {
            return;
        }

        $config=get_item();

        if($idiom=='')
        {

            $idiom=(isset($config['language']) && $config['language'] !='') ? $config['language'] : 'english';
        }

        $found=FALSE;

        if(file_exists(BASE.'language/'.$idiom.'/'.$filename.EXE))
        {
            include(BASE.'language/'.$idiom.'/'.$filename.EXE);

            $found=TRUE;

        }

        if(!isset($lang))
        {

            display_error("the language file you set dont have any data in it");
        }

        if($return==TRUE)
        {
            return $lang;
        }

        if($found==FALSE)
        {
            display_error("unable to locate this file ".$idiom.$filename.EXE);
        }

        $this->is_language[]=$filename;
        $this->language=array_merge($lang, $this->language);
    }

    function line($lang)
    {

        $langvalue=(isset($this->language[$lang]) && $this->language[$lang] !='') ? $this->language[$lang] : FALSE;

        if($langvalue==FALSE)
        {

            text_log("error", "could not locate this language ".$lang);

            return FALSE;
        }

        return $langvalue;
    }
}
?>