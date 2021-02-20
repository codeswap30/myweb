<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Student Register | Dashboard</title>
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
                                        if(isset($type) && strtolower($type) == 'class' || (strtolower($type) == 'subject' && !empty($classname))){
                                            ?>
                                       <li class="has-children">
                                            <a href="#"><i class="fa fa-user"></i> <span><?php echo explode(' ',$classname)[0];?></span> <i class="fa fa-angle-right arrow"></i></a>
                                            <?php
                                            if(strtolower($type) == 'subject'){
                                                foreach(explode(',',$extra) as $clsEx){
                                                    $ss = explode('_',strtolower($clsEx))[0];
                                                    
                                            ?>
                                    
                                            <ul class="child-nav">
                                                <li><a href="<?php echo site_url('student/classes/'.str_replace(' ','_',$clsEx));?>"><?php echo $clsEx;?></a></li>
                                           </ul>
                                           <?php 
                                                    
                                                }
                                            }else{
                                             ?>

                                            <ul class="child-nav">
                                                <li><a href="<?php echo site_url('student/classes')?>"><?php echo $classname;?></a></li>
                                            </ul>
                                    
                                             <?php       


                                            }
                                    ?>
                                    </li>
                                    <?php    }

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
                                    <h2 class="title">Student Register</h2>      
                                </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->
                            
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="<?php echo site_url('home/dashboard');?>"><i class="fa fa-home"></i> Home</a></li>
                                        <li><a href="<?php echo site_url('student/registered');?>">Student Registered</a></li>
                                        <li class="active">Register</li>
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
                                                    <h5>Fill Student Register Info</h5>
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
                                                <form action="<?php echo site_url('student/register');?>" class="form-horizontal" method="post">
                                                <div class="form-group">
<label for="default" class="col-sm-2 control-label">Upload Image size 80kb</label>
<div class="col-sm-10">
<input type="file" name="files" class="form-control" id="files" onchange="auto_upload()">

<div id="progress"></div>
<div id="images"></div>

</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Full Name</label>
<div class="col-sm-10">
<input type="text" name="fname" class="form-control" id="fname" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Gender</label>
<div class="col-sm-10">
<select name="sex" class="form-control" id="default" required="required">
                                                <option value="">Select Gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Select Session</label>
<div class="col-sm-10">
<select name="session" class="form-control" id="default" required="required">
                                                <option value="">Select Session</option>
                                                <option value="2019/2020">2019/2020</option>
                                            </select>
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Select Term</label>
<div class="col-sm-10">
<select name="term" class="form-control" id="default" required="required">
                                                <option value="">Select Term</option>
                                                <option value="1st Term">1st Term</option>
                                                <option value="2nd Term">2nd Term</option>
                                                <option value="3rd Term">3rd Term</option>
                                            </select>
</div>
</div>

<div class="form-group">
<fieldset style="width:80%;padding:16px;">
<legend><?php echo $classname;?></legend>
<h4>Select subject</h4>
    <?php
        $ss = strtolower(explode(' ',$classname)[0]);
        if(count($subjects)>0){
            foreach($subjects as $rows){
                
                ?>
                <label class="containers"> <?php echo str_replace($ss.'_','',$rows['SubjectName']);?>
                    <input type="checkbox" name="subject[]" value="<?php echo $rows['SubjectName'];?>">
                    <span class="checkmark"></span>
                </label>
                <?php
                
            }
        }
    ?>
</fieldset>

</div>


<div class="form-group">
<label for="default" class="col-sm-2 control-label">Parent Name</label>
<div class="col-sm-10">
<input type="text" name="pname" class="form-control" id="pname" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Parent Phone Number</label>
<div class="col-sm-10">
<input type="phone" name="phone" class="form-control" id="phone" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Address </label>
<div class="col-sm-10">
<input type="text" name="address" class="form-control" id="address" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Religious </label>
<div class="col-sm-10">
<input type="text" name="rel" class="form-control" id="religious" value="Islam">
</div>
</div>


<div class="form-group">
<label for="default" class="col-sm-2 control-label">Posi</label>
<div class="col-sm-10">
<input type="text" name="post" class="form-control" placeholder="Enter Student Post" autocomplete="off">
</div>
</div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit" name="register" class="btn btn-primary">Register Student</button>
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

    function auto_upload(){
    var xhtml;
    var profile = document.getElementById("files");
    var success = document.getElementById("progress");
    
        if(profile.value ==""){
            return false;
        }
    
        try{
        if(window.XMLHttpRequest){
            xhtml = new XMLHttpRequest();
        }else{
            xhtml = new ActiveXObject("Microsoft.XMLHttp");
        }
        
        
        if(xhtml.upload){
        // create progress bar
		    var o = success;
		    var file = profile.files[0];
		    var progress = o.appendChild(document.createElement("p"));
		    progress.appendChild(document.createTextNode("upload " + file.name));
		    xhtml.upload.addEventListener("progress", function(e) {
			    var pc = parseInt((e.loaded / e.total * 100));
			    progress.style.backgroundPosition = pc + "% 0";
			    
			    //progress.innerHTML = pc + "% 0";
		    }, false);
		    
		    var data = new FormData();
            data.append("files",profile.files[0]);
            xhtml.onreadystatechange = function(){
                if(this.readyState==4){
                    document.getElementById('images').innerHTML = this.responseText;
                    progress.className = (this.status == 200 ? "success" : "failure");
                    //profile.value = "";
                }
            }
            
            
            xhtml.open("POST","<?php echo site_url('student/uploads');?>");
            xhtml.send(data);
        }
    
        
    }catch(e){
        alert(e.message);
    }
    
    }
       </script>
    </body>
</html>
