<?php
class register extends controller
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
	
	function teacher(){
		$flag = true;
		$class = "";
		$classEx = "";
		$subjectEx = "";
		if(isset($_POST['register'])){
			$this->validations->set_data(array(
				array('field'=>'fname', 'label'=>'Full Name', 'rule'=>'required'),
				array('field'=>'sex', 'label'=>'Gender', 'rule'=>'required'),
				array('field'=>'password', 'label'=>'Password', 'rule'=>'required'),
				array('field'=>'confirmPassword', 'label'=>'Retype password', 'rule'=>'required|length{6}|matche{password}'),
				array('field'=>'email', 'label'=>'Email Address', 'rule'=>'required|email'),
				array('field'=>'phone', 'label'=>'Phone Number', 'rule'=>'required'),
				array('field'=>'type', 'label'=>'Teacher Type', 'rule'=>'required'),
				array('field'=>'post', 'label'=>'post', 'rule'=>'required')
				
			));

				if($this->validations->run_form()===FALSE){
					$data['error']=error_data();
				}else{
					$fname = ucwords($this->validations->get_postdata('fname'));
					$sex = ucwords($this->validations->get_postdata('sex'));
					$password=ucwords($this->validations->get_postdata('password'));
					$email = ucwords($this->validations->get_postdata('email'));
					$phone = $this->validations->get_postdata('phone');
					$type = ucwords($this->validations->get_postdata('type'));
					$post = ucwords($this->validations->get_postdata('post'));
					$where = array('Pnumber'=>$phone);
					$use=$this->admin_table->unversel_check('teachers_tables',"*",$where,"","",array('OR','AND'));
					if($use > 0){
						$data['error'] = $phone." you want to use for registeration already exist";
					}else{

						if(strtolower($type) == 'class'){
							if(!empty($_POST['nursery00'])){
								$class = $_POST['nursery00'];
							}else if(!empty($_POST['primary00'])){
								$class = $_POST['primary00'];
							}else if(!empty($_POST['secondary00'])){
								$class = $_POST['secondary00'];
							}else{
								$data['error'] = "Please you have not select any class";
								$flag = false;
							}
						}else if(strtolower($type) == 'subject'){
							if((count($_POST['classEx']) > 0 && count($_POST['subjectEx']) > 0) || !empty($_POST['class'])){
								$classEx = implode(',',$_POST['classEx']);
								$subjectEx = implode(',',$_POST['subjectEx']);
								$class = !empty($_POST['class']) ? $_POST['class'] : "";
							}else{
								$data['error'] = "Please you have not select any class or subject";
								$flag = false;
							}
						}
						if($flag == true && isset($_SESSION['image'])){
							$this->admin_table->insertData(array('Fname'=>$fname,'Sex'=>$sex,'Password'=>md5($password),'Email'=>$email,'Pnumber'=>$phone,'Type'=>$type,'ClassName'=>$class,'ClassNameEx'=>$classEx,'SubjectNameEx'=>$subjectEx,'Posi'=>$post,'ImageName'=>$_SESSION['image'],'Time_Add'=>date('Y-m-d H:i:sa')),'teachers_tables');
							$data['msg'] = " ".$class." Successfully registered";
						}
						
					}
				}
		}
		$data['datastring'] = $this->admin_table->unversel_selection('classes_tables','*','','','');
		$data['subject'] = $this->admin_table->unversel_selection('subject_tables','*','','','');
		$this->load->views('administration/teacher/register',$data);
	}
	
	function uploads(){
		$targetDir = 'images/profile/';
		if(!is_dir($targetDir)){
			$targetDir = mkdir($targetDir);
		}
		
		$allowType = array('jpg','png','jpeg','gif');

		$status = $errormsg = $errorupload = $erroruploadtype = '';

		$fileName = basename($_FILES['files']['name']);
		
		$targetFilePath = $targetDir.$fileName;

		$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
		$fileSize = $_FILES['files']['size'];
		$requireSize = 100 * 1024;
	   if(in_array($fileType, $allowType)){
			if($fileSize <= $requireSize){
				if(move_uploaded_file($_FILES['files']['tmp_name'], $targetFilePath)){
					$_SESSION['image'] = $targetDir.$_FILES['files']['name'];
					echo "<img src='".base_url($_SESSION['image'])."' alt='' style='width:20%'>";
				}else{
					echo  "error encounter in upload image ".$_FILES['files']['error'];
				}
			}else{
				if($fileSize > 1024){
					$fileSizes =  floor(($fileSize / (1024 * 1024))).'MB';
				}else{
					$fileSizes = floor(($fileSize / 1024)).'kB';;
				}
				echo "The image size is too large size of ".round(($requireSize / 1024),2).'kb is required less than it';
			}
		   
	   }else{
		   echo "error upload type not supported";
	   }
	   
	}
}
