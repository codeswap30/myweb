<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Result Card</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" > <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
        <link rel="stylesheet" type="text/css" href="js/DataTables/datatables.min.css"/>
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
          <style>
        .errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}

*{box-sizing: border-box;padding:0;margin:0}
            .result-container{padding:0;margin:0 auto;width:80%;border:1px solid #000;}
            .result-header{padding:10px;margin:0;width:100%;background-color:#4caf60;}
            .row:after{content:"";clear:both;display:block;}
            [class*="cols-"]{float:left;}
            .cols-1{width:8.33%;}
            .cols-2{width:16.66%;}
            .cols-3{width:25%;}
            .cols-4{width:33.33%;}
            .cols-5{width:41.65%;}
            .cols-6{width:50%;}
            .cols-7{width:58.31%;}
            .cols-8{width:66.64%;}
            .cols-9{width:75%;}
            .cols-10{width:83.3%;}
            .cols-11{width:91.63%;}
            .cols-12{width:100%;}
            .result-container p{line-height:10px;}
            .result-content table,.result-content td,.result-content th{border:1px solid #000;border-collapse:collapse;}
        </style>
    </head>
    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
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
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
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
                                    <li class="has-children">
                                        <a href="#"><i class="fa fa-user"></i> <span>Student Form</span> <i class="fa fa-angle-right arrow"></i></a>
                                        <ul class="child-nav">
                                            <li><a href="<?php echo site_url('student/register');?>"><i class="fa fa-bars"></i> <span>Student Register</span></a></li>
                                            <li><a href="<?php echo site_url('student/sheet');?>"><i class="fa fa-bars"></i> <span>Print Student Report Sheet</span></a></li>
                                            <li><a href="<?php echo site_url('student/manage');?>"><i class="fa fa fa-server"></i> <span>Student Manager</span></a></li>      
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
                                <div class="col-md-6">
                                    <h2 class="title">Manage Teachers</h2>
                                
                                </div>
                                
                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
            							<li><a href="<?php echo site_url('home/dashboard');?>"><i class="fa fa-home"></i> Home</a></li>
                                        <li> Student Report Sheet</li>
            						</ul>
                                </div>
                             
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.container-fluid -->

                        <section class="section">
                            <div class="container-fluid">

                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>View Student Manager</h5>
                                                </div>
                                            </div>
<?php if(isset($msg)){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done!</strong> <?php echo $msg; ?>
 </div><?php } 
else if(isset($error)){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Oh snap!</strong> <?php echo $error; ?>
                                        </div>
                                        <?php } ?>
                                            <div class="panel-body p-20">
                                            <div class="result-container">
            <div class="result-header">
                <div class="row">
                    <div class="cols-3">
                        <div style="text-align:center;width:80%;margin:0 auto;overflow:hidden">
                            <img src="logo.jpg" style="width:80%;"/>
                        </div>
                    </div>
                    <div class="cols-6" style="color:#fff;font-weight:lighter;font-size:16px;font-family: 'Times New Roman', Times, serif;padding:5px 0px;text-align: center;">
                        <h2 style="text-align:center;font-size:25px;">AL - FITRAH ISLAMIC ACADEMY</h2>
                        <p style="opacity: .8;font-size: medium;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;padding:0;margin:10px;">UpHill Top Medical Road, Tunga, Minna</p>
                        <p style="opacity: .8;font-size: medium;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">Email: alfitrahacad@gmail.com</p>
                    </div>
                    <div class="cols-3">
                        <div style="width:80%;text-align:center;margin:0 auto;overflow:hidden">
                            <img src="<?php echo base_url($image)?>" style="width:80%;"/>
                        </div>
                    </div>
                </div>
                <div class="row" style="font-family:Arial, Helvetica, sans-serif;font-size:medium;color:#fff;font-weight: lighter;">
                    <div class="cols-4" style="padding:17px;line-height: 25px;">
                        <p><strong>Name: <?php if(isset($name)) echo $name;?></strong></p>
                        <p><strong>Class: <?php if(isset($class)) echo $class;?></strong></p>
                    </div>
                    <div class="cols-4" style="padding:17px;line-height: 25px;">
                        <p><strong>Sex: <?php if(isset($sex)) echo $sex;?></strong></p>
                        <p><strong>Session: <?php if(isset($session)) echo $session;?></strong></p>
                    </div>
                    <div class="cols-4" style="padding:17px;line-height: 25px;">
                        <p><strong>Term: <?php if(isset($term)) echo $term;?></strong></p>
                    </div>
                </div>
            </div>
            <div class="result-content">
                <table>
                    <tr>
                        <td>S/N</td>
                        <td>CA1</td>
                        <td>CA2</td>
                        <td>MTT</td>
                        <td>EXAM</td>
                        <td>TOTAL</td>
                        <td>GRADE</td>
                        <td>REMARK</td>
                    </tr>
                    <?php

                    //print_r($subject); 
                        if(isset($subject) && count($subject) > 0){
                            foreach($subject as $row){
                                ?>
<?php echo $row;?>
                                <?php
                            }
                        }
?>
<tr><td>Total</td><td></td><td></td><td></td><td></td><td><?php echo $Totals;?></td></tr>
                </table>
            </div>
        </div>
              
                                         
                                                <!-- /.col-md-12 -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-6 -->

                                                               
                                                </div>
                                                <!-- /.col-md-12 -->
                                            </div>
                                        </div>
                                        <!-- /.panel -->
                                    </div>
                                    <!-- /.col-md-6 -->

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
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>
        <script src="js/DataTables/datatables.min.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script>
            $(function($) {
                $('#example').DataTable();

                $('#example2').DataTable( {
                    "scrollY":        "300px",
                    "scrollCollapse": true,
                    "paging":         false
                } );

                $('#example3').DataTable();
            });

        </script>
    </body>
</html>