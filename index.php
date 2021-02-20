<?php
date_default_timezone_set("Africa/Lagos");
define('ENVIRONMENT',  'develop');

if(defined('ENVIRONMENT'))
{

switch(ENVIRONMENT)
{

case 'develop':
error_reporting(E_ALL);

break;
case 'produce':
case 'testing':
error_reporting(0);

break;
default:
exit("environment not in a right format");

}
}


$system='system';
$application='application';


if(defined('STDIN'))
{

chdir(dirname(__FILE__));

}



if(realpath($system) !==FALSE && isset($system))
{

$system=realpath($system).'/';

}
$system=rtrim($system, '/').'/';

if(!is_dir($system))
{

exit("system file can not be found please check ".pathinfo(__FILE__, PATHINFO_BASENAME));

}


     define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME)); //index.php
     define('FC', str_replace(SELF, '', __FILE__)); //htdoc/dir/
     define('BASE', str_replace("\\", "/", $system)); //htdoc/dir/system/
     define('EXE', '.php'); //php
     define('SYSDIR', trim(strrchr(trim(BASE, '/'), '/'), '/'));

if(is_dir($application))
{

define('APP', $application.'/');

}
else
{

if(is_dir(BASE.$application))
{

define('APP', BASE.$application.'/');

}
}

require_once BASE.'core/base'.EXE;
?>
