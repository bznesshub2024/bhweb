<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "Become a Seller";
    include("includes/headTag.php") ?>
</head>

<body>

	<?php
        include("includes/topbar.php")
        ?>
        <?php
        include("includes/navbar.php")
        ?>
	
<main class="become-seller-page">
	
	<!--Start: Become a Seller Section -->
	<section class="become-seller box-shadow">
		<div class="container">
			<div class="row">
				<div class="wrap">
					<h4>Become a Seller</h4>
					<p>Fill all form field to go to next step</p>
				</div>
				<form class="form">
					<!-- progressbar -->
					<ul id="progressbar" class="d-none d-lg-block">
						<li class="active" id="email">Email ID & GST</li>
						<li id="account">Password Creation</li>
						<li id="personal">Personal Info.</li>
						<li id="document">Documents Upload</li>
						<li id="confirm">Finish</li>
					</ul>
					<div class="progress d-lg-none">
						<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
					</div>
					<!-- fieldsets -->
					<fieldset>
						<div class="row g-3">
							<div class="col-7"><h6 class="text-start">Email ID & GST:</h6></div>
							<div class="col-5"><h6 class="text-end">Step 1 - 5</h6></div>
							
							<div class="col-md-6">
								<label class="form-label">Mobile No.:</label>
								<input type="text" class="form-control" placeholder="Mobile No." />
							</div>
							<div class="col-md-6">
								<label class="form-label">Email:</label>
								<input type="email" class="form-control" placeholder="Email Id" />
							</div>
							<div class="col-md-12">
								<label class="form-label">GST:</label>
								<input type="text" class="form-control" placeholder="GST" />
							</div>
							<div class="col-md-6">
								<label class="form-label">Username:</label>
								<input type="text" class="form-control" placeholder="UserName" />
							</div>
							<div class="col-md-6">
								<label class="form-label">Display Name:</label>
								<input type="text" class="form-control" placeholder="Display Name" />
							</div>
						</div>
						<a href="#" class="next btn btn-default">Next</a>
					</fieldset>
					<fieldset>
						<div class="row g-3">
							<div class="col-7"><h6 class="text-start">Password Creation:</h6></div>
							<div class="col-5"><h6 class="text-end">Step 2 - 5</h6></div>
							
							<div class="col-md-12">
								<label class="form-label">Password:</label>
								<input type="password" class="form-control" placeholder="Password" />
							</div>
							<div class="col-md-12">
								<label class="form-label">Confirm Password:</label>
								<input type="password" class="form-control" placeholder="Confirm Password" />
							</div>
						</div>
						<a href="#" class="previous btn btn-secondary">Previous</a>
						<a href="#" class="next btn btn-default">Next</a>
					</fieldset>
					<fieldset>
						<div class="row g-3">
							<div class="col-7"><h6 class="text-start">Personal Information:</h6></div>
							<div class="col-5"><h6 class="text-end">Step 3 - 5</h6></div>
							
							<div class="col-md-12">
								<label class="form-label">Full Name:</label>
								<input type="text" class="form-control" placeholder="Full Name" />
							</div>
							<div class="col-md-6">
								<label class="form-label">PAN Number:</label>
								<input type="text" class="form-control" placeholder="PAN Number" />
							</div>
							<div class="col-md-6">
								<label class="form-label">Aadhar Number:</label>
								<input type="text" class="form-control" placeholder="Aadhar Number" />
							</div>
							<div class="col-md-6">
								<label class="form-label">Business Name:</label>
								<input type="text" class="form-control" placeholder="Business Name" />
							</div>
							<div class="col-md-6">
								<label class="form-label">Pincode:</label>
								<input type="text" class="form-control" placeholder="Pincode" />
							</div>
							<div class="col-md-12">
								<label class="form-label">Full Address:</label>
								<textarea class="form-control" rows="5" placeholder="Full Address"></textarea>
							</div>
						</div>
						<a href="#" class="previous btn btn-secondary">Previous</a>
						<a href="#" class="next btn btn-default">Next</a>
					</fieldset>
					<fieldset>
						<div class="row g-3">
							<div class="col-7"><h6 class="text-start">Documents Upload:</h6></div>
							<div class="col-5"><h6 class="text-end">Step 4 - 5</h6></div>
							
							<div class="col-md-12">
								<label class="form-label">Upload Your Photo:</label>
								<input type="file" class="form-control" />
							</div>
							<div class="col-md-12">
								<label class="form-label">Upload Signature Photo:</label>
								<input type="file" class="form-control" />
							</div>
						</div>
						<a href="#" class="previous btn btn-secondary">Previous</a>
						<a href="#" class="next btn btn-default">Submit</a>
					</fieldset>
					<fieldset>
						<div class="row g-3">
							<div class="col-7"><h6 class="text-start">Finish:</h6></div>
							<div class="col-5"><h6 class="text-end">Step 5 - 5</h6></div>
							<img src="assets/images/icons/thanks-icon.png" class="success-img" />
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
    include("includes/footer.php")
    ?>

    <?php
    include("includes/script.php")
    ?>
	
</body>
	
</html>
