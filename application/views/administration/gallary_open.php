<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Manage Gallary</title>
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

.modals{
    display:none;
    position:fixed;
    z-index:1;
    left:0;
    top:0;
    width:100%;
    height:100%;
    overflow:auto;
    background-color:rgb(0,0,0);
    background-color:rgba(0,0,0,0.4);
    padding-top:60px;
}
.modals-content{
    background-color:#fefefe;
    margin:5px auto;
    border:1px solid #888;
    width:80%;
    padding:15px;
}
.close{
    color:#000;
    font-size:35px;
    font-weight:bold;
}
.close:hover, .close:focus{
    color:red;
    cursor:pointer;
}
.animate{
    -webkit-animation:animatezoom 0.6s;
    animation:animatezoom 0.6s;
}
@-webkit-keyframes animatezoom{
    from {-webkit-transform:scale(0);}
    to{-webkit-transform:scale(1);}
}

keyframes animatezoom{
    from {transform:scale(0)}
    to{transform:scale(1)}
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
        
        </style>
    </head>
    <body class="top-navbar-fixed">
        <div class="main-wrapper">

            <!-- ========== TOP NAVBAR ========== -->
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
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
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
                                <div class="col-md-6">
                                    <h2 class="title">Manage Video</h2>
                                
                                </div>
                                
                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
            							<li><a href="<?php echo site_url('admin/');?>"><i class="fa fa-home"></i> Home</a></li>
                                        <li class="active"><?php echo $files;?> Folder</li>
                                        <li><button class="btn btn-primary" onclick="document.getElementById('id02').style.display='block'">Upload File</button></li>
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
                                                    <h5>View Folder Info</h5>
                                                </div>
                                            </div>
<?php if(isset($msg)){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done!</strong><?php echo $msg; ?>
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
                                                            <th>Icon</th>
                                                            <th>Image</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                        <th>#</th>
                                                            <th>Icon</th>
                                                            <th>Image</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                    
                         <?php 
                            if(isset($datas) && count($datas) > 0){
                                foreach($datas as $row){
?>
<tr>
<td><?php echo $row['id'];?></td>
<td><img src="<?php echo base_url('img/icon/picture.jpeg')?>" style="width:10%"></td>
<td><?php echo $row;?></td>
<td><a href="<?php echo site_url('admin/gallary/'.$row['id']);?>">Delete</a></td>
</tr> 
<?php
                                }
                            }
                         ?>                             
                                                    
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
        
        <div id="id02" class="modals">
            <span onclick="document.getElementById('id02').style.display='none'" class="close" title="close Modal">&times;</span>
            <form class="modals-content animate" action="<?php echo site_url('admin/uplvideo');?>" method="post" enctype="multipart/form-data">
                <div id="progress"></div>
                <div id="shows"></div>
                <label for="section" class="col-sm-2 control-label">Upload Files</label>
                <input type="file" name="video_files" class="form-control" id="files" onchange="auto_upload()">
                <label for="folder">Folder Name: <?php echo $files;?></label> 
                <input type="hidden" name="folder" class="form-control" id="folder" value="<?php echo $files;?>">
                <button type="submit" name="submit-folder" class="btn btn-primary">Upload File</button>
            </form>
        </div>
        

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

            var modals = document.getElementById('id02');

            window.onclick = function(event){
                if(event.target == modals){
                    modals.style.display = "none";
                }
            }

            function auto_upload(){
                var xhtml;
                var profile = document.getElementById("files");
                var folder = document.getElementById("folder");
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
            data.append("video_files",profile.files[0]);
            data.append('folder',folder.value);
            xhtml.onreadystatechange = function(){
            if(this.readyState==4){
                document.getElementById('shows').innerHTML = this.responseText;
                progress.className = (this.status == 200 ? "success" : "failure");
                    //profile.value = "";
                }
            }
            
            
            xhtml.open("POST","<?php echo site_url('admin/uplvideo');?>");
            xhtml.send(data);
        }
        
                }catch(e){
                    alert(e.message);
                }
    
            }
        </script>
    </body>
</html>
