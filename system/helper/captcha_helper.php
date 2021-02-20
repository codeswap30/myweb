<?php
if(!defined('BASE'))exit("direct access not allow");

if(!function_exists('create_captcha'))
{

  function create_captcha($data="", $img_path="", $img_url="", $font_path="")
  {

     $defaults=array("word"=>"","img_path"=>"","width"=>150,"height"=>30,"img_url"=>"","font_path"=>"","expiration"=>7200);

     foreach($defaults as $key=>$value)
     {

        if(!is_array($data))
        {

          if(!isset($$key) || $$key=="")
          {
             $$key=$value;
          }
        }
        else
        {

          $$key=(!isset($data[$key])) ? $value : $data[$key];
        }
     }

     if($img_path=="" || $img_url=="")
     {

        return FALSE;
     }

     if(!is_dir($img_path))
     {
     
        display_error('invalid paths is submit '.$img_path);
        return FALSE;
     }


     if(!extension_loaded('gd'))
     {

        return FALSE;
     }

     list($usec, $sec)=explode(" ",microtime());
     $now=((float)$usec+(float)$sec);

     $current_dir=opendir($img_path);

     while($filename=readdir($current_dir))
     {
         if($filename!="." && $filename!=".." && $filename!="index.html")
         {

            $name=str_replace("jpeg","",$filename);
  
            if(($name+$expiration)<$now)
            {

              unlink($img_path.$filename);
            }
         }

      
     }

    closedir($current_dir);

     if($word=="")
     {

        $strings="0123456789abcdefghijklmnopkrstuvwxyzABCDEFGHIJKLMNOPQRSTUVXYZ";
      
        $str="";
        
        for($i=0;$i<8;$i++)
        {

           $str.=substr($strings,mt_rand(0,strlen($strings)-1),1);
        }

       $word=$str;           
     }

     $length=strlen($word);
     $angle=($length>=6)?rand(-($length-6),($length-6)) : 0;
     $x_axis=rand(6,(360/$length)-16);
     $y_axis=($angle>=0)?rand($height,$width) : rand(6,$height);

     if(function_exists('imagecreatetruecolor'))
     {
        $image=imagecreatetruecolor($width,$height);
     }
     else
     {
        $image=imagecreate($width,$height);
     }

     $bg_color=ImageColorAllocate($image,255,255,255);
     $border_color=ImageColorAllocate($image,153,102,102);
     $text_color=ImageColorAllocate($image,204,153,153);
     $grid_color=ImageColorAllocate($image,255,182,182);
     $shadow_color=ImageColorAllocate($image,255,240,240);

     ImageFilledRectangle($image,0,0,$width,$height,$bg_color);

     $theta=1;
     $thetac=7;
     $radius=16;
     $circle=20;
     $point=32;

     for($i=0;$i<($circle*$point)-1;$i++)
     {
        $theta=$theta+$thetac;
        $rad=$radius*($i/$point);
        $x=($rad*cos($theta))+$x_axis;
        $y=($rad*sin($theta))+$y_axis;
        $theta=$theta+$thetac;
        $rad1=$radius*(($i+1)/$point);
        $x1=($rad1*cos($theta))+$x_axis;
        $y1=($rad1*sin($theta))+$y_axis;
        imageline($image,$x,$y,$x1,$y1,$grid_color);
        $theta=$theta+$thetac;
     }


     $use_font=($font_path !="" && file_exists($font_path) && function_exists('imagettftext'))? TRUE : FALSE;
     
     if($use_font===TRUE)
     {

       $font_size=5;
       $x=rand(0,$width/($length/3));
       $y=0;
     }
     else
     {

       $font_size=16;
       $x=rand(0,$width/($length/1.5));
       $y=$font_size+2;

     }

     for($i=0;$i<strlen($word);$i++)
     {

        if($use_font===FALSE)
        {

          $y=rand(0,$height/2);
          ImageString($image,$font_size,$x,$y,substr($word,$i,1),$text_color);
          $x+=($font_size*2);
        }
        else
        {

           $y=rand($height/2,$height-3);
           imagettftext($image,$font_size,$angle,$x,$y,$text_color,$font_path,substr($word,$i,1));
           $x+=$font_size;
        }
    }
 
    ImageRectangle($image,0,0,$width-1,$height-1,$border_color);

    $img_name=$now.'.jpg';

    ImageJpeg($image,$img_path.$img_name);

    $img="<img src=\"$img_url/$img_name\" width=\"$width\" height=\"$height\" style=\"borde:0;\" alt=\"\"/>";
    
    ImageDestroy($image);
   
    return array("word"=>$word,"time"=>$now,"image"=>$img);    
       
         
  }
}
?>