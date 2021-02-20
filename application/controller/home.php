<?php
if(!defined('BASE')) die("direct access not allow");
class home extends controller{
    
     function __construct(){
          parent::__construct();
          $this->load->get_help(array('url','form','download'));
		  $this->load->library('validations');
		  $this->load->model('admin_table');
		  $this->admin_table->table();
		  ob_start();
		  session_start();
	}

	function index(){
		$this->load->views("index");
	}

	function portal(){
		$data[] = '';
		if(isset($_POST['login'])){
			$this->validations->set_data(array(
				array('field'=>'username', 'label'=>'Username', 'rule'=>'required'),
				array('field'=>'password', 'label'=>'Password', 'rule'=>'required'),
			));
			


			if($this->validations->run_form()===FALSE){
				$data['error']=error_data();
			}else{
				$username=$this->validations->get_postdata('username');
				$password=md5($this->validations->get_postdata('password'));
				$where = array('Pnumber'=>$username,'Password'=>$password);
				$use=$this->admin_table->unversel_check('teachers_tables',"*",$where,"","",array('OR','AND'));
				if($use==1){
					$_SESSION['user'] = $username;
					$where = array('Pnumber'=>$_SESSION['user']);
		 			$datas=$this->admin_table->unversel_selection('teachers_tables',"*",$where,"","",array('OR','AND'));
		 			foreach($datas as $res){
						$data['fname'] = $res['Fname'];
						$data['gender'] = $res['Sex'];
						$data['type'] = $res['Type'];
						$data['classname'] = $res['ClassName'];
						$data['extra'] = $res['ClassNameEx'];
						$data['extras'] = $res['SubjectNameEx'];
						$data['posi'] = $res['Posi'];
						$data['reg'] = $res['Time_Add'];
		 			}
					$this->load->views('teacher/dashboard',$data);
				}else{
					$data['error'] = "Username or Password incorrect";
					$this->load->views("portal/login",$data);	
				}
			}
			//$this->load->views('teachers/profile');
						
		}else{
			$this->load->views('portal/login',$data);
		}
		
	}

	function dashboard(){
		if(!isset($_SESSION['user'])){
			$this->load->views('portal/login');
			exit;
		}

		$where = array('Pnumber'=>$_SESSION['user']);
		$check=$this->admin_table->unversel_check('teachers_tables',"*",$where,"","",array('OR','AND'));
		if($check==1){
			$datas=$this->admin_table->unversel_selection('teachers_tables',"*",$where,"","",array('OR','AND'));
			foreach($datas as $res){
				$data['fname'] = $res['Fname'];
				$data['gender'] = $res['Sex'];
				$data['type'] = $res['Type'];
				$data['classname'] = $res['ClassName'];
				$data['extra'] = $res['ClassNameEx'];
				$data['extras'] = $res['SubjectNameEx'];
				$data['posi'] = $res['Posi'];
				$data['reg'] = $res['Time_Add'];
			}

			//echo $res['Type'];
			$this->load->views('teacher/dashboard',$data);
		}else{
			$data = $_SESSION['user'];
			$this->load->views('teacher/blacklist',$data);
		}
		
	}

	function gallary(){
		$this->load->views('gallary/gallary');
	}

	function admission(){
		$this->load->views('admission/admission');
	}

	function news(){
		$this->load->views('admission/admission');
	}
	
	function contact(){
		$this->load->views('admission/admission');
	}

	function about(){
		$this->load->views('about/about');
	}
	
	function register(){
		$data['error']="";
		$data['datastring']=$this->admin_table->unversel_selection('product_tables',"*","","Id ASC",30);
		if(isset($_POST['register'])){
			$this->validations->set_data(array(
				array('field'=>'fname', 'label'=>'Full Name', 'rule'=>'required'),
				array('field'=>'username', 'label'=>'Username', 'rule'=>'required'),
				array('field'=>'password', 'label'=>'Password', 'rule'=>'required'),
				array('field'=>'confirmPassword', 'label'=>'Retype password', 'rule'=>'required|length{6}|matche{password}'),
				array('field'=>'email', 'label'=>'Email Address', 'rule'=>'required|email'),
				array('field'=>'sex', 'label'=>'Sex', 'rule'=>'required'),
				array('field'=>'address', 'label'=>'Address', 'rule'=>'required'),
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
					$address = $this->validations->get_postdata('address');
					$phone = $this->validations->get_postdata('phone');
					$where = array('Username'=>$username);
					$use=$this->admin_table->unversel_check('users_tables',"*",$where,"","",array('OR','AND'));
					if($use > 0){
						$data['error'] = "Username already exist";
					}else{

						$this->admin_table->insertData(array('Fname'=>$fname,'Username'=>$username,'Password'=>md5($password),'Email'=>$email,'Sex'=>$sex,'Address'=>$address,'Pnumber'=>$phone),'users_tables');
						$data['success'] = "Successfully register, please click on login";
					}
				}
		}
		//$this->admin_table->insertData(array('Name'=>'Nurudeen Taiye Mohammed','Gender'=>'Male','Username'=>'Codedwap','Password'=>md5('coded3'),'Email'=>'Codedwapmaster@gmail.com','Pnumber'=>'08106291411','Posi'=>'2020-02-01 11:00'),'admin_tables');
		$this->load->views('login/register',$data);
	}

	

	function single($string = ""){
		if(!is_numeric($string) || $string == ""){
			display_404();
		}
		$where = array('id'=>$string);
		$string=$this->admin_table->unversel_selection('product_tables',"*",$where,"Id ASC",1);
		if(count($string)>0){
			foreach($string as $row){
				$data['File_Name'] = $row['File_Name'];
				$data['Product_Name'] = $row['Name'];
				$data['Amount'] = $row['Amount'];
				$data['Details'] = $row['Details'];
				$data['Categories'] = $row['Categories'];
			}
		}
		$name = $row['Name'];
		$where = array('Name'=>$name);
		$data['other']=$this->admin_table->unversel_selection('other_image_tables',"*",$where,"Id ASC","");
		$data['datastring']=$this->admin_table->unversel_selection('product_tables',"*","","Id ASC",30);
		$this->load->views('single-product',$data);
	}

	function logout(){
		if(isset($_SESSION['user']))
			unset($_SESSION['user']);
		
		$this->load->views("portal/login");
	}
	
}
?>