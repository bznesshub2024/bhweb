<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fleek Mart</title>
    
    <!-- Font awesome -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- SmartMenus jQuery Bootstrap Addon CSS -->
    <link href="css/jquery.smartmenus.bootstrap.css" rel="stylesheet">
    <!-- Product view slider -->
    <link rel="stylesheet" type="text/css" href="css/jquery.simpleLens.css">
    <!-- slick slider -->
    <link rel="stylesheet" type="text/css" href="css/slick.css">
    <!-- price picker slider -->
    <link rel="stylesheet" type="text/css" href="css/nouislider.css">
    <!-- Theme color -->
    <link id="switcher" href="css/theme-color/default-theme.css" rel="stylesheet">
    <!-- Top Slider CSS -->
    <link href="css/sequence-theme.modern-slide-in.css" rel="stylesheet" media="all">
    <!-- Main style sheet -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>


     
<?php //include header file
  include('header.php');
  // $exp = explode('-',$_REQUEST['product_id']);
  // if(count($exp)>0){
  //     $product_id = end($exp); 
  // }else{
  //     $product_id = $_REQUEST['product_id'];
  // }

?>

  </head>
  <body>
     <!-- Start header section -->
    <div id="header_wrap"></div>
    <div id="footer_wrap"></div>

<!-- Cart view section -->


<section class="pt-9">

  <div class="container">

    <div class="row">
<div class="col-md-12">
  <h2 class="text-center" style="color: #f35225;">Your Shopping Cart</h2>

<div class="row">
<div class="col-md-8">


<div class="tabset">
  <!-- Tab 1 -->
  <input type="radio" name="tabset" id="tab1" aria-controls="marzen" checked>
  <label for="tab1">Address</label>
  <!-- Tab 2 -->
  <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier">
  <label for="tab2">Payment</label>
  
    
  <div class="tab-panels">
    <section id="marzen" class="tab-panel">
      <form action="" class="aa-login-form">
<!--  <label for=""><span></span></label> -->


<!-- 
<input type="radio" name="tabset" id="tab1" aria-controls="marzen" checked>

  <label for="tab1">Lorem Ipsum is simply dummy text of the printing and typesetting industry. </label><br>
 <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier">
  <label for="tab2">Lorem Ipsum is simply dummy text of the printing and typesetting industry. </label><br> -->




<div class="row">

  <div class="col-md-6">

    <input type="text" placeholder="Full Name">
  </div>
  <div class="col-md-6">
     <input type="tel" placeholder="Phone NO">
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <input type="text" placeholder="Email">
  </div>
 
</div>

<div class="row">
  <div class="col-md-12">
    
    <textarea cols="8" rows="3">Type Address</textarea>
    
  </div>
</div>
<!--  <label for="">Password<span>*</span></label> -->



  <button class="checkout-btn">Save New Address</button>
<!--     <label class="rememberme" for="rememberme"><input type="checkbox" id="rememberme"> Remember me </label> -->



</form>
  </section>
    <section id="rauchbier" class="tab-panel">



        <div class="aa-payment-method">                    
                    <label for="cashdelivery"><input type="radio" id="cashdelivery" name="optionsRadios"> Cash on Delivery </label><br>
                    <label for="paypal"><input type="radio" id="paypal" name="optionsRadios" checked> Via Paypal </label><br>
                    <img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg" border="0" alt="PayPal Acceptance Mark">   <br> 
                    <input type="submit" value="Place Order" class="aa-browse-btn">                
                  </div>
    </section>

  </div>
  
</div>



</div>


<div class="col-md-4 bc-1">
<div class="price text-center">
  <h3><b>Apply Coupon </b></h3>
</div>
<div class="coupen-code text-center">
  <p>Total Savings : $20.00 (5% Discount)</p>
  <input type="text" pattern="[0-9]{5}" title="Five digit zip code" / placeholder="Coupon Code"><label>Apply</label>
</div>
<div class="checkout-right">
  <h3><b>Order Summary</b></h3>
  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quaerat voluptatibus modi pariatur.</p>
  <div class="aa-order-summary-area">
    <table class="table table-responsive">
      
      <tfoot>
      <tr>
        <th>Cart Value</th>
        <td>$360</td>
      </tr>
      <tr>
        <th>Discount</th>
        <td>-$02</td>
      </tr>
      <tr>
        <th>Tax</th>
        <td>+$35</td>
      </tr>
      <tr>
        <th>Delivery Charges</th>
        <td>+$05</td>
      </tr>
      <tr>
        <th>Total</th>
        <td>$368  </td>
      </tr>
      </tfoot>
    </table>
    <div class="aa-payment-method">
      <input type="submit" value="Place Order" class="aa-browse-btn">
    </div>
  </div>
  
</div>
</div>
</div>
</section>





















<!-- / footer -->


<!-- Login Modal -->
<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-body">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4>Login or Register</h4>
<form class="aa-login-form" action="">
<label for="">Username or Email address<span>*</span></label>
<input type="text" placeholder="Username or email">
<label for="">Password<span>*</span></label>
<input type="password" placeholder="Password">
<button class="aa-browse-btn" type="submit">Login</button>
<label for="rememberme" class="rememberme"><input type="checkbox" id="rememberme"> Remember me </label>
<p class="aa-lost-password"><a href="#">Lost your password?</a></p>
<div class="aa-register-now">
Don't have an account?<a href="account.html">Register now!</a>
</div>
</form>
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.js"></script>
<!-- SmartMenus jQuery plugin -->
<script type="text/javascript" src="js/jquery.smartmenus.js"></script>
<!-- SmartMenus jQuery Bootstrap Addon -->
<script type="text/javascript" src="js/jquery.smartmenus.bootstrap.js"></script>
<!-- To Slider JS -->
<script src="js/sequence.js"></script>
<script src="js/sequence-theme.modern-slide-in.js"></script>
<!-- Product view slider -->
<script type="text/javascript" src="js/jquery.simpleGallery.js"></script>
<script type="text/javascript" src="js/jquery.simpleLens.js"></script>
<!-- slick slider -->
<script type="text/javascript" src="js/slick.js"></script>
<!-- Price picker slider -->
<script type="text/javascript" src="js/nouislider.js"></script>
<!-- Custom js -->
<script src="js/custom.js"></script>

<!-- 
<?php //include header file
  include('footer.php');
  // $exp = explode('-',$_REQUEST['product_id']);
  // if(count($exp)>0){
  //     $product_id = end($exp); 
  // }else{
  //     $product_id = $_REQUEST['product_id'];
  // }

?> -->
</body>
</html>