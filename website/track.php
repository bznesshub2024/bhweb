<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "Track Order";
    include("includes/headTag.php") ?>
</head>

<body>

	<?php
        include("includes/topbar.php")
        ?>
        <?php
        include("includes/navbar.php")
        ?>
	
<main class="notification-page my-order-page cart-page">
	
	<!--Start: Notifications Section -->
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
						<h5 class="title">All Notifications <span class="d-lg-none"><a class="accordion-button collapsed" id="heading1" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">My Profile</a></span> <a href="javascript:void(0);" class="clear-all d-none d-lg-block">Clear All</a></h5>
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

						<div class="mt-5">
							<form class="form row g-3">
								<div class="col-md-12">
									<label class="form-label">Order Id</label>
									<input type="text" class="form-control" placeholder="Order Id" />
								</div>
								<div class="col-md-12 text-center">
									<a href="track-order.php" class="btn btn-default">Track</a>
								</div>
							</form>
						</div>

					</div>
				</div>

			</div>
		</div>
	</section>
	<!--End: Notifications Section -->

</main>

 <?php
    include("includes/footer.php")
    ?>

    <?php
    include("includes/script.php")
    ?>
	
</body>
	
</html>
