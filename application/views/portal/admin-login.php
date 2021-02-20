<!DOCTYPE html>
<html>
    <head>
        <title>Admin Login Area</title>
        <!-- BOOTSTRAP CORE STYLE CSS -->
  
        <style>
            *{box-sizing:border-box;margin:0;padding:0;}
            .modal{background-color:#eee;margin:10% auto;border:1px solid #ddd;width:50%;padding:16px;box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19)}
            input[type=text],input[type=password]{padding:12px 20px;border:1px solid #ccc;margin:8px 0;display:inline-block;color:#000;font-size:15px;width:100%}
            button{background-color:#4caf50;color:#fff;padding:14px 20px;border:none;cursor:pointer;width:30%;}
            button:hover{opacity:0.8;}
            .modal label{padding:8px 0;text-align:left;font-weight:bold;}
            
        </style>
    </head>
    <body>
        <div style="padding:16px;background-color:#34f7aa;width:80%;margin:auto;">
        <span style="font-size:18px;color:444;float:right;" onclick="parentElement.style.display='none'">&times;</span>
            <?php 
            if(isset($error) && $error!="")
                echo $error;
            ?>
        </div>
        <form action="<?php echo site_url('admin/login');?>" method="POST" class="modal">
            <label for="username">Username</label>
            <input type="text" name="username" placeholder="Enter your username">
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Enter your Password">
            <button type="submit" name="login" <?php if($_SESSION['error'] && $_SESSION['error']>=5) 'disabled';?>>Login</button>
        </form>
    </body>
</html>