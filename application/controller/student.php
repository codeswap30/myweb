<?php
class student extends controller
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
	
	
	 function classes($cls=""){
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
			$data['classname'] = $res['ClassName'];
			$classE = $res['ClassName'];
			$data['type'] = $res['Type'];
			$type = $res['Type'];
			$data['extra'] = $res['ClassNameEx'];
			$data['subjectEx'] = $res['SubjectNameEx'];
		}
		

		$data['current'] = $cls;
		if(strtolower($type) == "class"){
			$where = array('Section'=>strtolower(explode(' ',$classE)[0]));
			$data['datastring']=$this->admin_table->unversel_selection('subject_tables',"id, SubjectName",$where,"","",array('OR','AND'));
			$this->load->views('student/student',$data);
		}else if(strtolower($type) == "subject"){
			
			if(!is_null($classE) && $classE == str_replace('_',' ',$cls)){
				
				$correction = strtolower(explode(' ',$classE)[0]);
				if(in_array($correction, array('ss1','ss2','ss3')))
					$correctiion = "sss";

				$where = array('Section'=>$correctiion);
				$data['datastring']=$this->admin_table->unversel_selection('subject_tables',"id, SubjectName",$where,"","",array('OR','AND'));
				$data['section'] = strtolower(explode('_',$cls)[0]);
				$this->load->views('student/student',$data);
				
			}else{

				$correction = strtolower(explode('_',$cls)[0]);
				if(in_array($correction, array('ss1','ss2','ss3')))
					$correctiion = "sss";

				$where = array('Section'=>$correctiion);
				$data['datastring']=$this->admin_table->unversel_selection('subject_tables',"id, SubjectName",$where,"","",array('OR','AND'));
				$data['section'] = strtolower($cls);
				
				$this->load->views('student/student',$data);
			}

		}
	}else{
		$this->load->views('teacher/blacklist');
	}		
	 }

	 function sheet(){
		if(!isset($_SESSION['user']) && empty($id) && !is_numeric($id)){
			$this->load->views('portal/login');
			exit;
		} 

		$where = array('Pnumber'=>$_SESSION['user']);
		$check=$this->admin_table->unversel_check('teachers_tables',"*",$where,"","",array('OR','AND'));
		if($check==1){
		$datas=$this->admin_table->unversel_selection('teachers_tables',"*",$where,"","",array('OR','AND'));
		foreach($datas as $res){
			$data['fname'] = $res['Fname'];
			$data['classname'] = $res['ClassName'];
			$classE = $res['ClassName'];
			$data['type'] = $res['Type'];
			$type = $res['Type'];
			$data['extra'] = $res['ClassNameEx'];
			$data['subjectEx'] = $res['SubjectNameEx'];
		}

		//if(strtolower($type) == "class"){
			$student = strtolower(explode(' ',$classE)[0]);
			
			if(in_array($student, array('ss1','ss2','ss3')))
					$student = "sss";
			if($student == "jss" || $student == "sss")
				$student = "secondary";

			$where = array('ClassName'=>$classE);
			$data['datastring']=$this->admin_table->unversel_selection($student.'_tables',"*",$where,"","",array('OR','AND','AND'));
			$this->load->views('student/sheet',$data);
		

		echo $type;
	}else{
		$this->load->views('teacher/blacklist');
	}
	 }

	 function print($id = ""){
		if(!isset($_SESSION['user']) && empty($id) && !is_numeric($id)){
			$this->load->views('portal/login');
			exit;
		} 

		$where = array('Pnumber'=>$_SESSION['user']);
		$check=$this->admin_table->unversel_check('teachers_tables',"*",$where,"","",array('OR','AND'));
		if($check==1){
		$datas=$this->admin_table->unversel_selection('teachers_tables',"*",$where,"","",array('OR','AND'));
		foreach($datas as $res){
			$data['fname'] = $res['Fname'];
			$data['classname'] = $res['ClassName'];
			$classE = $res['ClassName'];
			$data['type'] = $res['Type'];
			$type = $res['Type'];
			$data['extra'] = $res['ClassNameEx'];
			$data['subjectEx'] = $res['SubjectNameEx'];
		}

		//if(strtolower($type) == "class"){
			$student = strtolower(explode(' ',$classE)[0]);
			
			//class name
			$_subject_section = "";

			if($student == "jss" || $student == "sss"){
				$_subject_section = $student;
				$student = "secondary";
			}
				

			$where = array('ClassName'=>$classE,"id"=>$id);
			$studrow=$this->admin_table->unversel_selection($student.'_tables',"*",$where,"","",array('OR','AND','AND'));
			foreach($studrow as $row){
				$data['name'] = $row['Fname'];
				$fname = $row['Fname'];
				$data['class'] = $row['ClassName'];
				$class = $row['ClassName'];
				$data['sex'] = $row['Sex'];
				$data['term'] = $term = $row['Term'];
				$subject = explode(',',$row['Subject']);
				$data['image'] = $row['ImageName'];	
			}

			if($_subject_section!=""){
				$student = $_subject_section;
			}

			$_subject = array();
			$subject = $this->admin_table->unversel_selection('subject_tables',"*",array('Section'=>strtolower($student)),"","");
			if(count($subject)>0){
				foreach($subject as $_sub){
					$_subject[] = $_sub['SubjectName'];
				}
			}
			$count = 0;
			$totals = 0;
			$ca = array();
			if(count($_subject) > 0){
				foreach($_subject as $sub){
					//echo $sub;
					$where = array('FullName'=>$fname,"Class"=>$class,'Term'=>$term);

					if(!empty($_subject_section))
						$sub = str_replace($_subject_section.'_','',$sub);
					
					$studrow=$this->admin_table->unversel_selection(strtolower(str_replace(' ','_',$sub)),"*",$where,"","",array('OR','AND','AND'));
					if(count($studrow)>0){
						foreach($studrow as $rows){
							$ca[$count] = "<tr><td>".$sub."</td><td>".$rows['CA1']."</td><td>".$rows['CA2']."</td><td>".$rows['MTT']."</td><td>".$rows['Exam']."</td><td>".$rows['Total']."</td><td>".$rows['Grade']."</td><td>".$rows['Remark']."</td></tr>";
							$data['session'] = $row['Session'];
							$count++;
							$totals += $rows['Total'];
						}
					}
				}
			}
			
			$data['subject'] = $ca;
			$data['Totals'] = $totals;
			
			$this->load->views('student/result',$data);
		//}
	}else{
		$this->load->views('teacher/blacklist');
	}
	 }

	 function subject($id){
		if(!isset($_SESSION['user']) && empty($id) && !is_numeric($id)){
			$this->load->views('portal/login');
			exit;
		}
		

		$_SESSION['identify'] = $id;

		$where = array('Pnumber'=>$_SESSION['user']);
		$check=$this->admin_table->unversel_check('teachers_tables',"*",$where,"","",array('OR','AND'));
		if($check==1){
		$dat=$this->admin_table->unversel_selection('teachers_tables',"*",$where,"","",array('OR','AND'));
		foreach($dat as $res){
			$data['fname'] = $res['Fname'];
			$data['classname'] = $res['ClassName'];
			$class = $res['ClassName'];
			$classEx = $res['ClassNameEx'];
			$data['subjectname'] = $res['SubjectNameEx'];
			$data['extra'] = $res['ClassNameEx'];
			$data['type'] = $res['Type'];
		}
		
		$clsEx = array();
		$clss = "";
		
		if(!is_null($classEx)){
			$clsEx = explode(',',$classEx);
		 }

		$ss = explode('_',$id)[0];

		if(count($clsEx)>0){
			$ids = $id;
			$x = explode('_',$id);
			$id = end($x);
			$clssE = str_replace('_'.$id,'',$ids);
			foreach($clsEx as $clss){
				if($clss == str_replace('_',' ',$clssE)){
					$class = $clss;
				}
			}
		}else{
			$class = $class;
		}
		
		$classExs = strtolower(explode(' ',$class)[0]);

		if(in_array($classExs, array('ss1','ss2','ss3')))
			$classExs = "sss";

		$data['_class_section'] = $classExs; 
		if($classExs == "jss" || $classExs == "sss"){
			$classExs = "secondary";
		}

		//echo $class;

		//select from teacher record table 
		$term = "";
		$where = array('ClassName'=>$class);

		$datas=$this->admin_table->unversel_selection($classExs.'_tables','Term',$where,"","",array('OR','AND'));
		foreach($datas as $res){
			$term = $res['Term'];
		}

		$where = array('id'=>$id);
		$datas=$this->admin_table->unversel_selection('subject_tables','SubjectName,Section',$where,"","",array('OR','AND'));
		foreach($datas as $res){
			$subject = $res['SubjectName'];
			$section = $res['Section'];
		}

		$ss = (!is_numeric($ids) && strpos(strtolower($ids), 's')) ? explode('_',strtolower($ids))[0].'_' : $section.'_';
		$subject = strtolower(str_replace(strtolower($ss).'_','',$subject));
		if(isset($_POST['sum'])){
			$iden = $_POST['id'];
			$ca1 = $_POST['ca1'];
			$ca2 = $_POST['ca2'];
			$mtt = $_POST['mtt'];
			$exam = $_POST['exam'];
			$total = $_POST['totals'];
			$grade = $_POST['grades'];
			$remark = $_POST['remarks'];
			$this->admin_table->updateData(str_replace($ss,'',str_replace(' ','_',$subject)),$iden,array('CA1'=>$ca1,'CA2'=>$ca2,'MTT'=>$mtt,'Exam'=>$exam,'Total'=>$total,'Grade'=>$grade,'Remark'=>$remark));
		}

		$where = array('Section'=>$section,'Class'=>$class,'Term'=>$term);
		$data['sub'] = $subject;
		$data['c'] = $class;
		//select the subject from the table 
		$data['datastring']=$this->admin_table->unversel_selection(str_replace($ss,'',str_replace(' ','_',$subject)),"*",$where,"","",array('OR','AND','AND'));
		$this->load->views('student/ca',$data);
	}else{
		$this->load->views('teacher/blacklist');
	}
	 }

	 function compute($id=""){
		 $id = str_replace('%20','_',$id);
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
			$data['classname'] = $res['ClassName'];
			$class = $res['ClassName'];
			$data['type'] = $res['Type'];
			$data['extra'] = $res['ClassNameEx'];
			$type = $res['Type'];
		}
		$ss = explode('_',$id);

		if(count($ss) > 2){
			$_sub = $ss[count($ss) - 3];
			$_subj = $ss[count($ss) - 2];
			$ss = $_sub.'_'.$_subj.'_';
		}else{
			$ss = explode('_',$id)[0].'_';
		}
		
		
		$x = explode('_',$id);
		$ids = end($x);
		$subject = str_replace('_'.$ids,'',$id);
		$where = array('id'=>$ids);

		if(count(explode('_',$subject)) > 2)
			$subject = explode('_',$subject)[1].'_'.explode('_',$subject)[2];

		if(count(explode('_',$subject)) == 2 && (strpos(strtolower($subject),'jss_')!==FALSE || strpos(strtolower($subject),'ss_')!==FALSE))
			$subject = explode('_',$subject)[1];

		$datas=$this->admin_table->unversel_selection(str_replace($ss,'',$subject),"*",$where,"","",array('OR','AND'));
		foreach($datas as $res){
			$data['fname'] = $res['FullName'];
			$data['Gender'] = $res['Gender'];
			$data['Class'] = $res['Class'];
			$data['CA1'] = $res['CA1'];
			$data['CA2'] = $res['CA2'];
			$data['MTT'] = $res['MTT'];
			$data['Exam'] = $res['Exam'];
			$data['Total'] = $res['Total'];
			$data['Grade'] = $res['Grade'];
			$data['Remark'] = $res['Remark'];
		}
		$data['id'] = $ids;
		$data['subject'] = $subject;
		$this->load->views('student/compute',$data);
	}else{
		$this->load->views('teacher/blacklist');
	}
	 }
	 
	 function register(){
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
			$data['classname'] = $res['ClassName'];
			$ss = strtolower(explode(' ',$res['ClassName'])[0]);
			$class = $res['ClassName'];
			$data['extra'] = $res['ClassNameEx'];
			$data['type'] = $res['Type'];
		}
		$section = strtolower(explode(' ',$class)[0]);
		$wh = array('Section'=>$section);
		$data['subjects']=$this->admin_table->unversel_selection('subject_tables',"SubjectName",$wh,"Id ASC",100);

		if(isset($_POST['register'])){
			$this->validations->set_data(array(
				array('field'=>'fname', 'label'=>'Full Name', 'rule'=>'required'),
				array('field'=>'sex', 'label'=>'Gender', 'rule'=>'required'),
				array('field'=>'session', 'label'=>'Session', 'rule'=>'required'),
				array('field'=>'term', 'label'=>'Term', 'rule'=>'required'),
				array('field'=>'subject', 'label'=>'Subject', 'rule'=>'required'),
				array('field'=>'pname', 'label'=>'Parent Name', 'rule'=>'required'),
				array('field'=>'phone', 'label'=>'Phone Number', 'rule'=>'required'),
				array('field'=>'address', 'label'=>'Address', 'rule'=>'required'),
				array('field'=>'rel', 'label'=>'Religion', 'rule'=>'required'),
				array('field'=>'post', 'label'=>'post', 'rule'=>'required')
				
			));
				
				if($this->validations->run_form()===FALSE){
					$data['error']=error_data();
				}else{
					$fname = ucwords($this->validations->get_postdata('fname'));
					$sex = ucwords($this->validations->get_postdata('sex'));
					$session = $this->validations->get_postdata('session');
					$term = $this->validations->get_postdata('term');
					$subject=$this->validations->get_postdata('subject');
					$pname=ucwords($this->validations->get_postdata('pname'));
					$phone=$this->validations->get_postdata('phone');
					$address = ucwords($this->validations->get_postdata('address'));
					$religious = ucwords($this->validations->get_postdata('rel'));
					$post = ucwords($this->validations->get_postdata('post'));
					$sub = implode(',',$subject);

					if($section == "jss" || $section == "sss")
						$sect = "secondary";
					else
						$sect = $section;

					$pns = '';
					
					$pinss = $this->auto_pins();
					$p=$this->admin_table->unversel_selection('pins_table',"Pins",array('Fname'=>$fname,'Session'=>$session,'Term'=>$term,'ClassName'=>$class),"","",array('OR','AND','AND','AND'));
					foreach($p as $ps){
						$pns = $ps['Pins'];
					}
					if($pns == $ss.'_'.$pinss){
						$password = $ss.'_'.$this->auto_pins();
					}else{
						$password = $ss.'_'.$this->auto_pins();
					}
					if(isset($_SESSION['images'])){
						$whs = array('Fname'=>$fname,'Term'=>$term,'ClassName'=>$class);
						$use=$this->admin_table->unversel_check($sect.'_tables',"*",$whs,"","",array('OR','AND','AND'));
						if($use > 0){
							$data['error'] = $fname. " Already exists the ".$class." in ".$term;
						}else{
							if(count($subject) > 0){
								
								foreach($subject as $sb){
									//$this->admin_table->auto_table(strtolower(str_replace(' ','_',$sb)),array('FullName VARCHAR(255) NOT NULL','Gender VARCHAR(100) NOT NULL','Term VARCHAR(255) NOT NULL','Section VARCHAR(255) NOT NULL','Class VARCHAR(255) NOT NULL','OpenSchool VARCHAR(255)','Present VARCHAR(255)','Absent VARCHAR(255)','CA1 VARCHAR(255)','CA2 VARCHAR(255)','MTT VARCHAR(255)','Exam VARCHAR(255)','Total VARCHAR(255)','Grade VARCHAR(255)','Remark VARCHAR(255)'));
									$this->admin_table->insertData(array('FullName'=>$fname,'Gender'=>$sex,'Term'=>$term,'Section'=>$section,'Class'=>$class,'Time_Add'=>date('Y-m-d H:i:sa')),str_replace($ss.'_','',str_replace(' ','_',strtolower($sb))));
								}
							}
							$this->admin_table->insertData(array('Fname'=>$fname,'Sex'=>$sex,'Session'=>$session,'Term'=>$term,'ClassName'=>$class,'Subject'=>$sub,'Password'=>$password,'ParentName'=>$pname,'ParentPhone'=>$phone,'Address'=>$address,'Religious'=>$religious,'Post'=>$post,'ImageName'=>$_SESSION['images'],'Time_Add'=>date('Y-m-d H:i:sa')),$sect.'_tables');
							$this->admin_table->insertData(array('Fname'=>$fname,'Session'=>$session,'Term'=>$term,'ClassName'=>$class),'pins_table'); 
							$data['msg'] =" ".$fname. " Successfully Registered Password is ".$password;
						}
						
					}
					
				}
		}
		
		
		$this->load->views("student/register",$data);
	}else{
		$this->load->views('teacher/blacklist');
	}
	 }

	 function auto_pins(){
		$random = mt_rand(000000,999999);
		return $random;
	 }

	 function registered(){
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
			$data['classname'] = $class = $res['ClassName'];
			//$class = $res['ClassName'];
			$data['extra'] = $res['ClassNameEx'];
			$data['type'] = $res['Type'];
		}
		$ss = explode(' ',strtolower($class))[0];
		if(in_array($ss, array('ss1','ss2','ss3')))
					$ss = "sss";
		if($ss=="jss" || $ss=="sss")
			$ss = "secondary";
		$wheres = array('ClassName'=>$class);
		$data['datastring']=$this->admin_table->unversel_selection($ss.'_tables',"*",$wheres,"","",array('OR','AND'));
		$section = strtolower(explode(' ',$class)[0]);
		$wheress = array('Section'=>$section);
		$checksub = array();
		$datastrings = $this->admin_table->unversel_selection('subject_tables',"*",$wheress,"","");
		foreach($datastrings as $subsss){
			$subsss['SubjectName'] = strtolower(str_replace(' ','_',$subsss['SubjectName']));
			if(strpos(strtolower($subsss['SubjectName']),'jss_') || strpos(strtolower($subsss['SubjectName']),'ss_'))
				$subsss['SubjectName'] = str_replace(substr(strtolower($subsss['SubjectName']),0,strlen(explode('_',strtolower($subsss['SubjectName']))[0])+1),'',$subsss['SubjectName']);

			
			$checks=$this->admin_table->unversel_check($subsss['SubjectName'],"*","","","");
			//echo $checks;
			if($checks==0){
				//foreach($checks as $subjectnamesss){
					$checksub[] = $subsss['SubjectName'];
				//} 
			}
		}
		$data['offer'] = (count($checksub) > 0) ? implode(',',$checksub) : "";
		$this->load->views("student/registered",$data);
	}else{
		$this->load->views("teacher/blacklist");
	}
	 }

	 function uploads(){
		if(!isset($_SESSION['user'])){
			$this->load->views('portal/login');
			exit;
		}

		$targetDir = 'images/profile/student/';
		if(!is_dir($targetDir)){
			$targetDir = mkdir($targetDir);
		}
		
		$allowType = array('jpg','png','jpeg','gif');

		$status = $errormsg = $errorupload = $erroruploadtype = '';

		$fileName = basename($_FILES['files']['name']);
		
		$targetFilePath = $targetDir.$fileName;

		$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
		$fileSize = $_FILES['files']['size'];
		$requireSize = 80 * 1024;
	   if(in_array($fileType, $allowType)){
			if($fileSize <= $requireSize){
				if(move_uploaded_file($_FILES['files']['tmp_name'], $targetFilePath)){
					$_SESSION['images'] = $targetDir.$_FILES['files']['name'];
					echo "<img src='".base_url($_SESSION['images'])."' alt='' style='width:20%'>";
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

	function edit(){
		if(!isset($_SESSION['user'])){
			$this->load->views('portal/login');
			exit;
		}

		$data['error'] = '';
		$where = array('Pnumber'=>$_SESSION['user']);
		$check=$this->admin_table->unversel_check('teachers_tables',"*",$where,"","",array('OR','AND'));
		if($check==1){
		$datas=$this->admin_table->unversel_selection('teachers_tables',"*",$where,"","",array('OR','AND'));
		foreach($datas as $res){
			$data['fname'] = $res['Fname'];
			$data['classname'] = $class = $res['ClassName'];
			//$class = $res['ClassName'];
			$data['type'] = $res['Type'];
		}
		$ss = explode(' ',strtolower($class))[0];

		$_store_section = "";
		if($ss=="jss" || $ss=="sss"){
			$_store_section = $ss;
			$ss = "secondary";
			 
		}
			

		if(isset($_POST['modify'])){
			$_subject = $_POST['subject'];
			$stud = "";

			if(is_array($_POST['students'])){
				$stud = implode(',',$_POST['students']);
			}else if(strtolower($_POST['students']) == 'all'){
				//select student from their class 
				$wheres = array('ClassName'=>$class);

				

				$st=$this->admin_table->unversel_selection($ss.'_tables',"*",$wheres,"","",array('OR','AND'));
				$ts = array();
				foreach($st as $t){
					//select the student on array data
					$ts[] = $t['Fname'];
				}
				$stud = implode(',',$ts);
			}
			
			if($stud !==""){
				$stu = explode(',',$stud);

				foreach($stu as $_stu){
					$_wheres = array('ClassName'=>$class,'Fname'=>$_stu);
					$_st=$this->admin_table->unversel_selection($ss.'_tables',"*",$_wheres,"","",array('OR','AND'));
					foreach($_st as $_t){
						$this->admin_table->insertData(array('FullName'=>$_t['Fname'],'Gender'=>$_t['Sex'],'Term'=>$_t['Term'],'Section'=>strtolower(explode(' ',$class)[0]),'Class'=>$class,'Time_Add'=>date('Y-m-d H:i:sa')),strtolower($_subject));
					}
				}

				$data['msg'] = "Data inserted";

			}else{
				$data['error'] = "Please insert a valid data";
			}
		}
		$wheres = array('ClassName'=>$class);
		$data['datastring']=$this->admin_table->unversel_selection($ss.'_tables',"*",$wheres,"","",array('OR','AND'));
		$section = strtolower(explode(' ',$class)[0]);
		$wheress = array('Section'=>$section);
		$checksub = array();
		$datastrings = $this->admin_table->unversel_selection('subject_tables',"*",$wheress,"","");
		foreach($datastrings as $subsss){
			
			$subsss['SubjectName'] = strtolower(str_replace(' ','_',$subsss['SubjectName']));
			
			if($_store_section != "")
				$subsss['SubjectName'] = str_replace($_store_section.'_','',$subsss['SubjectName']);

			$checks=$this->admin_table->unversel_check($subsss['SubjectName'],"*","","","");
			//echo $checks;
			if($checks==0){
				//foreach($checks as $subjectnamesss){
					$checksub[] = $subsss['SubjectName'];
				//} 
			}
		}
		$data['offer'] = (count($checksub) > 0) ? implode(',',$checksub) : "";
		$this->load->views("student/student-edit",$data);
	}else{
		$this->load->views("teacher/blacklist");
	}


	}

	function forms(){
		if(!isset($_SESSION['user'])){
			$this->load->views('portal/login');
			exit;
		}

		$where = array('Pnumber'=>$_SESSION['user']);
		
		$datas=$this->admin_table->unversel_selection('teachers_tables',"*",$where,"","",array('OR','AND'));
		foreach($datas as $res){
			
			$class = $res['ClassName'];
		}

		$ss = explode(' ',strtolower($class))[0];
		if($ss=="jss" || $ss=="sss")
			$ss = "secondary";
		$wheres = array('id'=>$_POST['id'],'ClassName'=>$class);
		$datas=$this->admin_table->unversel_selection($ss.'_tables',"*",$wheres,"","",array('OR','AND'));
		 foreach($datas as $res){
			$fname = $res['Fname'];
			$gender = $res['Sex'];
			$session = $res['Session'];
			$term = $res['Term'];
			$pass = $res['Password'];
			$parentname = $res['ParentName'];
			$phonephone = $res['ParentPhone'];
			$address = $res['Address'];
			$classname = $res['ClassName'];
			$subject = $res['Subject'];
			$rel = $res['Religious'];			
			$reg = $res['Time_Add'];
			$image = $res['ImageName'];
		 }
		 echo '<div style="margin:0 auto;width:50%;padding-bottom:15px;"> <img src="'.$image.'" alt="" style="width:30%;height:40%;"></div>';
		 echo '<table>';
		echo '<tr><td><strong>Full Name</strong></td><td>'.$fname.'</td></tr>';
		echo '<tr><td><strong>Gender</strong></td><td>'.$gender.'</td></tr>';
		echo '<tr><td><strong>Session</strong></td><td>'.$session.'</td></tr>';
		echo '<tr><td><strong>Term</strong></td><td>'.$term.'</td></tr>';
		echo '<tr><td><strong>Password</strong></td><td>'.$pass.'</td></tr>';
		echo '<tr><td><strong>Parent Name</strong></td><td>'.$parentname.'</td></tr>';
		echo '<tr><td><strong>Parent Phone</strong></td><td>'.$phonephone.'</td></tr>';
		echo '<tr><td><strong>Address</strong></td><td>'.$address.'</td></tr>';
		echo '<tr><td><strong>Class</strong></td><td>'.$classname.'</td></tr>';
		echo '<tr><td><strong>Subject</strong></td><td>'.$subject.'</td></tr>';
		echo '<tr><td><strong>Religious</strong></td><td>'.$rel.'</td></tr>';
        echo '<tr><td><strong>Time Registered</strong></td><td>'.$reg.'</td></tr>';
		echo '</table>';
	}

}
