<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "Submit Comment";
    include("includes/headTag.php") ?>
</head>

<body>

	<?php
        include("includes/topbar.php")
        ?>
        <?php
        include("includes/navbar.php")
        ?>
	
<main class="submit-comment product-details-page">
	
	<!--Start: Submit Comment Section -->
	<section>
		<div class="container" style="max-width:1344px;">
			<h5 class="mb-3">Share Your Experience</h5>
			<div class="row">
				<div class="col-lg-3">
					<div class="trending-section mt-0">
						<!--Block-->
						<div class="card">
							<div class="card-img zoom-img">
								<img src="assets/images/featured-img-4.png" class="card-img-top" alt="..." />
								<div class="favorite"><a href="javascript:void(0);"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.08109 12.7492L10.4543 18.7362C10.6465 18.9167 10.7425 19.0069 10.852 19.0412C10.9492 19.0716 11.0534 19.0716 11.1507 19.0412C11.2601 19.0069 11.3561 18.9167 11.5483 18.7362L17.9215 12.7492C19.7147 11.0647 19.9324 8.29271 18.4243 6.34889L18.1407 5.98339C16.3366 3.65802 12.7151 4.048 11.4474 6.70417C11.2683 7.07937 10.7343 7.07937 10.5552 6.70417C9.28748 4.048 5.66605 3.65802 3.86189 5.98339L3.57831 6.34888C2.07017 8.29271 2.28793 11.0647 4.08109 12.7492Z" stroke=""/></svg></a></div>
							</div>
							<div class="card-body">
								<h6>Banasari Saree Blue soft Silk</h6>
								<h6 class="price-off text-danger">37% OFF<h6>
								
								<div class="row">
									<div class="col-6">
										<h6 class="old-price">₹1229</h6>
										<h5 class="new-price">₹749/-</h5>
									</div>
									<div class="col-6">
										<div class="btn-by-now">
											<a href="#" class="btn btn-default w-100">Buy Now</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--/*Block-->
					</div>
				</div>
				<div class="col-lg-9">
					<div class="become-seller box-shadow">
						<form class="form row g-3">
							<div class="col-md-12">
								<label class="form-label">Rate this product</label>
							</div>
							<div class="col-md-12 mt-0">
								<div id="half-stars-example">
								  <div class="rating-group">
									<input class="rating-input rating-input-none" checked name="rating2" id="rating2-0" value="0" type="radio">
									
									<label aria-label="0.5 stars" class="rating-label rating-label-half" for="rating2-05"><i class="rating-icon rating-icon-star fa fa-star-half"></i></label>
									<input class="rating-input" name="rating2" id="rating2-05" value="0.5" type="radio">
									<label aria-label="1 star" class="rating-label" for="rating2-10"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
									<input class="rating-input" name="rating2" id="rating2-10" value="1" type="radio">
									<label aria-label="1.5 stars" class="rating-label rating-label-half" for="rating2-15"><i class="rating-icon rating-icon-star fa fa-star-half"></i></label>
									<input class="rating-input" name="rating2" id="rating2-15" value="1.5" type="radio">
									<label aria-label="2 stars" class="rating-label" for="rating2-20"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
									<input class="rating-input" name="rating2" id="rating2-20" value="2" type="radio">
									<label aria-label="2.5 stars" class="rating-label rating-label-half" for="rating2-25"><i class="rating-icon rating-icon-star fa fa-star-half"></i></label>
									<input class="rating-input" name="rating2" id="rating2-25" value="2.5" type="radio">
									<label aria-label="3 stars" class="rating-label" for="rating2-30"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
									<input class="rating-input" name="rating2" id="rating2-30" value="3" type="radio">
									<label aria-label="3.5 stars" class="rating-label rating-label-half" for="rating2-35"><i class="rating-icon rating-icon-star fa fa-star-half"></i></label>
									<input class="rating-input" name="rating2" id="rating2-35" value="3.5" type="radio">
									<label aria-label="4 stars" class="rating-label" for="rating2-40"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
									<input class="rating-input" name="rating2" id="rating2-40" value="4" type="radio">
									<label aria-label="4.5 stars" class="rating-label rating-label-half" for="rating2-45"><i class="rating-icon rating-icon-star fa fa-star-half"></i></label>
									<input class="rating-input" name="rating2" id="rating2-45" value="4.5" type="radio">
									<label aria-label="5 stars" class="rating-label" for="rating2-50"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
									<input class="rating-input" name="rating2" id="rating2-50" value="5" type="radio">
								  </div>
								</div>
							</div>
							<div class="col-md-12">
								<label class="form-label">Comment</label>
								<textarea class="form-control" rows="5" placeholder="Comments here..."></textarea>
							</div>
							<div class="col-md-12">
								<label class="form-label">Title (optional)</label>
								<input type="text" class="form-control" placeholder="Title" />
							</div>
							<div class="col-md-6">
								<label class="form-label">Name:</label>
								<input type="text" class="form-control" placeholder="Name" />
							</div>
							<div class="col-md-6">
								<label class="form-label">Email Id:</label>
								<input type="email" class="form-control" placeholder="Email Id:" />
							</div>
						
							<a href="javascript:void(0);" class="btn btn-default">Submit</a>
						</form>
						
					</div>
				</div>
				
			</div>
			
		</div>
	</section>
	<!--End: Submit Comment Section -->

</main>

 <?php
    include("includes/footer.php")
    ?>

    <?php
    include("includes/script.php")
    ?>
	
</body>
	
</html>
