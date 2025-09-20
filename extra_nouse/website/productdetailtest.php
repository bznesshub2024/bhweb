  <?php
      $pid = $_POST['pid'];
      $sku = $_POST['sku'];
      $sid = $_POST['sid'];
     $MEDIA_URL ='https://fleekmart.com/media/'
  ?>


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
    <script src="https://code.jquery.com/jquery-1.11.1.min.js" type="text/javascript"></script>
    

<style>
  .c-product-price{
        font-size: 22px;
    font-weight: 700;
    margin: 5px 0;
  }
  .c-product-stk {
    font-size: 18px;
    font-weight: 700;
    margin: 5px 0;
}
.c-product-stok {
    font-size: 18px;
    font-weight: 700;
    margin: 5px 0;
}
.c-product-rmark {
    font-size: 15px;
    font-weight: 700;
    margin: 5px 0;
}
.c-product-desc{
      font-size: 16px;
    font-weight: 500;
    margin: 5px 0;
    line-height: 1.5;
    clear: both;
}
.c-product-gallary img{
      width: 90px;
    border-radius: 6px;
    margin: 20px 15px;
}
.c-size, .c-color, .c-weight {
    border: 1px solid;
    margin: 8px 0;
    text-align: center;
    width: 100px;
    padding: 8px;
        width: 29%;
    float: left;
        margin-right: 10px;
    border-radius: 40px;
}
.aa-prod-view-bottom{
      overflow: hidden;
    clear: both;

}

li.col.portfolio-item {
    list-style: none;
}
.portfolio-wrapp h4{
  margin: 25px 0;
}
.portfolio-wrapp p{
      width: 50%;
    float: left;
}


.portfolio-wrapp img{
      margin: 0 auto;
    display: block;
    width: auto;
        width: 250px;
    height: 225px;
    object-fit: contain;
    background: transparent;
}
.portfolio-wrapp-buy{
      transition: 0.3s;
    padding: 10px;
    height: 320px;
    border-radius: 10px;
    z-index: 1;
    background: #fff;
        margin-bottom: 10px;
    box-shadow: 0px 2px 15px rgb(0 0 0 / 15%);
}
.portfolio-wrapp-buy img{
    width: 250px;
    height: 225px;
    object-fit: contain;
}
.mt-6{
  margin: 50px 0;
}
.portfolio-item{
  width: auto;
}
.portfolio-wrapp-buy p{
      width: 50%;
    float: left;
}
#related-product{
      display: inline-block;
    width: 100%;
}
.aa-product-also-buy .portfolio-item{
  width: 19%;
  float: left;
  margin: 0 5px;
}
.c-size ~ .button-tag {
    clear: both;
}
.button-tag h5{
  clear: both;
}
.button-tag{
  
}
</style>






  </head>
  <body> 

   <input type="text" class="form-control1" id="pid" value=<?php echo $pid; ?> ></input>
   <input type="text" class="form-control1" id="sku" value=<?php echo $sku; ?> ></input>
   <input type="text" class="form-control1" id="sid" value=<?php echo $sid; ?> ></input>





   <!-- Start header section -->
    <header id="aa-header">
      <!-- start header top  -->
      <div class="aa-header-top">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="aa-header-top-area">
                <!-- start header top left -->
                <div class="aa-header-top-left">
                  <!-- start language -->
                  <div class="aa-language">
                    <p><span class="fa fa-envelope"></span>Info@whereicanfindhappiness.com</p>
                  </div>
                  <!-- / language -->
                  <!-- start currency -->
                  
                  <!-- / currency -->
                  <!-- start cellphone -->
                  <div class="cellphone hidden-xs">
                    <p><span class="fa fa-phone"></span>Call : 00011122233</p>
                  </div>
                  <!-- / cellphone -->
                </div>
                <!-- / header top left -->
                <div class="aa-header-top-right">
                  <ul class="aa-head-top-nav-right">
                    
                    <li class="hidden-xs"><a href="#"><span class="fa fa-shopping-basket"></span></a></li>
                    <li class="hidden-xs"><a href="#"><span class="fa fa-heart"></span></a></li>
                    
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- / header top  -->
      <!-- start header bottom  -->
      <div class="aa-header-bottom">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <div class="aa-header-bottom-area">
                <!-- logo  -->
                <div class="aa-logo">
                  <!-- Text based logo -->
                  <a href="#">
                    <h1>Your <strong>Logo</strong> <span></span></h1>
                  </a>
                  <!-- img based logo -->
                  <!-- <a href="index.html"><img src="img/logo.jpg" alt="logo img"></a> -->
                </div>
                <!-- / logo  -->
                <!-- cart box -->
                <div class="aa-cartbox aa-mailbox">
                  <a class="aa-mail" href="#">
                    <span><a href="" data-toggle="modal" data-target="#login-modal" style="color: #fff;">Login</a></span>
                    
                  </a>
                  
                  
             
              </div>
              <!-- / cart box -->
              <!-- search box -->
              <div class="aa-search-box">
                <form action="">
                  <input type="text" name="" id="" placeholder="Search Here ">
                  <button type="submit"><span class="fa fa-search"></span></button>
                </form>
              </div>
              <!-- / search box -->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- / header bottom  -->
  </header>
  <!-- / header section -->
  <!-- menu -->
  <section id="menu">
    <div class="container">
      <div class="menu-area">
        <!-- Navbar -->
        <div class="navbar navbar-default" role="navigation">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
          </div>
          <div class="navbar-collapse collapse">
            <!-- Left nav -->
            <ul class="nav navbar-nav">
              <li><a href="#">Category 1 </a></li>
              <li><a href="#">Category 2  <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Category 1</a></li>
                <li><a href="#">Category 2</a></li>
                <li><a href="#">Category 3</a></li>
                <li><a href="#">Category 4</a></li>
                <li><a href="#">Category 5</a></li>
                <li><a href="#">Category 6</a></li>
                <li><a href="#">Category 7</a></li>
                <li><a href="#">Category 8</a></li>
                <li><a href="#">Category 9 <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Category A</a></li>
                  <li><a href="#">Category B</a></li>
                  <li><a href="#">Category C</a></li>
                </ul>
              </li>
            </ul>
          </li>
          <li><a href="#">Category 3  <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Category 1</a></li>
            <li><a href="#">Category 2</a></li>
            <li><a href="#">Category 3</a></li>
            <li><a href="#">Category 4</a></li>
            <li><a href="#">Category 5</a></li>
            <li><a href="#">Category 6</a></li>
            <li><a href="#">Category 7</a></li>
            <li><a href="#">Category 8</a></li>
            <li><a href="#">And more.. <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">Category A</a></li>
              <li><a href="#">Category B</a></li>
              <li><a href="#">Category C</a></li>
              <li><a href="#">And more.. <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Category 1</a></li>
                <li><a href="#">Category 2</a></li>
                <li><a href="#">Category 3</a></li>
                <li><a href="#">Category 4</a></li>
                <li><a href="#">Category 5</a></li>
                <li><a href="#">Category 6</a></li>
                <li><a href="#">Category 7</a></li>
                <li><a href="#">Category 8</a></li>
                <li class="disabled"><a class="disabled" href="#">Category 9</a></li>
                
              </ul>
            </li>
          </ul>
        </li>
      </ul>
    </li>
    <li><a href="#">Category 4  <span class="caret"></span></a>
    <ul class="dropdown-menu">
      <li><a href="#">Category 1</a></li>
      <li><a href="#">Category 2</a></li>
      <li><a href="#">Category 3</a></li>
      <li><a href="#">Category 4</a></li>
      <li><a href="#">Category 5</a></li>
      <li><a href="#">Category 6</a></li>
      <li><a href="#">Category 7</a></li>
      <li><a href="#">Category 8</a></li>
      <li><a href="#">And more.. <span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="#">Category A</a></li>
        <li><a href="#">Category B</a></li>
        <li><a href="#">Category C</a></li>
      </ul>
    </li>
  </ul>
</li>
<li><a href="#">Category 5 </a></li>
<li><a href="#">Category 6  <span class="caret"></span></a>
<ul class="dropdown-menu">
  <li><a href="#">Camera</a></li>
  <li><a href="#">Mobile</a></li>
  <li><a href="#">Tablet</a></li>
  <li><a href="#">Laptop</a></li>
  <li><a href="#">Accesories</a></li>
</ul>
</li>
<li><a href="#">Category 7 </a></li>
<li><a href="#">Category 8  <span class="caret"></span></a>
<ul class="dropdown-menu">
<li><a href="#">Category A</a></li>
<li><a href="#">Category B</a></li>
<li><a href="#">Category C</a></li>
</ul>
</li>
<li><a href="#">Category 9  <span class="caret"></span></a>
<ul class="dropdown-menu">
<li><a href="#">Category A</a></li>
<li><a href="#">Category B</a></li>
<li><a href="#">Category C</a></li>
</ul>
</li>
</ul>
</div><!--/.nav-collapse -->
</div>
</div>
</div>
</div>
</section>
<!-- / menu --> 


  <!-- product category -->
<section id="aa-product-details">
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="aa-product-details-area">
<div class="aa-product-details-content">
<div class="row">
<!-- Modal view slider -->
<div class="col-md-6 col-sm-6 col-xs-12">
<div class="aa-product-view-slider">

<div id="demo-1" class="simpleLens-gallery-container">
  <div class="simpleLens-container">
    <div class="simpleLens-big-image-container">
      <a data-lens-image="img/view-slider/large/rectangle-large.png" class="simpleLens-lens-image">
        <img src="img/view-slider/medium/Rectangle 241.png" class="simpleLens-big-image"></a>
    </div>
  </div>

   <!--  <div class="c-product-gallary"></div>
 -->



  <div class="simpleLens-thumbnails-container c-product-gallary">
    <a data-big-image="img/view-slider/medium/Rectangle 241.png" data-lens-image="img/view-slider/large/rectangle-large.png" class="simpleLens-thumbnail-wrapper" href="#">
      <img src="img/view-slider/thumbnail/polo-shirt-1.png">
    </a>
    <a data-big-image="img/view-slider/medium/Rectangle 241.png" data-lens-image="img/view-slider/large/rectangle-large.png" class="simpleLens-thumbnail-wrapper" href="#">
      <img src="img/view-slider/thumbnail/polo-shirt-3.png">
    </a>
    <a data-big-image="img/view-slider/medium/Rectangle 241.png" data-lens-image="img/view-slider/large/rectangle-large.png" class="simpleLens-thumbnail-wrapper" href="#">
      <img src="img/view-slider/thumbnail/polo-shirt-4.png">
    </a>
  </div>
</div>
</div>
</div>
<!-- Modal view content -->
<div class="col-md-6 col-sm-6 col-xs-12">
<div class="aa-product-view-content">
  <h2 class="c-product-title"></h2>
  <div class="c-product-price">
    Price:- 
    <span></span>
  </div>
  <div class="c-product-stk"></div>
  <div class="c-product-stok"></div>
  <div class="c-product-rmark"></div>
  <div class="c-product-desc">
    Description:- 
    <span></span>
  </div>
  <div class="c-product-full">
    Description:- 
    <span></span>
  </div>
  <div class="c-product-brand"></div>  
<div class="star-rating">
    <!--   <span class="fa fa-star checked"></span>
      <span class="fa fa-star checked"></span>
      <span class="fa fa-star checked"></span>
      <span class="fa fa-star"></span>
      <span class="fa fa-star"></span> -->
</div>
<div class="c-product-rating"></div>
  <div class="c-product-seller"></div>  
  <div class="c-product-cat"></div>
  <div class="c-product-policy"></div>
  <div class="c-product-limit">
     Limit:- 
    <span></span>
  </div>
<div class="c-product-attr"></div>

<div class="c-product-off"></div>
<div class="c-product-sellere"></div>
<div class="c-product-percent">
  OffPercent:- 
  <span></span>
</div>
<div class="c-product-total">
  Total Off:-
</div>
<div class="c-product-attr"></div>








          

























<!-- 


<div class="star">
<span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star checked"></span>
<span class="fa fa-star"></span>
<span class="fa fa-star"></span>
</div> -->
<!-- <div class="button-tag">
  <h5>Color</h5>
</div> -->

<div id="product_weight_div"></div>
<div id="product_desc_ul"></div>
<div id="product_attribute_div"></div>

<!-- <div class="aa-color-tag">
  <a href="#" class="aa-color-red"></a>
  <a href="#" class="aa-color-green"></a>
  <a href="#" class="aa-color-pink"></a>
  <a href="#" class="aa-color-white"></a>
  <a href="#" class="aa-color-black"></a>
  
</div>
<div class="aa-color-tag">
  <a href="#" class="aa-color-blue"></a>
  <a href="#" class="aa-color-brown"></a>
  <a href="#" class="aa-color-yellow"></a>
  <a href="#" class="aa-color-orange"></a>
  <a href="#" class="aa-color-purple"></a>
  
</div> -->
<!-- <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis animi, veritatis quae repudiandae quod nulla porro quidem, itaque quis quaerat!</p> -->
<!-- <div class="button-tag">
  <h5>Size</h5>
</div>
<div class="aa-prod-view-size">
  <a href="#">1000 gm</a>
  <a href="#">1000 gm</a>
  <a href="#">1000 gm</a>
  <a href="#">1000 gm</a>
</div>
<div class="aa-prod-view-size">
  <a href="#">1000 gm</a>
  <a href="#">1000 gm</a>
  <a href="#">1000 gm</a>
  <a href="#">1000 gm</a>
</div>
<div class="button-tag">
  <h5>Delivery</h5>
</div>
<div class="zip-code">
  <input type="text" pattern="[0-9]{5}" title="Five digit zip code" / placeholder="ZIP CODE"><label>CHECK</label>
</div> -->
<!--        <div class="aa-prod-quantity">
  <form action="">
    <select id="" name="">
      <option selected="1" value="0">1</option>
      <option value="1">2</option>
      <option value="2">3</option>
      <option value="3">4</option>
      <option value="4">5</option>
      <option value="5">6</option>
    </select>
  </form>
  <p class="aa-prod-category">
    Category: <a href="#">Polo T-Shirt</a>
  </p>
</div> -->
<div class="aa-prod-view-bottom">
<!--   <a class="aa-add-to-cart-btn" href="#">Add To Cart</a>
  <a class="aa-add-to-cart-btn" href="#">Wishlist</a> -->
  <a class="aa-add-to-cart-btn" href="#">Return</a>
  
  
</div>
</div>
</div>
</div>
</div>
<div class="aa-product-details-right">
<div class="price text-center">
 <div class="c-product-price">
     
    <span></span>
  </div
<h1 style="color: #FF5400;"></h1>
</div>
<div class="coupen-code text-center">
<p>Total Savings : $20.00 (5% Discount)</p>
<input type="text" pattern="[0-9]{5}" title="Five digit zip code" / placeholder="Coupon Code"><label>Apply</label>
</div>
<h4><b>Available Offers</b> </h4>
<div class="side-text">
<p>Bank Offer10% Instant Discount on Punjab National Bank Debit and Credit CardsT&C<br>
Bank Offer5% Unlimited Cashback on Flipkart Axis Bank Credit CardT&C<br>
Bank Offer20% off on 1st txn with Amex Network Cards issued by ICICI Bank,IndusInd Bank,SBI Cards and MobikwikT&C<br>
Partner OfferBuy and Get Free 6 months Gaana Plus SubscriptionKnow More<br>
Bank OfferFlat ₹75 off on first Flipkart Pay Later order of ₹500 and aboveT&C</p>
</div>
<div class="buy">
<button> <a href="#">Buy Now</a></button>
</div>
<div class="cart">
<button><a href="#">Add To Cart</a></button>
</div>
</div>
<div class="aa-product-details-bottom">
<ul class="nav nav-tabs" id="myTab2">
<li><a href="#details" data-toggle="tab">DETAILS</a></li>
<li><a href="#review" data-toggle="tab">REVIEWS</a></li>
</ul>
<!-- Tab panes -->
<div class="tab-content text-center" style="margin-top: 20px;">
<div class="tab-pane fade in active" id="#details">

<div class="c-product-full">

       <span></span>
  </div>
</div>
<div class="tab-pane fade " id="review">
<div class="aa-product-review-area">
<h4>2 Reviews for T-Shirt</h4>
<ul class="aa-review-nav">
  <li>
    <div class="media">
      <div class="media-left">
        <a href="#">
          <img class="media-object" src="img/testimonial-img-3.jpg" alt="girl image">
        </a>
      </div>
      <div class="media-body">
        <h4 class="media-heading"><strong>Marla Jobs</strong> - <span>March 26, 2016</span></h4>
        <div class="aa-product-rating">
          <span class="fa fa-star"></span>
          <span class="fa fa-star"></span>
          <span class="fa fa-star"></span>
          <span class="fa fa-star"></span>
          <span class="fa fa-star-o"></span>
        </div>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
      </div>
    </div>
  </li>
  <li>
    <div class="media">
      <div class="media-left">
        <a href="#">
          <img class="media-object" src="img/testimonial-img-3.jpg" alt="girl image">
        </a>
      </div>
      <div class="media-body">
        <h4 class="media-heading"><strong>Marla Jobs</strong> - <span>March 26, 2016</span></h4>
        <div class="aa-product-rating">
          <span class="fa fa-star"></span>
          <span class="fa fa-star"></span>
          <span class="fa fa-star"></span>
          <span class="fa fa-star"></span>
          <span class="fa fa-star-o"></span>
        </div>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
      </div>
    </div>
  </li>
</ul>
<h4>Add a review</h4>
<div class="aa-your-rating">
  <p>Your Rating</p>
  <a href="#"><span class="fa fa-star-o"></span></a>
  <a href="#"><span class="fa fa-star-o"></span></a>
  <a href="#"><span class="fa fa-star-o"></span></a>
  <a href="#"><span class="fa fa-star-o"></span></a>
  <a href="#"><span class="fa fa-star-o"></span></a>
</div>
<!-- review form -->
<form action="" class="aa-review-form">
  <div class="form-group">
    <label for="message">Your Review</label>
    <textarea class="form-control" rows="3" id="message"></textarea>
  </div>
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" placeholder="Name">
  </div>
  <div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" placeholder="example@gmail.com">
  </div>
  <button type="submit" class="btn btn-default aa-review-submit">Submit</button>
</form>
</div>
</div>
</div>
</div>
<!-- Related product -->





<div id="related-product">
       <h2 class="text-center mt-6"><b>Similar Product</b></h2>







<div class="aa-product-related-item">
<h3><b>Similar Products</b></h3>
<ul class="aa-product-catg aa-related-item-slider">
<!-- start single product item -->
<li class="related-product-single">
<figure>
<a class="aa-product-img" href="#"><img src="img/man/girl-6.png" alt="polo shirt img" style="width: 250px;"></a>
<figcaption>
<h4 class="aa-product-title"><a href="#"><b>Six Sized Paint Buckets</b></a></h4>
<div class="c-product-price">
    Price:- 
    <span>₹2,000</span>
  </div>

<span class="aa-product-price-left">$100.00</span><span class="aa-product-price-right  fa fa-shopping-cart"></span>
</figcaption>
</figure>
<!-- product badge -->
</li>
<!-- start single product item -->
<li class="related-product-single">
<figure>
<a class="aa-product-img" href="#"><img src="img/man/girl-6.png" alt="polo shirt img" style="width: 250px;"></a>
<figcaption>
<h4 class="aa-product-title"><a href="#"><b>Six Sized Paint Buckets</b></a></h4>
<span class="aa-product-price-left">$100.00</span><span class="aa-product-price-right  fa fa-shopping-cart"></span>
</figcaption>
</figure>
<!-- product badge -->
</li>

<!-- start single product item -->
<li class="related-product-single">
<figure>
<a class="aa-product-img" href="#"><img src="img/man/girl-6.png" alt="polo shirt img" style="width: 250px;"></a>
<figcaption>
<h4 class="aa-product-title"><a href="#"><b>Six Sized Paint Buckets</b></a></h4>
<span class="aa-product-price-left">$100.00</span><span class="aa-product-price-right  fa fa-shopping-cart"></span>
</figcaption>
</figure>
<!-- product badge -->
</li>

<!-- start single product item -->
<li class="related-product-single">
<figure>
<a class="aa-product-img" href="#"><img src="img/man/girl-6.png" alt="polo shirt img" style="width: 250px;"></a>
<figcaption>
<h4 class="aa-product-title"><a href="#"><b>Six Sized Paint Buckets</b></a></h4>
<span class="aa-product-price-left">$100.00</span><span class="aa-product-price-right  fa fa-shopping-cart"></span>
</figcaption>
</figure>
<!-- product badge -->
</li>

<!-- start single product item -->
<li class="related-product-single">
<figure>
<a class="aa-product-img" href="#"><img src="img/man/girl-6.png" alt="polo shirt img" style="width: 250px;"></a>
<figcaption>
<h4 class="aa-product-title"><a href="#"><b>Six Sized Paint Buckets</b></a></h4>
<span class="aa-product-price-left">$100.00</span><span class="aa-product-price-right  fa fa-shopping-cart"></span>
</figcaption>
</figure>
<!-- product badge -->
</li>
<!-- start single product item -->
<li class="related-product-single">
<figure>
<a class="aa-product-img" href="#"><img src="img/man/girl-6.png" alt="polo shirt img" style="width: 250px;"></a>
<figcaption>
<h4 class="aa-product-title"><a href="#"><b>Six Sized Paint Buckets</b></a></h4>
<span class="aa-product-price-left">$100.00</span><span class="aa-product-price-right  fa fa-shopping-cart"></span>
</figcaption>
</figure>
<!-- product badge -->
</li>

<!-- start single product item -->
<li class="related-product-single">
<figure>
<a class="aa-product-img" href="#"><img src="img/man/girl-6.png" alt="polo shirt img" style="width: 250px;"></a>
<figcaption>
<h4 class="aa-product-title"><a href="#"><b>Six Sized Paint Buckets</b></a></h4>
<span class="aa-product-price-left">$100.00</span><span class="aa-product-price-right  fa fa-shopping-cart"></span>
</figcaption>
</figure>
<!-- product badge -->
</li>
<!-- start single product item -->
<li class="related-product-single">
<figure>
<a class="aa-product-img" href="#"><img src="img/man/girl-6.png" alt="polo shirt img" style="width: 250px;"></a>
</figure>
<figcaption>
<h4 class="aa-product-title"><a href="#"><b>Six Sized Paint Buckets</b></a></h4>
<span class="aa-product-price-left">$100.00</span><span class="aa-product-price-right  fa fa-shopping-cart"></span>
</figcaption>
<!-- product badge -->
</li>
<!-- start single product item -->

<li class="related-product-single">
<figure>
<a class="aa-product-img" href="#"><img src="img/man/girl-6.png" alt="polo shirt img" style="width: 250px;"></a>
<figcaption>
<h4 class="aa-product-title"><a href="#"><b>Six Sized Paint Buckets</b></a></h4>
<span class="aa-product-price-left">$100.00</span><span class="aa-product-price-right  fa fa-shopping-cart"></span><span class="aa-product-price"><!-- <del>$100.00</del> --></span>
</figcaption>
</figure>
</li>
<!-- start single product item -->
<li class="related-product-single">
<figure>
<a class="aa-product-img" href="#"><img src="img/man/girl-6.png" alt="polo shirt img" style="width: 250px;"></a>
<figcaption>
<h4 class="aa-product-title"><a href="#"><b>Six Sized Paint Buckets</b></a></h4>
<span class="aa-product-price-left">$100.00</span><span class="aa-product-price-right  fa fa-shopping-cart"></span>
</figcaption>
</figure>
</li>

<!-- start single product item -->


</ul>
<!-- quick view modal -->
<div class="modal fade" id="quick-view-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-body">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <div class="row">
    <!-- Modal view slider -->
    <div class="col-md-6 col-sm-6 col-xs-12">
      <div class="aa-product-view-slider">
        <div class="simpleLens-gallery-container" id="demo-1">
          <div class="simpleLens-container">
            <div class="simpleLens-big-image-container">
              <a class="simpleLens-lens-image" data-lens-image="img/view-slider/large/polo-shirt-1.png">
                <img src="img/view-slider/medium/polo-shirt1.png" class="simpleLens-big-image">
              </a>
            </div>
          </div>
          <div class="simpleLens-thumbnails-container">
            <a href="#" class="simpleLens-thumbnail-wrapper"
              data-lens-image="img/view-slider/large/polo-shirt-1.png"
              data-big-image="img/view-slider/medium/polo-shirt1.png">
              <img src="img/view-slider/thumbnail/polo-shirt-1.png">
            </a>
            <a href="#" class="simpleLens-thumbnail-wrapper"
              data-lens-image="img/view-slider/large/polo-shirt-3.png"
              data-big-image="img/view-slider/medium/polo-shirt3.png">
              <img src="img/view-slider/thumbnail/polo-shirt-3.png">
            </a>
            <a href="#" class="simpleLens-thumbnail-wrapper"
              data-lens-image="img/view-slider/large/polo-shirt-4.png"
              data-big-image="img/view-slider/medium/polo-shirt4.png">
              <img src="img/view-slider/thumbnail/polo-shirt-4.png">
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal view content -->
    <div class="col-md-6 col-sm-6 col-xs-12">
      <div class="aa-product-view-content">
        <h3>T-Shirt</h3>
        <div class="aa-price-block">
          <span class="aa-product-view-price">$34.99</span>
          <p class="aa-product-avilability">Avilability: <span>In stock</span></p>
        </div>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis animi, veritatis quae repudiandae quod nulla porro quidem, itaque quis quaerat!</p>
        <h4>Size</h4>
        <div class="aa-prod-view-size">
          <a href="#">S</a>
          <a href="#">M</a>
          <a href="#">L</a>
          <a href="#">XL</a>
        </div>
        <div class="aa-prod-quantity">
          <form action="">
            <select name="" id="">
              <option value="0" selected="1">1</option>
              <option value="1">2</option>
              <option value="2">3</option>
              <option value="3">4</option>
              <option value="4">5</option>
              <option value="5">6</option>
            </select>
          </form>
          <p class="aa-prod-category">
            Category: <a href="#">Polo T-Shirt</a>
          </p>
        </div>
        <div class="aa-prod-view-bottom">
          <a href="#" class="aa-add-to-cart-btn"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
          <a href="#" class="aa-add-to-cart-btn">View Details</a>
        </div>
      </div>
    </div>
  </div>
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>
<!-- / quick view modal -->
</div>
</div>
</div>
</div>
</div>
</div>
</section>


     <section id="portfolio" class="portfolio" style="margin: 0 0 80px 0;">

          <div class="container">
             <h2 class="text-center mt-6"><b>People Also Buy</b></h2>
     <div class="row">
      <div class="col-lg-12">
        <div class="aa-product-also-buy"></div>
          <!--     <div class="col portfolio-item-buy filter-app">
                  <div class="portfolio-wrapp p-2">
                  <img src="img/fashion/color-box.png" class="img-fluid" alt="">

                  <h4>Six Sized Paint Buckets</h4>
                  <p class="mb-1"><small>Price</small></p>
                  <span class="aa-product-price-left"><b style="color: #f35225;;">$100.00</b></span><span class="aa-icon-right  fa fa-shopping-cart"></span>
                  
                </div>
              </div>
               <div class="col portfolio-item filter-app">
                  <div class="portfolio-wrapp-buy p-2">
                  <img src="img/fashion/asd.png" class="img-fluid" alt="">

                  <h4>Six Sized Paint Buckets</h4>
                  <p class="mb-1"><small>Price</small></p>
                  <span class="aa-product-price-left"><b style="color: #f35225;;">$100.00</b></span><span class="aa-icon-right  fa fa-shopping-cart"></span>
                  
                </div>
              </div> -->
         <!--       <div class="col portfolio-item-buy filter-app">
                  <div class="portfolio-wrapp p-2">
                  <img src="img/fashion/asdf.png" class="img-fluid" alt="">

                  <h4>Six Sized Paint Buckets</h4>
                  <p class="mb-1"><small>Price</small></p>
                  <span class="aa-product-price-left"><b style="color: #f35225;;">$100.00</b></span><span class="aa-icon-right  fa fa-shopping-cart"></span>
                  
                </div>
              </div>
               <div class="col portfolio-item-buy filter-app">
                  <div class="portfolio-wrapp p-2">
                   <img src="img/fashion/asdd.png" class="img-fluid" alt="">

                  <h4>Six Sized Paint Buckets</h4>
                  <p class="mb-1"><small>Price</small></p>
                  <span class="aa-product-price-left"><b style="color: #f35225;;">$100.00</b></span><span class="aa-icon-right  fa fa-shopping-cart"></span>
                  
                </div>
              </div>
               <div class="col portfolio-item-buy filter-app">
                  <div class="portfolio-wrapp p-2">
                  <img src="img/fashion/multi.png" class="img-fluid" alt="">

                  <h4>Six Sized Paint Buckets</h4>
                  <p class="mb-1"><small>Price</small></p>
                  <span class="aa-product-price-left"><b style="color: #f35225;;">$100.00</b></span><span class="aa-icon-right  fa fa-shopping-cart"></span>
                  
                </div>
              </div> -->
    
              
    
</div>
</div>
          </div>   
          </section>







          <section class="sector" style="margin: 0 0 80px 0;">

  <div class="container">
      <h2 class="text-center m-5"><b>On Offer now.</b></h2>
    <div class="col-lg-12 col-md-12 col-xs-12">

     <div class="row">
               <div class="col-lg-4 text-light">
                  <div class="icon-box">
                    <div class="icon-text">
                      
                      <h3><b>Get Amazing Offers <br>on Building<br>Materials</b></h3>
                      <button class="btn-get">Shop Now</button>
                    </div>
                    <div class="icon-img">
                      <img src="img/fashion/tiles.png" style="width: 170px;">
                    </div>
                  </div>
                  
                </div>
                       <div class="col-lg-4 text-light">
                  <div class="icon-box" style="background: linear-gradient(#475ABD, #1E2A8D);">
                    <div class="icon-text">
                      
                      <h3><b>Get Amazing Offers <br>on Building<br>Materials</b></h3>
                      <button class="btn-get">Shop Now</button>
                    </div>
                    <div class="icon-img">
                      <img src="img/fashion/road.png" style="width: 170px;">
                    </div>
                  </div>
                  
                </div>
                       <div class="col-lg-4 text-light">
                  <div class="icon-box" style="background: linear-gradient(#31D77D, #139830);">
                    <div class="icon-text">
                      
                      <h3><b>Get Amazing Offers <br>on Building<br>Materials</b></h3>
                      <button class="btn-get">Shop Now</button>
                    </div>
                    <div class="icon-img">
                      <img src="img/fashion/paper.png" style="width: 170px;">
                    </div>
                  </div>
                  
                </div>
      
    </div>
    
  </div>
</div>
</section>



<section style="margin: 0 0 80px 0;">
  <div class="container">
    <div class="col-lg-12">
      <div class="row">
       
        <div class="m-0 tab-color">
          <div class="yello-img">
            <img src="img/fashion/w.png">
          </div>
          <div class="yello-text">
            <p><b>Lusioc Yello Single Hand Roller Brush</b></p>
            <p class="mb-1"><small>Price</small></p>
            <span class="aa-product-price-left"><b style="color: #f35225;;">$100.00</b></span><span class="aa-icon-right  fa fa-shopping-cart"></span>
          </div>
        </div>
        

               <div class="m-0 tab-color text-light">
          <div class="yello-img">
            <img src="img/fashion/w.png">
          </div>
          <div class="yello-text">
            <p><b>Lusioc Yello Single Hand Roller Brush</b></p>
            <p class="mb-1"><small>Price</small></p>
            <span class="aa-product-price-left"><b style="color: #f35225;;">$100.00</b></span><span class="aa-icon-right  fa fa-shopping-cart"></span>
          </div>
        </div>


               <div class="m-0 tab-color text-light">
          <div class="yello-img">
            <img src="img/fashion/w.png">
          </div>
          <div class="yello-text">
            <p><b>Lusioc Yello Single Hand Roller Brush</b></p>
            <p class="mb-1"><small>Price</small></p>
            <span class="aa-product-price-left"><b style="color: #f35225;;">$100.00</b></span><span class="aa-icon-right  fa fa-shopping-cart"></span>
          </div>
        </div>
               <div class="m-0 tab-color">
          <div class="yello-img">
            <img src="img/fashion/w.png">
          </div>
          <div class="yello-text">
            <p><b>Lusioc Yello Single Hand Roller Brush</b></p>
            <p class="mb-1"><small>Price</small></p>
            <span class="aa-product-price-left"><b style="color: #f35225;;">$100.00</b></span><span class="aa-icon-right  fa fa-shopping-cart"></span>
          </div>
        </div>
      </div>


            <div class="row">
       
        <div class="mt-5 tab-color">
          <div class="yello-img">
            <img src="img/fashion/w.png">
          </div>
          <div class="yello-text">
            <p><b>Lusioc Yello Single Hand Roller Brush</b></p>
            <p class="mb-1"><small>Price</small></p>
            <span class="aa-product-price-left"><b style="color: #f35225;;">$100.00</b></span><span class="aa-icon-right  fa fa-shopping-cart"></span>
          </div>
        </div>
        

               <div class="mt-5 tab-color">
          <div class="yello-img">
            <img src="img/fashion/w.png">
          </div>
          <div class="yello-text">
            <p><b>Lusioc Yello Single Hand Roller Brush</b></p>
            <p class="mb-1"><small>Price</small></p>
            <span class="aa-product-price-left"><b style="color: #f35225;;">$100.00</b></span><span class="aa-icon-right  fa fa-shopping-cart"></span>
          </div>
        </div>


               <div class="mt-5 tab-color">
          <div class="yello-img">
            <img src="img/fashion/w.png">
          </div>
          <div class="yello-text">
            <p><b>Lusioc Yello Single Hand Roller Brush</b></p>
            <p class="mb-1"><small>Price</small></p>
            <span class="aa-product-price-left"><b style="color: #f35225;;">$100.00</b></span><span class="aa-icon-right  fa fa-shopping-cart"></span>
          </div>
        </div>
               <div class="mt-5 tab-color">
          <div class="yello-img">
            <img src="img/fashion/w.png">
          </div>
          <div class="yello-text">
            <p><b>Lusioc Yello Single Hand Roller Brush</b></p>
            <p class="mb-1"><small>Price</small></p>
            <span class="aa-product-price-left"><b style="color: #f35225;;">$100.00</b></span><span class="aa-icon-right  fa fa-shopping-cart"></span>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>

<!-- footer -->
<footer id="aa-footer">
<!-- footer bottom -->
<div class="aa-footer-top">
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="aa-footer-top-area">
<div class="row">
<div class="col-md-4 col-sm-6">
  <div class="aa-footer-widget">
    <h3><b>Your Logo</b></h3>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt</p>
    <div class="aa-subscribe-area">
      
      <form action="" class="aa-subscribe-form">
        <input type="email" name="" id="" placeholder="Enter your Email">
        <input type="submit" value="Subscribe">
      </form>
    </div>
    <!--  <ul class="aa-footer-nav">
      <li><a href="#">Home</a></li>
      <li><a href="#">Our Services</a></li>
      <li><a href="#">Our Products</a></li>
      <li><a href="#">About Us</a></li>
      <li><a href="#">Contact Us</a></li>
    </ul> -->
  </div>
</div>
<div class="col-md-4 col-sm-6">
  <div class="aa-footer-widget">
    <div class="aa-footer-widget">
      <h3>Quicklinks</h3>
      <ul class="aa-footer-nav">
        <li><a href="#">Product Catelogue</a></li>
        <li><a href="#">Categories</a></li>
        <li><a href="#">Help & Privacy</a></li>
        <li><a href="#">Refund Option</a></li>
        
      </ul>
    </div>
  </div>
</div>
<div class="col-md-4 col-sm-6">
  <div class="aa-footer-widget">
    <div class="aa-footer-widget">
      <h3>About us</h3>
      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's
      standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
    </div>
  </div>
</div>

</div>
</div>
</div>
</div>
</div>
</div>
<!-- footer-bottom -->
<div class="aa-footer-bottom">
<div class="container">
<div class="row">
<div class="col-md-12">
<div class="col-md-4 col-sm-6">
<div class="aa-footer-bottom-area">
<p> <a href="#">Download The App</a></p>
</div>
</div>
<div class="col-md-4 col-sm-6">
<div class="aa-footer-social">
<a href="#"><span class="fa fa-facebook"></span></a>

<a href="#"><span class="fa fa-linkedin"></span></a>
<a href="#"><span class="fa fa-github"></span></a>
<a href="#"><span class="fa fa-twitter"></span></a>
</div>
</div>
<div class="col-md-4 col-sm-6">
<address>
<p><span class="fa fa-envelope"></span>Info@whereicanfindhappiness.com</p>
<p><span class="fa fa-phone"></span>Call : 04 3440 6192</p>
</address>
</div>
</div>
</div>
</div>
</div>
</footer>
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










<script>
  function gotoproductpage(pid,sid,sku){
      alert("productID productSKU productSID"+pid+"  "+sku+"  "+sid+"  ");
                var mapForm = document.createElement("form");
                mapForm.target = "_self";
                mapForm.method = "POST"; // or "post" if appropriate
                mapForm.action = "productdetail.php";
            
                var mapInput = document.createElement("input");
                mapInput.type = "text";
                mapInput.name = "pid";
                mapInput.value = pid;
                mapForm.appendChild(mapInput);
            
                 var mapInput = document.createElement("input");
                mapInput.type = "text";
                mapInput.name = "sid";
                mapInput.value = sid;
                mapForm.appendChild(mapInput);

                     var mapInput = document.createElement("input");
                mapInput.type = "text";
                mapInput.name = "sku";
                mapInput.value = sku;
                mapForm.appendChild(mapInput);


                document.body.appendChild(mapForm);
            
                map = window.open("", "_self" );
            
                if (map) {
                    mapForm.submit();
                } else {
                    alert('You must allow popups for this map to work.');
                }
  }
</script>

  <script>
    function get_productdetail(){
      var pidvalue = 'P1NqQhloc2G';//$('#pid').val()
      var skuvalue = 'chips-varient-kamal';//$('#sku').val()
      var sidvalue = 'SlN82LwrPFg';//$('#sid').val()
    alert("call" +pidvalue);
      $.ajax({
        method: 'POST',
        url: 'https://fleekmart.com/API/index.php/app/getProductDetails',
        headers: {
          'X-API-KEY':'ysh2zka3fhcn4hsdkcn',
        },
        data: {
          language: "default",
          devicetype:"2",
          pid: pidvalue,
          sku: skuvalue,
          sid: sidvalue,
          web_url: "",
   },

       success: function(response){
          console.log(response);
          //alert("response is "+response);
          var resJSON  = response;
          var prodmrp = resJSON.Information.mrp; 
          var prodname = resJSON.Information.name;
          var prodShortDesc = resJSON.Information.short_desc;
          var prodfulldetail = resJSON.Information.fulldetail;
          var prodstock = resJSON.Information.stock; 
          var prodremark = resJSON.Information.remark; 
          var prodpurchase_limit = resJSON.Information.purchase_limit;
          var prodstock_status = resJSON.Information.stock_status;
          var prodbrand = resJSON.Information.brand;
          var prodrating = resJSON.Information.rating;
          var prodprod_rating_count = resJSON.Information.prod_rating_count;
          var prodseller_name = resJSON.Information.seller_name;
        
          var prodreturn_policy = resJSON.Information.return_policy;
          // var prodlimit = resJSON.Information.purchase_limit;
          var prodtotaloff = resJSON.Information.totaloff;
             // var prodlimit = resJSON.Information.purchase_limit;
               var prodtotaloff = resJSON.Information.totaloff;
                var prodoffpercent = resJSON.Information.offpercent;
          var imageObj = resJSON.Information.gallary_img_url;

          var singleImage = resJSON.Information.imgurl;



          console.log( imageObj);
          var img_arr = imageObj.length;
          var other_img_list = '';
          if(img_arr >0){
            for(j=0;j<img_arr;j++){
              var other_image_url = imageObj[j].url;
              other_img_list += '<a data-big-image="<?php echo $MEDIA_URL; ?>'+other_image_url+'" data-lens-image="<?php echo $MEDIA_URL; ?>'+other_image_url+'" class="simpleLens-thumbnail-wrapper" href="#"><img src="<?php echo $MEDIA_URL; ?>'+other_image_url+'"></a>';
            }
          }


          // var singleImage = imageObj.length;
          // if(singleImage >0){
          //   for(j=0;j<singleImage;j++){
          //     var other_image_url = imageObj[j].url;
          //     other_img_list += '<a data-big-image="<?php echo $MEDIA_URL; ?>'+other_image_url+'" data-lens-image="<?php echo $MEDIA_URL; ?>'+other_image_url+'" class="simpleLens-thumbnail-wrapper" href="#"><img src="<?php echo $MEDIA_URL; ?>'+other_image_url+'"></a>';
          //   }
          // }

          
            
          $(".simpleLens-big-image-container").html ('<a class="simpleLens-lens-image" data-lens-image="<?php echo $MEDIA_URL; ?>'+singleImage+'"><img src="<?php echo $MEDIA_URL; ?>'+singleImage+'" class="simpleLens-big-image"></a>');

          $(".c-product-title").text (prodname);
          $(".c-product-price span").text(prodmrp);
          $(".c-product-stk").html('Stock:' + prodstock);
          $(".c-product-stok").text(prodstock_status);
          $(".c-product-rmark").html('Remark:- ' +prodremark);
          $(".c-product-limit").html(prodpurchase_limit);
          $(".c-product-desc span").html(prodShortDesc);
          $(".c-product-full span").html(prodfulldetail);
          $(".c-product-brand").text(prodbrand);
             $(".c-product-sellere").text(prodseller_name);        
          $(".c-product-star-rating").html(prodrating);
          $(".c-product-rating").html(prodprod_rating_count);
          $(".c-product-seller").text(prodseller_name);
          $(".c-product-policy").text(prodreturn_policy);
          $(".c-product-limit span").text(prodpurchase_limit);
          // $(".c-product-limit").text(prodcat_name);
          $(".c-product-gallary").html(other_img_list);
          $(".c-product-total span").text(prodtotaloff);
          $(".c-product-percent span").text(prodoffpercent);



          var attrObj = resJSON.Information.configure_attr;

          console.log( attrObj);



          var attrName = attrObj.length;
          var attrNameList = '';
          if(attrName >0){
            for(j=0;j<attrName;j++){
              var attrNameText = attrObj[j].attr_name;
              var items = attrObj[j].item;

              var itemId = attrObj[j].attr_id;
              var attritems_count = items.length;
              var item_html = '';
              // var item_html_end = '</a>';
              
              // other_img_list += '';

              if(itemId == 1){
                for(itm=0;itm<attritems_count;itm++){ 
                  item_html += '<div class="c-size">'+items[itm].itemvalue+'</div>';
                }
              } 
              else if(itemId == 2){
                for(itm=0;itm<attritems_count;itm++){ 
                  item_html += '<div class="attr-item c-color">'+items[itm].itemvalue+'</div>';
                }
              } 
              else if(itemId == 3){
                for(itm=0;itm<attritems_count;itm++){ 
                  item_html += '<div class="attr-item c-weight">'+items[itm].itemvalue+'</div>';
                }
              } 
          
              attrNameList += '<div class="button-tag"><h5>'+attrNameText+'</h5></div>'+item_html;
            }
          
            $("#product_weight_div").html(attrNameList);
                      
          }



const configure_attr = document.querySelector('.aa-product-related-item');


        }
      });
    };

   function get_relatedProd(){
      var pidvalue = 'P1NqQhloc2G';//$('#pid').val()
      var skuvalue = 'chips-varient-kamal';//$('#sku').val()
      var sidvalue = 'SlN82LwrPFg';//$('#sid').val()
      alert("call rel" +pidvalue);
      $.ajax({
        method: 'POST',
        url: 'https://fleekmart.com/API/index.php/app/getRelatedProductDetails',
        headers: {
          'X-API-KEY':'ysh2zka3fhcn4hsdkcn',
        },
        data: {
          language: "default",
          devicetype:"2",
          pid: pidvalue,
          sku: skuvalue,
          sid: sidvalue
  },

       success: function(response){
          console.log(response);
          var resJSON  = response;
          var totalrelprod = resJSON.Information.length; 
          // console.log("info lenght of releted is" + totalprod );   
          var infoarray = resJSON.Information;
          var rel_product_list ="";
           // aa-product-related-item 
          for(var i =0 ; i<totalrelprod; i++){
          var infoobj = infoarray[i];
          var prodname = infoobj.name;
          var prodImg = infoobj.imgurl;
          var prodPrice = infoobj.price;
          // var prodLink = infoobj.web_url;
          //alert( "prod name is "+ prodname);
          // <input type="hidden">
          var pid = infoobj.id;
          var sku = infoobj.sku;
          var sid = infoobj.vendor_id;


          rel_product_list += '<li class="col portfolio-item"><div class="portfolio-wrapp"><img class="img-fluid" src="https://www.fleekmart.com/media/'+prodImg+'" alt="'+prodname+'"><h4><a href="https://www.fleekmart.com/'+sku+'"><b>'+prodname+'</b></a></h4><p><b style="color: #f35225;;">'+prodPrice+'</b></p><span class="aa-icon-right  fa fa-shopping-cart"></span></div></li>';

          }
       
          $(".aa-product-related-item").html(rel_product_list);
          $(".srelate_product").click(function() {
            var $row = $(this).closest("li");    // Find the row
            var pid = $row.find(".related-product-single").val(); 
            var sku = $row.find(".productSKU").val(); 
            var sid = $row.find(".productSID").val(); 
            // parentvalue = text;
            alert("related-product-single productSKU productSID"+pid+"  "+sku+"  "+sid+"  "); 
            gotoproductpage(pid,sid,sku);
          });
        }
    });
 }
    
      function get_UpSellProd(){
        var pidvalue = 'P1NqQhloc2G';//$('#pid').val()
        var skuvalue = 'chips-varient-kamal';//$('#sku').val()
        var sidvalue = 'SlN82LwrPFg';//$('#sid').val()
        alert("call upsell " +pidvalue);
        $.ajax({
          method: 'POST',
          url: 'https://fleekmart.com/API/index.php/app/getUpsellProductDetails',
          headers: {
            'X-API-KEY':'ysh2zka3fhcn4hsdkcn',
          },
          data: {
            language: "default",
            devicetype:"2",
            pid: pidvalue,
            sku: skuvalue,
            sid: sidvalue
         },

        success: function(response){
          console.log(response);
          var resJSON  = response;
          var totalrelprod = resJSON.Information.length; 
          // console.log("info lenght of releted is" + totalprod );   
          var infoarray = resJSON.Information;
          var rel_product_list ="";
           // aa-product-related-item 
          for(var i =0 ; i<totalrelprod; i++){
          var infoobj = infoarray[i];
          var prodname = infoobj.name;
          var prodImg = infoobj.imgurl;
          var prodPrice = infoobj.price;
          // var prodLink = infoobj.web_url;
          //alert( "prod name is "+ prodname);
          // <input type="hidden">
          var pid = infoobj.id;
          var sku = infoobj.sku;
          var sid = infoobj.vendor_id;


          rel_product_list += '<li class="col portfolio-item"><div class="portfolio-wrapp-buy"><img class="img-fluid" src="https://www.fleekmart.com/media/'+prodImg+'" alt="'+prodname+'"><h4><a href="https://www.fleekmart.com/'+sku+'"><b>'+prodname+'</b></a></h4><p><b style="color: #f35225;;">'+prodPrice+'</b></p><span class="aa-icon-right  fa fa-shopping-cart"></span></div></li>';

          }
       
          $(".aa-product-also-buy").html(rel_product_list);
          $(".srelate_product").click(function() {
            var $row = $(this).closest("li");    // Find the row
            var pid = $row.find(".related-product-single").val(); 
            var sku = $row.find(".productSKU").val(); 
            var sid = $row.find(".productSID").val(); 
            // parentvalue = text;
            alert("related-product-single productSKU productSID"+pid+"  "+sku+"  "+sid+"  "); 
            gotoproductpage(pid,sid,sku);
          });
        }
      });
    }
    $(document).ready(function() {
      get_productdetail();
      get_relatedProd();
      get_UpSellProd();
    });
  </script>


 

  </body>
</html>