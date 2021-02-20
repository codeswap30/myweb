<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>AL - FITRAH ISLAMIC ACADEMY | LOGIN PORTAL</title>
    <!-- BOOTSTRAP CORE STYLE CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME CSS -->
<link href="assets/css/font-awesome.min.css" rel="stylesheet" />
     <!-- FLEXSLIDER CSS -->
<link href="assets/css/flexslider.css" rel="stylesheet" />
    <!-- CUSTOM STYLE CSS -->
    <link href="assets/css/style.css" rel="stylesheet" />    
  <!-- Google	Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css' />
    <style>
        .containers{
            border-radius:5px;
            background-color:#f2f2f2;
            padding:20px;
            border:1px solid #f1f1f1;
            text-align:center;padding:16px 0;
            width:50%;
            margin:auto;
            box-shadow:0 4px 8px 0 rgba(0,0,0,0.2);}
        input[type=text],
        input[type=password]{
            width:100%;padding:12px 20px;margin:8px 0;display:inline-block;border:1px solid #ccc;
        }
        button{background-color:#4caf50;color:#fff;padding:14px 20px;margin:8px 0;border:none;cursor:pointer;width:100%}
        button:hover{opacity:0.8}
        .imgcontainer{text-align:center;margin:24px 0 12px 0;}
        img.logo{width:40%;border-radius:50%;}
        @media screen and (max-width:750px){
            .containers{width:100%;}
        }
    </style>
</head>
<body >
   
 <div class="navbar navbar-inverse navbar-fixed-top " id="menu">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo site_url('home/portal');?>"><strong style="color:#fff">AL - FITRAH ISLAMIC ACADEMY</strong></a>
            </div>
            <div class="navbar-collapse collapse move-me">
                <ul class="nav navbar-nav navbar-right">
                    <li ><a href="<?php echo site_url('home/');?>">HOME</a></li>
                     <li><a href="#">Login Portal</a></li>
                    <li><a href="<?php echo site_url('home/gallary');?>">Photo gallary</a></li>
                     <li><a href="<?php echo site_url('home/admission');?>">Admission</a></li>
                     <li><a href="<?php echo site_url('home/news');?>">News</a></li>
                     <li><a href="<?php echo site_url('home/contact');?>">Contact</a></li>
                </ul>
            </div>
           
        </div>
    </div>
      <!--NAVBAR SECTION END-->
      <div class="containers" data-scroll-reveal="enter from the bottom after 0.2s">
        <h1 class="header-line">LOGIN PORTAL </h1>
      <?php
                        if(isset($msg)){
                            echo $msg;
                        }else if(isset($error)){
                            echo $error;
                        }
                     ?>
        <div class="imgcontainer">
            <img src="" alt="logo" class="logo">
        </div>
                   <form action="<?php echo site_url('home/portal');?>" method="post" style="padding:15px;">
                        <div class="form-group">
                            <input type="text" class="form-control" name="username"  required="required" placeholder="Enter your Phone Number" />
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" required="required" placeholder="Enter Your Password" />
                        </div>
                        <div class="form-group">
                            <button type="submit" name="login" class="btn btn-info btn-block btn-lg">Login</button>
                        </div>
                    </form>
      </div>
        <div class="container">
             <div class="row set-row-pad"  >
    <div class="col-lg-4 col-md-4 col-sm-4   col-lg-offset-1 col-md-offset-1 col-sm-offset-1 " data-scroll-reveal="enter from the bottom after 0.4s">

                    <h2 ><strong>Our Location </strong></h2>
        <hr />
                    <div>
                        <h4>Along Top Medical Road, Tunga Minna</h4>
                        <h4>Niger State.</h4>
                        <h4><strong>Call:</strong>   </h4>
                        <h4><strong>Email: </strong>info@alfitrahIslamicacademy.edu.ng</h4>
                    </div>


                </div>
                 <div class="col-lg-4 col-md-4 col-sm-4   col-lg-offset-1 col-md-offset-1 col-sm-offset-1" data-scroll-reveal="enter from the bottom after 0.4s">

                    <h2 ><strong>Social Conectivity </strong></h2>
        <hr />
                    <div >
                        <a href="#">  <img src="assets/img/Social/facebook.png" alt="" /> </a>
                     <a href="#"> <img src="assets/img/Social/google-plus.png" alt="" /></a>
                     <a href="#"> <img src="assets/img/Social/twitter.png" alt="" /></a>
                    </div>
                    </div>


                </div>
                 </div>
     <!-- CONTACT SECTION END-->
     <div id="footer">
          &copy 2020 codedwapmaster | All Rights Reserved |  <a href="http://codedwapmaster.com" style="color: #fff" target="_blank">Design by : codedwapmaster.com</a>
    </div>
     <!-- FOOTER SECTION END-->
   
    <!--  Jquery Core Script -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!--  Core Bootstrap Script -->
    <script src="assets/js/bootstrap.js"></script>
    <!--  Flexslider Scripts --> 
         <script src="assets/js/jquery.flexslider.js"></script>
     <!--  Scrolling Reveal Script -->
    <script src="assets/js/scrollReveal.js"></script>
    <!--  Scroll Scripts --> 
    <script src="assets/js/jquery.easing.min.js"></script>
    <!--  Custom Scripts --> 
         <script src="assets/js/custom.js"></script>
</body>
</html>
