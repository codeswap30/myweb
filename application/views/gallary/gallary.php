<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>AL - FITRAH ISLAMIC ACADEMY | GALLARY</title>
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
        .main{max-width:1000px;margin:auto;}
        .row{margin:8px -16px}
        .row, .row > .column{padding:8px}
        .column{float:left;width:33.33%;display:none}
        .row:after{content:"";display:table;clear:both;}
        .content{background-color:#fff;padding:10px}
        .show{display:block;}
        .btn{border:none;outline:none;padding:12px 16px;background-color:#4caf50;cursor:pointer}
        .btn:hover{background-color:#ddd;}
        .btn.active{background-color:#666;color:white;}
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
                     <li><a href="<?php echo site_url('home/portal');?>">Login Portal</a></li>
                    <li><a href="#">Photo gallary</a></li>
                     <li><a href="<?php echo site_url('home/admission');?>">Admission</a></li>
                     <li><a href="<?php echo site_url('home/news');?>">News</a></li>
                     <li><a href="<?php echo site_url('home/contact');?>">Contact</a></li>
                </ul>
            </div>
           
        </div>
    </div>
      <!--NAVBAR SECTION END-->
        <div class="main" >
             <h2>PORTFOLIO</h2>
            <div id="btnContainer">
                <button class="btn active" onclick="filterselection('all')">Show All</button>
                <button class="btn" onclick="filterselection('science')">Science Lab</button>
                <button class="btn" onclick="filterselection('computer')">Computer Lab</button>
                <button class="btn" onclick="filterselection('school')">School Environment</button>
            </div>

            <div class="row">
                <?php
                for($i=1;$i<=21;$i++){
                    ?>
                <div class="column science">
                    <div class="content">
                        <img src="img/science/<?php echo $i?>.jpg" alt="lab" style="width:100%">
                        <h4>Science Lab</h4>
                    </div>
                </div>
<?php
                }
?>

<?php
                for($i=1;$i<=3;$i++){
                    ?>
                <div class="column computer">
                    <div class="content">
                        <img src="img/computer/<?php echo $i?>.jpg" alt="lab" style="width:100%">
                        <h4>Computer Lab</h4>
                    </div>
                </div>
<?php
                }
?>

<?php
                for($i=1;$i<=20;$i++){
                    ?>
                <div class="column school">
                    <div class="content">
                        <img src="img/school/<?php echo $i?>.jpg" alt="lab" style="width:100%">
                        <h4>School Environment</h4>
                    </div>
                </div>
<?php
                }
?>
            </div>            
        </div>
             <!--/.HEADER LINE END-->

</div>
           
<div id="faculty-sec" >
    <div class="container set-pad">
             <div class="row text-center">
                 <div class="col-lg-8 col-lg-offset-2 col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
                     <h1 data-scroll-reveal="enter from the bottom after 0.1s" class="header-line">OUR FACULTY </h1>
                     <p data-scroll-reveal="enter from the bottom after 0.3s">
                      
                         </p>
                 </div>

             </div>
             <!--/.HEADER LINE END-->

           <div class="row" >
                 <div class="col-lg-4  col-md-4 col-sm-4" data-scroll-reveal="enter from the bottom after 0.4s">
                     <div class="faculty-div">
                     <img src="assets/img/faculty/computer.jpg" style="width:100%" class="img-rounded" />
                   <h3 >COMPUTER LAB</h3>
                 <hr />
                         <h4>Practical <br /> Computer faculty</h4>
                </div>
                   </div>
                 <div class="col-lg-4  col-md-4 col-sm-4" data-scroll-reveal="enter from the bottom after 0.5s">
                     <div class="faculty-div">
                     <img src="assets/img/faculty/science.jpg" style="width:60%;" class="img-rounded" />
                   <h3 >Science Lab</h3>
                 <hr />
                         <h4>Physic & Chemistry <br /> Lab</h4>
                </div>
                   </div>
               <div class="col-lg-4  col-md-4 col-sm-4" data-scroll-reveal="enter from the bottom after 0.6s">
                     <div class="faculty-div">
                     <img src="assets/img/faculty/arab.jpg" style="width:70%;" class="img-rounded" />
                   <h3 >Arabic</h3>
                 <hr />
                         <h4>Arabic Section</h4>
                </div>
                   </div>
                 
               </div>
             </div>
        </div>
    <!-- FACULTY SECTION END-->
      <div id="course-sec" class="container set-pad">
             <div class="row text-center">
                 <div class="col-lg-8 col-lg-offset-2 col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
                     <h1 data-scroll-reveal="enter from the bottom after 0.1s" class="header-line">OUR SCHOOLS </h1>
                     <p data-scroll-reveal="enter from the bottom after 0.3s">
                      we have three section in al-fitrah islamic academy the Nursery, Primary and Secondary.
                         </p>
                 </div>

             </div>
             <!--/.HEADER LINE END-->


           <div class="row set-row-pad" >
           <div class="col-lg-6 col-md-6 col-sm-6 " data-scroll-reveal="enter from the bottom after 0.4s" >
                 <img src="assets/img/lab.jpg" class="img-thumbnail" />
           </div>
               <div class="col-lg-4 col-md-4 col-sm-4 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
                   <div class="panel-group" id="accordion">
                        <div class="panel panel-default" data-scroll-reveal="enter from the bottom after 0.5s">
                            <div class="panel-heading" >
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" class="collapsed">
                                  <strong>3</strong> NURSERY SECTION 
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse1" class="panel-collapse collapse" style="height: 0px;">
                                <div class="panel-body">
                                    <ul>
                                        <li>Nursery One</li>
                                        <li>Nursery Two</li>
                                        <li>Nursery Three</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default" data-scroll-reveal="enter from the bottom after 0.7s">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" class="collapsed">
                                      <strong> 5</strong> PRIMARY SECTION
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse2" class="panel-collapse collapse" style="height: 0px;">
                                <div class="panel-body">
                                    <ul>
                                        <li>Primary One</li>
                                        <li>Primary Two</li>
                                        <li>Primary Three</li>
                                        <li>Primary Four</li>
                                        <li>Primary Five</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default" data-scroll-reveal="enter from the bottom after 0.9s">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" class="collapsed">
                                        <strong>   10</strong> SECONDARY SECTIOON 
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse3" class="panel-collapse collapse"  style="height: 0px;">
                                <div class="panel-body">
                                    <h2>Junior Section</h2>
                                    <ul>
                                        <li>Jss One Boys</li>
                                        <li>Jss One Girls</li>
                                        <li>Jss Two Boys</li>
                                        <li>Jss Two Girls</li>
                                        <li>Jss Three Boys</li>
                                        <li>Jss Three Girls</li>
                                    </ul>
                                    <h2>Senior Section</h2>
                                    <ul>
                                        <li>ss One Boys</li>
                                        <li>ss One Girls</li>
                                        <li>ss Two</li>
                                        <li>ss Three</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                   <div class="alert alert-info" data-scroll-reveal="enter from the bottom after 1.1s" >
                       <span style="font-size:18px;">
                          <strong>AL - FITRAH ISLAMIC ACADEMY TIME</strong> 
                           <hr />
                           <p><strong>7:30am - 1:20pm</strong> Morning Section Western Education</p>
                           <p><strong>1:20pm - 4:00pm</strong> Afternoon Section Islamic Education</p>
                       </span>
                   </div>
           </div>
             
                 
                 
               </div>
             </div>
      <!-- COURSES SECTION END-->
    <div id="contact-sec"   >
           <div class="overlay">
 <div class="container set-pad">
      <div class="row text-center">
                 <div class="col-lg-8 col-lg-offset-2 col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
                     <h1 data-scroll-reveal="enter from the bottom after 0.1s" class="header-line" >CONTACT US  </h1>
                     <p data-scroll-reveal="enter from the bottom after 0.3s">
                      
                         </p>
                 </div>

             </div>
             <!--/.HEADER LINE END-->
           <div class="row set-row-pad"  data-scroll-reveal="enter from the bottom after 0.5s" >
           
               
                 <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
                    <form>
                        <div class="form-group">
                            <input type="text" class="form-control "  required="required" placeholder="Your Name" />
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control " required="required"  placeholder="Your Email" />
                        </div>
                        <div class="form-group">
                            <textarea name="message" required="required" class="form-control" style="min-height: 150px;" placeholder="Message"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block btn-lg">SUBMIT REQUEST</button>
                        </div>

                    </form>
                </div>

                   
     
              
              
                
               </div>
                </div>
          </div> 
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
          &copy 2020 codedwapmaster | All Rights Reserved |  <a href="http://binarytheme.com" style="color: #fff" target="_blank">Design by : binarytheme.com</a>
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

<script>

filterselection('all');

function filterselection(c){
    var x, i;
    x = document.getElementsByClassName("column");
    if(c == "all") c = "";

    for(i = 0; i < x.length; i++){
        CDRemoveClass(x[i], "show");
        if(x[i].className.indexOf(c) > -1) CDAddClass(x[i], "show");
    }
}

function CDAddClass(element, name){
    var i, arr1, arr2;
    arr1 = element.className.split(" ");
    arr2 = name.split(" ");
    for(i = 0; i < arr2.length; i++){
        if(arr1.indexOf(arr2[i]) == -1){
            element.className +=" " + arr2[i];
        }
    }
}

function CDRemoveClass(element, name){
    var i, arr1, arr2;
    arr1 = element.className.split(" ");
    arr2 = name.split(" ");
    for(i = 0; i < arr2.length; i++){
        while(arr1.indexOf(arr2[i]) > -1){
            arr1.splice(arr1.indexOf(arr2[i]), 1)
        }
    }
    element.className = arr1.join(" ");
}

var btnContainer = document.getElementById("btnContainer");
var btns = btnContainer.getElementsByClassName("btn");
for(var i = 0; i < btns.length; i++){
    btns[i].addEventListener("click", function(){
        var current = document.getElementsByClassName("active");
        current[0].className = current[0].className.replace(" active","");
        this.className += " active";
    })
}
</script>
</body>
</html>