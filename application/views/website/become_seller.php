<!DOCTYPE html>
<html lang="en">

<head>
	<?php $title = "Virtual Partner";
	include("include/headTag.php") ?>
</head>
<style>
	#progressbar
	{
		padding-left : 0;
	}
	.spinner-border {
		height: 19px;
		width: 19px;
		margin-right: 4px;
	}
	 table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px 0;
            display : inline-table;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
</style> 
<body>

	<?php
	include("include/topbar.php")
	?>
	<?php
	include("include/navbar.php")
	?>

	<main class="become-seller-page">

		<!--Start: Become a Seller Section -->
		<section class="become-seller box-shadow">
			<div class="container">

				<?php if (!empty($this->session->flashdata("seller_form_msg"))) : ?>
					<div class="alert alert-success alert-dismissible fade show text-start" role="alert">
						<?= $this->session->flashdata("seller_form_msg");  ?>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				<?php endif; ?>
				<div class="row">
					<div class="wrap">
						<h4>Virtual Partner</h4>
						<p>Fill all form field to go to next step</p>
					</div>


					<!--<form class="form" id="formoid" action="add_seller" method="POST" enctype="multipart/form-data">-->
					<form class="form" id="formoid" action="" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

						<!-- progressbar -->
						<!--<ul id="progressbar" class="d-none d-lg-block">-->
						<ul id="progressbar" class="">
							<li class="active" id="email"><span class="d-none d-lg-block">Seller Information & GST</span></li>
							<li id="account"><span class="d-none d-lg-block">Shop Description</span></li>
							<li id="personal"><span class="d-none d-lg-block">Personal Info.</span></li>
							<li id="document"><span class="d-none d-lg-block">Documents Upload</span></li>
							<li id="confirm"><span class="d-none d-lg-block">Finish</span></li>
						</ul>
						<!--<div class="progress d-lg-none">-->
						<div class="progress d-none">
							<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<!-- fieldsets -->
						<fieldset>
							<div class="row g-3" id="seller_form">
								<div class="col-7">
									<h6 class="text-start"><b>Seller Information & GST:</b></h6>
								</div>
								<div class="col-5">
									<h6 class="text-end">Step 1 - 5</h6>
								</div>
								<div class="col-md-6">
									<label class="form-label">Seller Name :</label>
									<input type="text" class="form-control" id="seller_name" name="seller_name" placeholder="Seller Name." required />
									<span id="error"></span>
								</div>

								<div class="col-md-6">
									<label class="form-label">Shop Name :</label>
									<input type="text" class="form-control" id="business_name" name="business_name" placeholder="Shop Name." required />
									<span id="error"></span>
								</div>
								<div class="col-md-12">
									<label class="form-label">Shop Address:</label>
									<textarea class="form-control" rows="5" id="business_address" name="business_address" placeholder="Shop Address" required></textarea>
									<span id="error"></span>
								</div>
								<div class="col-md-12">
									<label class="form-label">Shop Details:</label>
									<textarea class="form-control" rows="5" id="business_details" name="business_details" required placeholder="Shop Details"></textarea>
									<span id="error"></span>
								</div>
								<div class="col-md-6">
									<label class="form-label">Seller Type :</label>
									<select id="seller_type" name="seller_type" class="form-control" required>
										<option value="">Select type</option>
										<option value="Street Merchant">Virtual Partner</option>
										<option value="Shop">Shop</option>
										<option value="Firm">Firm</option>
										<option value="Company">Company</option>
									</select>
								</div>
								<div class="col-md-6" style="display:none;" id="gst_div">
									<label class="form-label">GST:</label>
									<input type="text" class="form-control" id="tax_number" name="tax_number" aceholder="GST" />
									<span id="error"></span>
								</div>

								<div class="col-md-6" id="plan_div">
									<label class="form-label">Select Plans:</label>

<input type="hidden" name="plan_price" id="plan_price">

<select name="selectplan" id="selectplan" class="form-control" onchange="show_data()">

<!-- <option value="">Select Plans</option> -->

<?php foreach ($get_plans as $plans_data) { ?>
<option data-plan_value="<?php echo $plans_data['plan_value']; ?>" value="<?php echo $plans_data['plan_id']; ?>">


<?php echo $plans_data['plan_name']?>

<?php 
if($plans_data['plan_value'] > 0){
echo' (Price: ' . $plans_data['plan_value'] . ')';
}else{
echo '(Free)';
}
 ?>


(Duration : <?php echo $plans_data['duration']; ?> Days)
</option>


<?php } ?>

</select>
									<span id="error"></span>
								</div>
								
								<div class="col-md-6" style="display:none;" id="plan_all_div"> 
									<label class="form-label">Select Plans:</label>
									<select name="selectplan1" id="selectplan1" class="form-control" onchange="show_data1()">

										<option value="">Select Plans</option>

										<?php foreach ($get_plans as $plans_data) { ?>
											<option data-plan_value="<?php echo $plans_data['plan_value']; ?>" value="<?php echo $plans_data['plan_id']; ?>"><?php echo $plans_data['plan_name'] . ' (' . $plans_data['plan_value'] . ')'; ?></option>

											
										<?php   } ?>

									</select>
									<span id="error"></span>
								</div>
								
								<div class="col-md-6">
									<label class="form-label">Refer Code:</label>
									<input type="text" class="form-control" id="refer_codes" name="refer_code" aceholder="Refer Code" />
									<span id="error"></span>
								</div>

							</div>
							<a href="#" class="seller_form btn btn-default ">Next</a>
						</fieldset>
						<fieldset>
							<div class="row g-3" id="seller_desc">
								<div class="col-7">
									<h6 class="text-start"><b>Shop Description:</b></h6>
								</div>
								<div class="col-5">
									<h6 class="text-end">Step 2 - 5</h6>
								</div>

								<div class="col-md-12">
									<label class="form-label">Select State:</label>
									<select name="selectstate" id="selectstate" required class="form-control">

										<option value="">Select State</option>

										<?php /* foreach ($get_state as $state_data) { ?>

											<option value="<?php echo $state_data['id']; ?>"><?php echo $state_data['name']; ?></option>

										<?php } */ ?>

									</select>
									<span id="error"></span>
								</div>
								<div class="col-md-12">
									<label class="form-label">Select City:</label>
									<select name="selectcity" id="selectcity" required class="form-control">

										<option value="">Select City</option>

										<?php /* foreach ($get_city as $city_data) { ?>

											<option value="<?php echo $city_data['id']; ?>"><?php echo $city_data['name']; ?></option>

										<?php } */ ?>

									</select>
									<span id="error"></span>
								</div>
								<div class="col-md-12">
									<label class="form-label">Enter Pincode:</label>
									<input type="text" class="form-control" id="pincode" name="pincode" maxlength="6" required onkeypress="return AllowOnlyNumbers(event);" placeholder="Seller Pincode" />
									<span id="error"></span>
								</div>
								<div class="col-md-12">
									<label class="form-label">Enter No Of Products:</label>
									<input type="text" class="form-control" id="no_of_products" name="no_of_products" maxlength="6" required onkeypress="return AllowOnlyNumbers(event);" placeholder="No Of Products" />
									<span id="error"></span>
								</div>

							</div>
							<a href="#" class="previous btn btn-secondary btn-radious btn-radious btn-radious">Previous</a>
							<a href="#" class="seller_desc btn btn-default  ">Next</a>
						</fieldset>
						<fieldset>
							<div class="row g-3" id="seller_info">
								<div class="col-7">
									<h6 class="text-start"><b>Personal Information:</b></h6>
								</div>
								<div class="col-5">
									<h6 class="text-end">Step 3 - 5</h6>
								</div>

								<div class="col-md-12">
									<label class="form-label">Enter Phone Number:</label>
									<input type="text" class="form-control" id="phone" maxlength="10" required onkeypress="return AllowOnlyNumbers(event);" name="phone" placeholder="Enter Phone Number" />
									<span id="error"></span>
								</div>
								<div class="col-md-12">
									<label class="form-label">Enter Email:</label>
									<input type="email" class="form-control" id="emails" maxlength="30" required name="email" placeholder="Seller Email" />
									<span id="error"></span>
								</div>
								<div class="col-md-12">
									<label class="form-label">Password:</label>
									<input type="password" id="password" maxlength="30" name="password" required class="form-control" placeholder="Seller Password" />
									<span id="error"></span>
								</div>

							</div>
							<a href="#" class="previous btn btn-secondary btn-radious">Previous</a>
							<a href="#" class="seller_info btn btn-default ">Next</a>

						</fieldset>
						<fieldset>
							<div class="row g-3" id="seller_doc">
								<div class="col-7">
									<h6 class="text-start"><b>Documents Upload:</b></h6>
								</div>
								<div class="col-5">
									<h6 class="text-end">Step 4 - 5</h6>
								</div>
								<div class="col-md-12">
									<label class="form-label">Upload Id Proof:</label>
									<input type="file" name="aadhar_card" id="aadhar_card" class="form-control" />
									<span id="error"></span>
								</div>
								<div class="col-md-12">
									<label class="form-label">Upload Pan card :</label>
									<input type="file" id="pan_card" name="pan_card" class="form-control" />
									<span id="error"></span>
								</div>
								<div class="col-md-12">
									<label class="form-label">Business Logo :</label>
									<input type="file" id="seller_logo" name="seller_logo" class="form-control" />
									<span id="error"></span>
								</div>
								<div class="col-md-12">
									<label class="form-label">Upload Business Proof:</label>
									<input type="file" name="business_proof" id="business_proof" class="form-control" />
									<span id="error"></span>
								</div>
								
								<div class="col-md-12">
								  <label for="myCheckbox">
                                        <input type="checkbox" id="myCheckbox" name="myCheckbox">
                                        I agree to the terms and conditions
                                    </label>
								</div>
								<div class="col-md-12">
								   <table>
								       <tr>
								           <td>Plan</td>
								           <td><span id="plan_name"></span></td>
								       </tr>
								       <tr>
								           <td>Amount</td>
								           <td><span id="plan_amount"></span></td>
								       </tr>
								        <tr>
								           <td>GST 18%</td>
								           <td><span id="plan_gst"></span></td>
								       </tr>
								       <tr>
								           <td><b>Total Amount</b></td>
								           <td><b><span id="plan_total_amount"></span></b></td>
								       </tr>
								   </table>
								</div>
								
							</div>
							<a href="#" class="previous btn btn-secondary btn-radious">Previous</a>
							<button onclick="form_send()" class="btn btn-default  sendBtn seller_doc" name="submit" type="submit">Submit</button>

						</fieldset>
						<fieldset>
							<div class="row g-3">
								<div class="col-7">
									<h6 class="text-start"><b>Finish:</b></h6>
								</div>
								<div class="col-5">
									<h6 class="text-end">Step 5 - 5</h6>
								</div>
								<img src="<?php echo base_url; ?>assets_web/images/icons/thanks-icon.png" class="success-img" />
								<h4>SUCCESS !</h4>
								<h6>Congratulations, You are now a seller of our company.</h6>
								<h6>Thanks.</h6>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</section>
		<!--End: Become a Seller Section -->

	</main>

	<?php
	include("include/footer.php")
	?>

	<?php
	include("include/script.php")
	?>
	<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
	<script>
		var csrfName = $('.txt_csrfname').attr('name'); // 
		var csrfHash = $('.txt_csrfname').val(); // CSRF hash
		var site_url = $('.site_url').val(); // CSRF hash

		$(function() {
			window.onload = getStatedata();
			window.onload = getCitydata(0);
		});
       	show_data();

        function show_data1()
        {
            plan_value = $('#selectplan1 option:selected').data('plan_value');
            plan_name = $('#selectplan1 option:selected').text();
           

			$("#plan_price").val(plan_value);
			plan_gst=0;
			plan_amount=0;
			plan_total_amount=0;

			if(plan_value > 0){
			plan_gst = (plan_value * 18) / 118;
            plan_amount = plan_value - plan_gst;
            plan_total_amount = plan_value;
			}

           // plan_gst = (plan_value * 18) / 118;
           // plan_amount = plan_value - plan_gst;
           // plan_total_amount = plan_value
           
           $('#plan_name').html(plan_name);
           $('#plan_amount').html(plan_amount.toFixed(2));
           $('#plan_gst').html(plan_gst.toFixed(2));
           $('#plan_total_amount').html('₹ '+plan_total_amount);
           
        }
         function show_data()
        {
            plan_value = $('#selectplan option:selected').data('plan_value');
            plan_name = $('#selectplan option:selected').text();
			$("#plan_price").val(plan_value);
			plan_gst=0;
			plan_amount=0;
			plan_total_amount=0;

			if(plan_value > 0){
			plan_gst = (plan_value * 18) / 118;
			plan_amount = plan_value - plan_gst;
			plan_total_amount = plan_value;
			}
           
           //console.log('>>>>>>>>>>>>>>>>>',plan_gst,plan_amount,plan_total_amount);
           $('#plan_name').html(plan_name);
           $('#plan_amount').html(plan_amount.toFixed(2));
           $('#plan_gst').html(plan_gst.toFixed(2));
           $('#plan_total_amount').html('₹'+plan_total_amount);
           
        }


       


		$('#selectstate').on('change', function() {
		    
			getCitydata(this.value);
		});
			
		function form_send()
		{
			var spinner = '<div class="spinner-border" role="status"><span class="se-only"></span></div> Wait..';
			$('.sendBtn').html(spinner);
			$('.sendBtn').addClass('disabled-link');
			
			
			
		}

		function getStatedata() {

			$.ajax({
				method: 'POST',
				url: site_url + "get_state",
				data: {
					language: default_language,
					[csrfName]: csrfHash
				},
				success: function(response) {
					var data = $.parseJSON(response);
					$('#selectstate').empty();
					$('#tcity').empty();
					var o = new Option("Select State", "");
					$("#selectstate").append(o);
					if (data["status"] == "1") {
						$getcity = true;
						var stateid = ''
						$firstitemid = '';
						$firstitemflag = true;
						$(data["data"]).each(function() {
							if (stateid === this.id) {
								var o = new Option(this.name, this.id);
								$("#selectstate").append(o);
								$('#selectstate').val(this.id);
								$getcity = false;
							} else {
								var o = new Option(this.name, this.id);
								$("#selectstate").append(o);
							}

							if ($firstitemflag == true) {
								$firstitemflag = false;
								$firstitemid = this.id;
							}
						});

						if ($getcity == true) {
							$getcity = false;
						}

					} else {
						successmsg(data["msg"]);
					}
				}
			});
		}

		function getCitydata(stateid) {
			$.ajax({
				method: 'POST',
				url: site_url + "get_city",
				data: {
					stateid: stateid,
					[csrfName]: csrfHash
				},
				success: function(response) {
					var data = $.parseJSON(response);
					$('#selectcity').empty();
					var o = new Option("Select", "");
					$("#selectcity").append(o);
					if (data["status"] == "1") {
						var cityid = '';

						$(data["data"]).each(function() {
							if (cityid === this.id) {
								var o = new Option(this.name, this.id);
								$("#selectcity").append(o);
								$('#selectcity').val(this.id);

							} else {
								var o = new Option(this.name, this.id);
								$("#selectcity").append(o);
							}


						});

					} else {
						successmsg(data["msg"]);
					}
				}
			});
		}

		const validateDocForm = () => {
			var aadhar_card = document.getElementById('aadhar_card');
			var pan_card = document.getElementById('pan_card');
			var seller_logo = document.getElementById('seller_logo');
			var business_proof = document.getElementById('business_proof');

			var flag_aadhar_card = false;
			var flag_pan_card = false;
			var flag_seller_logo = true;
			var flag_business_proof = false;

			if (aadhar_card.value === '') {
				flag_aadhar_card = false;
				setErrorMsg(aadhar_card, '<i class="fa-solid fa-circle-xmark"></i> ID proof is required.');
			} else {
				flag_aadhar_card = true;
				setSuccessMsg(aadhar_card);
			}

			if (pan_card.value === '') {
				flag_pan_card = false;
				setErrorMsg(pan_card, '<i class="fa-solid fa-circle-xmark"></i> PAN card is required.');
			} else {
				flag_pan_card = true;
				setSuccessMsg(pan_card);
			}

			if (document.querySelector('#seller_type').value !== 'Street Merchant') {
				if (business_proof.value === '') {
					flag_business_proof = false;
					setErrorMsg(business_proof, '<i class="fa-solid fa-circle-xmark"></i> Business proof is required.');
				} else {
					flag_business_proof = true;
					setSuccessMsg(pan_card);
				}
			} else {
				flag_business_proof = true;
			}

			if (flag_aadhar_card == true && flag_pan_card == true && flag_seller_logo == true && flag_business_proof == true) {
				return true;
			} else {
				return false;
			}
		}
		
		/*,refer_codes,selectstate,selectcity,pincode,no_of_products,phone,emails,password
								aadhar_card,pan_card,seller_logo,business_proof*/

		$("#formoid").submit(function(event) {
			//showloader();
			event.preventDefault();
			//if (validateDocForm()) {
				var seller_name = $('#seller_name').val();
				var business_name = $('#business_name').val();
				var website = $('#website').val();
				var business_address = $('textarea#business_address').val();
				var business_details = $('textarea#business_details').val();
				var tax_number = $('#tax_number').val();;
				var seller_type = $('#seller_type').val();;
				var pan_number = $('#pan_number').val();
				var selectcountry = 1;
				var selectstate = $('#selectstate').val();
				var selectcity = $('#selectcity').val();
				var pincode = $('#pincode').val();
				var no_of_products = $('#no_of_products').val();
				var phone = $('#phone').val();
				var email = $('#emails').val();
				var passwords = $('#password').val();
				var plan_id = $('#selectplan').val();
				var plan_id1 = $('#selectplan1').val();
				var refer_code = $('#refer_codes').val();

				var seller_logo = $('#seller_logo').prop('files')[0];
				var pan_card = $('#pan_card').prop('files')[0];
				var aadhar_card = $('#aadhar_card').prop('files')[0];
				var business_proof = $('#business_proof').prop('files')[0];
				// console.log(aadhar_card);
				// var seller_logo = '';
				// var pan_card = '';
				// var aadhar_card = '';
				// var business_proof = '';
				// var logo = '';

				var form_data = new FormData();
				form_data.append('seller_name', seller_name);
				form_data.append('business_name', business_name);
				form_data.append('website', website);
				form_data.append('business_address', business_address);
				form_data.append('business_details', business_details);
				form_data.append('seller_type', seller_type);
				form_data.append('tax_number', tax_number);
				form_data.append('pan_number', pan_number);
				form_data.append('selectcountry', selectcountry);
				form_data.append('selectstate', selectstate);
				form_data.append('selectcity', selectcity);
				form_data.append('pincode', pincode);
				form_data.append('no_of_products', no_of_products);
				form_data.append('phone', phone);
				form_data.append('email', email);
				form_data.append('passwords', passwords);
				form_data.append('seller_logo', seller_logo);
				form_data.append('pan_card', pan_card);
				form_data.append('aadhar_card', aadhar_card);
				form_data.append('business_proof', business_proof);
				form_data.append('plan_id', plan_id);
				form_data.append('plan_id1', plan_id1);
				form_data.append('refer_code', refer_code);
				form_data.append([csrfName], csrfHash);
				
				var plan_value = 0;
				$('#selectplan option').each(function() {
					if (this.selected)
					  plan_value = $('#selectplan option:selected').data('plan_value');
					 else
					   plan_value = $('#selectplan1 option:selected').data('plan_value');
				});
				
				//var amount = response.Information.payable_amount_value - $('#default_discount').text();
				/*if($('#selectplan option:selected').data('plan_value') == '' || $('#selectplan option:selected').data('plan_value') == null)
				{
					plan_value = $('#selectplan1 option:selected').data('plan_value');
				}
				else
				{
					plan_value = $('#selectplan option:selected').data('plan_value');
				}*/
				
				form_data.append('plan_value', plan_value);
				var plan_value = $("#plan_price").val(); 

				var amount = plan_value;

if(amount == 0){

$.ajax({
method: 'post',
url: site_url + 'add_seller',
cache: false,
contentType: false,
processData: false,
data: form_data,
success: function(response) {
window.location.href = site_url + 'thankyou_seller';
}
});
return ;
}




							var options = {
								key: 'rzp_live_oVzpJnJRDQttrF',
								amount: amount * 100, // Amount in paise
								currency: 'INR',
								name: 'Bznesshub',
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
											method: 'post',
											url: site_url + 'add_seller',
											cache: false,
											contentType: false,
											processData: false,
											data: form_data,

											success: function(response) {
												//hideloader();
												//alert(response);
												//location.reload();
												//Swal.fire({
												// position: "center",
												//icon: "success",
												// title: response,
												//showConfirmButton: false,
												//confirmButtonColor: '#ff5400',
												//timer: 1000
												// })
												// setTimeout(function(){
												//thankyouseller.php
												// window.location = site_url + "thankyouseller";
												//location.reload();
												//}, 3000);
											//	hideloader();

												window.location.href = site_url + 'thankyou_seller';

												/*Swal.fire({

													position: "center",

													//icon: "success",

													title: 'Add Seller Successfully',

													showConfirmButton: false,

													confirmButtonColor: '#ff5400',

													timer: 3000

												})

												setTimeout(function() {

													window.location.href = site_url + 'thankyou_seller';

												}, 2000);*/

											}
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
				
				
				
				

				
			//}
		});
	</script>
</body>

</html>