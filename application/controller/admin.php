<?php
class admin extends controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('admin_table');
		$this->load->library('validations');
	   $this->load->get_help(array("url_helper","form","directory")); 
	   ob_start();
	   session_start();
	}
	
	function login(){
		$data['error'] = "";
		if(isset($_POST['login'])){
			$user = $_POST['username'];
			$pass = $_POST['password'];

			if(!isset($_SESSION['error']))
				$_SESSION['error'] = 0;
			
			$where=array('')
			$check=$this->admin_table->unversel_check('admin_tables',"*","","Id ASC",5);
			if($check==1){
				$_SESSION['admin'] = $user;
				//$this->index();
			}else{
				$_SESSION['error']++;
				$data['error'] = "Username or password is incorrect. please contact the developer <br/> You have make ".$_SESSION['error'].". please stop now because after five (5) error your account will be suspended";
			}

			if($_SESSION['error'] <=5){
				$this->load->views('portal/admin-login',$data);
			}else{
				$data['error'] = "Your account have been suspended for sometime. try again later";
				$this->load->views('portal/admin-login',$data);
			}

		}
	}
	function index(){
		if(!isset($_SESSION['admin'])){
			$this->load->views('portal/admin-login');
			exit;	
		}
		$this->load->views('administration/administration');
	 }

	 function registered($id=""){
		if(!isset($_SESSION['admin'])){
			$this->load->views('portal/admin-login');
			exit;
		}

		if(!empty($id) && is_numeric($id)){
			$this->admin_table->deleteData('admin_tables',$id);
			$data['msg'] = " Data delete successfully";
		}

		$data['datastring']=$this->admin_table->unversel_selection('admin_tables',"*","","Id ASC",5);
		$this->load->views("administration/registered",$data);
	 }

	 function classm($id=""){

		if(!isset($_SESSION['admin'])){
			$this->load->views('portal/admin-login');
			exit;	
		}

		if(isset($_POST['add-class'])){
			$this->validations->set_data(array(
				array('field'=>'classname', 'label'=>'Class Name', 'rule'=>'required'),
				array('field'=>'section','label'=>'Section','rule'=>'required')
			));

			if($this->validations->run_form()===FALSE){
				$data['error']=error_data();
			}else{
				$classname = ucwords($this->validations->get_postdata('classname'));
				$section = strtolower($this->validations->get_postdata('section'));
				$where = array('ClassName'=>$classname);
				$use=$this->admin_table->unversel_check('classes_tables',"*",$where,"","",array('OR','AND'));
				if($use > 0){
					$data['error'] = $classname." already exists";
				}else{

					$this->admin_table->insertData(array('ClassName'=>$classname,'Section'=>$section,'Time_Add'=>date('Y-m-d H:i:sa')),'classes_tables');
					$data['msg'] = $classname." Successfull added";
				}
				
			}
		}else if(!empty($id) && is_numeric($id)){
			$this->admin_table->deleteData('classes_tables',$id);
			$data['msg'] = " Data delete successfully";
		}
		$data['datastring']=$this->admin_table->unversel_selection('classes_tables',"*","","Section DESC","");
		
		$this->load->views("administration/teacher/class-manager",$data);
	 }

	 function subjectm($id=""){
		if(!isset($_SESSION['admin'])){
			$this->load->views('portal/admin-login');
			exit;	
		}

		if(isset($_POST['add-subject'])){
			$this->validations->set_data(array(
				array('field'=>'subject', 'label'=>'Subject Name', 'rule'=>'required'),
				array('field'=>'section','label'=>'Section','rule'=>'required')

			));

			if($this->validations->run_form()===FALSE){
				$data['error']=error_data();
			}else{
				$subject = ucwords($this->validations->get_postdata('subject'));
				$section = strtolower($this->validations->get_postdata('section'));
				$where = array('SubjectName'=>$section.'_'.$subject,'Section'=>$section);
				$use=$this->admin_table->unversel_check('subject_tables',"*",$where,"","",array('OR','AND','AND'));
				if($use > 0){
					$data['error'] = $subject." already exists";
				}else{
					$this->admin_table->auto_table(str_replace(' ','_',strtolower($subject)),array('FullName VARCHAR(255) NOT NULL','Gender VARCHAR(50) NOT NULL','Term VARCHAR(100) NOT NULL','Section VARCHAR(100) NOT NULL','Class VARCHAR(100) NOT NULL','OpenSchool VARCHAR(100)','Present VARCHAR(100)','Absent VARCHAR(100)','CA1 VARCHAR(255)','CA2 VARCHAR(255)','MTT VARCHAR(255)','Exam VARCHAR(255)','Total VARCHAR(255)','Grade VARCHAR(255)','Remark VARCHAR(255)'));
					if($section == 'allnps'){
						$sub = array('nursery','primary','jss','sss');
						foreach($sub as $subs){
							if($subs == 'primary' || $subs=='nursery')
								$this->admin_table->insertData(array('SubjectName'=>$subject,'Section'=>$subs,'Time_Add'=>date('Y-m-d H:i:sa')),'subject_tables');
							else
								$this->admin_table->insertData(array('SubjectName'=>$subs.'_'.$subject,'Section'=>$subs,'Time_Add'=>date('Y-m-d H:i:sa')),'subject_tables');
						}
					}else if($section == 'allps'){
						//$section = strtoupper($section);
						$sub = array('primary','jss','sss');
						foreach($sub as $subs){
							if($subs == 'primary' || $subs=='nursery')
								$this->admin_table->insertData(array('SubjectName'=>$subject,'Section'=>$subs,'Time_Add'=>date('Y-m-d H:i:sa')),'subject_tables');
							else
								$this->admin_table->insertData(array('SubjectName'=>$subs.'_'.$subject,'Section'=>$subs,'Time_Add'=>date('Y-m-d H:i:sa')),'subject_tables');
							//$this->admin_table->insertData(array('SubjectName'=>$subs.'_'.$subject,'Section'=>$subs,'Time_Add'=>date('Y-m-d H:i:sa')),'subject_tables');
						}
						
					}else if($section == 'alljs'){ 
						$sub = array('jss','sss');
						foreach($sub as $subs){
							$this->admin_table->insertData(array('SubjectName'=>$subs.'_'.$subject,'Section'=>$subs,'Time_Add'=>date('Y-m-d H:i:sa')),'subject_tables');
						}
					}else if($section == 'jss' || $section == 'sss'){
						
						$this->admin_table->insertData(array('SubjectName'=>$section.'_'.$subject,'Section'=>$section,'Time_Add'=>date('Y-m-d H:i:sa')),'subject_tables');

					}else{
						$this->admin_table->insertData(array('SubjectName'=>$subject,'Section'=>$section,'Time_Add'=>date('Y-m-d H:i:sa')),'subject_tables');
					}
					
					$data['msg'] = $subject." Successfull added";
				}	
			}
		}else if(!empty($id) && is_numeric($id)){
			$where = array('id'=>$id);
			$sub = "";
			$d=$this->admin_table->unversel_selection('subject_tables',"*",$where,"","");
			foreach($d as $r){
				$sub = $r['SubjectName'];
			}
			$this->admin_table->del_table(strtolower(str_replace(' ','_',$sub)));
			$this->admin_table->deleteData('subject_tables',$id);
			$data['msg'] = " Data delete successfully ";
		}
		$data['datastring']=$this->admin_table->unversel_selection('subject_tables',"*","","Section ASC","");
		$data['results']=$this->admin_table->unversel_selection('classes_tables',"*","","","");
		$this->load->views("administration/teacher/subject-manager",$data);
	 }

	 function classe($arg=""){
		if(!isset($_SESSION['admin'])){
			$this->load->views('portal/admin-login');
			exit;	
		}

		 if(!is_numeric($arg) && empty($arg)){
			 display_404();
		 }

		 if(isset($_POST['update'])){
			$this->validations->set_data(array(
				array('field'=>'classname', 'label'=>'Class Name', 'rule'=>'required'),
				array('field'=>'section','label'=>'Section','rule'=>'required')
			));

			if($this->validations->run_form()===FALSE){
				$data['error']=error_data();
			}else{
				$id = $_POST['id'];
				$classname = Ucfirst($this->validations->get_postdata('classname'));
				$section = strtolower($this->validations->get_postdata('section'));
				$where = array('ClassName'=>$classname);
				$use=$this->admin_table->unversel_check('classes_tables',"*",$where,"","",array('OR','AND'));
				if($use > 0){
					$data['error'] = $classname." already exists in ".$section.' Section';
				}else{
					
					$this->admin_table->updateData('classes_tables',$id,array('Classname'=>$classname,'Section'=>$section));
					$data['msg'] = $classname." Update Successfull";
				}
			}
		 }
		 $where = array('id'=>$arg);
		 $datas=$this->admin_table->unversel_selection('classes_tables',"*",$where,"","",array('OR','AND'));
		 if(count($datas)==0){
			$data['datastring'] = $this->admin_table->unversel_selection('classes_tables',"*","","","","");
			$this->load->views("administration/teacher/class-manager",$data);
		 }else{
			foreach($datas as $row){
				$data['ClassName'] = $row['ClassName'];
				$data['Section'] = $row['Section'];
			}
			$data['Id'] = $arg;
			$this->load->views("administration/teacher/class-edit",$data);
		 } 
	 }

	 function register(){
		if(!isset($_SESSION['admin'])){
			$this->load->views('portal/admin-login');
			exit;	
		}
		 

		$data['error']="";
		if(isset($_POST['register'])){
			$this->validations->set_data(array(
				array('field'=>'fname', 'label'=>'Full Name', 'rule'=>'required'),
				array('field'=>'username', 'label'=>'Username', 'rule'=>'required'),
				array('field'=>'password', 'label'=>'Password', 'rule'=>'required'),
				array('field'=>'confirmPassword', 'label'=>'Retype password', 'rule'=>'required|length{6}|matche{password}'),
				array('field'=>'email', 'label'=>'Email Address', 'rule'=>'required|email'),
				array('field'=>'sex', 'label'=>'Sex', 'rule'=>'required'),
				array('field'=>'post', 'label'=>'post', 'rule'=>'required'),
				array('field'=>'phone', 'label'=>'Phone Number', 'rule'=>'required'),
			));

				if($this->validations->run_form()===FALSE){
					$data['error']=error_data();
				}else{
					$fname = $this->validations->get_postdata('fname');
					$username=$this->validations->get_postdata('username');
					$password=$this->validations->get_postdata('password');
					$email = $this->validations->get_postdata('email');
					$sex = $this->validations->get_postdata('sex');
					$post = $this->validations->get_postdata('post');
					$phone = $this->validations->get_postdata('phone');
					$where = array('Username'=>$username);
					$use=$this->admin_table->unversel_check('admin_tables',"*",$where,"","",array('OR','AND'));
					if($use > 0){
						$data['error'] = "Username already exist";
					}else{

						$this->admin_table->insertData(array('Name'=>$fname,'Username'=>$username,'Password'=>md5($password),'Email'=>$email,'Gender'=>$sex,'Pnumber'=>$phone,'Posi'=>$post,'Time_Add'=>date('Y-m-d H:i:sa')),'admin_tables');
						$data['msg'] = "Successfully register";
					}
				}
		}
		$this->load->views('administration/register',$data);
	}

	function profile(){
		if(!isset($_SESSION['admin'])){
			$this->load->views('portal/admin-login');
			exit;	
		}
		if(!isset($_SESSION['admin'])){
			$this->load->views('portal/admin-login');
			exit;
		}
		$where = array('Username'=>$_SESSION['admin']);
		$string=$this->admin_table->unversel_selection('admin_tables',"*",$where,"Id ASC",5);
		foreach($string as $str){
			$data['fname'] = $str['Name'];
			$data['sex'] = $str['Gender'];
			$data['email'] = $str['Email'];
			$data['phone'] = $str['Pnumber'];
			$data['posi'] = $str['Posi'];
		}
		$this->load->views('administration/profile',$data);
	}

	function teacher(){
		if(!isset($_SESSION['admin'])){
			$this->load->views('portal/admin-login');
			exit;
		}
		if(isset($_POST['update'])){
			$this->validations->set_data(array(
				array('field'=>'fname', 'label'=>'First Name', 'rule'=>'required'),
				array('field'=>'id','label'=>'Id','rule'=>'required'),
				array('field'=>'password','label'=>'Password','rule'=>'required')
			));

			if($this->validations->run_form()===FALSE){
				$data['error']=error_data();
			}else{
				$fname = Ucwords($this->validations->get_postdata('fname'));
				$password = md5($this->validations->get_postdata('password'));
				$id = $this->validations->get_postdata('id');
					
				$this->admin_table->updateData('teachers_tables',$id,array('Fname'=>$fname,'Password'=>$password));
				$data['msg'] = $fname." Update Successfull";
				
			}
		}
		$data['datastring']=$this->admin_table->unversel_selection('teachers_tables',"*","","","","");
		$this->load->views('administration/teacher/teacher-manager',$data);
	}

	function editprofile(){
		if(!isset($_SESSION['admin'])){
			$this->load->views('portal/admin-login');
			exit;
		}
		$where = array('Username'=>$_SESSION['admin']);
		$data['datastring']=$this->admin_table->unversel_selection('admin_tables',"*",$where,"Id ASC",1);
		$this->load->views('administration/edit-profile',$data);
	}

	function gallary($id=""){
		if(!isset($_SESSION['admin'])){
			$this->load->views('portal/admin-login');
			exit;	
		}
		if(isset($_POST['submit-folder'])){
			if(!is_dir('img/folders/gallary/'.$_POST['folder'])){
				mkdir('img/folders/gallary/'.$_POST['folder']);
				$this->admin_table->insertData(array('Image'=>$_POST['folder'],'Time_Add'=>date('YYYY-mm-dd H:i:sa')),'folder_tables');
				$data['msg'] = " <strong>".$_POST['folder']."</strong> Folder Created";
			}else{
				$data['msg'] = " <strong>".$_POST['folder']."</strong> Already Created";
			}
			
		}elseif($id!=""){
			//unlink('img/folders/'.$_POST['folder']);
			$this->admin_table->deleteData('folder_tables',$id);
			$data['msg'] = " <strong>".$_POST['folder']."</strong> Folder Deleted!";
		}
		$where = array('Type'=>'gallary');
		$data['datastring']=$this->admin_table->unversel_selection('folder_tables',"*",$where,"Id ASC","");
		$this->load->views('administration/gallary',$data);
	}


	function video($id=""){
		if(!isset($_SESSION['admin'])){
			$this->load->views('portal/admin-login');
			exit;	
		}
		if(isset($_POST['submit-folder'])){
			if(!is_dir('img/folders/videoss/'.$_POST['folder'])){
				if(mkdir('img/folders/videoss/'.$_POST['folder'],0700)){
					$this->admin_table->insertData(array('Image'=>$_POST['folder'],'Type'=>'video','Time_Add'=>date('YYYY-mm-dd H:i:sa')),'folder_tables');
					$data['msg'] = " <strong>".$_POST['folder']."</strong> Folder Created";
				}
			}else{
				$data['msg'] = " <strong>".$_POST['folder']."</strong> Already Created";
			}
			
		}elseif($id!=""){
			//unlink('img/folders/'.$_POST['folder']);
			$this->admin_table->deleteData('folder_tables',$id);
			$data['msg'] = " <strong>".$_POST['folder']."</strong> Folder Deleted!";
		}
		$where = array('Type'=>'video');
		$data['datastring']=$this->admin_table->unversel_selection('folder_tables',"*",$where,"Id ASC","");
		$this->load->views('administration/video',$data);
	}

	function open($file=""){
		if(!isset($_SESSION['admin'])){
			$this->load->views('portal/admin-login');
			exit;	
		}
		$video = explode('_',$file)[0];
		$file = str_replace($video.'_','',$file);
		$data['datas']=directory('img/folders/'.$video.'/'.$file);
		$data['files'] = $file;
		$this->load->views('administration/gallary_open',$data);
	}
	
	function uplvideo(){
		if(!isset($_SESSION['admin'])){
			$this->load->views('portal/admin-login');
			exit;	
		}
		ini_set('upload_max_filesize','3000M');
		ini_set('upload_max_size','2000M');
		ini_set('post_max_size','165M');
		$targetDir = 'img/folders/videoss/'.$_POST['folder'].'/';
		if(!is_dir($targetDir)){
			$targetDir = mkdir($targetDir);
		}
		
		$allowType = array('mov','mp4','avi','3gp','mpeg');

		$status = $errormsg = $errorupload = $erroruploadtype = '';

		$fileName = basename($_FILES['video_files']['name']);
		
		$targetFilePath = $targetDir.$fileName;

		$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
		$fileSize = $_FILES['video_files']['size'];
		$requireSize = 5 * 1024 * 1024;
	   if(in_array($fileType, $allowType)){
			if($fileSize <= $requireSize){
				move_uploaded_file($_FILES['video_files']['tmp_name'], $targetFilePath);
					//$_SESSION['video'] = $targetDir.$_FILES['files']['name'];
					echo "<video width='300' height='200' controls>";
					echo "<source src='".$targetFilePath."' type='video/".$fileType."'>";
					echo "</video>";
					echo $_FILES['video_files']['tmp_name'];
				//}else{
					//echo  "error encounter in upload video ".$_FILES['files']['error'];
				//}
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

	function changes(){
		if(!isset($_SESSION['admin'])){
			$this->load->views('portal/admin-login');
			exit;
		}

		if(isset($_POST['submit'])){
			$pass = $_POST['newpassword'];
			$this->admin_table->updateData('admin_tables',$_SESSION['admin'],array('Password'=>md5($pass)));
			$data['msg'] = "password changed successfully";
		}

		$where = array('Username'=>$_SESSION['admin']);
		$string=$this->admin_table->unversel_selection('admin_tables',"*",$where,"Id ASC",5);
		foreach($string as $str){
			$data['current'] = $str['Password'];
		}
		$this->load->views('administration/password',$data);
	}

	function forms(){

		if(!isset($_SESSION['admin'])){
			$this->load->views('portal/admin-login');
			exit;	
		}

		$where = array('id'=>$_POST['id']);
		 $datas=$this->admin_table->unversel_selection('teachers_tables',"*",$where,"","",array('OR','AND'));
		 foreach($datas as $res){
			$fname = $res['Fname'];
			$gender = $res['Sex'];
			$type = $res['Type'];
			$pass = $res['Password'];
			$classname = $res['ClassName'];
			$extra = $res['ClassNameEx'];
			$extras = $res['SubjectNameEx'];
			$posi = $res['Posi'];
			$reg = $res['Time_Add'];
			$image = $res['ImageName'];
		 }
		 echo '<div style="margin:0 auto;width:50%;padding-bottom:15px;"> <img src="'.$image.'" alt="" style="width:30%;height:40%;"></div>';
		 echo '<table>';
		 echo '<tr><td><strong>Id</strong></td><td>'.$_POST['id'].'</td></tr>';
		 echo '<input type="hidden" name="id" value="'.$_POST['id'].'">';
		echo '<tr><td><strong>Full Name</strong></td><td><input type="text" name="fname" class="form-control" id="success" value="'.$fname.'" required></td></tr>';
		echo '<tr><td><strong>Gender</strong></td><td>'.$gender.'</td></tr>';
		echo '<tr><td><strong>Change Password</strong></td><td><input type="text" name="password" class="form-control" id="success" value="'.$pass.'" required></td></tr>';
        echo '<tr><td><strong>Teacher Type</strong></td><td>'.$type.'</td></tr>';
				if(strtolower($type) == 'class'){
					echo '<tr><td><strong>Class</strong></td><td>'.$classname.'</td></tr>';
                            }else if(strtolower($type) == 'subject'){
                        
					echo '<tr><td><strong>Class</strong></td><td>'.$classname.'</td></tr>';
                    echo '<tr><td><strong>Extra Class</strong></td><td>'.$extra.'</td></tr>';
                    echo '<tr><td><strong>Extra Subject</strong></td><td>'.$extras.'</td></tr>';
}

					echo '<tr><td><strong>Posi</strong></td><td>'.$posi.'</td></tr>';
                    echo '<tr><td><strong>Time Registered</strong></td><td>'.$reg.'</td></tr>';
					echo '<tr><td><button type="submit" name="update" class="btn btn-success btn-labeled">Update Record<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button></td><td><button type="button" class="btn btn-success btn-labeled" style="background-color:red;" onclick="document.getElementById(\'id02\').style.display=\'none\'">Cancel Record<span class="btn-label btn-label-right"><i class="fa fa-remove"></i></span></button></td></tr>';
					echo '</table>';
	}

	function phpinfos(){
		echo phpinfo();
	}

	function logout(){
		unset($_SESSION['admin']);
		$this->load->views('portal/admin-login');	
	}
}
