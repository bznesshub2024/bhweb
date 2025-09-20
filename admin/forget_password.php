<?php
include('../app/db_connection.php'); 

$error=$message=''; // Variable To Store Error Message
include('common_function.php');


$Common_Function = new Common_Function();

if(isset($_POST['emailvalue'])){
	$email_id = trim($_POST['emailvalue']);
	
	$query = $conn->query("SELECT fullname,email FROM `admin_login` WHERE email ='".$email_id."'");
	if($query->num_rows > 0){
		$rows = $query->fetch_assoc();
		
		$adminname = $rows['fullname'];
		$admin_email = $rows['email'];
		
		$checksum = date('dym').$Common_Function->random_strings(10).date('his');
		
		$query = $conn->query("UPDATE `admin_login` SET checksum ='".$checksum."' WHERE email ='".$email_id."'");
		
		$Common_Function->send_email_forgot_password($conn,$admin_email,$adminname,$checksum,BASEURL,'Forgot Password');
		$message ="Mail sent successfully";
	}else{
		$error = "User Not Exist";
	}
	
}
?>
<!DOCTYPE html>
<!-- saved from url=(0014)about:internet -->
<html lang="en">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <title>Admin Login</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" type="image/png" href="">
      <!-- Bootstrap Core CSS -->
      <link href="<?php echo BASEURL; ?>assets/css/bootstrap.css" rel='stylesheet' type='text/css' />
	  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

      <!-- font-awesome icons CSS-->
      <link href="<?php echo BASEURL; ?>assets/css/font-awesome.css" rel="stylesheet">
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
      <!-- //font-awesome icons CSS-->
      <link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>assets/login/animate.css">
      <link rel="stylesheet" type="text/css" href="<?php echo BASEURL; ?>assets/login/main.css">
      <meta name="robots" content="noindex, follow">
   </head>
   <style>
	.wrap-login100{
		background: transparent !important;
		border: 1px solid white !important;
		padding: 50px !important;
	}
	.vendor_login_box {
        border: 0px;
		color: white !important;
		font-size: 14px;
        border-bottom: 1px solid white;
        background-color: transparent;
        border-radius: 0px !important;
		margin-left: 10px;
    }

	.vendor_login_box::placeholder{
		color: #ffffffcf !important;
	}
	
	.vendor_login_box:focus{
		border-bottom: 1px solid white !important;
	}
	.vendor-login-icons{
		margin-top: 15px;
	}
	@media (max-width: 576px) and (min-width: 250px) {		
		.vendor_login_box{
			font-size: 12px !important;
		}
	}
	.login100-form {
		width: 400px;
	}
	
	@media (min-width: 576px) and (max-width: 767px){
		.login100-form{
			width: 100%!important;
		}
	}

   </style>
   <body>
      <div class="limiter">
         <div class="container-login100">
            <div class="wrap-login100">
               <div class="login100-pic js-tilt" data-tilt="" style="will-change: transform; transform: perspective(300px) rotateX(-1.61deg) rotateY(-4.28deg) scale3d(1.1, 1.1, 1.1);">
                  <img src="<?php echo BASEURL; ?>assets/login/img-01.png" alt="IMG">
               </div>
               <form class="login100-form validate-form" method="post" id="login_form">
                  <span class="login100-form-title text-blue">
                  Forget Password
                  </span>
                  <span style="color:red;"><?php echo $error; ?></span>
                  <span style="color:green;"><?php echo $message; ?></span>
                  <div class="form-group my-1 mb-5 d-flex validate-input" data-validate="Valid email is required: ex@abc.xyz">
                    <!-- <input class="input100" type="email" id="user_name" name="emailvalue" placeholder="Enter Your Email" required=""> -->
					 <i class="fa-solid fa-envelope fa-2xl vendor-login-icons" style="color: #ffffff;"></i>
					 <input type="email" id="user_name" name="emailvalue" class="my-1 vendor_login_box w-100" placeholder="Enter your Email" required>
                  </div>
                  <div class="container-login100-form-btn">
                     <button class="login100-form-btn" id="login_btn" name="submit">
                     Send
                     </button>
						<br><br><span style="color:green;"><?php echo $msg; ?></span>
                  </div>
               </form>
			   
            </div>
         </div>
      </div>

 <!-- js-->
<script src="<?php echo BASEURL; ?>assets/js/jquery-1.11.1.min.js"></script>

<script src="<?php echo BASEURL; ?>assets/login/popper.js"></script>
 <script src="<?php echo BASEURL; ?>assets/js/bootstrap.js"> </script>
 
 <script src="<?php echo BASEURL; ?>assets/login/tilt.jquery.min.js"></script>
<script>
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>

	
<script>
		
$(document).ready(function() {
  
	
	$("#login_btn").click(function(event){
		//event.preventDefault();			
		var emailvalue = $('#user_name').val();
          
           
		if (emailvalue == '') {
			successmsg("Please enter Email");
		}else if (validate_email(emailvalue) == 'invalid') {
			successmsg("User name Email id is invalid");
		}else{
			$("#login_form").submit(); 
        }
	});	
	

  
});
function validate_email(email) {
    var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
    if (!pattern.test(email)) {
        return 'invalid';
    } else {
        return 'valid';
    }
}
function successmsg(msg) {
    xdialog.confirm(msg, function() {
        // do work here if ok/yes selected...
            
    }, {
        style: 'width:420px;font-size:0.8rem;',
        buttons: {
             ok: 'OK'
         },
        oncancel: function() {
             // console.warn('Cancelled!');
         }
 });
}


	
	</script>
	
	
   <link href="<?php echo BASEURL; ?>assets/css/xdialog.min.css" rel="stylesheet" />
<script src="<?php echo BASEURL; ?>assets/js/xdialog.min.js"></script>


</body></html>