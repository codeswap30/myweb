<?php
if(!defined('BASE'))exit("direct access not allow");

function check_friends($email,$friend)
{
  $cl=object_controller();
  $d="SELECT * FROM request_friends WHERE Email='".$email."' AND Friend='".$friend."'";
  $data=$cl->db->query($d);
  return $cl->num_rows();

}
?>