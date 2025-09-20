<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "Manage New Address";
    include("includes/headTag.php") ?>
</head>

<body>

	<?php
        include("includes/topbar.php")
        ?>
        <?php
        include("includes/navbar.php")
        ?>
	
<main class="new-address my-order-page cart-page">
	
	<!--Start: Manage New Address Section -->
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
						<h5 class="title">Add New Address <span class="d-lg-none"><a class="accordion-button collapsed" id="heading1" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">My Profile</a></span></h5>

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

						<form class="form row g-3">
							<div class="col-md-7">
								<label class="form-label">Title</label>
								<input type="text" class="form-control" placeholder="Office" />
							</div>
							<div class="col-md-7">
								<label class="form-label">Name</label>
								<input type="text" class="form-control" placeholder="Name" />
							</div>
							<div class="col-md-7">
								<label class="form-label">Email</label>
								<input type="email" class="form-control" placeholder="Email" />
							</div>
							<div class="col-md-5">
							  <label class="form-label">Phone no</label>
							  <input type="text" class="form-control" placeholder="Phone no" />
							</div>
							<div class="col-md-12">
								<label class="form-label">Address 1</label>
								<input type="text" class="form-control" placeholder="Address 1" />
							</div>
							<div class="col-md-12">
								<label class="form-label">Address 2</label>
								<input type="text" class="form-control" placeholder="Address 2" />
							</div>
							<div class="col-md-7">
								<label class="form-label">Street</label>
								<input type="text" class="form-control" placeholder="Street" />
							</div>
							<div class="col-md-5">
							  <label class="form-label">Pin Code</label>
							  <input type="text" class="form-control" placeholder="Pin Code" />
							</div>
							<div class="col-md-6">
								<label class="form-label">City</label>
								<input type="text" class="form-control" placeholder="City" />
							</div>
							<div class="col-md-6">
								<label class="form-label">State</label>
								<input type="text" class="form-control" placeholder="State" />
							</div>
							<div class="col-md-12 text-center">
							  <button type="submit" class="btn btn-default">SAVE</button>
							</div>
						</form>

					</div>
				</div>

			</div>
		</div>
	</section>
	<!--End: Manage New Address Section -->

</main>

 <?php
    include("includes/footer.php")
    ?>

    <?php
    include("includes/script.php")
    ?>
	
</body>
	
</html>
