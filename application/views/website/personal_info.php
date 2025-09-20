<!DOCTYPE html>
<html lang="en">

<head>
	<?php $title = "Personal Information";
	include("include/headTag.php") ?>
</head>

<body>

	<?php
	include("include/topbar.php")
	?>
	<?php
	include("include/navbar.php")
	?>

	<main class="personal-info new-address my-order-page cart-page">

		<!--Start: Personal Information Section -->
		<section>
			<div class="container" style="max-width:1344px;">
				<div class="row">
					<?php
					include("include/sidebar.php");
					?>
					<div class="col-lg-8">
						<div class="left-block box-shadow" id="MyProfile">
							<h5 class="title">Personal Information <span class="d-lg-none"><a class="accordion-button collapsed" id="heading1" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">My Profile</a></span></h5>

							<?php
							include("include/mobile_sidebar.php");
							?>

							<form class="form row g-3 m-0" action="add_user_details"  method="POST">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								<div class="col-md-12 px-0">
									<label class="form-label">Name </label>
									<input type="text" class="form-control" placeholder="Name" value="<?php echo $this->session->userdata("user_name") ?>" disabled />
								</div>
								<div class="col-md-12 px-0">
									<label class="form-label">Email Address</label>
									<input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $this->session->userdata("user_email") ?>" />
								</div>
								<div class="col-md-12 px-0">
									<label class="form-label">Phone no</label>
									<input type="text" class="form-control" placeholder="Phone no" value="+91-<?php echo $this->session->userdata("user_phone") ?>" disabled />
								</div>
								<div class="form-group d-flex-center">
                                    <button class="btn btn-primary btn-lg w-25" id="save" type="submit">Save</button>
                                </div>
							</form>

							<div class="add_bank_detail mt-5">
								<div class="card px-0">
									<div class="card-header">
										<h5 class="text-center">
											Add your bank Details
										</h5>
									</div>
									<div class="card-body mx-auto">
										<img src="<?php base_url ?>assets_web/images/icons/bank.webp" alt="" class="rounded-circle border"><br>
										<div class="text-center">
											<a href="<?php base_url ?>bank-details" class="btn btn-outline-primary btn-lg mt-5">Add Bank Details</a>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>

				</div>
			</div>
		</section>
		<!--End: Personal Information Section -->

	</main>

	<?php
	include("include/footer.php")
	?>

	<?php
	include("include/script.php")
	?>

</body>

</html>