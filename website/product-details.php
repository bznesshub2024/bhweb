<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "Product Details";
    include("includes/headTag.php") ?>
</head>

<body>

	<?php
        include("includes/topbar.php")
        ?>
        <?php
        include("includes/navbar.php")
        ?>
	
<main class="product-details-page">
	
	<!--Start: Slider Section -->
	<section class="product-slider">
		<div class="container" style="max-width:1416px;">
			<div class="row">
				<div class="col-md-5">
					<div class="left-block">
						<div class="column small-11 small-centered">
                            <div class="slider slider-single light-box">
                                <a class="spotlight zoom-img" data-page="false" data-animation="fade" data-control="zoom,fullscreen,close" data-theme="white" data-autohide=false href="assets/images/slide1.png">
									<div>
										<img class="img-fluid" src="assets/images/slide1.png">
										<svg width="30" height="30" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.08109 12.7492L10.4543 18.7362C10.6465 18.9167 10.7425 19.0069 10.852 19.0412C10.9492 19.0716 11.0534 19.0716 11.1507 19.0412C11.2601 19.0069 11.3561 18.9167 11.5483 18.7362L17.9215 12.7492C19.7147 11.0647 19.9324 8.29271 18.4243 6.34889L18.1407 5.98339C16.3366 3.65802 12.7151 4.048 11.4474 6.70417C11.2683 7.07937 10.7343 7.07937 10.5552 6.70417C9.28748 4.048 5.66605 3.65802 3.86189 5.98339L3.57831 6.34888C2.07017 8.29271 2.28793 11.0647 4.08109 12.7492Z" stroke=""/></svg>
									</div>
								</a>
                                <a class="spotlight zoom-img" data-page="false" data-animation="fade" data-control="zoom,fullscreen,close" data-theme="white" data-autohide=false href="assets/images/slide2.png">
									<div>
										<img class="img-fluid" src="assets/images/slide2.png">
										<svg width="30" height="30" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.08109 12.7492L10.4543 18.7362C10.6465 18.9167 10.7425 19.0069 10.852 19.0412C10.9492 19.0716 11.0534 19.0716 11.1507 19.0412C11.2601 19.0069 11.3561 18.9167 11.5483 18.7362L17.9215 12.7492C19.7147 11.0647 19.9324 8.29271 18.4243 6.34889L18.1407 5.98339C16.3366 3.65802 12.7151 4.048 11.4474 6.70417C11.2683 7.07937 10.7343 7.07937 10.5552 6.70417C9.28748 4.048 5.66605 3.65802 3.86189 5.98339L3.57831 6.34888C2.07017 8.29271 2.28793 11.0647 4.08109 12.7492Z" stroke=""/></svg>
									</div>
								</a>
								<a class="spotlight zoom-img" data-page="false" data-animation="fade" data-control="zoom,fullscreen,close" data-theme="white" data-autohide=false href="assets/images/slide3.png">
									<div>
										<img class="img-fluid" src="assets/images/slide3.png">
										<svg width="30" height="30" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.08109 12.7492L10.4543 18.7362C10.6465 18.9167 10.7425 19.0069 10.852 19.0412C10.9492 19.0716 11.0534 19.0716 11.1507 19.0412C11.2601 19.0069 11.3561 18.9167 11.5483 18.7362L17.9215 12.7492C19.7147 11.0647 19.9324 8.29271 18.4243 6.34889L18.1407 5.98339C16.3366 3.65802 12.7151 4.048 11.4474 6.70417C11.2683 7.07937 10.7343 7.07937 10.5552 6.70417C9.28748 4.048 5.66605 3.65802 3.86189 5.98339L3.57831 6.34888C2.07017 8.29271 2.28793 11.0647 4.08109 12.7492Z" stroke=""/></svg>
									</div>
								</a>

								<div data-bs-toggle="modal" data-bs-target="#sliderModal"><img class="img-fluid" src="assets/images/slide4.png"></div>

								<a class="spotlight zoom-img" data-page="false" data-animation="fade" data-control="zoom,fullscreen,close" data-theme="white" data-autohide=false href="assets/images/featured-img-1.png">
									<div>
										<img class="img-fluid" src="assets/images/featured-img-1.png">
										<svg width="30" height="30" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.08109 12.7492L10.4543 18.7362C10.6465 18.9167 10.7425 19.0069 10.852 19.0412C10.9492 19.0716 11.0534 19.0716 11.1507 19.0412C11.2601 19.0069 11.3561 18.9167 11.5483 18.7362L17.9215 12.7492C19.7147 11.0647 19.9324 8.29271 18.4243 6.34889L18.1407 5.98339C16.3366 3.65802 12.7151 4.048 11.4474 6.70417C11.2683 7.07937 10.7343 7.07937 10.5552 6.70417C9.28748 4.048 5.66605 3.65802 3.86189 5.98339L3.57831 6.34888C2.07017 8.29271 2.28793 11.0647 4.08109 12.7492Z" stroke=""/></svg>
									</div>
								</a>
								<a class="spotlight zoom-img" data-page="false" data-animation="fade" data-control="zoom,fullscreen,close" data-theme="white" data-autohide=false href="assets/images/featured-img-2.png">
									<div>
										<img class="img-fluid" src="assets/images/featured-img-2.png">
										<svg width="30" height="30" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.08109 12.7492L10.4543 18.7362C10.6465 18.9167 10.7425 19.0069 10.852 19.0412C10.9492 19.0716 11.0534 19.0716 11.1507 19.0412C11.2601 19.0069 11.3561 18.9167 11.5483 18.7362L17.9215 12.7492C19.7147 11.0647 19.9324 8.29271 18.4243 6.34889L18.1407 5.98339C16.3366 3.65802 12.7151 4.048 11.4474 6.70417C11.2683 7.07937 10.7343 7.07937 10.5552 6.70417C9.28748 4.048 5.66605 3.65802 3.86189 5.98339L3.57831 6.34888C2.07017 8.29271 2.28793 11.0647 4.08109 12.7492Z" stroke=""/></svg>
									</div>
								</a>
                			</div>
                            <div class="slider slider-nav">
                                <div><img class="img-fluid" src="assets/images/slide1.png"></div>
                                <div><img class="img-fluid" src="assets/images/slide2.png"></div>
								<div><img class="img-fluid" src="assets/images/slide3.png"></div>
								<div><img class="img-fluid" src="assets/images/slide4.png"></div>
								<div><img class="img-fluid" src="assets/images/featured-img-1.png"></div>
								<div><img class="img-fluid" src="assets/images/featured-img-2.png"></div>
							</div>
                        </div>
					</div>
				</div>
				<div class="col-md-7">
					<div class="right-block ">
						<h6>NIKE</h6>
						<h6 class="product-name">Men Self Design Round Neck White T-Shirt</h6>
						<div class="rate">
							<h5>₹749</h5>
							<div class="old-price">₹1749</div>
							<div class="off-price">60% OFF</div>
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
						<h6 class="deliver-time">Deliver in 5-7 Business Days</h6>
						<div class="p-size">
							<h6>Size:</h6>
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
							<h6>Color:</h6>
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
								<li class="bg-success">
									<a href="#">G</a>
								</li>
							</ul>
						</div>
						<div class="btn-wrap">
							<a href="#" class="btn btn-default"><svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.1234 28.9947C17.1234 28.9947 17.124 28.9938 17.1253 28.9921C17.124 28.9939 17.1234 28.9947 17.1234 28.9947ZM18.5242 29.3032C18.5242 29.3033 18.524 29.3023 18.5236 29.3003C18.524 29.3022 18.5242 29.3032 18.5242 29.3032ZM16.4732 5.69675C16.4732 5.69673 16.4734 5.69768 16.4738 5.69969C16.4734 5.69779 16.4732 5.69678 16.4732 5.69675ZM17.874 6.00529C17.874 6.00532 17.8734 6.00615 17.8722 6.00769C17.8734 6.00603 17.874 6.00526 17.874 6.00529ZM10.0867 20.2019L10.9262 19.6655L10.0867 20.2019C10.4662 20.7958 11.0721 20.9828 11.5688 21.0565C12.032 21.1252 12.6233 21.1251 13.2672 21.125C13.2904 21.125 13.3136 21.125 13.3369 21.125H16.4987V28.3549L16.4987 28.408C16.4986 28.8071 16.4986 29.1867 16.529 29.4692C16.5443 29.6119 16.5756 29.8257 16.6685 30.0336C16.7715 30.264 17.0114 30.6075 17.4798 30.7107C17.9482 30.8138 18.3103 30.6029 18.5005 30.4371C18.6722 30.2875 18.7904 30.1066 18.8643 29.9836C19.0105 29.74 19.17 29.3955 19.3376 29.0332L19.3599 28.9851L24.3829 18.1354C24.3927 18.1142 24.4025 18.0931 24.4122 18.0721C24.6828 17.4878 24.9313 16.9512 25.0635 16.5021C25.2054 16.0204 25.2902 15.392 24.9107 14.7981C24.5312 14.2042 23.9253 14.0172 23.4286 13.9435C22.9655 13.8748 22.3742 13.8749 21.7302 13.875C21.707 13.875 21.6838 13.875 21.6605 13.875H18.4987V6.64513C18.4987 6.62739 18.4987 6.60969 18.4987 6.59202C18.4988 6.19289 18.4988 5.8133 18.4684 5.5308C18.4531 5.38807 18.4218 5.1743 18.3289 4.96638C18.2259 4.73598 17.986 4.39249 17.5176 4.28932C17.0492 4.18616 16.6871 4.39706 16.4969 4.56288C16.3252 4.71252 16.207 4.89337 16.1331 5.01644C15.9869 5.26004 15.8274 5.60453 15.6598 5.96676C15.6524 5.98279 15.6449 5.99885 15.6375 6.01494L10.6145 16.8646C10.6047 16.8858 10.5949 16.9069 10.5852 16.9279C10.3146 17.5122 10.0661 18.0488 9.93386 18.4979C9.79204 18.9796 9.70715 19.608 10.0867 20.2019Z" stroke="" stroke-width="2"/></svg> Buy Now</a>

							<a href="#" class="btn btn-secondary"><svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.1263 32.0833C13.9317 32.0833 14.5846 31.4304 14.5846 30.625C14.5846 29.8196 13.9317 29.1667 13.1263 29.1667C12.3209 29.1667 11.668 29.8196 11.668 30.625C11.668 31.4304 12.3209 32.0833 13.1263 32.0833Z" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M29.1654 32.0833C29.9708 32.0833 30.6237 31.4304 30.6237 30.625C30.6237 29.8196 29.9708 29.1667 29.1654 29.1667C28.3599 29.1667 27.707 29.8196 27.707 30.625C27.707 31.4304 28.3599 32.0833 29.1654 32.0833Z" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M1.45703 1.45833H7.29036L11.1987 20.9854C11.3321 21.6568 11.6973 22.2599 12.2305 22.6892C12.7638 23.1184 13.431 23.3464 14.1154 23.3333H28.2904C28.9748 23.3464 29.642 23.1184 30.1752 22.6892C30.7084 22.2599 31.0737 21.6568 31.207 20.9854L33.5404 8.75H8.7487" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Add to Cart</a>
						</div>

						<div class="delivery">
							<form>
								<div class="wrap">
									<div class="input-group">
										<h6>Delivery:</h6>
										<span class="input-group-text"><img src="assets/images/icons/location.png" /></span>
										<input type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
										<a href="#" class="input-group-text input-group-check">Check</a>
									</div>
									<ul class="">
										<li>Delivery in 5-7 business Days</li>
										<li>Free Delivery</li>
									</ul>
								</div>
							</form>
						</div>
						<div class="delivery-reviews">
							<ul class="nav nav-pills" id="pills-tab" role="tablist">
								<li class="nav-item" role="presentation">
								<button class="nav-link active" id="pills-product-tab" data-bs-toggle="pill" data-bs-target="#pills-product" type="button" role="tab" aria-controls="pills-product" aria-selected="true">Product Details</button>
								</li>
								<li class="nav-item" role="presentation">
								<button class="nav-link" id="pills-reviews-tab" data-bs-toggle="pill" data-bs-target="#pills-reviews" type="button" role="tab" aria-controls="pills-reviews" aria-selected="false">
									Ratings & Reviews
									<div class="rate mt-0">
										<div class="rating">4.1 <img src="assets/images/icons/star.png" /></div>
										<div class="rating-details">56 ratings and 8 reviews </div>
									</div>
								</button>
								</li>
							</ul>
							<div class="tab-content" id="pills-tabContent">
								<div class="tab-pane fade show active" id="pills-product" role="tabpanel" aria-labelledby="pills-product-tab">
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmodtempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmodtempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmodtempor incididunt ut labore et dolore magna aliqua.</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmodtempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmodtempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmodtempor incididunt ut labore et dolore magna aliqua.</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmodtempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmodtempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmodtempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmodtempor incididunt ut labore et dolore magna aliqua.</p>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmodtempor incididunt ut labore et dolore magna aliqua.</p>
									<div class="return-product"><a href="return-policy.html" data-bs-toggle="modal" data-bs-target="#policyModal">Return Policy</a></div>
								</div>
								<div class="tab-pane fade" id="pills-reviews" role="tabpanel" aria-labelledby="pills-reviews-tab">
									<div class="add-reviews"><a href="#" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#reviewsModal">Add Reviews</a></div>
									<div class="review-details">
										<div class="rate">
											<div class="rating bg-danger">1 <img src="assets/images/icons/star.png" /></div>
											<div class="rating-details">Lorem ipsum dolor sit amet, consectetur adipiscing</div>
										</div>
										<div class="customer">
											Marurang customer
											<p>2 months ago</p>
										</div>
									</div>
									<div class="review-details">
										<div class="rate">
											<div class="rating bg-golden">2 <img src="assets/images/icons/star.png" /></div>
											<div class="rating-details">Lorem ipsum dolor sit amet, consectetur adipiscing</div>
										</div>
										<div class="customer">
											Marurang customer
											<p>2 months ago</p>
										</div>
									</div>
									<div class="review-details">
										<div class="rate">
											<div class="rating bg-fern-frond">3 <img src="assets/images/icons/star.png" /></div>
											<div class="rating-details">Lorem ipsum dolor sit amet, consectetur adipiscing</div>
										</div>
										<div class="customer">
											Marurang customer
											<p>2 months ago</p>
										</div>
									</div>
									<div class="review-details">
										<div class="rate">
											<div class="rating bg-success">4 <img src="assets/images/icons/star.png" /></div>
											<div class="rating-details">Lorem ipsum dolor sit amet, consectetur adipiscing</div>
										</div>
										<div class="customer">
											Marurang customer
											<p>1 months ago</p>
										</div>
									</div>
									<div class="add-reviews all-reviews"><a href="#">All 8 reviews</a></div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			
		</div>
	</section>
	<!--End: Slider Section -->

	<!--Trending Section -->
	<section class="trending-section">
		<div class="container" style="max-width:1225px;">
			<h4>Featured Items</h4>
			<div class="slider slider-trending">
				<!--Block-->
				<div class="card">
					<div class="card-img zoom-img">
						<img src="assets/images/featured-img-1.png" class="card-img-top" alt="..." />
						<div class="favorite"><a href="javascript:void(0);"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.08109 12.7492L10.4543 18.7362C10.6465 18.9167 10.7425 19.0069 10.852 19.0412C10.9492 19.0716 11.0534 19.0716 11.1507 19.0412C11.2601 19.0069 11.3561 18.9167 11.5483 18.7362L17.9215 12.7492C19.7147 11.0647 19.9324 8.29271 18.4243 6.34889L18.1407 5.98339C16.3366 3.65802 12.7151 4.048 11.4474 6.70417C11.2683 7.07937 10.7343 7.07937 10.5552 6.70417C9.28748 4.048 5.66605 3.65802 3.86189 5.98339L3.57831 6.34888C2.07017 8.29271 2.28793 11.0647 4.08109 12.7492Z" stroke=""/></svg></a></div>
					</div>
				  <div class="card-body">
					<h6>Banasari Saree Blue soft Silk</h6>
					<h6 class="price-off text-danger">37% OFF<h6>
					
					<div class="row">
						<div class="col-6">
							<h6 class="old-price">₹1229</h6>
							<h5 class="new-price">₹749/-</h5>
						</div>
						<div class="col-6">
							<div class="btn-by-now">
								<a href="#" class="btn btn-default w-100">Buy Now</a>
							</div>
						</div>
					</div>
				  </div>
				</div>
				<!--/*Block-->

				<!--Block-->
				<div class="card">
					<div class="card-img zoom-img">
						<img src="assets/images/featured-img-2.png" class="card-img-top" alt="..." />
						<div class="favorite"><a href="javascript:void(0);"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.08109 12.7492L10.4543 18.7362C10.6465 18.9167 10.7425 19.0069 10.852 19.0412C10.9492 19.0716 11.0534 19.0716 11.1507 19.0412C11.2601 19.0069 11.3561 18.9167 11.5483 18.7362L17.9215 12.7492C19.7147 11.0647 19.9324 8.29271 18.4243 6.34889L18.1407 5.98339C16.3366 3.65802 12.7151 4.048 11.4474 6.70417C11.2683 7.07937 10.7343 7.07937 10.5552 6.70417C9.28748 4.048 5.66605 3.65802 3.86189 5.98339L3.57831 6.34888C2.07017 8.29271 2.28793 11.0647 4.08109 12.7492Z" stroke=""/></svg></a></div>
					</div>
				  <div class="card-body">
					<h6>Banasari Saree Blue soft Silk</h6>
					<h6 class="price-off text-danger">37% OFF<h6>
					
					<div class="row">
						<div class="col-6">
							<h6 class="old-price">₹1229</h6>
							<h5 class="new-price">₹749/-</h5>
						</div>
						<div class="col-6">
							<div class="btn-by-now">
								<a href="#" class="btn btn-default w-100">Buy Now</a>
							</div>
						</div>
					</div>
				  </div>
				</div>
				<!--/*Block-->

				<!--Block-->
				<div class="card">
					<div class="card-img zoom-img">
						<img src="assets/images/featured-img-3.png" class="card-img-top" alt="..." />
						<div class="favorite"><a href="javascript:void(0);"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.08109 12.7492L10.4543 18.7362C10.6465 18.9167 10.7425 19.0069 10.852 19.0412C10.9492 19.0716 11.0534 19.0716 11.1507 19.0412C11.2601 19.0069 11.3561 18.9167 11.5483 18.7362L17.9215 12.7492C19.7147 11.0647 19.9324 8.29271 18.4243 6.34889L18.1407 5.98339C16.3366 3.65802 12.7151 4.048 11.4474 6.70417C11.2683 7.07937 10.7343 7.07937 10.5552 6.70417C9.28748 4.048 5.66605 3.65802 3.86189 5.98339L3.57831 6.34888C2.07017 8.29271 2.28793 11.0647 4.08109 12.7492Z" stroke=""/></svg></a></div>
					</div>
				  <div class="card-body">
					<h6>Banasari Saree Blue soft Silk</h6>
					<h6 class="price-off text-danger">37% OFF<h6>
					
					<div class="row">
						<div class="col-6">
							<h6 class="old-price">₹1229</h6>
							<h5 class="new-price">₹749/-</h5>
						</div>
						<div class="col-6">
							<div class="btn-by-now">
								<a href="#" class="btn btn-default w-100">Buy Now</a>
							</div>
						</div>
					</div>
				  </div>
				</div>
				<!--/*Block-->

				<!--Block-->
				<div class="card">
					<div class="card-img zoom-img">
						<img src="assets/images/featured-img-4.png" class="card-img-top" alt="..." />
						<div class="favorite"><a href="javascript:void(0);"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.08109 12.7492L10.4543 18.7362C10.6465 18.9167 10.7425 19.0069 10.852 19.0412C10.9492 19.0716 11.0534 19.0716 11.1507 19.0412C11.2601 19.0069 11.3561 18.9167 11.5483 18.7362L17.9215 12.7492C19.7147 11.0647 19.9324 8.29271 18.4243 6.34889L18.1407 5.98339C16.3366 3.65802 12.7151 4.048 11.4474 6.70417C11.2683 7.07937 10.7343 7.07937 10.5552 6.70417C9.28748 4.048 5.66605 3.65802 3.86189 5.98339L3.57831 6.34888C2.07017 8.29271 2.28793 11.0647 4.08109 12.7492Z" stroke=""/></svg></a></div>
					</div>
				  <div class="card-body">
					<h6>Banasari Saree Blue soft Silk</h6>
					<h6 class="price-off text-danger">37% OFF<h6>
					
					<div class="row">
						<div class="col-6">
							<h6 class="old-price">₹1229</h6>
							<h5 class="new-price">₹749/-</h5>
						</div>
						<div class="col-6">
							<div class="btn-by-now">
								<a href="#" class="btn btn-default w-100">Buy Now</a>
							</div>
						</div>
					</div>
				  </div>
				</div>
				<!--/*Block-->

				<!--Block-->
				<div class="card">
					<div class="card-img zoom-img">
						<img src="assets/images/featured-img-5.png" class="card-img-top" alt="..." />
						<div class="favorite"><a href="javascript:void(0);"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.08109 12.7492L10.4543 18.7362C10.6465 18.9167 10.7425 19.0069 10.852 19.0412C10.9492 19.0716 11.0534 19.0716 11.1507 19.0412C11.2601 19.0069 11.3561 18.9167 11.5483 18.7362L17.9215 12.7492C19.7147 11.0647 19.9324 8.29271 18.4243 6.34889L18.1407 5.98339C16.3366 3.65802 12.7151 4.048 11.4474 6.70417C11.2683 7.07937 10.7343 7.07937 10.5552 6.70417C9.28748 4.048 5.66605 3.65802 3.86189 5.98339L3.57831 6.34888C2.07017 8.29271 2.28793 11.0647 4.08109 12.7492Z" stroke=""/></svg></a></div>
					</div>
				  <div class="card-body">
					<h6>Banasari Saree Blue soft Silk</h6>
					<h6 class="price-off text-danger">37% OFF<h6>
					
					<div class="row">
						<div class="col-6">
							<h6 class="old-price">₹1229</h6>
							<h5 class="new-price">₹749/-</h5>
						</div>
						<div class="col-6">
							<div class="btn-by-now">
								<a href="#" class="btn btn-default w-100">Buy Now</a>
							</div>
						</div>
					</div>
				  </div>
				</div>
				<!--/*Block-->

				<!--Block-->
				<div class="card">
					<div class="card-img zoom-img">
						<img src="assets/images/featured-img-6.png" class="card-img-top" alt="..." />
						<div class="favorite"><a href="javascript:void(0);"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.08109 12.7492L10.4543 18.7362C10.6465 18.9167 10.7425 19.0069 10.852 19.0412C10.9492 19.0716 11.0534 19.0716 11.1507 19.0412C11.2601 19.0069 11.3561 18.9167 11.5483 18.7362L17.9215 12.7492C19.7147 11.0647 19.9324 8.29271 18.4243 6.34889L18.1407 5.98339C16.3366 3.65802 12.7151 4.048 11.4474 6.70417C11.2683 7.07937 10.7343 7.07937 10.5552 6.70417C9.28748 4.048 5.66605 3.65802 3.86189 5.98339L3.57831 6.34888C2.07017 8.29271 2.28793 11.0647 4.08109 12.7492Z" stroke=""/></svg></a></div>
					</div>
				  <div class="card-body">
					<h6>Banasari Saree Blue soft Silk</h6>
					<h6 class="price-off text-danger">37% OFF<h6>
					
					<div class="row">
						<div class="col-6">
							<h6 class="old-price">₹1229</h6>
							<h5 class="new-price">₹749/-</h5>
						</div>
						<div class="col-6">
							<div class="btn-by-now">
								<a href="#" class="btn btn-default w-100">Buy Now</a>
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

	<!--Trending Section -->
	<section class="trending-section mb-5">
		<div class="container" style="max-width:1225px;">
			<h4>Bought Together</h4>
			<div class="slider slider-trending">
				<!--Block-->
				<div class="card">
					<div class="card-img zoom-img">
						<img src="assets/images/featured-img-5.png" class="card-img-top" alt="..." />
						<div class="favorite"><a href="javascript:void(0);"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.08109 12.7492L10.4543 18.7362C10.6465 18.9167 10.7425 19.0069 10.852 19.0412C10.9492 19.0716 11.0534 19.0716 11.1507 19.0412C11.2601 19.0069 11.3561 18.9167 11.5483 18.7362L17.9215 12.7492C19.7147 11.0647 19.9324 8.29271 18.4243 6.34889L18.1407 5.98339C16.3366 3.65802 12.7151 4.048 11.4474 6.70417C11.2683 7.07937 10.7343 7.07937 10.5552 6.70417C9.28748 4.048 5.66605 3.65802 3.86189 5.98339L3.57831 6.34888C2.07017 8.29271 2.28793 11.0647 4.08109 12.7492Z" stroke=""/></svg></a></div>
					</div>
				  <div class="card-body">
					<h6>Banasari Saree Blue soft Silk</h6>
					<h6 class="price-off text-danger">37% OFF<h6>
					
					<div class="row">
						<div class="col-6">
							<h6 class="old-price">₹1229</h6>
							<h5 class="new-price">₹749/-</h5>
						</div>
						<div class="col-6">
							<div class="btn-by-now">
								<a href="#" class="btn btn-default w-100">Buy Now</a>
							</div>
						</div>
					</div>
				  </div>
				</div>
				<!--/*Block-->

				

				<!--Block-->
				<div class="card">
					<div class="card-img zoom-img">
						<img src="assets/images/featured-img-3.png" class="card-img-top" alt="..." />
						<div class="favorite"><a href="javascript:void(0);"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.08109 12.7492L10.4543 18.7362C10.6465 18.9167 10.7425 19.0069 10.852 19.0412C10.9492 19.0716 11.0534 19.0716 11.1507 19.0412C11.2601 19.0069 11.3561 18.9167 11.5483 18.7362L17.9215 12.7492C19.7147 11.0647 19.9324 8.29271 18.4243 6.34889L18.1407 5.98339C16.3366 3.65802 12.7151 4.048 11.4474 6.70417C11.2683 7.07937 10.7343 7.07937 10.5552 6.70417C9.28748 4.048 5.66605 3.65802 3.86189 5.98339L3.57831 6.34888C2.07017 8.29271 2.28793 11.0647 4.08109 12.7492Z" stroke=""/></svg></a></div>
					</div>
				  <div class="card-body">
					<h6>Banasari Saree Blue soft Silk</h6>
					<h6 class="price-off text-danger">37% OFF<h6>
					
					<div class="row">
						<div class="col-6">
							<h6 class="old-price">₹1229</h6>
							<h5 class="new-price">₹749/-</h5>
						</div>
						<div class="col-6">
							<div class="btn-by-now">
								<a href="#" class="btn btn-default w-100">Buy Now</a>
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


<!-- Slider Modal -->
<div class="modal fade" id="sliderModal" tabindex="-1" aria-labelledby="sliderModal" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
	  <div class="modal-content">
		<div class="modal-header border-0 pb-0">
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
			<div class="text-center">
				<iframe width="100%" height="500" src="https://www.youtube.com/embed/GhRNksWxUSk?autoplay=1&mute=1">
				</iframe>
			</div>
		</div>
	  </div>
	</div>
</div>
<!--/*Slider Modal -->

<!-- Slider Return Policy Modal -->
<div class="modal fade" id="policyModal" tabindex="-1" aria-labelledby="policyModal" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
	  <div class="modal-content">
		<div class="modal-header border-0 pb-0">
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body pt-0 return-policy faq">
			<!--Start: Return Policy Section -->
				<div class="container">
					<div class="header-wrap m-0">
						<h5><span>Return Policy</span></h5>
						<p>(15 days product return policy)</p>
					</div>
					
					<div class="wrap">
						<h6>Lorem ipsum</h6>
						<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.</p>
						<p>Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus.</p>
					</div>
					<div class="wrap">
						<h6>Lorem ipsum dolor sit amet</h6>
						<ul>
							<li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</li>
							<li>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</li>
							<li>Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.</li>
							<li>Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus.</li>
						</ul>
						<p>Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus.</p>
					</div>
					<div class="wrap">
						<h6>Lorem ipsum</h6>
						<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.</p>
						<p>Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus.</p>
						<p>In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo.</p>
					</div>
				</div>
			<!--End: Return Policy Section -->
		</div>
	  </div>
	</div>
</div>
<!--/*Slider Return Policy Modal -->

<!-- Slider Add Reviews Modal -->
<div class="modal fade" id="reviewsModal" tabindex="-1" aria-labelledby="reviewsModal" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
	  <div class="modal-content">
		<div class="modal-header border-0 pb-0">
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body pt-0 submit-comment product-details-page1">
			<!--Start: Submit Comment Section -->
			<section>
				<div class="container" style="max-width:1344px;">
					<h5 class="mb-3">Share Your Experience</h5>
					<div class="row">
						
						<div class="col-xl-12">
							<div class="become-seller box-shadow">
								<form class="form row g-3">
									<div class="col-md-12">
										<label class="form-label">Rate this product</label>
									</div>
									<div class="col-md-12 mt-0">
										<div id="half-stars-example">
										  <div class="rating-group">
											<input class="rating-input rating-input-none" checked name="rating2" id="rating2-0" value="0" type="radio">
											
											<label aria-label="0.5 stars" class="rating-label rating-label-half" for="rating2-05"><i class="rating-icon rating-icon-star fa fa-star-half"></i></label>
											<input class="rating-input" name="rating2" id="rating2-05" value="0.5" type="radio">
											<label aria-label="1 star" class="rating-label" for="rating2-10"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
											<input class="rating-input" name="rating2" id="rating2-10" value="1" type="radio">
											<label aria-label="1.5 stars" class="rating-label rating-label-half" for="rating2-15"><i class="rating-icon rating-icon-star fa fa-star-half"></i></label>
											<input class="rating-input" name="rating2" id="rating2-15" value="1.5" type="radio">
											<label aria-label="2 stars" class="rating-label" for="rating2-20"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
											<input class="rating-input" name="rating2" id="rating2-20" value="2" type="radio">
											<label aria-label="2.5 stars" class="rating-label rating-label-half" for="rating2-25"><i class="rating-icon rating-icon-star fa fa-star-half"></i></label>
											<input class="rating-input" name="rating2" id="rating2-25" value="2.5" type="radio">
											<label aria-label="3 stars" class="rating-label" for="rating2-30"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
											<input class="rating-input" name="rating2" id="rating2-30" value="3" type="radio">
											<label aria-label="3.5 stars" class="rating-label rating-label-half" for="rating2-35"><i class="rating-icon rating-icon-star fa fa-star-half"></i></label>
											<input class="rating-input" name="rating2" id="rating2-35" value="3.5" type="radio">
											<label aria-label="4 stars" class="rating-label" for="rating2-40"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
											<input class="rating-input" name="rating2" id="rating2-40" value="4" type="radio">
											<label aria-label="4.5 stars" class="rating-label rating-label-half" for="rating2-45"><i class="rating-icon rating-icon-star fa fa-star-half"></i></label>
											<input class="rating-input" name="rating2" id="rating2-45" value="4.5" type="radio">
											<label aria-label="5 stars" class="rating-label" for="rating2-50"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
											<input class="rating-input" name="rating2" id="rating2-50" value="5" type="radio">
										  </div>
										</div>
									</div>
									<div class="col-md-12">
										<label class="form-label">Comment</label>
										<textarea class="form-control" rows="5" placeholder="Comments here..."></textarea>
									</div>
									<div class="col-md-12">
										<label class="form-label">Title (optional)</label>
										<input type="text" class="form-control" placeholder="Title" />
									</div>
									<div class="col-md-6">
										<label class="form-label">Name:</label>
										<input type="text" class="form-control" placeholder="Name" />
									</div>
									<div class="col-md-6">
										<label class="form-label">Email Id:</label>
										<input type="email" class="form-control" placeholder="Email Id:" />
									</div>
								
									<a href="javascript:void(0);" class="btn btn-default">Submit</a>
								</form>
								
							</div>
						</div>
						
					</div>
					
				</div>
			</section>
			<!--End: Submit Comment Section -->
		</div>
	  </div>
	</div>
</div>
<!--/*Slider Add Reviews Modal -->

<div class="btn-wrap btn-mb" id="btn-mb">
	<a href="#" class="btn btn-secondary"><svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.1263 32.0833C13.9317 32.0833 14.5846 31.4304 14.5846 30.625C14.5846 29.8196 13.9317 29.1667 13.1263 29.1667C12.3209 29.1667 11.668 29.8196 11.668 30.625C11.668 31.4304 12.3209 32.0833 13.1263 32.0833Z" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M29.1654 32.0833C29.9708 32.0833 30.6237 31.4304 30.6237 30.625C30.6237 29.8196 29.9708 29.1667 29.1654 29.1667C28.3599 29.1667 27.707 29.8196 27.707 30.625C27.707 31.4304 28.3599 32.0833 29.1654 32.0833Z" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M1.45703 1.45833H7.29036L11.1987 20.9854C11.3321 21.6568 11.6973 22.2599 12.2305 22.6892C12.7638 23.1184 13.431 23.3464 14.1154 23.3333H28.2904C28.9748 23.3464 29.642 23.1184 30.1752 22.6892C30.7084 22.2599 31.0737 21.6568 31.207 20.9854L33.5404 8.75H8.7487" stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Add to Cart</a>
	<a href="#" class="btn btn-default"><svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.1234 28.9947C17.1234 28.9947 17.124 28.9938 17.1253 28.9921C17.124 28.9939 17.1234 28.9947 17.1234 28.9947ZM18.5242 29.3032C18.5242 29.3033 18.524 29.3023 18.5236 29.3003C18.524 29.3022 18.5242 29.3032 18.5242 29.3032ZM16.4732 5.69675C16.4732 5.69673 16.4734 5.69768 16.4738 5.69969C16.4734 5.69779 16.4732 5.69678 16.4732 5.69675ZM17.874 6.00529C17.874 6.00532 17.8734 6.00615 17.8722 6.00769C17.8734 6.00603 17.874 6.00526 17.874 6.00529ZM10.0867 20.2019L10.9262 19.6655L10.0867 20.2019C10.4662 20.7958 11.0721 20.9828 11.5688 21.0565C12.032 21.1252 12.6233 21.1251 13.2672 21.125C13.2904 21.125 13.3136 21.125 13.3369 21.125H16.4987V28.3549L16.4987 28.408C16.4986 28.8071 16.4986 29.1867 16.529 29.4692C16.5443 29.6119 16.5756 29.8257 16.6685 30.0336C16.7715 30.264 17.0114 30.6075 17.4798 30.7107C17.9482 30.8138 18.3103 30.6029 18.5005 30.4371C18.6722 30.2875 18.7904 30.1066 18.8643 29.9836C19.0105 29.74 19.17 29.3955 19.3376 29.0332L19.3599 28.9851L24.3829 18.1354C24.3927 18.1142 24.4025 18.0931 24.4122 18.0721C24.6828 17.4878 24.9313 16.9512 25.0635 16.5021C25.2054 16.0204 25.2902 15.392 24.9107 14.7981C24.5312 14.2042 23.9253 14.0172 23.4286 13.9435C22.9655 13.8748 22.3742 13.8749 21.7302 13.875C21.707 13.875 21.6838 13.875 21.6605 13.875H18.4987V6.64513C18.4987 6.62739 18.4987 6.60969 18.4987 6.59202C18.4988 6.19289 18.4988 5.8133 18.4684 5.5308C18.4531 5.38807 18.4218 5.1743 18.3289 4.96638C18.2259 4.73598 17.986 4.39249 17.5176 4.28932C17.0492 4.18616 16.6871 4.39706 16.4969 4.56288C16.3252 4.71252 16.207 4.89337 16.1331 5.01644C15.9869 5.26004 15.8274 5.60453 15.6598 5.96676C15.6524 5.98279 15.6449 5.99885 15.6375 6.01494L10.6145 16.8646C10.6047 16.8858 10.5949 16.9069 10.5852 16.9279C10.3146 17.5122 10.0661 18.0488 9.93386 18.4979C9.79204 18.9796 9.70715 19.608 10.0867 20.2019Z" stroke="" stroke-width="2"/></svg> Buy Now</a>
</div>

</main>

 <?php
    include("includes/footer.php")
    ?>

    <?php
    include("includes/script.php")
    ?>
	
	
<script type="text/javascript">
    const spL = document.getElementById("spotlight");
    if (spL) {
        const copyLink = document.querySelector(".spl-autofit");
        const url = window.location.href;

        if (copyLink) {

            copyLink.addEventListener("click", () => {
                navigator.clipboard.writeText(url);
                alert("URL Copied");
            })
        } else {
            console.log("not")
        }
    } else {
        console.log("not fnd")
    }
</script>


<script type="text/javascript">
    $(".slider-single").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        adaptiveHeight: true,
        infinite: true,
        useTransform: true,
        speed: 400,
        cssEase: "cubic-bezier(0.77, 0, 0.18, 1)",
		responsive: [{
                    breakpoint: 767,
                    settings: {
						dots: true,
                    },
                },
            ],
    });

    $(".slider-nav")
        .on("init", function(event, slick) {
            $(".slider-nav .slick-slide.slick-current").addClass("is-active");
        })
        .slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            dots: false,
            focusOnSelect: true,
			arrows: true,
            infinite: false,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 640,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                    },
                },
                {
                    breakpoint: 420,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                    },
                },
            ],
        });


    $(".slider-single").on("afterChange", function(event, slick, currentSlide) {
        $(".slider-nav").slick("slickGoTo", currentSlide);
        var currrentNavSlideElem =
            '.slider-nav .slick-slide[data-slick-index="' + currentSlide + '"]';
        $(".slider-nav .slick-slide.is-active").removeClass("is-active");
        $(currrentNavSlideElem).addClass("is-active");
    });

    $(".slider-nav").on("click", ".slick-slide", function(event) {
        event.preventDefault();
        var goToSingleSlide = $(this).data("slick-index");

        $(".slider-single").slick("slickGoTo", goToSingleSlide);
    });
</script>

<script type="text/javascript">
	$('.slider-trending').slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		arrows: true,
		infinite: false,
		autoplay: false,
		responsive: [
			{
			breakpoint: 1199,
			settings: {
				slidesToShow: 4,
				slidesToScroll: 1
			}
			},
			{
			breakpoint: 991,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 1
			}
			},
			{
			breakpoint: 767,
			settings: {
				slidesToShow: 3,
				slidesToScroll: 1
			}
			},
			{
			breakpoint: 575,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 1
			}
			}
			// You can unslick at a given breakpoint now by adding:
			// settings: "unslick"
			// instead of a settings object
		]
	});
</script>
	
</body>
	
</html>
