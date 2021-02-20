<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Register Teacher | Dashboard</title>
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
                			<a class="navbar-brand" href="<?php echo site_url('admin/');?>">
                			    AL - FITRAH ISLAMIC ACADEMY | ADMIN CPANEL
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
                                <li class="hidden-sm hidden-xs"><a href="<?php echo site_url('admin/');?>" class="user-info-handle"><i class="fa fa-user"></i></a></li>
                                <li class="hidden-sm hidden-xs"><a href="#" class="full-screen-handle"><i class="fa fa-arrows-alt"></i></a></li>
                       
                				<li class="hidden-xs hidden-xs"><!-- <a href="#">My Tasks</a> --></li>
                               
                			</ul>
                            <!-- /.nav navbar-nav -->

                			<ul class="nav navbar-nav navbar-right" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                             
                				
                				    <li><a href="<?php echo site_url('admin/logout');?>" class="color-danger text-center"><i class="fa fa-sign-out"></i> Logout</a></li>
                					
                		
                            
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
                                <img src="#" alt="user" class="img-circle profile-img">
                                <h6 class="title"><?php if(isset($_SESSION['admin'])) echo $_SESSION['admin'];?></h6>
                                <small class="info">Register</small>
                            </div>
                            <!-- /.user-info -->

                            <div class="sidebar-nav">
                                <ul class="side-nav color-gray">
                                    <li class="nav-header">
                                        <span class="">Main Category</span>
                                    </li>
                                    <li>
                                        <a href="<?php echo site_url('admin/');?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>
                                     
                                    </li>

                                    <li class="nav-header">
                                        <span class="">Appearance</span>
                                    </li>
                                    <li class="has-children">
                                        <a href="#"><i class="fa fa-file-text"></i> <span>Admin Form</span> <i class="fa fa-angle-right arrow"></i></a>
                                        <ul class="child-nav">
                                            <li><a href="<?php echo site_url('admin/register');?>"><i class="fa fa-bars"></i> <span>Admin Register</span></a></li>
                                            <li><a href="<?php echo site_url('admin/registered');?>"><i class="fa fa fa-server"></i> <span>Admin Manager</span></a></li>      
                                        </ul>
                                    </li>
                                    
                                    <li class="has-children">
                                        <a href="#"><i class="fa fa-info-circle"></i> <span>Admin Info</span> <i class="fa fa-angle-right arrow"></i></a>
                                        <ul class="child-nav">
                                            <li><a href="<?php echo site_url('admin/profile');?>"><i class="fa fa-bars"></i> <span>Profile</span></a></li>
                                            <li><a href="<?php echo site_url('admin/editprofile');?>"><i class="fa fa fa-server"></i> <span>Edit Profile</span></a></li>
                                           
                                        </ul>
                                        <li><a href="<?php echo site_url('admin/changes');?>"><i class="fa fa fa-server"></i> <span> Admin Change Password</span></a></li>
                                           
                                    </li>
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
                                    <h2 class="title">Teacher Register</h2>      
                                </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->
                            
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="<?php echo site_url('admin/');?>"><i class="fa fa-home"></i> Home</a></li>
                                        <li><a href="<?php echo site_url('admin/teacher');?>">Teacher Registered</a></li>
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
                                                    <h5>Fill Teacher Register Info</h5>
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
                                                <form action="<?php echo site_url('register/teacher');?>" class="form-horizontal" method="post">
                                                <div class="form-group">
<label for="default" class="col-sm-2 control-label">Upload Image size 30kb</label>
<div class="col-sm-10">
<input type="file" name="files" class="form-control" id="files" onchange="auto_upload()" required="required" autocomplete="off">

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
<label for="default" class="col-sm-2 control-label">Password</label>
<div class="col-sm-10">
<input type="password" name="password" class="form-control" id="password" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Confirm Password</label>
<div class="col-sm-10">
<input type="password" name="confirmPassword" class="form-control" id="confirmPassword" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Email</label>
<div class="col-sm-10">
<input type="email" name="email" class="form-control" id="email" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Phone Number</label>
<div class="col-sm-10">
<input type="phone" name="phone" class="form-control" id="phone" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="teacher" class="col-sm-2 control-label">Select Class Teacher</label>
<div class="col-sm-10">
<select name="type" class="form-control" id="teachers" required="required">
        <option value="">Select Class Teacher</option>
        <option value="class">Class Teacher</option>
        <option value="subject">Subject Teacher</option>
    </select> 
</div>
</div>

<div class="form-group class" style="display:none">
<label for="section" class="col-sm-2 control-label">Select School</label>
<div class="col-sm-10">
    <select name="section" class="form-control" id="section">
        <option value="">Select School</option>
        <option value="nursery">Nursery</option>
        <option value="primary">Primary</option>
        <option value="secondary">Secondary</option>
    </select>
</div>

<br/>
<br/>
<div class="form-group nursery"  style="display:none;">
<label for="nursery" class="col-sm-2 control-label">Select Nursery</label>
<div class="col-sm-10">
    <select name="nursery00" class="form-control" id="nursery">
        <option value="">Select Nursery</option>
        <?php 
            if(count($datastring)>0){
                foreach($datastring as $row){
                    if($row['Section']=='nursery'){
                ?>
                    <option value="<?php echo $row['ClassName']?>"><?php echo $row['ClassName']?></option>            
                <?php
                    }
                }
            }
        ?>
    </select>
</div>
</div>

<div class="form-group primary"  style="display:none;">
<label for="primary" class="col-sm-2 control-label">Select Primary</label>
<div class="col-sm-10">
    <select name="primary00" class="form-control" id="primary">
        <option value="">Select Primary</option>
        <?php 
            if(count($datastring)>0){
                foreach($datastring as $row){
                    if($row['Section']=='primary'){
                ?>
                    <option value="<?php echo $row['ClassName']?>"><?php echo $row['ClassName']?></option>            
                <?php
                    }
                }
            }
        ?>
    </select>
</div>
</div>

<div class="form-group secondary"  style="display:none;">
<label for="secondary" class="col-sm-2 control-label">Select Secondary</label>
<div class="col-sm-10">
    <select name="secondary00" class="form-control" id="secondary">
        <option value="">Select Secondary</option>
        <?php 
            if(count($datastring)>0){
                foreach($datastring as $row){
                    if($row['Section']=='jss' || $row['Section']=='sss'){
                ?>
                    <option value="<?php echo $row['ClassName']?>"><?php echo $row['ClassName']?></option>            
                <?php
                    }
                }
            }
        ?>
    </select>
</div>
</div>

</div>

<div class="form-group subject" style="display:none">
<fieldset> 
    <legend>Primary</legend>
    <h4>Select the class you are teaching</h4>
    <?php
        if(count($datastring)>0){
            foreach($datastring as $rows){
                if($rows['Section'] == "primary"){
                ?>
                <label class="containers"> <?php echo $rows['ClassName'];?>
                    <input type="checkbox" name="classEx[]" value="<?php echo $rows['ClassName'];?>">
                    <span class="checkmark"></span>
                </label>
                <?php
                }
            }
        }
    ?>
    <hr/>
    <h4>Select the subject you are teaching</h4>
    <?php
        if(count($subject)>0){
            foreach($subject as $rows){
                if($rows['Section'] == "primary"){
                ?>
                <label class="containers"> <?php echo $rows['SubjectName'];?>
                    <input type="checkbox" name="subjectEx[]" value="<?php echo $rows['SubjectName'];?>">
                    <span class="checkmark"></span>
                </label>
                <?php
                }
            }
        }
    ?>    
</fieldset>
<fieldset> 
    <legend>Junior Secondary School</legend>
    <h4>Select the class you are teaching</h4>
    <?php
        if(count($datastring)>0){
            foreach($datastring as $rows){
                if($rows['Section'] == "jss"){
                ?>
                <label class="containers"> <?php echo $rows['ClassName'];?>
                    <input type="checkbox" name="classEx[]" value="<?php echo $rows['ClassName'];?>">
                    <span class="checkmark"></span>
                </label>
                <?php
                }
            }
        }
    ?>
    <hr/>
    <h4>Select the subject you are teaching</h4>
    <?php
        if(count($subject)>0){
            foreach($subject as $rows){
                if($rows['Section'] == "jss"){
                ?>
                <label class="containers"> <?php echo str_replace('jss_','',$rows['SubjectName']);?>
                    <input type="checkbox" name="subjectEx[]" value="<?php echo $rows['SubjectName'];?>">
                    <span class="checkmark"></span>
                </label>
                <?php
                }
            }
        }
    ?>    
</fieldset>
<fieldset> 
    <legend>Senior Secondary School</legend>
    <h4>Select the class you are teaching</h4>
    <?php
        if(count($datastring)>0){
            foreach($datastring as $rows){
                if($rows['Section'] == "sss"){
                ?>
                <label class="containers"> <?php echo $rows['ClassName'];?>
                    <input type="checkbox" name="classEx[]" value="<?php echo $rows['ClassName'];?>">
                    <span class="checkmark"></span>
                </label>
                <?php
                }
            }
        }
    ?>
    <hr/>
    <h4>Select the subject you are teaching</h4>
    <?php
        if(count($subject)>0){
            foreach($subject as $rows){
                if($rows['Section'] == "sss"){
                ?>
                <label class="containers"> <?php echo str_replace('sss_','',$rows['SubjectName']);?>
                    <input type="checkbox" name="subjectEx[]" value="<?php echo $rows['SubjectName'];?>">
                    <span class="checkmark"></span>
                </label>
                <?php
                }
            }
        }
    ?>    
</fieldset>
<label style="width:80%;margin:0 auto;text-align:left" class="containers">Are you also class teacher? If Yes Click to select your class
                    <input type="checkbox" id="cked" onclick="checks()">
                    <span class="checkmark"></span>
                </label>
<br/>
<br/>
<div class="form-group primary"  style="display:none;"  id="subject">
<label for="section" class="col-sm-2 control-label">Select School</label>
<div class="col-sm-10">
    <select name="class" class="form-control">
        <option value="">Select Class</option>
        <?php 
            if(count($datastring)>0){
                foreach($datastring as $row){
                    
                ?>
                    <option value="<?php echo $row['ClassName']?>"><?php echo $row['ClassName']?></option>            
                <?php
                    
                }
            }
        ?>
    </select>
</div>

</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Post</label>
<div class="col-sm-10">
<input type="text" name="post" class="form-control" placeholder="Enter Student Post" autocomplete="off">
</div>
</div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit" name="register" class="btn btn-primary">Register Teacher</button>
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

            document.getElementById('teachers').addEventListener('change',function(){
                if(this.value == 'class'){
                    var val = document.getElementsByClassName(this.value)[0];
                    vals = val.className.split(' ')[1];
                    document.getElementsByClassName(vals)[0].getElementsByTagName('select')[0].addEventListener('change',function(){
                        if(this.value == 'nursery'){
                            
                            document.getElementsByClassName(this.value)[0].style.display = "block";
                            document.getElementsByClassName("primary")[0].style.display = "none";
                            document.getElementsByClassName("secondary")[0].style.display = "none";
                        }else if(this.value == "primary"){
                            document.getElementsByClassName(this.value)[0].style.display = "block";
                            document.getElementsByClassName("nursery")[0].style.display = "none";
                            document.getElementsByClassName("secondary")[0].style.display = "none";
                        }else if(this.value=="secondary"){
                            document.getElementsByClassName(this.value)[0].style.display = "block";
                            document.getElementsByClassName("primary")[0].style.display = "none";
                            document.getElementsByClassName("nursery")[0].style.display = "none";
                        }else{
                            document.getElementsByClassName("nursery")[0].style.display = "none";
                            document.getElementsByClassName("primary")[0].style.display = "none";
                            document.getElementsByClassName("secondary")[0].style.display = "none";
                        }
                    });
                    val.style.display = "block"
                    
                    document.getElementsByClassName('subject')[0].style.display = "none";
                }else if(this.value == 'subject'){
                    document.getElementsByClassName(this.value)[0].style.display = "block";
                    document.getElementsByClassName('class')[0].style.display = "none";
                }else{
                    document.getElementsByClassName('subject')[0].style.display = "none";
                    document.getElementsByClassName('class')[0].style.display = "none";
                }
            });

            document.getElementById('class').addEventListener('change',function(){
                if(this.value == 'nursery'){
                    document.getElementsByClassName(this.value)[0].style.display = "block";
                    document.getElementsByClassName('primary')[0].style.display = "none";
                    document.getElementsByClassName('secondary')[0].style.display = "none";
                }else if(this.value == 'primary'){
                    document.getElementsByClassName(this.value)[0].style.display = "block";
                    document.getElementsByClassName('nursery')[0].style.display = "none";
                    document.getElementsByClassName('secondary')[0].style.display = "none";
                }else if(this.value == 'secondary'){
                    document.getElementsByClassName(this.value)[0].style.display = "block";
                    document.getElementsByClassName('nursery')[0].style.display = "none";
                    document.getElementsByClassName('primary')[0].style.display = "none";
                }else{
                    document.getElementsByClassName('nursery')[0].style.display = "none";
                    document.getElementsByClassName('primary')[0].style.display = "none";
                    document.getElementsByClassName('secondary')[0].style.display = "none";
                }
            });
            function checks(){
                var c = document.getElementById("cked");
                if(c.checked){
                    document.getElementById("subject").style.display = 'block';
                }else{
                    document.getElementById("subject").style.display = 'none';
                }
            }



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
            
            
            xhtml.open("POST","<?php echo site_url('register/uploads');?>");
            xhtml.send(data);
        }
    
        
    }catch(e){
        alert(e.message);
    }
    
    }
       </script>
    </body>
</html>
