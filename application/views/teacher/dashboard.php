<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Teacher| Dashboard</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/toastr/toastr.min.css" media="screen" >
        <link rel="stylesheet" href="css/icheck/skins/line/blue.css" >
        <link rel="stylesheet" href="css/icheck/skins/line/red.css" >
        <link rel="stylesheet" href="css/icheck/skins/line/green.css" >
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>        
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
                                        <a href="#"><i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>
                                     
                                    </li>

                                    <li class="nav-header">
                                        <span class="">Appearance</span>
                                    </li>
                                    <?php 
                                        
                                        if(isset($type) && (strtolower($type) == 'class' || strtolower($type) == 'subject') && !empty($classname)){
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
                                    <li class="has-children">
                                        <a href="#"><i class="fa fa-user"></i> <span>Student Form</span> <i class="fa fa-angle-right arrow"></i></a>
                                        <ul class="child-nav">
                                            <li><a href="<?php echo site_url('student/register');?>"><i class="fa fa-bars"></i> <span>Student Register</span></a></li>
                                            <li><a href="<?php echo site_url('student/sheet');?>"><i class="fa fa-bars"></i> <span>Print Student Report Sheet</span></a></li>
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
                                    <li><a href="<?php echo site_url('admin/changes');?>"><i class="fa fa fa-server"></i> <span> Teacher Change Password</span></a></li>
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
                                    <h2 class="title"><?php if(isset($FullName)) echo $FullName;?> Dashboard</h2>
                                  
                                </div>
                                <!-- /.col-sm-6 -->
                            </div>
                            <!-- /.row -->
                      
                        </div>
                        <!-- /.container-fluid -->

                        <section class="section">
                            <div class="container-fluid">
                                <div class="row">
                                        <?php 
                                            if(strtolower($type) == 'class'){
                                                ?>
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="margin-botton:16px;">
                                        <a class="dashboard-stat bg-success" href="<?php echo site_url('student/classes')?>">
                                            <span class="name"><?php echo $classname;?></span>
                                            <span class="bg-icon"><i class="fa fa-info-circle"></i></span>
                                        </a>
                                        <!-- /.dashboard-stat -->
                                    </div>
                                    <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->
                                                    <?php
                                                
                                            }else if(strtolower($type) == 'subject' || !empty($classname)){
                                                foreach(explode(',',$extra) as $clsEx){
                                                    $ss = explode('_',strtolower($clsEx))[0];
                                                    if($clsEx == $classname){
?>
                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="border:3px dotted #addeee;">
                                        <a class="dashboard-stat bg-success" href="<?php echo site_url('student/classes/'.str_replace(' ','_',$clsEx));?>">
                                            <span class="name"><?php echo $clsEx;?></span>
                                            <span class="bg-icon"><i class="fa fa-info-circle"></i></span>
                                        </a>
                                        <!-- /.dashboard-stat -->
                                    </div>
                                    <?php
                                                    }else{
?>
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="margin-bottom:16px;">
                                        <a class="dashboard-stat bg-success" href="<?php echo site_url('student/classes/'.str_replace(' ','_',$clsEx));?>">
                                            <span class="name"><?php echo $clsEx;?></span>
                                            <span class="bg-icon"><i class="fa fa-info-circle"></i></span>
                                        </a>
                                        <!-- /.dashboard-stat -->
                                    </div>
<?php
                                                    }
                                    ?>
                                    <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->
<?php
                                                }
                                            }
                                        ?>                                   

                                    

                                    
                                    <!-- /.col-lg-3 col-md-3 col-sm-6 col-xs-12 -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.container-fluid -->
                        </section>
                        <!-- /.section -->

                    </div>
                    <!-- /.main-page -->

                    
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /.main-wrapper -->


        <!-- ========== COMMON JS FILES ========== -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/jquery-ui/jquery-ui.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>
        <script src="js/waypoint/waypoints.min.js"></script>
        <script src="js/counterUp/jquery.counterup.min.js"></script>
        <script src="js/amcharts/amcharts.js"></script>
        <script src="js/amcharts/serial.js"></script>
        <script src="js/amcharts/plugins/export/export.min.js"></script>
        <link rel="stylesheet" href="js/amcharts/plugins/export/export.css" type="text/css" media="all" />
        <script src="js/amcharts/themes/light.js"></script>
        <script src="js/toastr/toastr.min.js"></script>
        <script src="js/icheck/icheck.min.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script src="js/production-chart.js"></script>
        <script src="js/traffic-chart.js"></script>
        <script src="js/task-list.js"></script>
        <script>
            $(function(){

                // Counter for dashboard stats
                $('.counter').counterUp({
                    delay: 10,
                    time: 1000
                });

                // Welcome notification
                toastr.options = {
                  "closeButton": true,
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": false,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": false,
                  "onclick": null,
                  "showDuration": "300",
                  "hideDuration": "1000",
                  "timeOut": "5000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }
                toastr["success"]( "<?php if(isset($_SESSION['admin'])) echo $_SESSION['user'];?> Welcome to your Dashboard!");

            });
        </script>
        
    </body>
</html>
