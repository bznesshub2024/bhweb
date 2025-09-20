<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "Wishlist";
    include("includes/headTag.php") ?>
</head>

<body>

	<?php
        include("includes/topbar.php")
        ?>
        <?php
        include("includes/navbar.php")
        ?>
	
<main class="wishlist-page my-order-page cart-page">
	
	<!--Start: Wishlist Section -->
	<section>
		<div class="container" style="max-width:1344px;">
			<div class="row">
				<div class="col-lg-4 d-none d-lg-block">
					<div class="right-block p-0">
						<div class="wrap box-shadow">
							<div class="wrap-block align-items-center">
								<img src="assets/images/icons/avtar.png" class="" />
								<div class="wrap-details">
									<h6>Hello,</h6>
									<h5>Sachin Singh</h5>
								</div>
							</div>
						</div>
						<div class="wrap box-shadow">
							<div class="wrap-block">
								<img src="assets/images/icons/order.png" class="" />
								<div class="wrap-details">
									<h5>My Orders</h5>
								</div>
							</div>
							<hr/>
							<div class="wrap-block">
								<img src="assets/images/icons/account.png" class="" />
								<div class="wrap-details">
									<h5>Account Settings</h5>
									<h6><a href="javascript:void(0);"><h6>Personal Information</a></h6>
									<h6><a href="javascript:void(0);">Manage Addresses</a></h6>
								</div>
							</div>
							<hr/>
							<div class="wrap-block">
								<img src="assets/images/icons/credit-card.png" class="" />
								<div class="wrap-details">
									<h5>Payments</h5>
									<h6><a href="javascript:void(0);"><h6>Gift Cards</a></h6>
								</div>
							</div>
							<hr/>
							<div class="wrap-block">
								<img src="assets/images/icons/stuff.png" class="" />
								<div class="wrap-details">
									<h5>My Stuff</h5>
									<h6><a href="javascript:void(0);"><h6>My Coupons</a></h6>
									<h6><a href="javascript:void(0);">My Reviews & Ratings</a></h6>
									<h6><a href="javascript:void(0);"><h6>All Notifications</a></h6>
									<h6><a href="javascript:void(0);"><h6>My Wishlist</a></h6>
									<h6><a href="javascript:void(0);"><h6>My Orders</a></h6>
								</div>
							</div>
							<hr/>
							<div class="wrap-block">
								<img src="assets/images/icons/logout.png" class="" />
								<div class="wrap-details">
									<h5><a href="javascript:void(0);"><h5>Logout</a></h5>
								</div>
							</div>
						</div>

						<div class="wrap box-shadow">
							<h6><a href="javascript:void(0);"><h6>Track Order</a></h6>
							<h6><a href="javascript:void(0);"><h6>Help Center</a></h6>
						</div>

					</div>
				</div>
				<div class="col-lg-8">
					<div class="left-block box-shadow" id="MyProfile">
						<h5 class="title">My Cart (3) <span class="d-lg-none"><a class="accordion-button collapsed" id="heading1" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">My Profile</a></span></h5>

						<div id="MyProfile" class="d-lg-none">
							
						  <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1" data-bs-parent="#MyProfile">
							
							<div class="right-block">
								<div class="wrap box-shadow">
									<div class="wrap-block align-items-center">
										<img src="assets/images/icons/avtar.png" class="" />
										<div class="wrap-details">
											<h6>Hello,</h6>
											<h5>Sachin Singh</h5>
										</div>
									</div>
								</div>
								<div class="wrap box-shadow">
									<div class="wrap-block">
										<img src="assets/images/icons/order.png" class="" />
										<div class="wrap-details">
											<h5>My Orders</h5>
										</div>
									</div>
									<hr/>
									<div class="wrap-block">
										<img src="assets/images/icons/account.png" class="" />
										<div class="wrap-details">
											<h5>Account Settings</h5>
											<h6><a href="javascript:void(0);"><h6>Personal Information</a></h6>
											<h6><a href="javascript:void(0);">Manage Addresses</a></h6>
										</div>
									</div>
									<hr/>
									<div class="wrap-block">
										<img src="assets/images/icons/credit-card.png" class="" />
										<div class="wrap-details">
											<h5>Payments</h5>
											<h6><a href="javascript:void(0);"><h6>Gift Cards</a></h6>
										</div>
									</div>
									<hr/>
									<div class="wrap-block">
										<img src="assets/images/icons/stuff.png" class="" />
										<div class="wrap-details">
											<h5>My Stuff</h5>
											<h6><a href="javascript:void(0);"><h6>My Coupons</a></h6>
											<h6><a href="javascript:void(0);">My Reviews & Ratings</a></h6>
											<h6><a href="javascript:void(0);"><h6>All Notifications</a></h6>
											<h6><a href="javascript:void(0);"><h6>My Wishlist</a></h6>
											<h6><a href="javascript:void(0);"><h6>My Orders</a></h6>
										</div>
									</div>
									<hr/>
									<div class="wrap-block">
										<img src="assets/images/icons/logout.png" class="" />
										<div class="wrap-details">
											<h5><a href="javascript:void(0);"><h5>Logout</a></h5>
										</div>
									</div>
								</div>
		
								<div class="wrap box-shadow">
									<h6><a href="javascript:void(0);"><h6>Track Order</a></h6>
									<h6><a href="javascript:void(0);"><h6>Help Center</a></h6>
								</div>
							</div>
							
						  </div>							
						</div>

						<div class="cart-details">
							<img src="assets/images/product-thumb.png" class="product-thumb" />
							<div class="cart-body">
								<h6>Banarasi Saree Pure Silk Purple</h6>
								<div class="row">
									<div class="col-md-6">
										<div class="rate">
											<div class="rating">5.0 <img src="assets/images/icons/star.png" /></div>
											<div class="rating-details">Excellent</div>
										</div>
										<div class="wrap-details">
											<div class="rate">
												<h5>₹749</h5>
												<div class="old-price">₹1749</div>
												<div class="off-price">60% off</div>
											</div>
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
											
										</div>
									</div>
								</div>
							</div>
							<div class="favorite active"><a href="javascript:void(0);"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.08109 12.7492L10.4543 18.7362C10.6465 18.9167 10.7425 19.0069 10.852 19.0412C10.9492 19.0716 11.0534 19.0716 11.1507 19.0412C11.2601 19.0069 11.3561 18.9167 11.5483 18.7362L17.9215 12.7492C19.7147 11.0647 19.9324 8.29271 18.4243 6.34889L18.1407 5.98339C16.3366 3.65802 12.7151 4.048 11.4474 6.70417C11.2683 7.07937 10.7343 7.07937 10.5552 6.70417C9.28748 4.048 5.66605 3.65802 3.86189 5.98339L3.57831 6.34888C2.07017 8.29271 2.28793 11.0647 4.08109 12.7492Z" stroke=""/></svg></a></div>
						</div>

						<div class="cart-details">
							<img src="assets/images/product-thumb.png" class="product-thumb" />
							<div class="cart-body">
								<h6>Banarasi Saree Pure Silk Purple</h6>
								<div class="row">
									<div class="col-md-6">
										<div class="rate">
											<div class="rating">4.1 <img src="assets/images/icons/star.png" /></div>
											<div class="rating-details">Good</div>
										</div>
										<div class="wrap-details">
											<div class="rate">
												<h5>₹749</h5>
												<div class="old-price">₹1749</div>
												<div class="off-price">60% off</div>
											</div>
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
											
										</div>
									</div>
								</div>
							</div>
							<div class="favorite active"><a href="javascript:void(0);"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.08109 12.7492L10.4543 18.7362C10.6465 18.9167 10.7425 19.0069 10.852 19.0412C10.9492 19.0716 11.0534 19.0716 11.1507 19.0412C11.2601 19.0069 11.3561 18.9167 11.5483 18.7362L17.9215 12.7492C19.7147 11.0647 19.9324 8.29271 18.4243 6.34889L18.1407 5.98339C16.3366 3.65802 12.7151 4.048 11.4474 6.70417C11.2683 7.07937 10.7343 7.07937 10.5552 6.70417C9.28748 4.048 5.66605 3.65802 3.86189 5.98339L3.57831 6.34888C2.07017 8.29271 2.28793 11.0647 4.08109 12.7492Z" stroke=""/></svg></a></div>
						</div>

						<div class="cart-details">
							<img src="assets/images/product-thumb.png" class="product-thumb" />
							<div class="cart-body">
								<h6>Banarasi Saree Pure Silk Purple</h6>
								<div class="row">
									<div class="col-md-6">
										<div class="rate">
											<div class="rating bg-fern-frond">3.0 <img src="assets/images/icons/star.png" /></div>
											<div class="rating-details">Fine</div>
										</div>
										<div class="wrap-details">
											<div class="rate">
												<h5>₹749</h5>
												<div class="old-price">₹1749</div>
												<div class="off-price">60% off</div>
											</div>
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
											
										</div>
									</div>
								</div>
							</div>
							<div class="favorite active"><a href="javascript:void(0);"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.08109 12.7492L10.4543 18.7362C10.6465 18.9167 10.7425 19.0069 10.852 19.0412C10.9492 19.0716 11.0534 19.0716 11.1507 19.0412C11.2601 19.0069 11.3561 18.9167 11.5483 18.7362L17.9215 12.7492C19.7147 11.0647 19.9324 8.29271 18.4243 6.34889L18.1407 5.98339C16.3366 3.65802 12.7151 4.048 11.4474 6.70417C11.2683 7.07937 10.7343 7.07937 10.5552 6.70417C9.28748 4.048 5.66605 3.65802 3.86189 5.98339L3.57831 6.34888C2.07017 8.29271 2.28793 11.0647 4.08109 12.7492Z" stroke=""/></svg></a></div>
						</div>

					</div>
				</div>

			</div>
		</div>
	</section>
	<!--End: Wishlist Section -->

</main>

 <?php
    include("includes/footer.php")
    ?>

    <?php
    include("includes/script.php")
    ?>
	
</body>
	
</html>
