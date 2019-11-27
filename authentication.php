<?php 
session_start();


if (isset($_SESSION['login_user'])) {
    header('Location:index.php');
}
?>
<!doctype html>
<html lang="en">
<?php 
  include ('x-head.php')
?>
  <body>
     <?php 
 include('x-header.php');
 ?>


    <div class="container">
      <div class="row">
    <div class="col" style=" border: 1px solid #1d8f1d; border-radius:5px 0px 0px 5px">
    
    <div class="text-center" style="padding:20%">
      <h2>E-Trading</h2>
      <img src="assets/img/icon1.png" width="80%">
    </div>
    </div>
    <div class="col" style=" background-color: #f0f0f0; border: 1px solid #1d8f1d; border-radius:0px 5px 5px 0px;" >

  <div class="text-center mb-4">
    <img class="mb-4"  src="assets/img/logo.png" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal" id="f_text">Login</h1>
  </div>
<div id="f_login">
<form class="form-signin" id="login_form" method="POST">
  <div class="form-label-group">
    <input type="text" id="inputEmail" class="form-control" placeholder="Username" name="username" required autofocus>
    <label for="inputEmail">Username</label>
  </div>

  <div class="form-label-group">
    <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required>
    <label for="inputPassword">Password</label>
  </div>

  <div class="checkbox mb-3">
    <label>
      <input type="checkbox" value="remember-me"> Remember me
    </label>
  </div>

  <input type="hidden" name="operation" value="submit_login">
  <button class="btn btn-lg btn-primary btn-block" type="submit" style="background-color: #1d8f1d" name="submit_login">Sign in</button>
  <div class="text-center">
     Don't have an account? <a href="#" id="a_sign">Sign up</a>
    </div>
    </form>
</div>
<div id="f_register">
  <form class="form-signin" id="register_form" method="POST">
     <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="acc_username">Username</label>
                  <input type="text" class="form-control" id="acc_username" name="acc_username" placeholder="" value=""  required="">
                </div>
                <div class="form-group col-md-6">
                  <label for="acc_email">Email:</label>
                  <input type="email" class="form-control" id="acc_email" name="acc_email" placeholder="" value="" required="">
                </div>
              </div>  
               <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="acc_name">Full Name</label>
                  <input type="text" class="form-control" id="acc_name" name="acc_name" placeholder="" value="" required="">
                </div>
              </div> 
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="acc_pass" id="l_acc_pass">Password</label>
                  <input type="password" class="form-control" id="acc_pass" name="acc_pass" placeholder="" value="" required="">
                </div>
                <div class="form-group col-md-6">
                  <label for="acc_cpass" id="l_acc_cpass">Confirm:</label>
                  <input type="password" class="form-control" id="acc_cpass" name="acc_cpass" placeholder="" value="" required="">
                </div>
              </div> 

              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="acc_add">Address</label>
                  <input type="text" class="form-control" id="acc_add" name="acc_add" placeholder="" value="" required="">
                </div>
              </div> 
               <button class="btn btn-lg btn-primary btn-block" type="submit" style="background-color: #1d8f1d" name="submit_register">Register</button>
   <div class="text-center">
     Already have an account? <a href="#" id="a_login">Login</a>
    </div>
  </form>
</div>

  <p class="mt-5 mb-3 text-muted text-center">&copy; <?php
            $fromYear = 2019; 
            $thisYear = (int)date('Y'); 
            echo $fromYear . (($fromYear != $thisYear) ? '-' . $thisYear : '');?> E-Trade, All rights reserved</p>

    </div>
  </div>

    </div>

</body>
<?php 
include('x-script.php');
?>
<script type="text/javascript">

   $('#f_register').hide();
   $(document).on('submit', '#login_form', function(event){
            event.preventDefault();

              $.ajax({
                url:"data-login.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                type:  'html',
                success:function(data)
                {
                  var newdata = JSON.parse(data);
                  if (newdata.success) {
                      alertify.alert(newdata.success).setHeader('Login Success');
                     window.location.assign("dashboard/");
                  }
                  else{
                    alertify.alert(newdata.error).setHeader('Error Login');
                  }
                }
              });
           
          });
      $(document).on('submit', '#register_form', function(event){
            event.preventDefault();

              $.ajax({
                url:"data-register.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                type:  'html',
                success:function(data)
                {
                  var newdata = JSON.parse(data);
                  console.log(newdata);
                  if (newdata.success) {
                      alertify.alert(newdata.success).setHeader('Successfully Register');
                     $('#f_login').show();
                     $('#f_register').hide();
                  }
                  else{

                    alertify.alert(newdata.error).setHeader('Register Error ');
                    
                  }
                }
              });
           
          });
  $(document).on('click', '#a_sign', function(){
    
       $('#f_text').text('Register');
        $('#f_login').hide();
        $('#f_register').show();
    });
  $(document).on('click', '#a_login', function(){
     $('#f_text').text('Login');
        $('#f_login').show();
        $('#f_register').hide();
    });
</script>
</html>
