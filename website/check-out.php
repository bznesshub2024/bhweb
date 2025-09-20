<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "Check Out";
    include("includes/headTag.php") ?>
</head>

<body>

	<?php
        include("includes/topbar.php")
        ?>
        <?php
        include("includes/navbar.php")
        ?>
	
<main class="cart-page checkout-page">
	
	<!--Start: Check-Out Page -->
	<section>
		<div class="container" style="max-width:1344px;">
			<div class="row">
				<div class="col-lg-8">
					<div class="left-block box-shadow">
						<h5>Delivery Addresses</h5>
						<div class="align-items-start">
							<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
							  <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">
								<div class="form-check address-details box-shadow">
									<input class="form-check-input" type="radio" name="address" />
									<label class="form-check-label">
										<span class="badge">Home</span>
										<ul class="name">
											<li><h6>7248527632</h6></li>
											<li><h6>Sachin Singh </h6></li>
										</ul>
										<div class="address">
											<h6>St. 05, Rani Garden, Delhi, 37564 </h6>
										</div>
										<a href="javascript:void(0);" class="btn btn-default d-none">Deliver here</a>
									</label>
								</div>
							  </button>
							  <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">
								<div class="form-check address-details box-shadow">
									<input class="form-check-input" type="radio" name="address" />
									<label class="form-check-label">
										<span class="badge">Office</span>
										<ul class="name">
											<li><h6>7248527632</h6></li>
											<li><h6>Sachin Singh </h6></li>
										</ul>
										<div class="address">
											<h6>St. 05, Rani Garden, Delhi, 37564 </h6>
										</div>
										<a href="javascript:void(0);" class="btn btn-default d-none">Deliver here</a>
									</label>
								</div>
							  </button>
							  <a href="new-address.php" class="btn btn-light">Add new Shipping Address</a>
							</div>
						  </div>
						
						
						<div class="payment-option">
							<h5>Payment Options</h5>
							<form>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="payment" checked />
									<label class="form-check-label">Cash On Delivery (Cash/UPI)</label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="payment" />
									<label class="form-check-label">Credit/Debit Card <img src="assets/images/icons/credit-card.png" class="" alt="" /></label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="radio" name="payment" />
									<label class="form-check-label">UPI (GPay/PhonePe) <img src="assets/images/icons/upi-img.png" class="" alt="" /></label>
								</div>
							</form>
						</div>
						<div class="easy-return">
							<h5>Easy Return & Exchange Available*</h5>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="right-block box-shadow">
						<div class="price-details">
							<h5>Order Summar</h5>
							<ul class="price">
								<li><h6>Cart Value (3 items)</h6></li>
								<li><h6>₹3498</h6></li>
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
							<li><h5>₹3498</h5></li>
						</ul>
						<div class="continue">
							<h6>You will save ₹1,500 on this order</h6>
							<a href="javascript:void(0);" class="btn btn-default">Place Order</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--End: Check-Out Page -->

</main>

 <?php
    include("includes/footer.php")
    ?>

    <?php
    include("includes/script.php")
    ?>
	
</body>
	
</html>
