<?php
if(!defined('BASE'))exit("direct access not allow");

if(!function_exists('site_url'))
{

     function site_url($url='')
     {

          $cl=object_controller();
          return $cl->config->site_url($url);

     }

}

if(!function_exists('base_url'))
{

     function base_url($url='')
     {

          $cl=object_controller();
          return $cl->config->base_url($url);

     }

}

if(!function_exists('current_url'))
{

     function current_url()
     {

          $cl=object_controller();
          return $cl->config->site_url($cl->url->url_strings());

     }

}

if(!function_exists('url_strings'))
{

     function url_strings()
     {

          $cl=object_controller();
          return $cl->url->url_strings();

     }

}

if(!function_exists('index_page'))
{

     function index_page()
     {

          $cl=object_controller();
          return $cl->config->fetch_item('index_page');

     }

}

if(!function_exists('anchor_link'))
{

     function anchor_link($url, $title='', $attribute='')
     {

          $title=(string)$title;

          if(is_string($url))
          {
               $url=(!preg_match('!^\w+://!i', $url)) ? site_url($url) : $url;

          }
          else
          {

               $url=site_url($url);

          }

          $title=($title=='') ? $url : $title;

          if($attribute!='')
          {
               $attribute=parse_attribute($attribute);
          }


          return '<a href="'.$url.'"'.$attribute.'>'.$title.'</a>';

     }

}

if(!function_exists('anchor_popup'))
{

     function anchor_popup($site, $title='')
     {

          $title=(string)$title;

          $site=(preg_match("|^\w+://|i", $site)) ? $site : site_url($site);

          $title=($title=='') ? $site : $title;

			return "<a href='javascript:void(0);' onclick=\"window.open('".$site."', '_blank');\">".$title."</a>";

     }
}

if(!function_exists('_parse_attribute'))
{
     function _parse_attribute($att='', $javascript=FALSE)
     {

          if(is_string($att))
          {

               return ($att=='')? '':' '.$att;
          }

         $at='';
          foreach($att as $k=>$v)
          {

               if($javascript==TRUE)
               {

                    $at=' '.$k .'='. $v;
               }
               else
               {

                    $at.=' '.$k .'="'. $v.'"';
               }

          }

          if($javascript==TRUE)
          {
               $att=substr($at, 0, -1);
           }

          return $at;
     }
}




?>