<?php
include('../app/db_connection.php'); 
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
include('common_function.php');
$Common_Function = new Common_Function();
if (isset($_POST['submit']) ) {

    if (empty($_POST['email']) || empty($_POST['password'])) {
        $error = "email or Password is invalid";
    }
    else
    {
        // Define $username and $password
        $email=$_POST['email'];
        $password=$_POST['password'];
  
        $email = stripslashes($email);
        $password = stripslashes($password);
        $notExist  = 1; 
        include('encryptfun.php');
        global $publickey_server;
        $encruptfun = new encryptfun();
        $encryptedpassword = $encruptfun->encrypt($publickey_server, $password);
      
      // echo "email is ".$notExist;
        $stmt = $conn->prepare("SELECT seller_id,fullname,email,status,role_id FROM admin_login WHERE email=? AND password=?");
        $stmt->bind_param("ss", $email, $encryptedpassword);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($col1,$col2,$col3,$col4,$col5 );
        
        while ($stmt->fetch()) {
            
			if($col4 ==1){

				$notExist = 0;
				if($col5 > 0){
					$stmt1 = $conn->prepare("SELECT id,title,premission FROM user_roles WHERE id=? ");
					$stmt1->bind_param("i", $col5);
					$stmt1->execute();
					$stmt1->store_result();
					$stmt1->bind_result($ids,$title,$premission);
					
					while ($stmt1->fetch()) {
						$_SESSION['title_role'] = $title; 
						$_SESSION['premission_role'] = $premission; 
					}
				}else if($col5 == 0){
					$_SESSION['title_role'] = 'admin'; 
					$_SESSION['premission_role'] = 'admin';
				}
				
				$_SESSION['admin'] = $col1; 
				$_SESSION['admin_name'] = $col2; 
				$_SESSION['admin_email'] = $col3; 
				$_SESSION['_token'] = md5(time());
				$_SESSION['type'] = 'admin';
			}else{
				$notExist = 2;
			}
           
        }
              

       // echo " not wxsist is ".$notExist;
        if ($notExist == 0) {
            header("location: dashboard.php"); // Redirecting To Other Page
          //  $error = " sucess valid";
          // echo " go to dashborad";
        }else if ($notExist == 2) {
    			$error = "Your account is deactiveted. Please contact administrator.";
    		} else {
              // $password = base64_decode ( $password );
                $error = "Email or Password is invalid";
              //  echo $error;
        }
      //  mysql_close($conn); // Closing Connection
    }
}


include('encryptfun.php');
 global $publickey_server;


if(isset($_POST['emailvalue'])){
	$email_id = trim($_POST['emailvalue']);
	
	$query = $conn->query("SELECT fullname,email FROM `admin_login` WHERE email ='".$email_id."'");
	if($query->num_rows > 0){
		$rows = $query->fetch_assoc();
		
		$adminname = $rows['fullname'];
		$admin_email = $rows['email'];
		
		$checksum = date('dym').$Common_Function->random_strings(10).date('his');
		
		//$query = $conn->query("UPDATE `admin_login` SET checksum ='".$checksum."' WHERE email ='".$email_id."'");

		$new_passwords = $Common_Function->generateRandomCode();
		$encruptfun = new encryptfun();
		$passwords = $encruptfun->encrypt($publickey_server, $new_passwords);

		$Common_Function->send_password_email($conn,$admin_email,$adminname,$new_passwords);

		$query = $conn->query("UPDATE `admin_login` SET password ='".$passwords."' WHERE email ='".$email_id."'");

		//$Common_Function->send_email_forgot_password($conn,$admin_email,$adminname,$checksum,BASEURL,'Forgot Password');
		$message ="Mail sent successfully";
	}else{
		$error = "User Not Exist";
	}
	
}


?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Bzness Hub — Auth UI (HTML + CSS)</title>
  <style>
    :root{
      --brand-orange: #FF6A00;
      --brand-navy: #05204A;
      --bg: #f8fafc; /* gray-50 */
      --card-radius: 18px;
      --max-width: 1100px;
      --glass: rgba(255,255,255,0.9);
    }
    *{box-sizing:border-box}
    html,body{height:100%;margin:0;font-family:Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; background:var(--bg); color:#0f172a}

    .page{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px}
    .layout{width:100%;max-width:var(--max-width);display:grid;grid-template-columns:1fr;gap:28px;align-items:center}

    /* show two-column on larger screens */
    @media(min-width:1024px){
      .layout{grid-template-columns: 1fr 520px}
    }

    /* left marketing panel */
    .panel{
      display:none;border-radius:var(--card-radius);padding:40px;color:white;background:linear-gradient(180deg,var(--brand-navy),#0b3461);
    }
    @media(min-width:1024px){.panel{display:block}}
    .panel h1{font-size:32px;margin:0 0 12px}
    .panel p{opacity:.92;margin:0 0 20px}
    .feature{display:flex;gap:12px;align-items:center;margin-bottom:12px}
    .feature .icon{width:44px;height:44px;border-radius:10px;background:rgba(255,255,255,0.08);display:flex;align-items:center;justify-content:center;font-size:18px}
    .feature .meta{line-height:1}
    .feature .meta .label{font-size:12px;opacity:.85}
    .feature .meta .title{font-weight:600}

    /* card */
    .card{background:white;border-radius:var(--card-radius);box-shadow:0 8px 30px rgba(2,6,23,0.06);padding:28px;border-top:6px solid var(--brand-orange)}
    .card-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px}
    .card-head h2{margin:0;font-size:20px;color:var(--brand-navy)}
    .card-head p{margin:4px 0 0;font-size:12px;color:#6b7280}

    .view-toggle{display:flex;gap:8px}
    .view-toggle button{padding:6px 12px;border-radius:999px;border:1px solid transparent;background:transparent;font-weight:600;cursor:pointer}
    .view-toggle button.active{background:var(--brand-orange);color:white;border-color:var(--brand-orange)}

    form{margin-top:6px}
    .field{margin-bottom:12px}
    label{display:block;font-size:13px;margin-bottom:6px;color:#374151}
    input[type=text],input[type=email],input[type=password]{width:100%;padding:12px 14px;border-radius:10px;border:1px solid #e6e9ef;font-size:14px}
    input:focus{outline:none;box-shadow:0 0 0 4px rgba(255,106,0,0.09);border-color:var(--brand-orange)}

    .row{display:flex;align-items:center;justify-content:space-between}
    .btn{display:inline-block;padding:12px 16px;border-radius:14px;border:none;cursor:pointer;font-weight:700}
    .btn.primary{width:100%;background:var(--brand-orange);color:#fff}
    .btn.ghost{background:white;border:1px solid #e6e9ef}

    .alt-auth{margin-top:14px}
    .hr-line{position:relative;margin-top:10px;margin-bottom:10px}
    .hr-line:before{content:'';position:absolute;left:0;right:0;height:1px;background:#e6e9ef;top:50%}
    .hr-line span{position:relative;padding:0 8px;background:white;font-size:12px;color:#6b7280}

    .socials{display:flex;gap:10px;margin-top:10px}
    .socials button{flex:1;padding:10px;border-radius:8px;border:1px solid #e6e9ef;background:white}

    .tiny{font-size:12px;color:#6b7280;text-align:center;margin-top:10px}

    .small-card{margin-top:14px;text-align:center}
    .link-btn{background:transparent;border:none;color:var(--brand-orange);font-weight:700;cursor:pointer}

    /* utility */
    .muted{color:#6b7280}

  </style>
</head>
<body>
  <div class="page">
    <div class="layout">

      <!-- Left: Marketing panel (hidden on small screens) -->
      <aside class="panel" aria-hidden="false">
        <h1>Welcome to Bzness Hub</h1>
        <p>🌐 Bzness Hub – Smart E-Commerce Growth Platform</p>

        <p>
          Bzness Hub is an upcoming e-commerce brand designed to help individuals and businesses grow their sales, gain permanent customers, and build their own virtual store through a powerful referral system.
<br/>
With simple referral codes, users can earn ₹50 per referral and also create a long-term customer base, making it easier to generate recurring income.
<br/>
Our mission is to provide a one-stop hub for business growth – combining technology, customer loyalty, and community-driven marketing.

        </p>
        <!-- <div class="feature">
          <div class="icon">🚀</div>
          <div class="meta"><div class="label">Feature</div><div class="title">Easy store setup</div></div>
        </div>

        <div class="feature">
          <div class="icon">🔗</div>
          <div class="meta"><div class="label">Refer</div><div class="title">₹50 per referral</div></div>
        </div> -->
      </aside>

      <!-- Right: Auth card -->
      <main>
        <div class="card" id="authCard">
          <div class="card-head">
            <div>
              <h2 id="cardTitle">Sign in to your account</h2>
              <p>Use your email and password to continue</p>
              <span style="color:red;"><?php echo $error; ?></span>
              <span style="color:green;"><?php echo $message; ?></span>
            </div>
            <div class="view-toggle" role="tablist" aria-label="Auth views">
              <button id="btnLogin" class="active" data-view="login">Login</button>
              <!-- <button id="btnSignup" data-view="signup">Sign up</button> -->
            </div>

          </div>

          <!-- Forms: login / signup / forgot -->

          <section id="viewLogin">
            <form  method="post" id="login_form">

              <div class="field">
                <label for="loginEmail">Email</label>
                <input type="email" id="user_name" name="email" class="" placeholder="you@example.com" required="">

                <!-- <input id="loginEmail" type="email" placeholder="you@example.com" required /> -->
              </div>
              <div class="field">
                <label for="loginPass">Password</label>

                <input type="password" name="password" id="password" placeholder="Enter password" required>

                <!-- <input id="loginPass" type="password" placeholder="Enter password" required /> -->
              </div>

              <div class="row" style="margin-bottom:12px">
                <label style="display:flex;align-items:center;gap:8px;font-size:13px"><input type="checkbox" /> <span class="muted">Remember me</span></label>
                <button type="button" class="link-btn" id="linkForgot">Forgot?</button>
              </div>

              <button class="btn primary" type="submit"  name="submit">Continue</button>

             <!--  <div class="alt-auth">
                <div class="hr-line"><span>Or sign in with</span></div>
                <div class="socials">
                  <button type="button" class="btn ghost">Google</button>
                  <button type="button" class="btn ghost">Phone</button>
                </div>
              </div> -->
            </form>
          </section>

          

          <section id="viewForgot" hidden>
            <form method="post" id="login_form">
              <div class="field">
                <label for="forgotEmail">Email</label>
                 <!-- <input type="email" id="user_name" name="emailvalue" class="my-1 vendor_login_box w-100" placeholder="Enter your Email" required> -->
                <input id="forgotEmail" type="email" name="emailvalue" placeholder="you@example.com" required />
              </div>
              <button class="btn primary" type="submit">Continue</button>
              <!-- <div class="tiny">Remembered? <button class="link-btn" id="toLoginFromForgot">Sign in</button></div> -->
            </form>
          </section>

          <!-- <div class="tiny">By continuing you agree to our <strong style="color:var(--brand-navy)">Terms</strong> and <strong style="color:var(--brand-navy)">Privacy</strong>.</div> -->
        </div>

     <!--    <div class="small-card">
          <div class="muted">Need help? <button class="link-btn" id="forgotFooter">Forgot password</button></div>
        </div> -->

      </main>

    </div>
  </div>

  <script>
    (function(){
      const btnLogin = document.getElementById('btnLogin');
     // const btnSignup = document.getElementById('btnSignup');
      const viewLogin = document.getElementById('viewLogin');
      const viewSignup = document.getElementById('viewSignup');
      const viewForgot = document.getElementById('viewForgot');
      const cardTitle = document.getElementById('cardTitle');

      function setView(v){
        // buttons
        btnLogin.classList.toggle('active', v === 'login');
       // btnSignup.classList.toggle('active', v === 'signup');

        // sections
        viewLogin.hidden = v !== 'login';
       // viewSignup.hidden = v !== 'signup';
        viewForgot.hidden = v !== 'forgot';

        // title
        if(v === 'login') cardTitle.textContent = 'Sign in to your account';
      //  else if(v === 'signup') cardTitle.textContent = 'Create your account';
        else if(v === 'forgot') cardTitle.textContent = 'Reset your password';
      }

      btnLogin.addEventListener('click', ()=> setView('login'));
     // btnSignup.addEventListener('click', ()=> setView('signup'));

      document.getElementById('linkForgot').addEventListener('click', ()=> setView('forgot'));
      document.getElementById('toLoginFromSignup').addEventListener('click', ()=> setView('login'));
      document.getElementById('toLoginFromForgot').addEventListener('click', ()=> setView('login'));
      document.getElementById('forgotFooter').addEventListener('click', ()=> setView('forgot'));

      // initial
      setView('login');
    })();
  </script>
</body>
</html>