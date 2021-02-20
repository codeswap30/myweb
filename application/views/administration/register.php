<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Register | Dashboard</title>
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
    </head>
    <body class="top-navbar-fixed">
        <div class="main-wrapper">
              <!-- topbar start -->
              <nav class="navbar top-navbar bg-white box-shadow">
            	<div class="container-fluid">
                    <div class="row">
                        <div class="navbar-header no-padding">
                			<a class="navbar-brand" href="<?php echo site_url('admin/');?>">
                			    AREWA SHOP | ADMIN CPANEL
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
                                <small class="info">Admin</small>
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
                                    <h2 class="title">Admin Register</h2>      
                                </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->
                            
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="<?php echo site_url('admin/');?>"><i class="fa fa-home"></i> Home</a></li>
                                
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
                                                    <h5>Fill Admin info</h5>
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
                                                <form action="<?php echo site_url('admin/register');?>" class="form-horizontal" method="post">

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Full Name</label>
<div class="col-sm-10">
<input type="text" name="fname" class="form-control" id="fname" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Username</label>
<div class="col-sm-10">
<input type="text" name="username" class="form-control" id="username" required="required" placeholder="Enter Username" autocomplete="off">
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
<input type="text" name="password" class="form-control" id="password" required="required" autocomplete="off">
</div>
</div>

<div class="form-group">
<label for="default" class="col-sm-2 control-label">Confirm Password</label>
<div class="col-sm-10">
<input type="text" name="confirmPassword" class="form-control" id="confirmPassword" required="required" autocomplete="off">
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
<label for="default" class="col-sm-2 control-label">Post</label>
<div class="col-sm-10">
<input type="text" name="post" class="form-control" placeholder="Enter Student Post" autocomplete="off" required>
</div>
</div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit" name="register" class="btn btn-primary">Add Admin</button>
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
       </script>
    </body>
</html>
