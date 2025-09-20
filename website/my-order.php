<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "My Orders";
    include("includes/headTag.php") ?>
</head>

<body>

	<?php
        include("includes/topbar.php")
        ?>
        <?php
        include("includes/navbar.php")
        ?>
	
<main class="my-order-page cart-page">
	
	<!--Start: My Orders Section -->
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
						
						<div class="collapse" id="MyProfile">
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

						<div class="cart-details">
							<img src="assets/images/product-thumb.png" class="product-thumb" />
							<div class="cart-body">
								<h6>Banarasi Saree Pure Silk Purple</h6>
								<div class="row">
									<div class="col-md-7 col-sm-6">
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
											<div class="qty">Qty: 01</div>
											<div class="order-id"><span>Order ID:</span> xxxxxxxxxxxx</div>
										</div>
									</div>
									<div class="col-md-5 col-sm-6">
										<div class="order-id"><span>Order Date:</span> 02-Mar-2023</div>
										<div class="order-id"><span>Order Status:</span> Dispatch</div>
										<h6 class="track-order"><a href="track-order.php">Track Order</a></h6>
									</div>
								</div>
							</div>
						</div>

						<div class="cart-details">
							<img src="assets/images/product-thumb.png" class="product-thumb" />
							<div class="cart-body">
								<h6>Banarasi Saree Pure Silk Purple</h6>
								<div class="row">
									<div class="col-md-7 col-sm-6">
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
											<div class="qty">Qty: 01</div>
											<div class="order-id"><span>Order ID:</span> xxxxxxxxxxxx</div>
										</div>
									</div>
									<div class="col-md-5 col-sm-6">
										<div class="order-id"><span>Order Date:</span> 02-Mar-2023</div>
										<div class="order-id"><span>Order Status:</span> Dispatch</div>
										<h6 class="track-order"><a href="track-order.php">Track Order</a></h6>
									</div>
								</div>
							</div>
						</div>

						<div class="cart-details">
							<img src="assets/images/product-thumb.png" class="product-thumb" />
							<div class="cart-body">
								<h6>Banarasi Saree Pure Silk Purple</h6>
								<div class="row">
									<div class="col-md-7 col-sm-6">
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
											<div class="qty">Qty: 01</div>
											<div class="order-id"><span>Order ID:</span> xxxxxxxxxxxx</div>
										</div>
									</div>
									<div class="col-md-5 col-sm-6">
										<div class="order-id"><span>Order Date:</span> 02-Mar-2023</div>
										<div class="order-id"><span>Order Status:</span> Dispatch</div>
										<h6 class="track-order"><a href="track-order.php">Track Order</a></h6>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>

			</div>
		</div>
	</section>
	<!--End: My Orders Section -->

</main>

 <?php
    include("includes/footer.php")
    ?>

    <?php
    include("includes/script.php")
    ?>
	
</body>
	
</html>
