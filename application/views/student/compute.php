<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Compute| Dashboard</title>
        <link rel="stylesheet" href="<?php echo base_url('css/bootstrap.min.css');?>?>" media="screen" >
        <link rel="stylesheet" href="<?php echo base_url('css/font-awesome.min.css');?>" media="screen" >
        <link rel="stylesheet" href="<?php echo base_url('css/animate-css/animate.min.css');?>" media="screen" >
        <link rel="stylesheet" href="<?php echo base_url('css/lobipanel/lobipanel.min.css');?>" media="screen" >
        <link rel="stylesheet" href="<?php echo base_url('css/toastr/toastr.min.css');?>" media="screen" >
        <link rel="stylesheet" href="<?php echo base_url('css/icheck/skins/line/blue.css');?>" >
        <link rel="stylesheet" href="<?php echo base_url('css/icheck/skins/line/red.css');?>" >
        <link rel="stylesheet" href="<?php echo base_url('css/icheck/skins/line/green.css');?>" >
        <link rel="stylesheet" href="<?php echo base_url('css/main.css');?>" media="screen" >
        <script src="<?php echo base_url('js/modernizr/modernizr.min.js');?>"></script>
        <style>
            .containers{display:inline-block;position:relative;padding-left:35px;margin-bottom:12px;cursor:pointer;font-size:22px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;}
            .containers input{position:absolute;opacity:0;cursor:pointer;height:0;width:0;}
            .checkmark{position:absolute;top:0;left:0;height:25px;width:25px;background-color:#eee}
            .containers:hover input ~.checkmark{background-color:#aca30c}
            .containers input:checked ~.checkmark{background-color:#4caf50;}
            .checkmark:after{content:"";position:absolute;display:none;}
            .containers input:checked ~.checkmark:after{display:block}
            .containers .checkmark:after{
                left:9px;
                top:5px;
                width:5px;
                height:10px;
                border: solid #fff;
                border-width: 0 3px 3px 0;
                -webkit-transform:rotate(45deg);
                -ms-transform:rotate(45deg);
                transform:rotate(45deg);
            }
            fieldset{
                width:80%;
                margin:0 auto;
                margin-bottom:20px;
            }

            #progress p{
	        display: block;
	        width: 240px;
	        padding: 2px 5px;
	        margin: 2px 0;
	        border: 1px inset #446;
	        border-radius: 5px;
	        color:#fff;
        }
        #progress p.success{
	        background: #0c0 none 0 0 no-repeat;
        }

        #progress p.failed{
	        background: #c00 none 0 0 no-repeat;
        }
        
        #progresses p{
	        display: block;
	        width: 240px;
	        padding: 2px 5px;
	        margin: 2px 0;
	        border: 1px inset #446;
	        border-radius: 5px;
	        color:#fff;
        }
        #progresses p.success{
	        background: #0c0 none 0 0 no-repeat;
        }

        #progresses p.failed{
	        background: #c00 none 0 0 no-repeat;
        }
        </style>        
    </head>
    <body class="top-navbar-fixed">
        <div class="main-wrapper">
              <!-- topbar start -->
              <nav class="navbar top-navbar bg-white box-shadow">
            	<div class="container-fluid">
                    <div class="row">
                        <div class="navbar-header no-padding">
                			<a class="navbar-brand" href="dashboard.php">
                			    AL - FITRAH ISLAMIC ACADEMY | Teacher CPANEL
                			</a>
                            <span class="small-nav-handle hidden-sm hidden-xs"><i class="fa fa-outdent"></i></span>
                			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
                				<span class="sr-only">Toggle navigation</span>
                				<i class="fa fa-ellipsis-v"></i>
                			</button>
                            <button type="button" class="navbar-toggle mobile-nav-toggle" >
                				<i class="fa fa-bars"></i>
                			</button>
                		</div>
                        <!-- /.navbar-header -->

                		<div class="collapse navbar-collapse" id="navbar-collapse-1">
                			<ul class="nav navbar-nav" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                <li class="hidden-sm hidden-xs"><a href="#" class="user-info-handle"><i class="fa fa-user"></i></a></li>
                                <li class="hidden-sm hidden-xs"><a href="#" class="full-screen-handle"><i class="fa fa-arrows-alt"></i></a></li>
                       
                				<li class="hidden-xs hidden-xs"><!-- <a href="#">My Tasks</a> --></li>
                               
                			</ul>
                            <!-- /.nav navbar-nav -->

                			<ul class="nav navbar-nav navbar-right" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                             
                				    <li><a href="<?php echo site_url('home/logout');?>" class="color-danger text-center"><i class="fa fa-sign-out"></i> Logout</a></li>
                            
                			</ul>
                            <!-- /.nav navbar-nav navbar-right -->
                		</div>
                		<!-- /.navbar-collapse -->
                    </div>
                    <!-- /.row -->
            	</div>
            	<!-- /.container-fluid -->
            </nav>
              <!-- topbar end -->
              <div class="content-wrapper">
                <div class="content-container">
        <!-- sider start -->
        <div class="left-sidebar bg-black-300 box-shadow ">
                        <div class="sidebar-content">
                            <div class="user-info closed">
                            <img src="<?php if(isset($image)) echo $image;?>" alt="user" class="img-circle profile-img">
                                <h6 class="title"><?php if(isset($fname)) echo $fname;?></h6>
                                <small class="info">Teacher Profile</small>
                            </div>
                            <!-- /.user-info -->

                            <div class="sidebar-nav">
                                <ul class="side-nav color-gray">
                                    <li class="nav-header">
                                        <span class="">Main Category</span>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('home/dashboard');?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>
                                     
                                    </li>

                                    <li class="nav-header">
                                        <span class="">Appearance</span>
                                    </li>
                                    <?php 
                                        if(isset($type) && strtolower($type) == 'class' || (strtolower($type) == 'subject' && !empty($class))){
                                            ?>
                                    <li class="has-children">
                                        <a href="#"><i class="fa fa-user"></i> <span>Student Form</span> <i class="fa fa-angle-right arrow"></i></a>
                                        <ul class="child-nav">
                                            <li><a href="#"><i class="fa fa-bars"></i> <span>Student Register</span></a></li>
                                            <li><a href="<?php echo site_url('student/sheet');?>"><i class="fa fa-bars"></i> <span>Report Sheet Manager</span></a></li>
                                            
                                            <li><a href="<?php echo site_url('student/registered');?>"><i class="fa fa fa-server"></i> <span>Student Manager</span></a></li>      
                                        </ul>
                                    </li>
                                    <?php
                                        }

                                    ?>
                                    <li class="has-children">
                                        <a href="#"><i class="fa fa-file-text"></i> <span>Teacher Database</span> <i class="fa fa-angle-right arrow"></i></a>
                                        <ul class="child-nav">
                                            <li><a href="<?php echo site_url('teacher/test');?>"><i class="fa fa-bars"></i> <span>Test Question</span></a></li>
                                            <li><a href="<?php echo site_url('teacher/exam');?>"><i class="fa fa-bars"></i> <span>Exam Question</span></a></li>
                                        </ul>   
                                    </li>
                                    <li class="has-children">
                                        <a href="#"><i class="fa fa-info-circle"></i> <span>Teacher Info</span> <i class="fa fa-angle-right arrow"></i></a>
                                        <ul class="child-nav">
                                            <li><a href="<?php echo site_url('teacher/profile');?>"><i class="fa fa-bars"></i> <span>Profile</span></a></li>
                                        </ul>   
                                    </li>
                                    <li><a href="<?php echo site_url('home/changes');?>"><i class="fa fa fa-server"></i> <span> Teacher Change Password</span></a></li>
                                </ul>
                            </div>
                            <!-- /.sidebar-nav -->
                        </div>
                        <!-- /.sidebar-content -->
                    </div>  
        <!-- sider end -->
                    <div class="main-page">
                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-sm-6">
                                    <h2 class="title">Compute Result</h2>      
                                </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->
                            
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="<?php echo site_url('home/dashboard');?>"><i class="fa fa-home"></i> Home</a></li>
                                        <li><a href="<?php echo site_url('student/classes/'.str_replace(' ','_',$Class));?>">Return to <?php echo str_replace('_',' ',$Class);?></a></li>
                                        <li class="active">Compute</li>
                                    </ul>
                                </div>
                             
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.container-fluid -->

                        <div class="container-fluid">
                           
                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>Fill the Result For <?php echo $Class;?></h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">
<?php if(isset($msg) && !empty($msg)){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done!</strong><?php echo htmlentities($msg); ?>
 </div><?php } 
else if(isset($error) && !empty($error)){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Oh error!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                                <form action="<?php echo site_url('student/subject/'.$_SESSION['identify']);?>" class="form-horizontal" method="post">
          

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Full Name</label>
<div class="col-sm-10">
<?php echo $fname;?>
<input type="hidden" name="id" value="<?php echo $id;?>">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">CA1</label>
<div class="col-sm-10">
<input type="text" name="ca1" class="form-control" id="ca1" required="required" value="<?php echo $CA1?>" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">CA2</label>
<div class="col-sm-10">
<input type="text" name="ca2" class="form-control" id="ca2" required="required" value="<?php echo $CA2?>" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Mid Term Test</label>
<div class="col-sm-10">
<input type="text" name="mtt" class="form-control" id="mtt" required="required" value="<?php echo $MTT;?>" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Exam</label>
<div class="col-sm-10">
<input type="text" name="exam" class="form-control" id="exam" required="required" value="<?php echo $Exam?>" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Total</label>
<div class="col-sm-10">
<input type="text" name="total" class="form-control" id="total" value="<?php echo $Total?>" disabled>
<input type="hidden" name="totals" id="totals">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Grade</label>
<div class="col-sm-10">
<input type="text" name="grade" class="form-control" id="grade" value="<?php echo $Grade?>" disabled>
<input type="hidden" name="grades" id="grades">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Remark</label>
<div class="col-sm-10">
<input type="text" name="remark" class="form-control" id="remark" value="<?php echo $Remark;?>" disabled>
<input type="hidden" name="remarks" id="remarks">
</div>
</div>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit" name="sum" class="btn btn-primary">Compute Result</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-12 -->
                                </div>
                    </div>
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->
        </div>
        <!-- /.main-wrapper -->


        <!-- ========== COMMON JS FILES ========== -->
        <script src="<?php echo base_url('js/jquery/jquery-2.2.4.min.js');?>"></script>
        <script src="<?php echo base_url('js/jquery-ui/jquery-ui.min.js');?>"></script>
        <script src="<?php echo base_url('js/bootstrap/bootstrap.min.js');?>"></script>
        <script src="<?php echo base_url('js/pace/pace.min.js');?>"></script>
        <script src="<?php echo base_url('js/lobipanel/lobipanel.min.js');?>"></script>
        <script src="<?php echo base_url('js/iscroll/iscroll.js');?>"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="<?php echo base_url('js/prism/prism.js');?>"></script>
        <script src="<?php echo base_url('js/waypoint/waypoints.min.js');?>"></script>
        <script src="<?php echo base_url('js/counterUp/jquery.counterup.min.js');?>"></script>
        <script src="<?php echo base_url('js/amcharts/amcharts.js');?>"></script>
        <script src="<?php echo base_url('js/amcharts/serial.js');?>"></script>
        <script src="<?php echo base_url('js/amcharts/plugins/export/export.min.js');?>"></script>
        <link rel="stylesheet" href="<?php echo base_url('js/amcharts/plugins/export/export.css');?>" type="text/css" media="all" />
        <script src="<?php echo base_url('js/amcharts/themes/light.js');?>"></script>
        <script src="<?php echo base_url('js/toastr/toastr.min.js');?>"></script>
        <script src="<?php echo base_url('js/icheck/icheck.min.js');?>"></script>

        <!-- ========== THEME JS ========== -->
        <script src="<?php echo base_url('js/main.js');?>"></script>
        <script src="<?php echo base_url('js/production-chart.js');?>"></script>
        <script src="<?php echo base_url('js/traffic-chart.js');?>"></script>
        <script src="<?php echo base_url('js/task-list.js');?>"></script>
        <script>
            $(function($) {
                $(".js-states").select2();
                $(".js-states-limit").select2({
                    maximumSelectionLength: 2
                });
                $(".js-states-hide").select2({
                    minimumResultsForSearch: Infinity
                });
            });
try{
            var ca1,ca2,mtt,exam;
            var total = document.getElementById('total');
            total.value = 0;
            var totals = 0;

            ca1 = document.getElementById('ca1');
            ca1.addEventListener('change',function(){
                ca1 = this.value;
                if(ca1 <= 0){
                    alert("Please fill the box CA 1");
                    total.value = "";
                    this.value = "";
                    ca2.value = "";
                    mtt.value = "";
                    exam.value = "";
                }

                if(ca1 > 20){
                    alert("very large data");
                    total.value = "";
                    this.value = "";
                    ca2.value = "";
                    mtt.value = "";
                    exam.value = "";
                }else{
                    //var caf1;
                    //caf1 = parseInt(this.value);
                    total.value = 0;
                    total.value = parseInt(total.value) + parseInt(ca1);
                    //totals = total.value;
                         
                }

                
                
            });
            
            ca2 = document.getElementById('ca2');
            ca2.addEventListener('change',function(){
                ca2 = this.value;
                if(ca2 <= 0){
                    alert("Please fill the box CA 2");
                    total.value = "";
                    this.value = "";
                    mtt.value = "";
                    exam.value = "";
                }
                if(ca2 > 20){
                    alert("very large data");
                    total.value = "";
                    this.value = "";
                    mtt.value = "";
                    exam.value = "";
                }else{
                    
                    //total.value = parseInt(ca1) + parseInt(ca2);
                    total.value = parseInt(total.value) + parseInt(ca2);
                }

                
                
            });

            mtt = document.getElementById('mtt');
            mtt.addEventListener('change',function(){
                mtt = this.value;

                if(mtt <= 0){
                    alert("Please fill the box Mid Term Test");
                    total.value = "";
                    this.value = "";
                    exam.value = "";
                }

                if(mtt > 30){
                    alert("very large data");
                    total.value = "";
                    this.value = "";
                    exam.value = "";
                }else{
                    //alert(parseInt(total.value));
                    //total.value = parseInt(ca1) + parseInt(ca2)  + parseInt(mtt);
                    total.value = parseInt(total.value) + parseInt(mtt);
                }
               
            });
            _total = parseInt(total.value);
            exam = document.getElementById('exam');
            exam.addEventListener('change',function(){
                exam = this.value;
                

                if(exam <= 0){
                    alert("Please fill the box Exam");
                    total.value = "";
                    this.value = "";
                }

                if(exam > 60){
                    alert("very large data");
                    total.value = "";
                    this.value = "";
                }else{
                    //alert(total.value);
                    totals = parseInt(ca1) + parseInt(ca2) + parseInt(mtt) + parseInt(exam);
                    if(parseInt(total.value)==0){
                        total.value = parseInt(ca1) + parseInt(ca2) + parseInt(mtt) + parseInt(exam);;
                    }else{
                        total.value = parseInt(total.value) + parseInt(exam);
                    }

                    //alert(totals);
                   
                }

                
                if(totals > 100){
                    alert("very large data");
                    total.value = "";
                    this.value = "";
                }else{

                    if(isNaN(parseInt(total.value))==true){
                        document.getElementById("totals").value = "Not A Number";    
                    }else{
                        //total.value = totals;
                        document.getElementById('totals').value = totals;
                    }
                    
                }

                calcuate_grade();
                
                
            });

           

            function calcuate_grade(){

                //alert(totals);
                if(totals >= 75 && totals <= 100){
                    document.getElementById('grade').value = "A";
                    grade = "A"
                    
                    document.getElementById('grades').value = "A";
                }else if(totals >= 60 && totals <= 74){
                    document.getElementById('grade').value = "B";
                    grade = "B"
                    document.getElementById('grades').value = "B";
                }else if(totals >= 50 && totals <= 59){
                    document.getElementById('grade').value = "C";
                    grade = "C"
                    document.getElementById('grades').value = "C";
                }else if(totals >= 40 && totals <= 49){
                    document.getElementById('grade').value = "D";
                    grade = "D"
                    document.getElementById('grades').value = "D";
                }else if(totals >= 0 && totals <= 39){
                    document.getElementById('grade').value = "E";
                    document.getElementById('grades').value = "E";
                    grade = "E"
                }
                
                if(grade == "A"){
                    document.getElementById("remark").value="Excellent";
                    document.getElementById("remarks").value="Excellent";
                }else if(grade == "B"){
                    document.getElementById("remark").value="Very Good";
                    document.getElementById("remarks").value="Very Good";
                }else if(grade == "C"){
                    document.getElementById("remark").value="Credit";
                    document.getElementById("remarks").value="Credit";
                }else if(grade == "D"){
                    document.getElementById("remark").value="Passed";
                    document.getElementById("remarks").value="Passed";
                }if(grade == "E"){
                    document.getElementById("remark").value="Failed";
                    document.getElementById("remarks").value="Failed";
                }

                //alert(totals);
            }
}catch(e){
    alert(e);
}
       </script>
    </body>
</html>
