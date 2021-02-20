<?php
class teacher extends controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_table');
		$this->load->library('validations');
	   $this->load->get_help(array("url_helper","form")); 
	   ob_start();
	   session_start();
	}
	
	function student(){
        $this->load->views('teachers/classes');
    }
}
