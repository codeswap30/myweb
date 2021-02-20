<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Student Record</title>
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

                                                <table id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Full Name</th>
                                                            <th>Gender</th>
                                                            <th>Class</th>
                                                            <th>Session</th>
                                                            <th>Term</th>
                                                            <th>Print</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                        <th>#</th>
                                                            <th>Full Name</th>
                                                            <th>Gender</th>
                                                            <th>Class</th>
                                                            <th>Session</th>
                                                            <th>Term</th>
                                                            <th>Print</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
<?php 
$cnt = 1;
if(isset($datastring) && count($datastring)> 0)
{
foreach($datastring as $result)
{   ?>
<tr>
 <td><?php echo htmlentities($cnt);?></td>
                                                            <td><?php echo htmlentities($result['Fname']);?></td>
                                                            <td><?php echo htmlentities($result['Sex']);?></td>
                                                            <td><?php echo htmlentities($result['ClassName']);?></td>
                                                            <td><?php echo htmlentities($result['Session']);?></td>
                                                            <td><?php echo htmlentities($result['Term']);?></td>
                                                            <td><a href="<?php echo site_url('student/print/'.$result['id']);?>" class="fa fa-edit"></a></td>
</tr>
<?php $cnt=$cnt+1;}} ?>
                                                       
                                                    
                                                    </tbody>
                                                </table>

                                         
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