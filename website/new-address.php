<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "Add New Address";
    include("includes/headTag.php") ?>
</head>

<body>

	<?php
        include("includes/topbar.php")
        ?>
        <?php
        include("includes/navbar.php")
        ?>
	
<main class="cart-page checkout-page new-address">
	
	<!--Start: New Address Page -->
	<section>
		<div class="container" style="max-width:1344px;">
			<div class="row">
				<div class="col-lg-8">
					<div class="left-block box-shadow">
						<h5>Add New Address</h5>
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
				<div class="col-lg-4">
					<div class="right-block box-shadow">
						<div class="price-details">
							<h5>Order Summar</h5>
							<ul class="price">
								<li><h6>Cart Value (3 items)</h6></li>
								<li><h6>₹5247</h6></li>
							</ul>
							<ul class="discount">
								<li><h6>Discount</h6></li>
								<li><h6>-₹1500</h6></li>
							</ul>
							<ul class="tax">
								<li><h6>Tax</h6></li>
								<li><h6>+80.00</h6></li>
							</ul>
							<ul class="discount">
								<li><h6>Delivery Charges</h6></li>
								<li><h6>FREE</h6></li>
							</ul>
							<form>
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Discount Code" />
									<span class="input-group-text btn btn-default">Apply</span>
								</div>
							</form>
						</div>
						<ul class="total">
							<li><h5>Total Amount</h5></li>
							<li><h5>₹5327</h5></li>
						</ul>
						<h5 class="save d-none">You will save ₹1,500 on this order</h5>
						<ul class="proceed d-none">
							<li>
								<h6>Total</h6>
								<h5 class="tax">₹2538.00</h5>
							</li>
							<li><a href="javascript:void(0);" class="btn btn-default">Proceed</a></li>
						</ul>
						<div class="continue">
							<h6>You will save ₹1,500 on this order</h6>
							<a href="javascript:void(0);" class="btn btn-default">Continue</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--End: New Address Page -->

</main>

 <?php
    include("includes/footer.php")
    ?>

    <?php
    include("includes/script.php")
    ?>
	
</body>
	
</html>
