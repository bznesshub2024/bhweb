<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "Product Details";
    include("includes/headTag.php") ?>
</head>

<body>

<main>
	<?php
        include("includes/topbar.php")
        ?>
        <?php
        include("includes/navbar.php")
        ?>
	
	<!--Start: Slider Section -->
	<section class="product-slider">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-5">
					<div class="left-block">
						<div id="slider" class="flexslider">
							<ul class="slides">
							<li>
								<img src="assets/images/slide1.png" />
							</li>
							<li>
								<img src="assets/images/slide2.png" />
							</li>
							<li>
								<img src="assets/images/slide3.png" />
							</li>
							<li>
								<img src="assets/images/slide4.png" />
							</li>
							<!-- items mirrored twice, total of 12 -->
							</ul>
						</div>
						<div id="carousel" class="flexslider">
							<ul class="slides">
							<li>
								<img src="assets/images/slide1.png" />
							</li>
							<li>
								<img src="assets/images/slide2.png" />
							</li>
							<li>
								<img src="assets/images/slide3.png" />
							</li>
							<li>
								<img src="assets/images/slide4.png" />
							</li>
							<!-- items mirrored twice, total of 12 -->
							</ul>
						</div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="right-block">
						<div class="comp-nm">NIKE</div>
						<h6>Men Self Design Round Neck White T-Shirt</h6>
						<div class="rate">
							<h5>₹749</h5>
							<div class="off-price">₹1749</div>
							<div class="off-rate">60% off</div>
						</div>
						<div class="rate">
							<div class="rating">4.1 <img src="assets/images/icons/star.png" /></div>
							<div class="rating-details">56 ratings and 8 reviews </div>
						</div>
						<div class="available-offers">
							<h6>Available Offers</h6>
							<div class="rate"><img src="assets/images/icons/lable-fill.png" /> Get extra 7% off upto ₹500 on 1 item(s) </div>
							<div class="rate"><img src="assets/images/icons/lable-fill.png" /> Get extra 7% off upto ₹500 on 1 item(s) </div>
						</div>
						<div class="deliver-time">Deliver in 5-7 Business Days</div>
						<div class="p-size">
							<h6>Size :</h6>
							<ul>
								<li>
									<a href="#">S</a>
								</li>
								<li>
									<a href="#">M</a>
								</li>
								<li>
									<a href="#">L</a>
								</li>
								<li>
									<a href="#" class="active">XL</a>
								</li>
								<li>
									<a href="#">XXL</a>
								</li>
							</ul>
						</div>
						<div class="p-color">
							<h6>Color :</h6>
							<ul>
								<li class="bg-warning">
									<a href="#">Y</a>
								</li>
								<li class="bg-danger">
									<a href="#">R</a>
								</li>
								<li class="bg-white active">
									<a href="#">W</a>
								</li>
								<li class="bg-primary">
									<a href="#">B</a>
								</li>
							</ul>
						</div>
						<div class="btn-wrap">
							<a href="#" class="btn btn-default"><svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.1234 28.9947C17.1234 28.9947 17.124 28.9938 17.1253 28.9921C17.124 28.9939 17.1234 28.9947 17.1234 28.9947ZM18.5242 29.3032C18.5242 29.3033 18.524 29.3023 18.5236 29.3003C18.524 29.3022 18.5242 29.3032 18.5242 29.3032ZM16.4732 5.69675C16.4732 5.69673 16.4734 5.69768 16.4738 5.69969C16.4734 5.69779 16.4732 5.69678 16.4732 5.69675ZM17.874 6.00529C17.874 6.00532 17.8734 6.00615 17.8722 6.00769C17.8734 6.00603 17.874 6.00526 17.874 6.00529ZM10.0867 20.2019L10.9262 19.6655L10.0867 20.2019C10.4662 20.7958 11.0721 20.9828 11.5688 21.0565C12.032 21.1252 12.6233 21.1251 13.2672 21.125C13.2904 21.125 13.3136 21.125 13.3369 21.125H16.4987V28.3549L16.4987 28.408C16.4986 28.8071 16.4986 29.1867 16.529 29.4692C16.5443 29.6119 16.5756 29.8257 16.6685 30.0336C16.7715 30.264 17.0114 30.6075 17.4798 30.7107C17.9482 30.8138 18.3103 30.6029 18.5005 30.4371C18.6722 30.2875 18.7904 30.1066 18.8643 29.9836C19.0105 29.74 19.17 29.3955 19.3376 29.0332L19.3599 28.9851L24.3829 18.1354C24.3927 18.1142 24.4025 18.0931 24.4122 18.0721C24.6828 17.4878 24.9313 16.9512 25.0635 16.5021C25.2054 16.0204 25.2902 15.392 24.9107 14.7981C24.5312 14.2042 23.9253 14.0172 23.4286 13.9435C22.9655 13.8748 22.3742 13.8749 21.7302 13.875C21.707 13.875 21.6838 13.875 21.6605 13.875H18.4987V6.64513C18.4987 6.62739 18.4987 6.60969 18.4987 6.59202C18.4988 6.19289 18.4988 5.8133 18.4684 5.5308C18.4531 5.38807 18.4218 5.1743 18.3289 4.96638C18.2259 4.73598 17.986 4.39249 17.5176 4.28932C17.0492 4.18616 16.6871 4.39706 16.4969 4.56288C16.3252 4.71252 16.207 4.89337 16.1331 5.01644C15.9869 5.26004 15.8274 5.60453 15.6598 5.96676C15.6524 5.98279 15.6449 5.99885 15.6375 6.01494L10.6145 16.8646C10.6047 16.8858 10.5949 16.9069 10.5852 16.9279C10.3146 17.5122 10.0661 18.0488 9.93386 18.4979C9.79204 18.9796 9.70715 19.608 10.0867 20.2019Z" stroke="" stroke-width="2"/></svg> Buy Now</a>

							<a href="#" class="btn btn-secondary"><svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.1263 32.0833C13.9317 32.0833 14.5846 31.4304 14.5846 30.625C14.5846 29.8196 13.9317 29.1667 13.1263 29.1667C12.3209 29.1667 11.668 29.8196 11.668 30.625C11.668 31.4304 12.3209 32.0833 13.1263 32.0833Z" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M29.1654 32.0833C29.9708 32.0833 30.6237 31.4304 30.6237 30.625C30.6237 29.8196 29.9708 29.1667 29.1654 29.1667C28.3599 29.1667 27.707 29.8196 27.707 30.625C27.707 31.4304 28.3599 32.0833 29.1654 32.0833Z" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M1.45703 1.45833H7.29036L11.1987 20.9854C11.3321 21.6568 11.6973 22.2599 12.2305 22.6892C12.7638 23.1184 13.431 23.3464 14.1154 23.3333H28.2904C28.9748 23.3464 29.642 23.1184 30.1752 22.6892C30.7084 22.2599 31.0737 21.6568 31.207 20.9854L33.5404 8.75H8.7487" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Add to Cart</a>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</section>
	<!--End: Slider Section -->

	<!--Trending Section -->
	<section class="trending-section">
		<div class="container" style="max-width: 1274px;">
			<div class="row">

				<!--Block-->
				<div class="col-lg-3 col-6">
					<div class="card">
					  <img src="assets/images/img-1.png" class="card-img-top" alt="..." />
					  <div class="card-body">
						<h6 class="card-title">Banasari Saree Blue soft Silk</h6>
						<h6 class="price-off">37% OFF<h6>
						<div class="row">
							<div class="col-6">
								<p>
									<h6 class="old-price">₹1229</h6>
									<h5 class="new-price">₹749/-</h5>
								</p>
							</div>
							<div class="col-6">
								<div class="btn-by-now">
									<a href="#" class="btn btn-default w-100">Buy Now</a>
								</div>
							</div>
						</div>
					  </div>
					</div>
				</div>
				<!--/*Block-->

				<!--Block-->
				<div class="col-lg-3 col-6">
					<div class="card">
					  <img src="assets/images/img-1.png" class="card-img-top" alt="..." />
					  <div class="card-body">
						<h6 class="card-title">Banasari Saree Blue soft Silk</h6>
						<h6 class="price-off">37% OFF<h6>
						<div class="row">
							<div class="col-6">
								<p>
									<h6 class="old-price">₹1229</h6>
									<h5 class="new-price">₹749/-</h5>
								</p>
							</div>
							<div class="col-6">
								<div class="btn-by-now">
									<a href="#" class="btn btn-default w-100">Buy Now</a>
								</div>
							</div>
						</div>
					  </div>
					</div>
				</div>
				<!--/*Block-->

				<!--Block-->
				<div class="col-lg-3 col-6">
					<div class="card">
					  <img src="assets/images/img-1.png" class="card-img-top" alt="..." />
					  <div class="card-body">
						<h6 class="card-title">Banasari Saree Blue soft Silk</h6>
						<h6 class="price-off">37% OFF<h6>
						
						<div class="row">
							<div class="col-6">
								<p>
									<h6 class="old-price">₹1229</h6>
									<h5 class="new-price">₹749/-</h5>
								</p>
							</div>
							<div class="col-6">
								<div class="btn-by-now">
									<a href="#" class="btn btn-default w-100">Buy Now</a>
								</div>
							</div>
						</div>
					  </div>
					</div>
				</div>
				<!--/*Block-->

				<!--Block-->
				<div class="col-lg-3 col-6">
					<div class="card">
					  <img src="assets/images/img-1.png" class="card-img-top" alt="..." />
					  <div class="card-body">
						<h6 class="card-title">Banasari Saree Blue soft Silk</h6>
						<h6 class="price-off">37% OFF<h6>
						
						<div class="row">
							<div class="col-6">
								<p>
									<h6 class="old-price">₹1229</h6>
									<h5 class="new-price">₹749/-</h5>
								</p>
							</div>
							<div class="col-6">
								<div class="btn-by-now">
									<a href="#" class="btn btn-default w-100">Buy Now</a>
								</div>
							</div>
						</div>
					  </div>
					</div>
				</div>
				<!--/*Block-->

			</div>
		</div>
	</section>
	<!--/*Trending Section -->

</main>
 <?php
    include("includes/footer.php")
    ?>

    <?php
    include("includes/script.php")
    ?>
	
</body>

	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script type="text/javascript">
		$(window).load(function() {
			// The slider being synced must be initialized first
			$('#carousel').flexslider({
			animation: "slide",
			controlNav: false,
			animationLoop: false,
			slideshow: false,
			itemWidth: 149,
			itemMargin: 10,
			minItems: 4,
    		maxItems: 7,
			asNavFor: '#slider'
			});

			$('#slider').flexslider({
			animation: "slide",
			controlNav: false,
			animationLoop: false,
			slideshow: false,
			directionNav:false,
			itemWidth: 656,
			sync: "#carousel"
			});
		});
	</script>
	
	
</html>
