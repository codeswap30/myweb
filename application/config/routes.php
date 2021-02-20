<?php

if(!defined('BASE'))exit("direct access not allow");


$route['default_controller']='home';

$route['404_override']='delay/section';

$route['admin']='admin/view';

?>