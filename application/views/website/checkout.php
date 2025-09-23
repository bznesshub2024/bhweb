<!DOCTYPE html>
<html lang="en">

<head>
	<?php $title = "CheckOut";
	include("include/headTag.php") ?>
</head>
<style>
	.cart-page .left-block {
		min-height: auto !important;
	}

	.checkout-page .left-block .nav-pills .nav-link.active .form-check-input {
		background-image: none;
	}

	.form-check-input:active,
	.form-check-input:checked {
		background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23F42525'/%3e%3c/svg%3e") !important;
	}

	input#captcha_test {
		height: 35px;
		width: 270px;
		padding: 12px;
	}
	
	.default_address_checker{
		margin: 5px 14px !important;
	}	
	
</style>

<body class="checkout-body">

	<?php
	include("include/loader.php")
	?>
	<?php
	include("include/topbar.php")
	?>
	<?php
	include("include/navbar.php")
	?>
	<?php
	//include("include/navForMobile.php")
	//print_r($checkout['default_discount']);

	if ($checkout['total_item'] == 0) {
		redirect('', 'refresh');
	}
	?>
	<main class="cart-page checkout-page mt-0">

		<!-- <?php echo print_r($data); ?> -->
		<!--Start: Check-Out Page -->

		<input type="hidden" value="<?php echo $checkout['total_price_value']; ?>" name="total_value" id="total_value">
		<input type="hidden" value="<?php echo $checkout['seller_pincode']; ?>" name="seller_pincode" id="seller_pincode">
		<input type="hidden" value="<?php echo $checkout['imgurl']; ?>" name="imgurl" id="imgurl">
		<div class="d-flex align-items-center h-100 responsive_nav d-block d-sm-none">
			<svg class="fa-angle-left ms-3" onclick="history.back(-1)" width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M15.5 19.5 8 12l7.5-7.5" stroke="#303030" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
			</svg>
			<h4 class="text-dark ms-2 mb-0 fw-bold">Checkout</h4>
		</div>
		<section class="mt-5">
			<div class="container" style="max-width:1344px;">


				<div class="row">
					<div class="col-lg-8">
						<div class="left-block box-shadow0">
							<h5>Delivery Addresses</h5>
							<div class="align-items-start">
								<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
									<?php
									if (!empty($address['address_details'])) {
										$address_count = 0;
										$last_element = array_pop($address['address_details']);
										array_unshift($address['address_details'], $last_element);
										foreach ($address['address_details'] as $add_data) {
											if ($address_count >= 5) break;
											else {
												/*if ($address['defaultaddress'] == $add_data['address_id']) { */
									?>

												<button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">
													<div class="form-check address-details box-shadow">
														<input class="form-check-input default_address_checker"  type="radio" name="DefaultAddress" id="defaultAdderess" value="<?php echo $add_data['address_id']; ?>">
														<label class="form-check-label">
															<span class="badge"><?php echo $add_data['addresstype']; ?></span><br>
															<ul class="name m-0 mb-1">
																<li class="pe-2">
																	<h6><?php echo $add_data['fullname']; ?>, </h6>
																</li>
																<li class="pe-2">
																	<h6><?= $add_data['email'] ?>, </h6>
																</li>
																<li class="pe-2">
																	<h6><?php echo $add_data['mobile']; ?></h6>
																</li>
															</ul>
															<div class="address m-0">
																<h6 class="m-0"><?php echo $add_data['fulladdress'] ?></h6>
																<h6 class="m-0"><?= $add_data['state_name'] . ', ' . $add_data['city'] . ', ' . $add_data['pincode']; ?></h6>
															</div>
															<a href="javascript:void(0);" class="btn btn-default d-none">Deliver here</a>
														</label>
													</div>
												</button>
									<?php
											}
											$address_count++;
										}
									}  ?>
									<!-- <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">
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
							  </button>-->
									<a href="" class="btn btn-light btn-radious" id="address_div_id">Add new shipping address</a>
								</div>
							</div>


							<div class="container" id="address_div" style="max-width:1344px;display:none">
								<div class="row">
									<div class="col-lg-12">
										<div class="left-block box-shadow">
											<h5>Add New Address</h5>
											<form id="formoid" action="" class="form row g-3" method="post">

												<div class="col-md-6">
													<label class="form-label">Full Name</label>
													<input type="text" class="form-control" id="fullname_a" name="name" placeholder="Full Name" />
													<span id="fullname1_error" style="color:red;"></span>

												</div>
												<div class="col-md-6">
													<label class="form-label">Email</label>
													<input type="email" class="form-control" id="email" maxlength="30" name="email" placeholder="Email" />
													<span id="emails_error" style="color:red;"></span>
												</div>
												<div class="col-md-6">
													<label class="form-label">Phone no</label>
													<input type="text" class="form-control" id="mobile" maxlength="10" onkeypress="return AllowOnlyNumbers(event);" name="mobile" placeholder="Phone no" />
													<span id="mobile_error" style="color:red;"></span>
												</div>
												<div class="col-md-6">
													<label class="form-label">Pin Code</label>
													<input type="text" class="form-control" id="pincode" name="pincode" maxlength="6" onkeypress="return AllowOnlyNumbers(event);" placeholder="Pin Code" />
													<span id="pincode_check" style="color:red;"></span>
												</div>


												<div class="col-md-12">
													<label class="form-label">Address</label>
													<input type="text" class="form-control" id="fulladdress" name="address" placeholder="Address 1" />
												</div>

												<div class="col-md-6">
													<label class="form-label">State</label>
													<select class="form-control" id="state" name="state">

														<option value="">Select State</option>

													</select>
													<span id="state_error" style="color:red;"></span>
												</div>

												<div class="col-md-6">
													<label class="form-label">City</label>
													<select name="city" id="city" class="form-control">

														<option>Select City</option>

														<?php foreach ($get_city as $city_data) { ?>

															<option <?php if ($this->session->userdata('city_id') == $city_data['city_id']) {
																		echo 'selected';
																	} ?> value="<?php echo $city_data['city_id']; ?>"><?php echo $city_data['city_name']; ?></option>

														<?php } ?>

													</select>
													<span id="city_error" style="color:red;"></span>
												</div>

												<input type="hidden" value="<?php echo $this->session->userdata('user_id'); ?>" type="user_id" id="user_id" name="user_id">
												<?php if (!empty($this->session->userdata("user_id"))) { ?>
													<!-- <div class="col-md-12 text-center">
														<button type="submit" id="submit" name="submit" class="btn btn-default">SAVE</button>
													</div> -->
													<!-- <button type="submit" id="address_save_btn" class="btn btn-default" style="display: block;">Add Address</button> -->
												<?php } ?>
											</form>
										</div>
									</div>

								</div> 
							</div>


							<div class="payment-option">
								<h5>Payment Options</h5>
								<form name="paymentOptions">

									<div class="form-check">
										<input class="form-check-input" type="radio" name="flexRadioDefault" id="netBanking" value="prepaid" checked />
										<label for="netBanking" class="form-check-label">Credit/Debit Card <img src="assets_web/images/icons/credit-card.png" class="" alt="<?php echo website_name; ?>" /></label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="flexRadioDefault" id="cardPayment" value="prepaid" />
										<label for="cardPayment" class="form-check-label">UPI (GPay/PhonePe) <img src="assets_web/images/icons/upi-img.png" class="" alt="<?php echo website_name; ?>" /></label>
									</div>
									<div class="form-check">
										<input class="form-check-input netBanking" type="radio" name="flexRadioDefault" id="netBanking0" value="prepaid" />
										<label for="netBanking0" class="form-check-label">Net Banking<img src="assets_web/images/icons/upi-img.png" class="" alt="<?php echo website_name; ?>" /></label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="flexRadioDefault" id="cashOnDelivery" value="cod" />
										<label for="cashOnDelivery" class="form-check-label">Cash On Delivery (Cash/UPI)</label>
									</div>

								</form>
							</div>
							<div class="easy-return">
								<?php
								$min  = 1;
								$max  = 50;
								$num1 = rand($min, $max);
								$num2 = rand($min, $max);
								?>
								<div class="col-12 captcha_div" style="display:none">
									<div class="row">
										<div class="col-md-6">
											<div class="row">
												<h6><label for="quiz" class="col-sm-3 col-form-label form-label">
														<?php echo $num1 . '+' . $num2 . ' = ?'; ?>
													</label></h6>
												<div class="col-sm-9">
													<input type="hidden" id="no1" value="<?php echo $num1 ?>">
													<input type="hidden" id="no2" value="<?php echo $num2 ?>">
													<input type="text" id="captcha_test" class="form-control1" Placeholder="Captcha Required**" autocomplete="off" required>
													<span style="color:red;" id="captcha_inerror"></span>
													<span style="color:green;" id="captcha_error"></span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<br><br>
								<p>Easy Return & Exchange Available*</p>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="right-block box-shadow">
							<div class="price-details">
								<h5>Order Summary</h5>
								<ul class="price">
									<li>
										<h6>Cart Value (<?php echo $checkout['total_item']; ?> items)</h6>
									</li>
									<li>
										<h6><span id="payable_value"><?php echo $checkout['total_mrp']; ?></span></h6>
									</li>
								</ul>
								<ul class="discount">
									<li>
										<h6>Discount</h6>
									</li>
									<li>
										<h6>-<span id="discount_value"><?php echo $checkout['total_discount']; ?></span></h6>
									</li>
								</ul>
								<ul class="discount">
									<li>
										<h6>BH Customer Discount</h6>
									</li>
									<li>
										<h5 style="color:#438F29;padding-bottom:0;border-bottom:none;">-<span id="default_discount"><?php echo $checkout['default_discount']; ?></span></h5>
									</li>
								</ul>
								<ul class="discount">
									<li>
										<h6>Coupon Discount</h6>
									</li>
									<li>
										<h6>-<span id="coupo_discount_value"><?php // echo $checkout['coupon_discount']; ?></span></h6>
									</li>
								</ul>
								<ul class="tax">
									<li>
										<h6>Tax (Included)</h6>
									</li>
									<li>
										<h6><span id="tex_value" class="text-dark"><?php echo $checkout['tax_payable']; ?></span></h6>
									</li>
								</ul>
								<ul class="discount">
									<li>
										<h6>Delivery Charges</h6>
									</li>
									<li>
										<h6><span id="shipping_fee" class="text-dark"><?php echo $checkout['shipping_fee']; ?></span></h6>
									</li>
								</ul>
									<div class="input-group">
										<input type="text" class="form-control" name="coupon_code" id="coupon_code" placeholder="Discount Code" />
										<span onclick="get_checkout_data()" class="input-group-text btn btn-default btn-radious">Apply</span>
									</div>
									<span id="coupon_message" style="color:#438F29;font-weight:600"></span>
							</div>
							<ul class="total">
								<li>
									<h5>Total Amount</h5>
								</li>
								<li>
									<h5><span id="total_val"><?= $checkout['total_price']; ?></span></h5>
								</li>
							</ul>

							<div class="continue paymentMethod0">
								<h6>You will save <?php echo $checkout['total_discount']; ?> on this order</h6>
								<?php
								$str_result = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZabcdefghijklmnpqrstuvwxyz';
								?>
								<!--<form method="post" action="<?= base_url('CCAvenue/save') ?>" id="ccrevenue_checkout_form" onsubmit="return CCAvenueValidateForm0()">-->
								<form  action="#" id="ccrevenue_checkout_form">
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
									<input type="hidden" name="tid" id="tid" value="" />
									<input type="hidden" name="merchant_id" value="2153910" readonly />
									<input type="hidden" name="order_id" id="order_id" value="<?= strtoupper('ODR' . substr(str_shuffle($str_result), 0, 6) . date("hi") . rand(1, 99)); ?>" />
									<input type="hidden" name="amount" id="amount" value="" />
									<input type="hidden" name="currency" id="currency" value="INR" />
									<input type="hidden" name="redirect_url" value="<?= base_url('CCAvenue/response') ?>" />
									<input type="hidden" name="cancel_url" value="<?= base_url('CCAvenue/response') ?>" />
									<input type="hidden" name="language" value="EN" />
									<input type="hidden" name="billing_name" value="" />
									<input type="hidden" name="billing_address" value="" />
									<input type="hidden" name="billing_city" value="" />
									<input type="hidden" name="billing_state" value="" />
									<input type="hidden" name="billing_zip" value="" />
									<input type="hidden" name="billing_country" value="India" />
									<input type="hidden" name="billing_tel" value="" />
									<input type="hidden" name="billing_email" value="" />
									<input type="hidden" name="delivery_name" id="delivery_name" value="" />
									<input type="hidden" name="delivery_address" id="delivery_address" value="" />
									<input type="hidden" name="delivery_city" id="delivery_city" value="" />
									<input type="hidden" name="delivery_state" id="delivery_state" value="" />
									<input type="hidden" name="delivery_zip" id="delivery_zip" value="" />
									<input type="hidden" name="delivery_country" id="delivery_country" value="India" />
									<input type="hidden" name="delivery_tel" id="delivery_tel" value="" />
									<div id="place-order-btn-div00">
										<!-- <a onclick="place_order_data(event)" href="javascript:void(0);" class="btn btn-default paymentMethodBtn" id="paymentMethodBtn">Place Order</a> -->
										
									</div>
								</form>
								<div id="place-order-btn-div">
										<!-- <a onclick="place_order_data(event)" href="javascript:void(0);" class="btn btn-default paymentMethodBtn" id="paymentMethodBtn">Place Order</a> -->
										<button onclick="place_order_data(event)" id="online_place_order_btn0" class="btn btn-default btn-radious">Place Order</button>
									</div>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--End: Check-Out Page -->

	</main>

	<?php
	include("include/footer.php")
	?>

	<?php
	include("include/script.php")
	?>
	
	<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
	<script>
		var timeout = null;
		$('#captcha_test').keyup(function() {
			clearTimeout(timeout);

			timeout = setTimeout(function() {
				var captcha_test = $('#captcha_test').val();
				var no1 = $('#no1').val();
				var no2 = $('#no2').val();
				var input_val = parseInt(no1) + parseInt(no2);
				if (captcha_test == input_val) {
					$("#online_place_order_btn").prop('disabled', false);
					$("#captcha_inerror").text("");
					$("#captcha_error").text("Captcha Validated.");
				} else {
					$("#captcha_error").text("");
					$("#captcha_inerror").text("Invalid Captcha.");
					$("#online_place_order_btn").prop('disabled', true);
				}


			}, 700);
		});

		$(document).ready(function() {

			$("#cashOnDelivery").click(function() {
				$("#online_place_order_btn").prop('disabled', true);
				$('.captcha_div').show();
			});

			$("#netBanking").click(function() {
				$('.captcha_div').hide();
			});
			$(".netBanking").click(function() {
				$('.captcha_div').hide();
			});
			$("#cardPayment").click(function() {
				$('.captcha_div').hide();
			});
			$("#netBanking0").click(function() {
				$('.captcha_div').hide();
			});

		});


		


		function convertToNumber(str) {
			// Remove all commas from the string
			const withoutCommas = str.replace(/,/g, '');

			// Extract the number from the string and convert it to a float
			const number = parseFloat(withoutCommas.slice(1));

			return number;
		}
		// Place order button visiblity
		const payment_options = document.paymentOptions.flexRadioDefault;
		const place_order_btn_div = document.getElementById('place-order-btn-div');
		var prev = null;
		for (var i = 0; i < payment_options.length; i++) {
			payment_options[i].addEventListener('change', function() {
				if (this !== prev) {
					prev = this;
				}
				if (this.value === 'prepaid') {
					//place_order_btn_div.innerHTML = '<button onclick="submitCCAvenueForm()" id="online_place_order_btn" class="btn btn-default btn-radious">Place Order</button>';
					place_order_btn_div.innerHTML = '<a onclick="place_order_data(event)" href="javascript:void(0);" class="btn btn-default btn-radious paymentMethodBtn" id="paymentMethodBtn">Place Order</a>';
					// document.getElementById('address_save_btn').style.display = 'block';
				} else if (this.value === 'cod') {
					place_order_btn_div.innerHTML = '<a onclick="place_order_data(event)" href="javascript:void(0);" class="btn btn-default btn-radious paymentMethodBtn" id="paymentMethodBtn">Place Order</a>';
					/*document.getElementById('address_save_btn').style.display = 'none';*/
				} else {

				}
			});
		}

	/*	const address_save_btn = document.getElementById('online_place_order_btn');
		// CCReveenue checkout hidden form
		var tid = document.forms["ccrevenue_checkout_form"]["tid"];
		var merchant_id = document.forms["ccrevenue_checkout_form"]["merchant_id"];
		var order_id = document.forms["ccrevenue_checkout_form"]["order_id"];
		var amount = document.forms["ccrevenue_checkout_form"]["amount"];
		var currency = document.forms["ccrevenue_checkout_form"]["currency"];
		var redirect_url = document.forms["ccrevenue_checkout_form"]["redirect_url"];
		var cancel_url = document.forms["ccrevenue_checkout_form"]["cancel_url"];
		var language = document.forms["ccrevenue_checkout_form"]["language"];
		var billing_name = document.forms["ccrevenue_checkout_form"]["billing_name"];
		var billing_address = document.forms["ccrevenue_checkout_form"]["billing_address"];
		var billing_city = document.forms["ccrevenue_checkout_form"]["billing_city"];
		var billing_state = document.forms["ccrevenue_checkout_form"]["billing_state"];
		var billing_zip = document.forms["ccrevenue_checkout_form"]["billing_zip"];
		var billing_country = document.forms["ccrevenue_checkout_form"]["billing_country"];
		var billing_tel = document.forms["ccrevenue_checkout_form"]["billing_tel"];
		var billing_email = document.forms["ccrevenue_checkout_form"]["billing_email"];
		var delivery_name = document.forms["ccrevenue_checkout_form"]["delivery_name"];
		var delivery_address = document.forms["ccrevenue_checkout_form"]["delivery_address"];
		var delivery_city = document.forms["ccrevenue_checkout_form"]["delivery_city"];
		var delivery_state = document.forms["ccrevenue_checkout_form"]["delivery_state"];
		var delivery_zip = document.forms["ccrevenue_checkout_form"]["delivery_zip"];
		var delivery_country = document.forms["ccrevenue_checkout_form"]["delivery_country"];
		var delivery_tel = document.forms["ccrevenue_checkout_form"]["delivery_tel"];
		// Address save without login
		const submitCCAvenueForm = () => {
			if (validateAddressForm()) {
				const str_result = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
				const randomChars = Array.from({
					length: 6
				}, () => str_result.charAt(Math.floor(Math.random() * str_result.length))).join("");
				const currentTime = new Date().toISOString().slice(11, 16).replace(":", "");
				const randomNumber = Math.floor(Math.random() * 99) + 1;
				const result = "ODR" + randomChars + currentTime + randomNumber;
				const uppercaseResult = result.toUpperCase();
				order_id.value = uppercaseResult + '-' + document.getElementById('city').value + '-' + document.getElementById('state').value;
				tid.value = new Date().getTime();
				// amount.value = document.getElementById('total_val').innerText.match(/(\d+)/)[0];
				amount.value = convertToNumber(document.getElementById('total_val').innerText);
				billing_name.value = document.getElementById('fullname_a').value;
				billing_address.value = document.getElementById('fulladdress').value;
				billing_city.value = document.getElementById('city').options[document.getElementById('city').selectedIndex].text;
				billing_state.value = document.getElementById('state').options[document.getElementById('state').selectedIndex].text;
				billing_zip.value = document.getElementById('pincode').value;
				billing_tel.value = document.getElementById('mobile').value;
				billing_email.value = document.getElementById('email').value;
				delivery_name.value = document.getElementById('fullname_a').value;
				delivery_address.value = document.getElementById('fulladdress').value;
				delivery_city.value = document.getElementById('city').options[document.getElementById('city').selectedIndex].text;
				delivery_state.value = document.getElementById('state').options[document.getElementById('state').selectedIndex].text;
				delivery_zip.value = document.getElementById('pincode').value;
				delivery_tel.value = document.getElementById('mobile').value;
			}
		}

		const validateAddressForm = () => {
			if ($('#fullname_a').val() !== '' && $('#fulladdress').val() !== '' && $('#city').val() !== '' && $('#state').val() !== '' && $('#pincode').val() !== '' && $('#mobile').val() !== '' && $('#email').val() !== '') {
				Swal.fire({
					position: 'center',
					icon: 'success',
					title: 'saved',
					showConfirmButton: false,
					timer: 1500
				});
				return true;
			} else if ($('#fullname_a').val() !== '' || $('#fulladdress').val() !== '' || $('#city').val() !== '' || $('#city').val() !== 'Select' || $('#state').val() !== '' || $('#state').val() !== 'Select State' || $('#pincode').val() !== '' || $('#mobile').val() !== '' || $('#email').val() !== '') {
				Swal.fire({
					position: 'center',
					icon: 'error',
					title: "Please fill all the required field",
					showConfirmButton: false,
					timer: 1500
				});
				return true;
			} 
			else if ($('#pincode').val() < 6)
			{
				Swal.fire({
					position: 'center',
					icon: 'error',
					title: "Please Add Valid Pincode.",
					showConfirmButton: false,
					timer: 1500
				});
				return false;
			} else {
				Swal.fire({
					position: 'center',
					icon: 'error',
					title: "Your address can't be blank",
					showConfirmButton: false,
					timer: 1500
				});
				return false;
			}
		}

		// CCAvenue form validation
		const CCAvenueValidateForm = () => {
			// console.log(tid.value);
			// console.log(merchant_id.value);
			// console.log(order_id.value);
			// console.log(amount.value);
			// console.log(currency.value);
			// console.log(redirect_url.value);
			// console.log(cancel_url.value);
			// console.log(language.value);
			// console.log(billing_name.value);
			// console.log(delivery_name.value);
			// console.log(delivery_address.value);
			// console.log(delivery_city.value);
			// console.log(delivery_state.value);
			// console.log(delivery_zip.value);
			// console.log(delivery_country.value);
			// console.log(delivery_tel.value);
			// Check if name is empty
			if (tid.value !== "" && merchant_id.value !== "" && order_id.value !== "" && amount.value !== "" && currency.value !== "" && redirect_url.value !== "" && cancel_url.value !== "" && language.value !== "" && delivery_name.value !== "" && delivery_address.value !== "" && delivery_city.value !== "" && delivery_state.value !== "" && delivery_zip.value !== "" && delivery_country.value !== "" && delivery_tel.value !== "" && delivery_state.value !== "Select State" && delivery_city.value !== "Select") {
				return true;
			}
			/*if ($('#user_id').val() != '') {
				if ($('#fullname_a').val() !== '' || $('#fulladdress').val() !== '' || $('#city').val() !== '' || $('#city').val() !== 'Select' || $('#state').val() !== '' || $('#state').val() !== 'Select State' || $('#pincode').val() !== '' || $('#mobile').val() !== '' || $('#email').val() !== '') {
				
					Swal.fire({
						position: 'center',
						icon: 'error',
						title: 'Please select address',
						showConfirmButton: false,
						// confirmButtonColor: '#F42525',
						timer: 1500
					})	
				}else {
					return true;
				}
			} else {
				
					Swal.fire({
						position: 'center',
						icon: 'error',
						title: 'Please fill all fields00',
						showConfirmButton: false,
						// confirmButtonColor: '#F42525',
						timer: 1500
					})
				
			}
			return false;
		}*/
		
		$(document).on('change', 'input[name="flexRadioDefault"]', function () {
			get_checkout_data($("#pincode").val());
		});


		function AllowOnlyNumbers(e) {



			e = (e) ? e : window.event;

			var clipboardData = e.clipboardData ? e.clipboardData : window.clipboardData;

			var key = e.keyCode ? e.keyCode : e.which ? e.which : e.charCode;

			var str = (e.type && e.type == "paste") ? clipboardData.getData('Text') : String.fromCharCode(key);



			return (/^\d+$/.test(str));

		}


		var csrfName = $(".txt_csrfname").attr("name"); //
		var csrfHash = $(".txt_csrfname").val(); // CSRF hash
		var site_url = $(".site_url").val(); // CSRF hash

		$(function() {
			//window.onload = get_checkout_data();
			window.onload = getStatedata();
			window.onload = getCitydata(0);
		});

		$('#state').on('change', function() {
			getCitydata(this.value);
		});

		/*$('#city').on('change', function() {
			get_checkout_data(0);
		});*/

		function getStatedata() {
			//   successmsg("prod id "+item );
			//alert('ddddd');
			$.ajax({
				method: 'POST',
				url: site_url + "get_state",
				data: {
					language: default_language,
					[csrfName]: csrfHash
				},
				success: function(response) {
					// successmsg(response); // display response from the PHP script, if any
					var data = $.parseJSON(response);
					$('#state').empty();
					$('#tcity').empty();
					var o = new Option("Select State", "");
					$("#state").append(o);
					if (data["status"] == "1") {
						$getcity = true;
						var stateid = '' // <?php $state; ?>;
						$firstitemid = '';
						$firstitemflag = true;
						//  successmsg('<?php echo "some info"; ?>');
						// successmsg("state "+ stateid );
						$(data["data"]).each(function() {
							//	successmsg(this.id +"--"+stateid+"--");
							if (stateid === this.id) {
								// successmsg("match==="+stateid);
								var o = new Option(this.name, this.id);
								$("#state").append(o);
								$('#state').val(this.id);
								$getcity = false;
								//getCitydata(this.id);
							} else {
								var o = new Option(this.name, this.id);
								$("#state").append(o);
							}

							if ($firstitemflag == true) {
								$firstitemflag = false;
								$firstitemid = this.id;
							}
						});

						if ($getcity == true) {
							$getcity = false;
							// getCitydata( $firstitemid );
						}

					} else {
						successmsg(data["msg"]);
					}
				}
			});
		}

		function getCitydata(stateid) {
			// successmsg("state id "+stateid );
			$.ajax({
				method: 'POST',
				url: site_url + "get_city",
				data: {
					stateid: stateid,
					[csrfName]: csrfHash
				},
				success: function(response) {
					// successmsg(response); // display response from the PHP script, if any
					var data = $.parseJSON(response);
					$('#city').empty();
					var o = new Option("Select", "");
					$("#city").append(o);
					if (data["status"] == "1") {
						var cityid = '';

						$(data["data"]).each(function() {
							//	successmsg(this.name+"---"+cityid);
							if (cityid === this.id) {
								// successmsg("match==="+stateid);
								var o = new Option(this.name, this.id);
								$("#city").append(o);
								$('#city').val(this.id);

							} else {
								var o = new Option(this.name, this.id);
								$("#city").append(o);
							}
							//	var o = new Option(this.name, this.id);
							//   $("#selectcity").append(o);
							// pass PHP variable declared above to JavaScript variable

						});

					} else {
						successmsg(data["msg"]);
					}
				}
			});
		}

		function get_checkout_data(user_pincode) {
			//alert(user_pincode);
			var user_pincode = $('#pincode').val();
			$('#coupon_message').html('');
			var input_code = $('#coupon_code').val();
			var city = $("#city option:selected").val();
			var payment_type = $('input[name="flexRadioDefault"]:checked').val();
			$(".paymentMethodBtn").prop('disabled', true);
			$.ajax({
				method: "post",
				url: site_url + "checkout",
				data: {
					language: default_language,
					coupon_code: input_code,
					shipping_city: city,
					shipping_pincode: user_pincode,
					payment_type: payment_type,
					[csrfName]: csrfHash
				},
				success: function(response) {

					var parsedJSON = response.Information;
					var product_html = "";
					$(".paymentMethod").empty();
					$('#total_discount_data').text();
					if (response.status == 2) {
						$('#coupon_message').html(response.msg);
						/*Swal.fire({
							position: "center",
							//icon: "success",
							title: response.msg,
							showConfirmButton: false,
							confirmButtonColor: "#ff5400",
							timer: 3000,
						});*/
					}
					$(parsedJSON).each(function() {
						$('#payable_value').text(this.total_mrp);
						$('#discount_value').text(this.total_discount);
						$('#tex_value').text(this.tax_payable);
						$('#shipping_fee').text(this.shipping_fee);
						$('#total_val').text(this.payable_amount);
						$('#coupon_message').html();
						//alert(this.shipping_fee);
						if (this.coupon_discount != '') {
							$('#total_discount_data').text('Total Savings :' + this.coupon_discount_text);
							$('#coupo_discount_value').text(this.coupon_discount);
							$('#coupon_message').html('Coupon applied successfully.');
						}
						else if(this.coupon_discount == 0)
						{
							$('#coupon_message').html('Invalid Coupon.');	
						}
							
						$(".paymentMethodBtn").prop('disabled', false);

						/*product_html += '<a onclick="place_order_data(event)" href="javascript:void(0);" class="btn btn-default paymentMethodBtn">Place Order</a>';
						$(".paymentMethod").html(product_html);
						alert(this.payable_amount);*/
					});
					//alert(response);
				}
			});
		}

		function get_shipping() {
			var pincode = $('#pincode').val();
			get_checkout_data(pincode);
		}
		
		$('#pincode').on('input', async function () {
		var pincode = $('#pincode').val();
		if (pincode.length === 6) {
			get_checkout_data(pincode);
		} else {
			$('#shipping_fee').html(`<span class="text-primary">--</span>`);
		}
	});




		// Address save with login
		// $(document).on('change', '#defaultAdderess', function() {

		// 	const str_result = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		// 	const randomChars = Array.from({
		// 		length: 6
		// 	}, () => str_result.charAt(Math.floor(Math.random() * str_result.length))).join("");
		// 	const currentTime = new Date().toISOString().slice(11, 16).replace(":", "");
		// 	const randomNumber = Math.floor(Math.random() * 99) + 1;
		// 	const result = "ODR" + randomChars + currentTime + randomNumber;
		// 	const uppercaseResult = result.toUpperCase();
		// 	order_id.value = uppercaseResult + '-' + document.getElementById('city').value + '-' + document.getElementById('state').value;
		// 	tid.value = new Date().getTime();
		// 	amount.value = document.getElementById('total_val').innerText.match(/(\d+)/)[0];
		// 	delivery_name.value = document.getElementById('fullname_a').value;
		// 	delivery_address.value = document.getElementById('fulladdress').value;
		// 	delivery_city.value = document.getElementById('city').options[document.getElementById('city').selectedIndex].text;
		// 	delivery_state.value = document.getElementById('state').options[document.getElementById('state').selectedIndex].text;
		// 	delivery_zip.value = document.getElementById('pincode').value;
		// 	delivery_tel.value = document.getElementById('mobile').value;
		// })

		/*$(document).ready(function() { */
		$(document).on('change', '#defaultAdderess', function() {
			var address_id = $('#defaultAdderess:checked').val();
			var user_id = $('#user_id').val();
			var total_value = $("#total_value").val();
			var seller_pincode = $('#seller_pincode').val();
			var user_pincode = '';
			$.ajax({
				method: "post",
				url: site_url + "getUserAddress",
				data: {
					language: default_language,
					user_id: user_id,
					[csrfName]: csrfHash
				},
				success: function(response) {
					var parsedJSON = response.Information.address_details;


					$(parsedJSON).each(function() {
						if (address_id == this.address_id) {

							$("#fullname_a").val(this.fullname);
							$("#mobile").val(this.mobile);

							$("#pincode").val(this.pincode);
							$("#email").val(this.email);
							setTimeout(() => {
								$("#state").val(this.state);
								setTimeout(() => {
									$('#city').val(this.city_id);
								}, 500);
							}, 500);
							//$("#city option:selected").val(this.city_id);
							//$("#city").children("option:selected").val(this.city_id);
							$("#fulladdress").val(this.fulladdress);
							//alert(this.city_id);

							user_pincode = this.pincode;

							// For online order only
							const str_result = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
							const randomChars = Array.from({
								length: 6
							}, () => str_result.charAt(Math.floor(Math.random() * str_result.length))).join("");
							const currentTime = new Date().toISOString().slice(11, 16).replace(":", "");
							const randomNumber = Math.floor(Math.random() * 99) + 1;
							const result = "ODR" + randomChars + currentTime + randomNumber;
							const uppercaseResult = result.toUpperCase();
							setTimeout(() => {
								order_id.value = uppercaseResult + '-' + document.getElementById('city').value + '-' + document.getElementById('state').value;
								tid.value = new Date().getTime();
								amount.value = convertToNumber(document.getElementById('total_val').innerText);
								billing_name.value = document.getElementById('fullname_a').value;
								billing_address.value = document.getElementById('fulladdress').value;

								billing_city.value = document.getElementById('city').options[document.getElementById('city').selectedIndex].text;
								billing_state.value = document.getElementById('state').options[document.getElementById('state').selectedIndex].text;
								billing_zip.value = document.getElementById('pincode').value;
								billing_tel.value = document.getElementById('mobile').value;
								billing_email.value = document.getElementById('email').value;
								delivery_name.value = document.getElementById('fullname_a').value;
								delivery_address.value = document.getElementById('fulladdress').value;
								delivery_city.value = document.getElementById('city').options[document.getElementById('city').selectedIndex].text;
								delivery_state.value = document.getElementById('state').options[document.getElementById('state').selectedIndex].text;
								delivery_zip.value = document.getElementById('pincode').value;
								delivery_tel.value = document.getElementById('mobile').value;
							}, 500)
						}
					});
					get_checkout_data(user_pincode);
					/*$.ajax({
					method: "post",
					url: site_url + "getshippingcost",
					data: {
					  language: default_language,
					  seller_pincode : seller_pincode,
					  user_pincode : user_pincode,
					  total_value : total_value,
					  [csrfName]: csrfHash
					},
					success: function (response) {
						var shipping_fee = response.Information;
						event.preventDefault();				
						$('#shipping_fee').text(shipping_fee);
					   $('#total_val').text(total_value-shipping_fee);
					   
					}
					});*/

				}
			});

			//get_brand_product(hidden_brandid, id, 0)
		});




async function place_order_data(ele) {
    ele.disabled = true;
	
	if ($('#fullname_a').val() == '' || $('#fulladdress').val() == '' || $('#city').val() == '' || $('#city').val() == 'Select' || $('#state').val() == '' || $('#state').val() == 'Select State' || $('#pincode').val() == '' || $('#mobile').val() == '' || $('#email').val() == '') {
					Swal.fire({
						position: 'center',
						icon: 'error',
						title: 'Please select address',
						showConfirmButton: false,
						// confirmButtonColor: '#F42525',
						timer: 1500
			})	
		}else {
	

	var mobile = $("#mobile").val();
	if(mobile.toString().length < 10)
	{
		$('#eror_mobile').text('Please add 10 Digit mobile number.');
	}
	else
	{
		 ele.disabled = false;
    try {
        // Wait for both functions to complete
       
        var coupon_code = $('#coupon_code').val();
        var coupon_value = $('#coupo_discount_value').text();
		var payment_type = $('input[name="flexRadioDefault"]:checked').val();

        var form_data = new FormData();
        form_data.append('language', default_language);
        form_data.append('fullname', $("#fullname_a").val());
        form_data.append('mobile', $("#mobile").val());
        form_data.append('user_id', $("#user_id").val());
        form_data.append('locality', '');
        form_data.append('fulladdress', $("#fulladdress").val());
        form_data.append('city', $('#city').find(":selected").text());
        form_data.append('city_id', $("#city").val());
        form_data.append('state', $('#state').find(":selected").text());
        form_data.append('state_id', $("#state").val());
        form_data.append('pincode', $("#pincode").val());
        form_data.append('addresstype', 'Home');
        form_data.append('email', $("#email").val());
        form_data.append('payment_id', 'Pay12345');
        form_data.append('payment_mode', $('input[name="flexRadioDefault"]:checked').val());
        form_data.append('coupon_code', coupon_code);
        form_data.append('coupon_value', coupon_value);
        form_data.append('kyc_document', null);
        form_data.append([csrfName], csrfHash);
		
		
		
		
		
					
			if ($('input[name="flexRadioDefault"]:checked').val() === 'cod') {
				$.ajax({
					method: "post",
					url: site_url + "placeOrder",
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,
					success: function (response) {

						if (response.status == 1) {
							var order_id = response.Information.order_id;
							location.href = site_url + "thankyou/" + order_id;

						} else {
							/*Swal.fire({
								position: "center",
								//icon: "success",
								title: response.Information.order_msg,
								showConfirmButton: false,
								confirmButtonColor: "#ff5400",
								timer: 3000,
							});*/
						}
					},
				});
			} else if ($('input[name="flexRadioDefault"]:checked').val() === 'prepaid') {
				
				$.ajax({
					method: "post",
					url: site_url + "checkout",
					data: {
						language: default_language,
						coupon_code: coupon_code,
						shipping_pincode: $("#pincode").val(),
						payment_type: payment_type,
						payment_method: $('input[name="flexRadioDefault"]:checked').val(),
						[csrfName]: csrfHash
					},
					success: function (response) {


						if (response.status) {
							//var amount = response.Information.payable_amount_value - $('#default_discount').text();
							var amount = response.Information.total_price_value;
							var pay_orderId = response.Information.pay_orderId;
// console.log('response>>>>>>>>>>>>.',response);
// return ;
							var options = {
								//key: 'rzp_test_R6HPHmrG7B2oge',
								key: 'rzp_live_oVzpJnJRDQttrF',
								amount: amount * 100, // Amount in paise
								currency: 'INR',
								name: 'Bznesshub',
								description: 'Place Order',
								order_id: pay_orderId,
								capture: 1,
								prefill: {
									name: $("#fullname_a").val(),
									email: $("#email").val(),
									contact: $("#mobile").val(),
								},
								handler: function (response) {
									// Handle Razorpay response here, like updating database or showing success message
									if (response.razorpay_payment_id) {
										/*const proxyUrl = site_url + 'Razorpay/capturePayment?payment_id=' + response.razorpay_payment_id + '&amount=' + amount * 100;

										fetch(proxyUrl)
											.then(response => {
												if (!response.ok) {
													throw new Error('Network response was not ok');
												}
												return response.text();
											})
											.then(data => {
												console.log(data); // Output: "Payment Captured" if successful
											})
											.catch(error => {
												console.error('There was a problem with the fetch operation:', error);
											});*/

										form_data.set('payment_id', response.razorpay_payment_id);
										$.ajax({
											method: "post",
											url: site_url + "placeOrder",
											cache: false,
											contentType: false,
											processData: false,
											data: form_data,
											success: function (response) {

												if (response.status == 1) {
													var order_id = response.Information.order_id;
													location.href = site_url + "thankyou/" + order_id;

												} else {
													/*Swal.fire({
														position: "center",
														//icon: "success",
														title: response.Information.order_msg,
														showConfirmButton: false,
														confirmButtonColor: "#ff5400",
														timer: 3000,
													});*/
												}
											},
										});
									} else {
										Swal.fire({
											text: 'Payment failed or was canceled.',
											type: "error",
											showCancelButton: true,
											showCloseButton: true,
											confirmButtonColor: theme_colour,
										});
									}
								},
								modal: {
									ondismiss: function () {
										// Reload the page if payment is canceled
										window.location.reload();
									}
								}
							};

							var rzp = new Razorpay(options);
							rzp.open();
						} else {
							window.location.href = site_url + '404';
						}
					}
				});
				
			} else {
				window.location.href = site_url + '404';
			}
		
    } catch (error) {
        // At least one of the functions failed
        // console.error('Error:', error);

        ele.disabled = false;
        ele.innerHTML = "Place Order"
    }
	}
	}
}





	async function place_order_data_old(event) {
			var tab = 'true';


			var address_id = $('#defaultAdderess:checked').val();
			var user_id = $('#user_id').val();


			var fullname = $("#fullname_a").val();
			var mobile = $("#mobile").val();
			var state = $("#state").val();
			var pincode = $("#pincode").val();
			var city = $("#city").val();
			var email = $("#email").val();
			var user_id = $("#user_id").val();
			var fulladdress = $("#fulladdress").val();
			var city_id = $("#city option:selected").val();

			if (user_id !== '') {
				if (validateAddressForm()) {

					$.ajax({
						method: "post",
						url: site_url + "getUserAddress",
						data: {
							language: default_language,
							user_id: user_id,
							[csrfName]: csrfHash
						},
						success: function(response) {

							var parsedJSON = response.Information.address_details;

							if (parsedJSON == '') {
								addUserAddress();
							} else {
								var isNewAddress = true;
								$(parsedJSON).each(function() {
									console.log('a');
									console.log(this)
									if (this.fullname === fullname && this.mobile === mobile && this.state === state && this.pincode === pincode && this.city_id === city && this.email === email && this.fulladdress === fulladdress) {
										console.log('b')
										isNewAddress = false;
										return false;
									}
								});
								if (isNewAddress) {
									addUserAddress();
								}
							}
						}
					});


					/* $.ajax({
						method: "post",
						url: site_url + "addUserAddress",
						data: {
							language: default_language,
							username: fullname,
							mobile: $("#mobile").val(),
							pincode: $("#pincode").val(),
							locality: "",
							fulladdress: $("#fulladdress").val(),
							state: $("#state").val(),
							city: $('#city').find(":selected").text(),
							addresstype: "home",
							email: $("#email").val(),
							city_id: $("#city option:selected").val(),
							[csrfName]: csrfHash,
						},
						success: function(response) {
							//hideloader();
							// location.reload();
						},
					}); */
				}
			}

			if (fullname == '') {
				Swal.fire({
					position: "center",
					//icon: "success",
					title: 'Please Select Address',
					showConfirmButton: false,
					confirmButtonColor: "#ff5400",
					timer: 3000,
				});
			} else {


				//alert("active---"+tab+"---");

				if (fulladdress == "" || fulladdress == null && fullname == "" || fullname == null && state == "" || state == null && city == "" || city == null && pincode == "" || pincode == null || pincode.length < 6) {

					if (fullname == "" || fullname == null) {
						$("#fullname1_error").text("Please Add Name.");
					} else {
						$("#fullname1_error").text("");
					}
					if (mobile == "" || mobile == null) {
						$("#mobile_error").text("Please Add Mobile No.");
					} else {
						$("#mobile_error").text("");
					}
					if (state == "" || state == null) {
						$("#state_error").text("Please Select State.");
					} else {
						$("#state_error").text("");
					}
					if (pincode == "" || pincode == null) {
						$("#pincode_check").text("Please Add Pincode.");
					} else if (pincode.length < 6) {
						$("#pincode_check").text("Please Add Valid Pincode.");
					} else {
						$("#pincode_check").text("");
					}
					
					if (city == "" || city == null) {
						$("#city_error").text("Please Select City.");
					} else {
						$("#city_error").text("");
					}

					if (email == "" || email == null) {
						$("#emails_error").text("Please Add Emails.");
					} else {
						$("#emails_error").text("");
					}
					
					

					if (fulladdress == "" || fulladdress == null) {
						$("#fulladdress_error").text("Please Add Full Address.");
					} else {
						$("#fulladdress_error").text("");
					}

					/*if( ){
					  /// write address filed validation code
					}else if(){ */

				} else {

					$("#fullname1_error").text("");
					$("#emails_error").text("");
					$("#mobile_error").text("");
					$("#state_error").text("");
					$("#city_error").text("");
					$("#fulladdress_error").text("");

					if (tab == 'true') {

						 alert("call true");
						 
					$.ajax({
                method: "post",
                url: site_url + "checkout",
                data: {
                    language: default_language,
                    coupon_code: '',
                    user_name: $("#fullname_a").val(),
                    user_mobile: $("#mobile").val(),
                    user_email: $("#email").val(),
                    user_fulladdress: $("#fulladdress").val(),
                    user_city: $('#city').find(":selected").text(),
                    user_city_id: $("#city").val(),
					user_state: $('#state').find(":selected").text(),
                    user_state_id: $("#state").val(),
					order_log: 'order_log',
                    shipping_pincode: $("#pincode").val(),
                    payment_method: $('input[name="flexRadioDefault"]:checked').val(),
                    [csrfName]: csrfHash
                },
                success: function (response) {
						
						var amount = response.Information.payable_amount_value;

                        var options = {
                            key: 'rzp_live_oVzpJnJRDQttrF',
                            amount: amount * 100,
                            currency: 'INR',
                            name: 'bznesshub',
                            description: 'Place Order',
                            capture: 1,
                            prefill: {
                                name: $("#fullname_a").val(),
                                email: $("#email").val(),
                                contact: $("#mobile").val(),
                            },
                            handler: function (response) {
								// Handle Razorpay response here, like updating database or showing success message
                                if (response.razorpay_payment_id) {
                                    const proxyUrl = site_url + 'Razorpay/capturePayment?payment_id=' + response.razorpay_payment_id + '&amount=' + amount * 100;

                                    fetch(proxyUrl)
                                        .then(response => {
                                            if (!response.ok) {
                                                throw new Error('Network response was not ok');
                                            }
                                            return response.text();
                                        })
                                        .then(data => {
                                            console.log(data); // Output: "Payment Captured" if successful
                                        })
                                        .catch(error => {
                                            console.error('There was a problem with the fetch operation:', error);
                                        });

                                    form_data.set('payment_id', response.razorpay_payment_id);
                                    $.ajax({
                                        method: "post",
                                        url: site_url + "placeOrder",
                                        cache: false,
                                        contentType: false,
                                        processData: false,
                                        data: form_data,
                                        success: function (response) {

                                            if (response.status == 1) {
                                                var order_id = response.Information.order_id;
                                                location.href = site_url + "thankyou/" + order_id;

                                            } else {
                                                /*Swal.fire({
                                                    position: "center",
                                                    //icon: "success",
                                                    title: response.Information.order_msg,
                                                    showConfirmButton: false,
                                                    confirmButtonColor: "#ff5400",
                                                    timer: 3000,
                                                });*/
                                            }
                                        },
                                    });
                                } else {
                                    Swal.fire({
                                        text: 'Payment failed or was canceled.',
                                        type: "error",
                                        showCancelButton: true,
                                        showCloseButton: true,
                                        confirmButtonColor: theme_colour,
                                    });
                                }
                            },
                            modal: {
                                ondismiss: function () {
                                    // Reload the page if payment is canceled
                                    window.location.reload();
                                }
                            }
                        };
					}
            });	
						
						

						var spinner = '<div class="spinner-border" role="status"><span class="se-only"></span></div> Please Wait..';
						$('.paymentMethodBtn').html(spinner);
						// $(".paymentMethodBtn").prop('disabled', true);
						$('.paymentMethodBtn').addClass('disabled-link');
						// alert(" place order req send ");
						var coupon_code = $('#coupon_code').val();
						var coupon_value = $('#coupo_discount_value').text();

						$.ajax({
							method: "post",
							url: site_url + "placeOrder0",
							data: {
								language: default_language,
								fullname: fullname,
								mobile: mobile,
								locality: '',
								fulladdress: fulladdress,
								city: $('#city').find(":selected").text(),
								state: state,
								pincode: pincode,
								addresstype: 'Home',
								email: email,
								payment_id: 'Pay12345',
								payment_mode: 'COD',
								city_id: city_id,
								coupon_code: coupon_code,
								coupon_value: coupon_value,
								[csrfName]: csrfHash,
							},
							success: function(response) {
								// $(".paymentMethodBtn").prop('disabled', false);
								$('.paymentMethodBtn').removeClass('disabled-link');
								$('.paymentMethodBtn').text('Place Order');
								//hideloader();

								if (response.status == 1) {
									// alert(response.status);
									//location.href = site_url + "thankyou/" + order_id;

									var imgurl = $("#imgurl").val();

									var order_id = response.Information.order_id;
									var message = 'Dear *' + fullname + '* ,';
									message += ' Your Order has been placed Successfully.';
									$.ajax({
										method: 'get',
										url: site_url + 'send_whatsapp_msg',
										data: {
											number: '91'.concat(mobile),
											type: 'media',
											message: message.replace(/ /g, "%20"),
											media_url: site_url + 'media/' + imgurl,
											// filename: '',
											instance_id: '64258107A62A7',
											access_token: '14e3c33fbe98cd4ac95bb8f15c2d9023'
										},
										success: function(response) {
											// alert(JSON.stringify(JSON.parse(response), null, 2));
										}
									});


									setTimeout(function() {


										location.href = site_url + "thankyou/" + order_id;
									}, 100);

								} else {
									Swal.fire({
										position: "center",
										//icon: "success",
										title: response.Information.order_msg,
										showConfirmButton: false,
										confirmButtonColor: "#ff5400",
										timer: 3000,
									});
								}
								//alert(response.Information.order_msg);
								//var order_id = response.Information.order_id
								//location.href=site_url+'thankyou/'+ order_id;

								//var parsedJSON = JSON.parse(response);
								//$(parsedJSON.Information).each(function() {
								//	 alert(this.order_id);
								//});
								//location.href=site_url+'thankyou';
							},
						});


					} else {
						//alert ("call else ");
						///$('#payment-tab').
						$('#address-tab').attr('aria-selected', false);
						$("#address-tab").removeClass('active');
						$("#address").removeClass('active');
						$("#address").removeClass('show');

						$("#payment-tab").addClass('active');
						$("#payment").addClass('active');
						$("#payment").addClass('show');
						$('#payment-tab').attr('aria-selected', true);
					}

				}


				/*
				  event.preventDefault();
				  var fullname = $("#name").val();
				  var mobile = $("#mobile").val();
				  var state = $("#state").val();
				  var pincode = $("#pincode").val();
				  var city = $("#city").val();
				  var email = $("#email").val();
				  var user_id = $("#user_id").val();
				  var fulladdress = $("textarea#address").val();
				  
				  

				 */
			}
		}

		function apply_coupon(event) {
			var total_value = $("#total_value").val();
			var coupon_code = $("#coupon_code").val();
			event.preventDefault();

			$.ajax({
				method: "post",
				url: site_url + "apply_coupon",
				data: {
					language: 1,
					coupon_code: coupon_code,
					price: "1000",
					[csrfName]: csrfHash,
				},
				success: function(response) {
					//hideloader();
					Swal.fire({
						position: "center",
						//icon: "success",
						title: response.msg,
						showConfirmButton: false,
						confirmButtonColor: "#ff5400",
						timer: 3000,
					});
					//alert(response.msg);
					//location.reload();
				},
			});
		}

		const addUserAddress = () => {

			var fullname = $("#fullname_a").val();
			var mobile = $("#mobile").val();
			var state = $("#state").val();
			var pincode = $("#pincode").val();
			var city = $("#city").val();
			var email = $("#email").val();
			var fulladdress = $("#fulladdress").val();
			var city_id = $("#city option:selected").val();

			if (fullname == "" || fullname == null) {
				$("#fullname1_error").text("Please Add Name.");
			} else if (mobile == "" || mobile == null) {
				$("#mobile_error").text("Please Add Mobile No.");
			} else if (state == "" || state == null) {
				$("#state_error").text("Please Select State.");
			} else if (pincode == "" || pincode == null) {
				alert('please Add Pincode.');
			} else if (pincode.length < 6) {
				alert('please Add Valid Pincode.');
			} else if (city == "" || city == null) {
				$("#city_error").text("Please Select City.");
			} else if (email == "" || email == null) {
				$("#emails_error").text("Please Add CiEmailty.");
			} else if (fulladdress == "" || fulladdress == null) {
				$("#fulladdress_error").text("Please Add Full Address.");
			} else {

				$.ajax({
					method: "post",
					url: site_url + "addUserAddress",
					data: {
						language: default_language,
						username: fullname,
						mobile: mobile,
						pincode: pincode,
						locality: "",
						fulladdress: fulladdress,
						state: state,
						city: $('#city').find(":selected").text(),
						addresstype: "home",
						email: email,
						city_id: city_id,
						[csrfName]: csrfHash,
					},
					success: function(response) {
						//hideloader();
						// location.reload();
					},
				});
			}
		};

		const getUserAddress = (user_id) => {

			var response = $.ajax({
				method: "post",
				url: site_url + "getUserAddress",

				data: {
					language: default_language,
					user_id: user_id,
					[csrfName]: csrfHash
				},
				success: function(response) {
					// alert(response);
				}
			});
			return response;

		}

		$(document).ready(function() {
			$("#address_div_id").click(function() {
				event.preventDefault();
				var user_id = $('#user_id').val();
				if (user_id == '') {
					$("#address_div").toggle();
					//  document.getElementById('formoid').querySelector('#address_save_btn').style.display = 'none';
				} else {
					// location.href = site_url + 'myaddress';
					$("#address_div").toggle();
				}
			});
		});
	</script>

</body>

</html>