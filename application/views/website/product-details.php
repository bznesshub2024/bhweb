<?php
/*function hexToRgb($hex)
{
	// Remove the "#" symbol
	$hex = str_replace("#", "", $hex);

	// Convert to RGB
	$r = hexdec(substr($hex, 0, 2));
	$g = hexdec(substr($hex, 2, 2));
	$b = hexdec(substr($hex, 4, 2));

	return array("r" => $r, "g" => $g, "b" => $b);
}*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php $title = "Product Details";

	include("include/headTag.php");
	$main_url_img = str_replace("-430-590", '', $productdetails['imgurl']);
	?>


	<!-- For Harabara Bold Font Style -->
	<link href="https://www.dafontfree.net/embed/aGFyYWJhcmEtYm9sZCZkYXRhLzI5L2gvMTUyMjg3L0hhcmFiYXJhLnR0Zg" rel="stylesheet" type="text/css" />

	<?php if ($productdetails['meta_title'] != '') { ?>
		<meta property="og:title" content="<?= $productdetails['meta_title']; ?>" />
	<?php } else { ?>
		<meta property="og:title" content="<?= $productdetails['name']; ?>" />
	<?php } ?>
	<meta property="og:image" content="<?= weburl . 'media/' . $main_url_img; ?>" />
	<meta property="og:site_name" content="Bussinesshub" />

	<?php if ($productdetails['meta_key'] != '') { ?>
		<meta property="og:keywords" content="<?= $productdetails['meta_key']; ?>" />
	<?php } ?>


	<?php if ($productdetails['meta_value'] != '') { ?>
		<meta property="og:description" content="<?= $productdetails['meta_value']; ?>" />
	<?php } else { ?>
		<meta property="og:description" content="<?= strip_tags($productdetails['short_desc']); ?>" />
	<?php } ?>

</head>

<style>
	body {
		font-family: var(--mr-body-font-family);
	}

	label.Color {
		height: 30px;
		width: 30px;
		border-radius: 50%;
		margin: 6px;
	}

	label.btn-outline-primary.Color {
		border: none;
	}

	.btn-check:checked+.btn-outline-primary.Color {
		border: 2px solid #f42525 !important;
		padding: 0;
	}

	label.btn.btn-outline-primary {
		margin: 6px;
		border-radius: 35px;
	}

	.btn-check:checked+.btn {
		color: #fff;
	}

	.slider-trending .slick-prev {
		margin-left: 3.6%;
	}

	.slider-trending .slick-next {
		margin-right: 3.6%;
	}

	.modal-dialog-scrollable .modal-content {
		max-height: 87%;
	}

	img.outof_stock {
		position: absolute;
		z-index: 1;
		margin-left: -6px;
		margin-top: -6px;
	}

	@media (max-width: 767px) {
		#cart_btns {
			display: none;
		}

		#check_pincode {
			width: 78%;
		}

		.product-details-page .btn-wrap#btn-mb0 {
			position: sticky;
			bottom: 0;
			padding: 8px 12px;
			background-color: #fff;
			border-radius: 3px 3px 0px 0px !important;
			/* margin: 0 8px; */
			box-shadow: 0 -2px 10px rgba(0, 0, 0, .1);
		}

		.image-container {
			position: relative;
			#isplay: inline-block;
		}

		.mobile_add_to_cart_box {
			width: 70% !important
		}

		.print-button {
			position: absolute;
			top: 10px;
			/* Adjust the top positioning as per your preference */
			right: 10px;
			/* Adjust the right positioning as per your preference */
		}

		.print-button button {
			padding: 10px;
			background-color: #fff;
			border: 1px solid #000;
		}
	}

	#cart_btns1 {
		width: 100%;
	}

	.hover_review {
		position: relative;
		border: none;
		background: transparent;
		text-decoration: none;
		cursor: pointer;
	}

	.hover_review::before {
		content: '';
		position: absolute;
		left: 0;
		bottom: -2px;
		width: 100%;
		height: 2px;
		background-color: #ff6600;
		transform: scaleX(0);
		transition: transform 0.2s ease-in-out;
	}

	.hover_review:hover::before {
		transform: scaleX(1);
		color: #ff6600;
	}

	.offcanvas-body {
		background-color: #fff8f3;
	}

	.cart_checkout_div {
		position: fixed;
		bottom: 0;
		right: 0;
		width: 35%;
		background-color: #fde3d0;
		padding: 20px;
	}

	.cart_checkout_btn {
		font-size: 16px;
		display: block;
		padding: 0px, 4px, 0px, 4px;
		transition: transform 0.3s ease-in;
	}

	.cart_checkout_btn:hover {
		color: white;
		font-weight: bold;
		transform: scale(1.1);
	}

	.font-weight-bold {
		font-weight: bold;
	}

	.font_size_bill {
		font-size: 20px;
	}

	.hr_total_bill {
		background-color: black;
		height: 2px;
	}


	#circle_attr {
		margin-top: 3px;
		width: 18px;
		height: 18px;
		border-radius: 50%;
		background-color: red;
		display: inline-block;
	}

	.mobile_buy_cart_btn {
		display: none;
	}

	@media (max-width: 575px) {
		.ratings_alignment {
			margin-left: 0.50rem;
		}

		.mobile_add_to_cart_box {
			width: 70% !important;
			top: 50px !important;
		}
	}

	@media (max-width: 770px) {
		/* .ratings_alignment {
			margin-left: 0.50rem;
		} */

		.mobile_buy_cart_btn {
			display: block;
		}
	}

	@media (max-width: 970px) and (min-width: 768px) {
		.product_desc {
			width: 58%;
		}

		.product_seller {
			width: 40%;
		}
	}


	#offcanvas-loader {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(255, 255, 255, 0.2);
		z-index: 2;
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.offcanvas_qty {
		width: 40px !important;
		height: 40px !important;
		display: flex;
		flex: 0 0 auto !important;
		border-radius: 50% !important;
		padding: 0;
		margin-right: 0px;
		padding-left: 15px;
	}

	.product_cart_bottom_btns {
		font-size: 12px;
	}

	.offcanvas_qty_btn {
		border-radius: 50% !important;
		width: 25px;
		height: 25px;
		position: relative;
		top: 6px;
	}

	.offcanvas_qty_icon {
		position: absolute;
		top: 5px;
		right: 5px;
	}

	.offcanvas_off_price{
		font-size: 14px !important;
	}

	.offcanvas_prod_name{
		color: black;
		font-size: 14px;
	}
	
	@media(max-width: 380px){
		.btn_container_offcanvas{
			display: block !important;
			text-align: center !important;
		}
		
		.buy_now_offcanvas, .add_to_cart_offcanvas{
			width: 90% !important;
			margin: 2px !important;
		}
		
	}
	.modal-backdrop
	{
		z-index : 0;
	}
	
	.five-card
	{
		width : 20%;
	}
	@media (max-width: 1200px) and (min-width: 768) {
		.five-card
		{
			width : 33.33%;
		}
	}

	@media screen and (max-width: 767px) {
		.five-card
		{
			width : 50%;
		}
	}

</style>


<body class="prod_details">
	<?php
	include("include/loader.php")
	?>
	<?php
	include("include/topbar.php");
	?>


	<!-- <?php
			// include("include/navbar.php")
			?> -->
	<div class="" style="position: sticky; top: 0; z-index: 999;">
		<?php
		include("include/navbar.php")
		?>
	</div>
	<?php
	// include("include/navForMobile.php")
	//print_r($productdetails);
	?>
	<main class="product-details-page">
		<?php $url = base_url . $_SERVER['REQUEST_URI'];
		$share_url = urldecode($url);

		/*print_r($product_review_total);*/
		$rating_count = 0;
		$rating_star = 0;
		foreach ($product_review as $riview) {
			$rating_star += $riview->rating;
			$rating_count++;
		}
		// $total_rating = $rating_star / $rating_count;
		?>
		<?php
		$ytarray = explode("/", $productdetails['youtube_url']);
		$ytendstring = end($ytarray);
		$ytendarray = explode("?v=", $ytendstring);
		$ytendstring = end($ytendarray);
		$ytendarray = explode("&", $ytendstring);
		$ytcode = $ytendarray[0];
		$thumbURL = 'http://img.youtube.com/vi/' . $ytcode . '/0.jpg';
		?>

		<div class="modal fade px-0" id="staticBackdrop" data-bs-backdrop="true" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-body p-0">
						<div class="ratio ratio-16x9">

							<video src="<?= weburl . 'media/' . $productdetails['youtube_url']; ?>" type="video/mp4" frameborder="0" allowfullscreen controls loop></video>

						</div>
					</div>
				</div>
			</div>
		</div>
		<input type="text" value="<?= $share_url; ?>" name="myInput" id="myInput">
		<input type="text" id="coupon_name" value="<?= $productdetails['coupon_name'] ?>">
		<?php /*<div class="d-flex justify-content-between align-items-center h-100 responsive_nav d-block d-sm-none">
			<div class="nav_inner" ></div>
			<svg class="fa-angle-left ms-3" onclick="history.back(-1)" width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M15.5 19.5 8 12l7.5-7.5" stroke="#303030" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
			</svg>
			<svg class="fa-heart me-3" onclick="add_to_wishlist(event,'<?= $productdetails['id'] ?>','<?= $productdetails['sku'] ?>','<?= $productdetails['vendor_id'] ?>','<?= $this->session->userdata('user_id'); ?>',1,'',2)" width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M12 20S3 14.91 3 8.727c0-1.093.375-2.152 1.06-2.997a4.672 4.672 0 0 1 2.702-1.638 4.639 4.639 0 0 1 3.118.463A4.71 4.71 0 0 1 12 6.909a4.71 4.71 0 0 1 2.12-2.354 4.639 4.639 0 0 1 3.118-.463 4.672 4.672 0 0 1 2.701 1.638A4.756 4.756 0 0 1 21 8.727C21 14.91 12 20 12 20z" stroke="#303030" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
			</svg>
		</div> */ ?>
		<?php //print_r($productdetails); 
		$product_custom_cloth = 0;
		?>

		<!-- Topbar for Mobile -->
		<div class="d-flex justify-content-between align-items-center h-100 responsive_nav d-block d-sm-none">
			<div class="nav_inner"></div>
			<svg class="fa-angle-left ms-3" onclick="history.back(-1)" width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M15.5 19.5 8 12l7.5-7.5" stroke="#303030" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
			</svg>
			<svg class="fa-heart me-3" onclick="add_to_wishlist(event,'<?= $productdetails['id'] ?>','<?= $productdetails['sku'] ?>','<?= $productdetails['vendor_id'] ?>','<?= $this->session->userdata('user_id'); ?>',1,'',2)" width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M12 20S3 14.91 3 8.727c0-1.093.375-2.152 1.06-2.997a4.672 4.672 0 0 1 2.702-1.638 4.639 4.639 0 0 1 3.118.463A4.71 4.71 0 0 1 12 6.909a4.71 4.71 0 0 1 2.12-2.354 4.639 4.639 0 0 1 3.118-.463 4.672 4.672 0 0 1 2.701 1.638A4.756 4.756 0 0 1 21 8.727C21 14.91 12 20 12 20z" stroke="#303030" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
			</svg>
		</div>

		<input type="hidden" name="sku" id="sku" value="<?= $get_sku; ?>">
		<input type="hidden" name="sid" id="sid" value="<?= $get_sid; ?>">
		<input type="hidden" name="pid" value="<?= $get_pid; ?>" id="pid">
		<input type="hidden" name="user_id" value="<?= $this->session->userdata("user_id"); ?>" id="user_id">
		<input type="hidden" name="qoute_id" value="<?= $this->session->userdata("qoute_id"); ?>" id="qoute_id">
		<input type="hidden" name="whats_btn" value="<?= $product_custom_cloth; ?>" id="whats_btn">
		<input type="hidden" name="whatsapp_number" value="<?= whatsapp_number; ?>" id="whatsapp_number">

		<!--Start: Slider Section -->
		<section class="product-slider">
			<div class="container" style="max-width:1416px;">
				<div class="row">
					<!-- For Image -->
					<div class="col-md-4 col-sm-12 product_image">
						<div class="left-block">
							<div class="column small-11 small-centered">
								<?php if ($productdetails['stock_status'] == 'Out of Stock' || $productdetails['stock'] <= 0) { ?>
									<img alt="<?php echo website_name; ?>" class="outof_stock" src="<?= weburl . '/assets/img/out_of_stock.png'; ?>">
								<?php } ?>
								<div class="slider slider-single light-box" id="gallery_view">
									<?php
										$gal_url_img = str_replace("-430-590", '', $productdetails['imgurl']);
										?>
										<a class="spotlight zoom-img0" id="gallarry_img" data-page="false" data-animation="fade" data-control="zoom,fullscreen,close" data-theme="white" data-autohide=false href="<?= weburl . 'media/' . $gal_url_img; ?>">
											<div>
												<img class="img-fluid" alt="<?php echo website_name; ?>" src="<?= weburl . 'media/' . $gal_url_img; ?>">
											</div>
										</a>
									<?php
										if (!empty($productdetails['gallary_img_url'])) {
										foreach ($productdetails['gallary_img_url'] as $gallary) {
											$gal_url = str_replace("-430-590", '', $gallary['url']);
									?>
											<a class="spotlight zoom-img0" id="gallarry_img" data-page="false" data-animation="fade" data-control="zoom,fullscreen,close" data-theme="white" data-autohide=false href="<?= weburl . 'media/' . $gal_url; ?>">
												<div>
													<img class="img-fluid" alt="<?php echo website_name; ?>" src="<?= weburl . 'media/' . $gal_url; ?>">
												</div>
											</a>
										<?php }
									} else { /*
										$gal_url_img = str_replace("-430-590", '', $productdetails['imgurl']);
										?>
										<a class="spotlight zoom-img0" id="gallarry_img" data-page="false" data-animation="fade" data-control="zoom,fullscreen,close" data-theme="white" data-autohide=false href="<?= weburl . 'media/' . $gal_url_img; ?>">
											<div class="image-container">
												<img class="img-fluid" alt="<?php echo website_name; ?>" src="<?= weburl . 'media/' . $gal_url_img; ?>">
												<div class="print-button">
													<p onclick="add_to_wishlist(event,'<?= $productdetails['id'] ?>','<?= $productdetails['sku'] ?>','<?= $productdetails['vendor_id'] ?>','<?= $this->session->userdata('user_id'); ?>',1,'',2)">Add To Wishlist :&nbsp;&nbsp; <i class="fa-regular fa-heart"></i></p>
												</div>
											</div>
										</a>
									<?php */ } ?>
									<?php if ($productdetails['youtube_url'] != '') { ?>
										<div class="carousel-cell light-box-carousel-cell ">
											<video style="height:inherit;width:inherit;" id="product-video" controls>
												<source src="<?= weburl . 'media/' . $productdetails['youtube_url']; ?>" type="video/mp4">
											</video>
											<div class="position-absolute top-0 play-icon" style="
											  width: 100%;
											  height: 100%;
											  opacity: 1;
											  display: flex;
											  align-items: center;
											  justify-content: center;
											  cursor: pointer;
											">
												<!-- <i class="bx bx-play-circle" style="font-size: 4.5rem; opacity: 1"></i> -->
												<i class="fa-solid fa-play" style="font-size: 1.5rem; padding: 12px 16px; border-radius:50%; background-color: #ffffff8b"></i>
											</div>
										</div>
									<?php } ?>
								</div>
								<div class="slider slider-nav">
									<div><img class="img-fluid" alt="<?php echo website_name; ?>" src="<?= weburl . 'media/' . $productdetails['imgurl']; ?>"></div>
									<?php if (!empty($productdetails['gallary_img_url'])) {
										foreach ($productdetails['gallary_img_url'] as $gallary) { ?>
											<div><img class="img-fluid" alt="<?php echo website_name; ?>" src="<?= weburl . 'media/' . $gallary['url']; ?>"></div>
										<?php }
									} else { /* ?>
										<div><img class="img-fluid" alt="<?php echo website_name; ?>" src="<?= weburl . 'media/' . $productdetails['imgurl']; ?>"></div>
									<?php */ } ?>

									<?php if ($productdetails['youtube_url'] != '') { ?>
										<div class=" ">
											<video width="100" height="100">
												<source src="<?= weburl . 'media/' . $productdetails['youtube_url']; ?>" type="video/mp4">
											</video>
											<div class="position-absolute top-0" data-bs-toggle="modal" data-bs-target="#staticBackdrop" style="
												  width: 100px;
												  height: 100px;
												  opacity: 1;
												  display: flex;
												  align-items: center;
												  justify-content: center;
												  cursor: pointer;
												">
												<i class="bx bx-play-circle" style="font-size: 2.5rem; opacity: 1"></i>
											</div>
										</div>
									<?php } ?>
									<span id="product_small_config_img"></span>
									<!--<div><img class="img-fluid" src="assets_web/images/slide2.png"></div>
								<div><img class="img-fluid" src="assets_web/images/slide3.png"></div>
								<div><img class="img-fluid" src="assets_web/images/slide4.png"></div>
								<div><img class="img-fluid" src="assets_web/images/featured-img-1.png"></div>
								<div><img class="img-fluid" src="assets_web/images/featured-img-2.png"></div>-->
								</div>
							</div>
						</div>
					</div>

					<!-- For Description of Product -->
					<div class="col-md-5 col-sm-12 product_desc">
						<div class="right-block mt-4">
							<!-- Name of Product -->
							<div class="d-flex justify-content-between align-items-center">
								<h6 class="product-name"><b><?= $productdetails['name']; ?></b></h6>
								<svg onclick="shareLink('<?= $actual_link ?>')" class="share share_buttoon_desktop" xmlns="http://www.w3.org/2000/svg" width="30" height="" viewBox="0 0 35 32">
									<path d="M25,20a5,5,0,0,0-3.91,1.93l-9.28-4.64A5,5,0,0,0,12,16a5,5,0,0,0-.19-1.29l9.28-4.64A5,5,0,0,0,25,12a5,5,0,1,0-5-5,5,5,0,0,0,.19,1.29l-9.28,4.64A5,5,0,0,0,7,11,5,5,0,0,0,7,21a5,5,0,0,0,3.91-1.93l9.28,4.64A5,5,0,1,0,25,20ZM25,4a3,3,0,1,1-3,3A3,3,0,0,1,25,4ZM7,19a3,3,0,1,1,3-3A3,3,0,0,1,7,19Zm18,9a3,3,0,1,1,3-3A3,3,0,0,1,25,28Z" />
								</svg>
							</div>

							<!-- Rating of Product -->
							<!-- Have to change the content od for loop -->
							<div class="row">
								<div class="col-md-4 col-sm-6 ratings_alignment">
									<div class="rate">
										<div class="rating-details me-2" style="margin:0;">Ratings</div>
										<?php
											$ratingHTML = '';
										if ($product_review_total['total_rating'] > 0) {
											$rating = round(($product_review_total['total_rating'] * 2) / 2,1);
											$wholeNumber = floor($rating);
											$fractionalPart = $rating - $wholeNumber;
											for ($i = 0; $i < $wholeNumber; $i++) {
												$ratingHTML .= '<i class="fa-solid fa-star fa-lg" style="color: #162b75;"></i>';
											}
											if ($fractionalPart >= 0.5) {
												$emptyStars = 5 - $wholeNumber - 1;
												$ratingHTML .= '<i class="fa-solid fa-star-half-stroke fa-lg" style="color: #162b75;"></i>';
											} else {
												$emptyStars = 5 - $wholeNumber;
											}
											
											for ($i = 0; $i < $emptyStars; $i++) {
												$ratingHTML .= '<i class="fa-solid fa-star fa-lg"></i>';
											}
											
										}
										?>
											<div class="">
												<?php echo $ratingHTML; ?>
											</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 ms-0">
									<div class="rate">
										<a href="#review_of_product" class="rating-details hover_review ms-0"><?= $product_review_total['rating_count']; ?> Reviews</a>
									</div>
								</div>
							</div>

							<!-- Price of Product -->
							<div class="rate">
								<h5><span id="product-price"><?= $productdetails['price']; ?></span></h5>
								<span class="text-muted">&nbsp;&nbsp;MRP</span>
								<div class="old-price"><span id="mrp"><?= $productdetails['mrp']; ?></span></div>
								<?php if ($productdetails['totaloff'] != 0) { ?>
									<div class="off-price">( <?= $productdetails['offpercent']; ?> OFF ) </div>
								<?php } ?>
							</div>

							<!-- Coupon Code for Product -->
							<?php if ($productdetails['coupon_name'] != '') { ?>
								<div class="available-offer">
									<h6>Available Offers</h6>
									<div class="rate justify-content-between justify-content-sm-start">
										<div class="d-flex align-items-center">
											<svg class="me-4" width="24" height="24" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="#000000">
												<path fill-rule="evenodd" clip-rule="evenodd" d="M13.2 2H8.017l-.353.146L1 8.81v.707L6.183 14.7h.707l2.215-2.215A4.48 4.48 0 0 0 15.65 9c.027-.166.044-.332.051-.5a4.505 4.505 0 0 0-2-3.74V2.5l-.5-.5zm-.5 2.259A4.504 4.504 0 0 0 11.2 4a.5.5 0 1 0 0 1 3.5 3.5 0 0 1 1.5.338v2.138L8.775 11.4a.506.506 0 0 0-.217.217l-2.022 2.022-4.475-4.476L8.224 3H12.7v1.259zm1 1.792a3.5 3.5 0 0 1 1 2.449 3.438 3.438 0 0 1-.051.5 3.487 3.487 0 0 1-4.793 2.735l3.698-3.698.146-.354V6.051z" />
											</svg>
											<div class="d-flex flex-column me-5">
												<h5 style="font-size:1.00625rem !important;font-weight:400 !important;"><?= $productdetails['coupon_name'] ?></h5>
												<div class="pt-2 pb-0"><?= $productdetails['coupon_description']; ?></div>
												<div class="pt-0" style="font-size: 0.725rem;">Valid till <span class="text-primary"><?= date('d M Y', strtotime($productdetails['coupon_todate'])); ?></span>
													<?php if ($productdetails['coupon_terms'] == '') { ?>
														<a style="text-decoration:none;color:#0000EE;" href="#" data-bs-toggle="modal" data-bs-target="#couponpolicyModal">T&C</a>
													<?php } ?>
												</div>
											</div>
										</div>
										<svg class="" onclick="copy_vendor_coupon()" style="cursor:pointer;" width="20" height="20" viewBox="-11 0 173 173" fill="none" xmlns="http://www.w3.org/2000/svg">
											<g clip-path="url(#clip0)">
												<path d="M30.9231 153.398C25.9082 153.062 21.2595 152.78 16.6153 152.431C13.3686 152.186 10.2997 151.464 7.57825 149.459C3.00684 146.09 1.56856 141.264 1.45752 136.007C1.29453 128.332 1.3601 120.646 1.56139 112.971C1.76659 105.186 2.08738 97.3959 2.65361 89.6298C3.85945 73.0868 4.37958 56.5257 4.83867 39.947C5.16774 31.9356 6.64051 24.0128 9.21208 16.4196C11.3588 9.78579 15.6757 5.67804 22.6329 4.53533C24.2764 4.26477 25.9218 3.95521 27.579 3.81993C50.8387 1.97287 74.0726 -0.472549 97.4629 0.405459C102.453 0.593417 107.451 0.999201 112.406 1.62356C118.56 2.39881 121.757 5.86334 121.976 12.0576C122.154 17.1357 121.886 22.2301 121.81 27.7778C122.815 27.7778 124.008 27.6887 125.186 27.7947C128.943 28.1322 132.725 28.3527 136.439 28.9654C142.402 29.9513 146.049 33.544 147.63 39.4325C148.915 44.4993 149.683 49.6836 149.923 54.9056C150.962 71.9558 149.786 88.9202 148.223 105.895C147.611 112.529 147.573 119.228 147.435 125.902C147.297 132.576 147.5 139.263 147.258 145.933C147.13 149.71 146.673 153.467 145.891 157.163C144.143 165.312 138.661 170.196 130.151 171.171C124.199 171.921 118.213 172.362 112.215 172.494C94.7719 172.676 77.3226 172.758 59.8815 172.485C54.1516 172.396 48.3809 171.399 42.7387 170.278C36.1316 168.965 32.0471 163.932 31.3101 157.17C31.1769 155.969 31.0621 154.766 30.9231 153.398ZM42.1303 105.059H41.7043C41.4796 112.397 41.2545 119.735 41.029 127.073C40.7536 135.633 40.44 144.191 40.1932 152.752C40.1523 154.189 40.3926 155.633 40.4588 157.076C40.5887 159.93 42.1549 161.708 44.8231 162.227C49.3899 163.117 53.9848 164.166 58.6069 164.406C68.2512 164.906 77.9245 165.201 87.5784 165.067C99.5655 164.9 111.549 164.269 123.526 163.708C126.073 163.54 128.597 163.116 131.059 162.443C134.088 161.671 136.161 159.649 136.683 156.506C137.389 152.801 137.843 149.051 138.043 145.284C138.262 137.614 138.034 129.932 138.177 122.261C138.285 116.482 138.437 110.684 139.001 104.936C140.466 89.9771 141.451 75.0022 140.733 59.9668C140.468 54.4224 140.112 48.8753 138.642 43.4636C137.98 41.0305 136.759 39.5275 134.086 39.4781C127.658 39.359 121.224 38.9747 114.801 39.0996C103.697 39.3149 92.6057 39.8527 81.5077 40.2214C73.6252 40.4816 65.7382 40.6117 57.8595 40.9538C54.3244 41.1072 50.7127 41.2972 47.4906 43.0057C46.3829 43.591 44.8608 44.551 44.69 45.5422C44.2323 48.6629 43.4542 51.7279 42.3679 54.6885C42.1903 55.4482 42.1426 56.2326 42.227 57.0083C42.1861 59.5663 42.1374 62.1248 42.1355 64.6827C42.1259 78.1396 42.1242 91.5985 42.1303 105.059ZM30.7977 143.928C30.923 141.672 31.0432 139.9 31.1166 138.126C31.4936 129.01 31.8649 119.894 32.2303 110.777C32.8101 96.6584 33.3426 82.5381 33.9984 68.4236C34.4114 59.539 34.6984 50.6261 36.6036 41.8935C36.9547 40.4047 37.6251 39.0103 38.5686 37.8072C41.2356 34.4555 45.0749 32.2443 49.3088 31.6215C54.8914 30.6969 60.5238 30.1038 66.1765 29.8454C80.6044 29.169 95.044 28.7541 109.478 28.2195C110.341 28.1876 111.198 28.0243 112.384 27.8851C112.736 22.5832 112.797 17.4317 111.688 11.8788C106.128 11.5341 100.604 11.0605 95.0706 10.8706C73.5895 10.1324 52.229 12.3483 30.8335 13.6744C28.2958 13.8311 25.788 14.4314 23.2555 14.7325C20.3237 15.0818 18.7822 16.8625 17.9277 19.5213C15.7651 26.07 14.4364 32.8659 13.9731 39.748C13.0069 55.9592 12.0153 72.1737 11.4237 88.4019C10.8802 103.295 10.8166 118.213 10.6257 133.121C10.656 135.122 10.8955 137.114 11.34 139.066C11.8549 141.637 13.2809 142.885 15.9147 143.141C19.34 143.474 22.7764 143.702 26.2114 143.913C27.6257 144.003 29.0516 143.928 30.7977 143.928Z" fill="#000000" />
											</g>
											<defs>
												<clipPath id="clip0">
													<rect width="150" height="173" fill="white" transform="translate(0.777344)" />
												</clipPath>
											</defs>
										</svg>
									</div>
								</div>
							<?php } ?>

							<!-- Short Description of Product -->
							<p class="product_details_short_desc"><?= $productdetails['short_desc']; ?></p>

							<h6 class="deliver-time">Deliver in 5-7 Business Days</h6>

							<!-- Description of produc that is color and size -->
							<div class="pDetails">
								<div class="product-size mb-4 mb-lg-4">
									<input type="hidden" name="attribute_data" value="<?= json_encode($productdetails['configure_attr']); ?>">
									<?php
									foreach ($productdetails['configure_attr'] as $p_weight) {

										if (!empty($p_weight['item'])) { ?>
											<span class="fw-bold"><?= $p_weight['attr_name']; ?></span>
										<?php  } ?>
										<?php $symbols = array(' ', ',', '.', '!', '@', '#', '$', '%', '&', '*', '+', '-', '/'); ?>
										<div class="p-size">
											<input type="hidden" name="<?= str_replace([' ', ',', '.', '!', '@', '#', '$', '%', '^', '&', '+', '/', '*', '(', ')'], '_', $p_weight['attr_name']); ?>_attr_name" id="<?= str_replace([' ', ',', '.', '!', '@', '#', '$', '%', '^', '&', '+', '/', '*', '(', ')'], '_', $p_weight['attr_name']); ?>_attr_name" value="<?= $p_weight['attr_name']; ?>">
											<input type="checkbox" style="display:none" name="<?= str_replace([' ', ',', '.', '!', '@', '#', '$', '%', '^', '&', '+', '/', '*', '(', ')'], '_', $p_weight['attr_name']); ?>_attr_id" id="<?= str_replace([' ', ',', '.', '!', '@', '#', '$', '%', '^', '&', '+', '/', '*', '(', ')'], '_', $p_weight['attr_name']); ?>_attr_id" class="product_attributes" value="<?= $p_weight['attr_id']; ?>">
											<?php
											//foreach ($productdetails['configure_attr'] as $p_weight) {
											if (empty($p_weight['item'])) {
											} else {
												foreach ($p_weight['item'] as $product_weight) {
											?>
													<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
														<input type="radio" onclick="get_product_attributes('<?= $p_weight['attr_name']; ?>')" class="btn-check attribute-values" attribute-label="<?= str_replace([' ', ',', '.', '!', '@', '#', '$', '%', '^', '&', '+', '/', '*', '(', ')'], '_', $p_weight['attr_name']); ?>" name="btnradio_<?= $p_weight['attr_name']; ?>" id="<?= $product_weight['itemvalue']; ?>" value="<?= $product_weight['itemvalue']; ?>" autocomplete="off">
														<label <?php if ($p_weight['attr_name'] == 'Color') {
																	$rgb = hexToRgb($product_weight['itemvalue']);
																	$dark_color = "rgb(" . $rgb['r'] * 0.8 . "," . $rgb['g'] * 0.8 . ',' . $rgb['b'] * 0.8 . ")";
																	echo 'style="background-color:' . $product_weight['itemvalue'] . '; border: 1px solid ' . $dark_color . '"';
																} ?> class="<?= $p_weight['attr_name']; ?> btn btn-outline-primary " for="<?= $product_weight['itemvalue']; ?>">
															<?php if ($p_weight['attr_name'] != 'Color') {
																echo $product_weight['itemvalue'];
															} ?></label>
													</div>
											<?php }
											} ?>
										</div>
									<?php

									}  ?>
								</div>
							</div>
							<p class="fs-4" id="prod_stock" style="color:green; font-weight:bold;"><?php echo $productdetails['stock']; ?> In stock</p>
							<div id="cart_btns" class="mb-5"></div>

							<!-- Add to Cart and By now and Whatsapp Buttons -->
							<div class="btn-wrap pBtns mb-5">
								<?php if ($productdetails['stock'] != '0' && $productdetails['stock_status'] != 'Out of Stock') { ?>
									
									<div class="row">
										<div class="col-md-12 col-lg-12">
											<a href="#" onclick="add_to_cart_product_buynow(event,'<?= $productdetails['id'] ?>','<?= $productdetails['sku'] ?>','<?= $productdetails['vendor_id'] ?>','<?= $this->session->userdata('user_id'); ?>',1,'',2,'<?= $this->session->userdata('qoute_id'); ?>')" class="btn btn-default">Buy Now</a>
											<a href="#" onclick="add_to_cart_products(event,'<?= $productdetails['id'] ?>','<?= $productdetails['sku'] ?>','<?= $productdetails['vendor_id'] ?>','<?= $this->session->userdata('user_id'); ?>',1,'',2,'<?= $this->session->userdata('qoute_id'); ?>')" class="btn btn-secondary"> Add to Cart</a>
										</div>
									</div>

								<?php } else { ?>
									<a class="btn btn-default" disabled><?= 'Out of Stock'; ?></a>
								<?php }
								$actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
								?>
							</div>

							<!-- Cart Items Lsit -->
							<div class="offcanvas offcanvas-end w-35 mobile_add_to_cart_box" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
								<div class="offcanvas-header">
									<h3 id="offcanvasRightLabel">Your Bucket</h3>
									<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
								</div>
								<div class="offcanvas-body">
									<div class="row"></div>
								</div>
								<div class="offcanvas-footer"></div>
								<div id="offcanvas-loader">
									<div class="spinner-border text-primary" role="status">
										<span class="visually-hidden">Loading...</span>
									</div>
								</div>
							</div>

							<!-- Add to Wishlist and Share Button for Mobile and Tablet -->
							<div class="mb-3 mobile_share_wishlist fullscreen_icons">
								<div class="col-12">
									<p data-bs-toggle="modal" data-bs-target="#shareModal">
										Click To Share &nbsp;
										<svg class="share ms-3" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 35 32">
											<path d="M25,20a5,5,0,0,0-3.91,1.93l-9.28-4.64A5,5,0,0,0,12,16a5,5,0,0,0-.19-1.29l9.28-4.64A5,5,0,0,0,25,12a5,5,0,1,0-5-5,5,5,0,0,0,.19,1.29l-9.28,4.64A5,5,0,0,0,7,11,5,5,0,0,0,7,21a5,5,0,0,0,3.91-1.93l9.28,4.64A5,5,0,1,0,25,20ZM25,4a3,3,0,1,1-3,3A3,3,0,0,1,25,4ZM7,19a3,3,0,1,1,3-3A3,3,0,0,1,7,19Zm18,9a3,3,0,1,1,3-3A3,3,0,0,1,25,28Z" />
										</svg>
									</p>
									<hr style="margin:2px; height:10px;">
									<p>
										Add to Wishlist
										<a onclick="add_to_wishlist(event,'<?= $productdetails['id'] ?>','<?= $productdetails['sku'] ?>','<?= $productdetails['vendor_id'] ?>','<?= $this->session->userdata('user_id'); ?>',1,'',2)" class="fullscreen_icons">&nbsp;&nbsp; <i class="fa-regular fa-heart"></i></a>
									</p>
								</div>
							</div>

							<!-- Pincode Block -->
							<div>
								<span style="display:none;"><i class="bx bx-map bx-xs"></i> Check For Delivery &nbsp;&nbsp;:&nbsp;&nbsp; </span>
								<br>
								<div class="row" style="display:none;">
									<div class="col-md-7 d-flex">
										<input type="text" name="check_pincode" id="check_pincode" maxlength="6" onkeypress="return AllowOnlyNumbers(event);" class="form-control border border-dark btn-radious" placeholder="Pincode">&nbsp;&nbsp;&nbsp;
										<button class="btn text-light pincodeBtn btn-radious" type="button" name="submit_pincode" onclick="submit_pincode(event)" id="submit_pincode" style="background-color:<?= $theme_color ?>">Check</button>
									</div>
									<div class="col-md-5">

									</div>
								</div>
								<?php
								$user_pincode = 0;
								if (!empty($address['address_details'])) {
									foreach ($address['address_details'] as $add_data) {
										if ($address['defaultaddress'] == $add_data['address_id']) {
											$user_pincode = $add_data['pincode'];
								?>
											<input type="hidden" id="user_pincode" name="user_pincode" value="<?php echo $user_pincode ?>">
									<?php
										}
									}
								} else {
									?>
									<input type="hidden" id="user_pincode" name="user_pincode" value="<?php echo $user_pincode ?>">
								<?php
								}
								?>
							</div>
							<span id="pincode_msg" style="color:green;display:none;"></span>
							<br>

							<!-- Product Details and Reviews -->
							<div class="delivery-reviews mt-3">
								<h4 style="font-weight: bold;">Product Highlights</h4>
								<div class="container ps-0 mx-0">
									<div class="tab-pane fade show active" id="pills-product" role="tabpanel" aria-labelledby="pills-product-tab">
										<div class="mt-3"><?= $productdetails['fulldetail']; ?></div>
										<?php if ($productdetails['return_policy_title'] != '') { ?>
											<div class="return-product">
												<h5>Return Policy</h5><a style="text-decoration:none;" href="return-policy.html" data-bs-toggle="modal" data-bs-target="#policyModal">
													<?= $productdetails['return_policy_title']; ?></a>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- For Coupon Code and Seller Details-->
					<div class="col-md-3 col-sm-12 product_seller">
						<!-- Coupon Code -->
						<?php if ($productdetails['coupon_name'] != '') { ?>
							<div class="col-md-12 col-xl-12">
								<div class="card shadow">
									<!-- Card header -->
									<div class="card-header border-bottom">
										<div class="cardt-title my-2">
											<h5 class="mb-0" style="font-weight: bold;">Offer &amp; Discount</h5>
										</div>
									</div>
									<!-- Card body -->
									<div class="card-body">
										<div class="rate justify-content-between justify-content-sm-start">
											<div class="d-flex align-items-center">
												<div class="d-flex flex-column me-5">
													<div class="row">
														<div class="col-md-10">
															<h5 style="font-size:large !important;font-weight:400 !important;"><?= $productdetails['coupon_name'] ?>Coupon Name lorem10</h5>
														</div>
														<div class="col-md-2 pb-0 align-items-end">
															<svg class="" onclick="copy_vendor_coupon()" style="cursor:pointer;" width="20" height="20" viewBox="-11 0 173 173" fill="none" xmlns="http://www.w3.org/2000/svg">
																<g clip-path="url(#clip0)">
																	<path d="M30.9231 153.398C25.9082 153.062 21.2595 152.78 16.6153 152.431C13.3686 152.186 10.2997 151.464 7.57825 149.459C3.00684 146.09 1.56856 141.264 1.45752 136.007C1.29453 128.332 1.3601 120.646 1.56139 112.971C1.76659 105.186 2.08738 97.3959 2.65361 89.6298C3.85945 73.0868 4.37958 56.5257 4.83867 39.947C5.16774 31.9356 6.64051 24.0128 9.21208 16.4196C11.3588 9.78579 15.6757 5.67804 22.6329 4.53533C24.2764 4.26477 25.9218 3.95521 27.579 3.81993C50.8387 1.97287 74.0726 -0.472549 97.4629 0.405459C102.453 0.593417 107.451 0.999201 112.406 1.62356C118.56 2.39881 121.757 5.86334 121.976 12.0576C122.154 17.1357 121.886 22.2301 121.81 27.7778C122.815 27.7778 124.008 27.6887 125.186 27.7947C128.943 28.1322 132.725 28.3527 136.439 28.9654C142.402 29.9513 146.049 33.544 147.63 39.4325C148.915 44.4993 149.683 49.6836 149.923 54.9056C150.962 71.9558 149.786 88.9202 148.223 105.895C147.611 112.529 147.573 119.228 147.435 125.902C147.297 132.576 147.5 139.263 147.258 145.933C147.13 149.71 146.673 153.467 145.891 157.163C144.143 165.312 138.661 170.196 130.151 171.171C124.199 171.921 118.213 172.362 112.215 172.494C94.7719 172.676 77.3226 172.758 59.8815 172.485C54.1516 172.396 48.3809 171.399 42.7387 170.278C36.1316 168.965 32.0471 163.932 31.3101 157.17C31.1769 155.969 31.0621 154.766 30.9231 153.398ZM42.1303 105.059H41.7043C41.4796 112.397 41.2545 119.735 41.029 127.073C40.7536 135.633 40.44 144.191 40.1932 152.752C40.1523 154.189 40.3926 155.633 40.4588 157.076C40.5887 159.93 42.1549 161.708 44.8231 162.227C49.3899 163.117 53.9848 164.166 58.6069 164.406C68.2512 164.906 77.9245 165.201 87.5784 165.067C99.5655 164.9 111.549 164.269 123.526 163.708C126.073 163.54 128.597 163.116 131.059 162.443C134.088 161.671 136.161 159.649 136.683 156.506C137.389 152.801 137.843 149.051 138.043 145.284C138.262 137.614 138.034 129.932 138.177 122.261C138.285 116.482 138.437 110.684 139.001 104.936C140.466 89.9771 141.451 75.0022 140.733 59.9668C140.468 54.4224 140.112 48.8753 138.642 43.4636C137.98 41.0305 136.759 39.5275 134.086 39.4781C127.658 39.359 121.224 38.9747 114.801 39.0996C103.697 39.3149 92.6057 39.8527 81.5077 40.2214C73.6252 40.4816 65.7382 40.6117 57.8595 40.9538C54.3244 41.1072 50.7127 41.2972 47.4906 43.0057C46.3829 43.591 44.8608 44.551 44.69 45.5422C44.2323 48.6629 43.4542 51.7279 42.3679 54.6885C42.1903 55.4482 42.1426 56.2326 42.227 57.0083C42.1861 59.5663 42.1374 62.1248 42.1355 64.6827C42.1259 78.1396 42.1242 91.5985 42.1303 105.059ZM30.7977 143.928C30.923 141.672 31.0432 139.9 31.1166 138.126C31.4936 129.01 31.8649 119.894 32.2303 110.777C32.8101 96.6584 33.3426 82.5381 33.9984 68.4236C34.4114 59.539 34.6984 50.6261 36.6036 41.8935C36.9547 40.4047 37.6251 39.0103 38.5686 37.8072C41.2356 34.4555 45.0749 32.2443 49.3088 31.6215C54.8914 30.6969 60.5238 30.1038 66.1765 29.8454C80.6044 29.169 95.044 28.7541 109.478 28.2195C110.341 28.1876 111.198 28.0243 112.384 27.8851C112.736 22.5832 112.797 17.4317 111.688 11.8788C106.128 11.5341 100.604 11.0605 95.0706 10.8706C73.5895 10.1324 52.229 12.3483 30.8335 13.6744C28.2958 13.8311 25.788 14.4314 23.2555 14.7325C20.3237 15.0818 18.7822 16.8625 17.9277 19.5213C15.7651 26.07 14.4364 32.8659 13.9731 39.748C13.0069 55.9592 12.0153 72.1737 11.4237 88.4019C10.8802 103.295 10.8166 118.213 10.6257 133.121C10.656 135.122 10.8955 137.114 11.34 139.066C11.8549 141.637 13.2809 142.885 15.9147 143.141C19.34 143.474 22.7764 143.702 26.2114 143.913C27.6257 144.003 29.0516 143.928 30.7977 143.928Z" fill="#000000" />
																</g>
																<defs>
																	<clipPath id="clip0">
																		<rect width="150" height="173" fill="white" transform="translate(0.777344)" />
																	</clipPath>
																</defs>
															</svg>
														</div>
													</div>
													<div class="pt-2 pb-0" style="text-align: justify;">
														<?= $productdetails['coupon_description']; ?>
													</div>

													<div class="row mt-4">
														<div class="col-md-1">
															<svg class="me-4" width="22" height="22" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="#000000">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M13.2 2H8.017l-.353.146L1 8.81v.707L6.183 14.7h.707l2.215-2.215A4.48 4.48 0 0 0 15.65 9c.027-.166.044-.332.051-.5a4.505 4.505 0 0 0-2-3.74V2.5l-.5-.5zm-.5 2.259A4.504 4.504 0 0 0 11.2 4a.5.5 0 1 0 0 1 3.5 3.5 0 0 1 1.5.338v2.138L8.775 11.4a.506.506 0 0 0-.217.217l-2.022 2.022-4.475-4.476L8.224 3H12.7v1.259zm1 1.792a3.5 3.5 0 0 1 1 2.449 3.438 3.438 0 0 1-.051.5 3.487 3.487 0 0 1-4.793 2.735l3.698-3.698.146-.354V6.051z" />
															</svg>
														</div>
														<div class="col-md-8 ms-2">
															<div class="pt-0" style="font-size: 0.725rem;">Valid till <span class="text-primary"><?= date('d M Y', strtotime($productdetails['coupon_todate'])); ?></span>
																<?php if ($productdetails['coupon_terms'] == '') { ?>
																	<a style="text-decoration:none;color:#0000EE;" href="#" data-bs-toggle="modal" data-bs-target="#couponpolicyModal">T&C</a>
																<?php } ?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>

						<!-- Seller Details -->
						<div class="col-md-12 col-xl-12 mt-4 seller_details pe-0">
							<div class="card seller-details-card">
								<!-- Card body -->
								<div class="card-body p-0">
									<div class=" justify-content-between justify-content-sm-start p-1">
										<div class="d-flex row align-items-center">
											<div class="col-4">
												<div class="d-flex-center">
													<?php 
													if($productdetails['seller_logo'] == '')
													{

														$seller_logo = weburl . 'img/seller_icons.png';
													}
													else
													{
														$seller_logo = weburl . 'media/' . $productdetails['seller_logo'];
													}
														?>
												
													<img src="<?= $seller_logo ?>" class="seller_logo_pd">
												</div>
												<!-- <h5 class="product_detail_headings"><?= $productdetails['seller_name'] ?></h5> -->
												<!-- <span>Verified Seller</span>
												<svg height="13px" width="13px" aria-hidden="true" class="Svg-sc-ytk21e-0 esyykA b0NcxAbHvRbqgs2S8QDg mx-0" viewBox="0 0 24 24" data-encore-id="icon" fill="#ff6600" style="margin-top:-10px;">
													<path d="M10.814.5a1.658 1.658 0 0 1 2.372 0l2.512 2.572 3.595-.043a1.658 1.658 0 0 1 1.678 1.678l-.043 3.595 2.572 2.512c.667.65.667 1.722 0 2.372l-2.572 2.512.043 3.595a1.658 1.658 0 0 1-1.678 1.678l-3.595-.043-2.512 2.572a1.658 1.658 0 0 1-2.372 0l-2.512-2.572-3.595.043a1.658 1.658 0 0 1-1.678-1.678l.043-3.595L.5 13.186a1.658 1.658 0 0 1 0-2.372l2.572-2.512-.043-3.595a1.658 1.658 0 0 1 1.678-1.678l3.595.043L10.814.5zm6.584 9.12a1 1 0 0 0-1.414-1.413l-6.011 6.01-1.894-1.893a1 1 0 0 0-1.414 1.414l3.308 3.308 7.425-7.425z"></path>
												</svg> -->
											</div>
											<div class="col-8 p-0">
												<div class="d-flex">
													<div class="col-md-12 p-0">
														<h5 class="product_detail_headings"><?= $productdetails['seller_name'] ?></h5>
														<div class="p-0">
															<span>Verified Seller</span>
															<svg height="13px" width="13px" aria-hidden="true" class="Svg-sc-ytk21e-0 esyykA b0NcxAbHvRbqgs2S8QDg mx-0" viewBox="0 0 24 24" data-encore-id="icon" fill="#ff6600" style="margin-top:-10px;">
																<path d="M10.814.5a1.658 1.658 0 0 1 2.372 0l2.512 2.572 3.595-.043a1.658 1.658 0 0 1 1.678 1.678l-.043 3.595 2.572 2.512c.667.65.667 1.722 0 2.372l-2.572 2.512.043 3.595a1.658 1.658 0 0 1-1.678 1.678l-3.595-.043-2.512 2.572a1.658 1.658 0 0 1-2.372 0l-2.512-2.572-3.595.043a1.658 1.658 0 0 1-1.678-1.678l.043-3.595L.5 13.186a1.658 1.658 0 0 1 0-2.372l2.572-2.512-.043-3.595a1.658 1.658 0 0 1 1.678-1.678l3.595.043L10.814.5zm6.584 9.12a1 1 0 0 0-1.414-1.413l-6.011 6.01-1.894-1.893a1 1 0 0 0-1.414 1.414l3.308 3.308 7.425-7.425z"></path>
															</svg>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<hr style="margin: 5px 0px;">
									<div class="pt-2 pb-0 px-3 product_description_content" style="text-align: justify;">
										<?= $productdetails['seller_description'];?>
									</div>
								</div>
								
							</div>
						</div>
						
						<div class="col-md-12 col-xl-12 mt-4 seller_details pe-0">
							<div class="card seller-details-card">
								<?php  foreach($productdetails['other_seller'] as $other_seller) { ?>
								<div class="card-body p-0 mx-2">
									<div class=" justify-content-between justify-content-sm-start p-1">
										<div class="d-flex row align-items-center">
											<div class="col-md-8">
														<h5 class="product_detail_headings"><?= $other_seller['seller'] ?></h5>
														<div class="p-0">
															<div class="rate">
																<h5><span id="product-price"><?= $other_seller['product_sale_price'] ?></span></h5>
																<div><span id="mrp" class="old-price"><?= $other_seller['product_mrp'] ?></span><span class="text-muted" style="font-size:15px !important">&nbsp;&nbsp;MRP</span></div>
															</div>
															
														</div>
													</div>
											<div class="col-md-4">
												<a href="#" onclick="add_to_cart_products(event,'<?= $productdetails['id'] ?>','<?= $productdetails['sku'] ?>','<?= $other_seller['seller_id'] ?>','<?= $this->session->userdata('user_id'); ?>',1,'',2,'<?= $this->session->userdata('qoute_id'); ?>')" class="btn btn-secondary btn-radious mx-2 w-100">Cart</a>
											</div>
										</div>
									</div>
									<hr style="margin: 5px 0px;">
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--End: Slider Section -->

		<!-- Slider Return Policy Modal -->
		<div class="modal fade" id="policyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
				<div class="modal-content">
					<div class="modal-header border-0 pb-0">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body pt-0 return-policy faq">
						<!--Start: Return Policy Section -->
						<div class="container">
							<div class="header-wrap m-0">
								<h5><span>Return Policy</span></h5>
								<!--<p>(15 days product return policy)</p>-->
							</div>
							<br>

							<div class="wrap">
								<?= $productdetails['return_policy_description']; ?>
							</div>
						</div>
						<!--End: Return Policy Section -->
					</div>
				</div>
			</div>
		</div>
		<!--/*Slider Return Policy Modal -->

		<!-- Vendor Coupon Terms & Conditions -->
		<div class="modal fade" id="couponpolicyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
				<div class="modal-content">
					<div class="modal-header border-0 pb-0">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body pt-0 return-policy faq">
						<!--Start: Return Policy Section -->
						<div class="container">
							<div class="header-wrap m-0">
								<h5><span>Terms & Conditions</span></h5>
								<!--<p>(15 days product return policy)</p>-->
							</div>
							<br>

							<div class="wrap">
								<?php echo $productdetails['coupon_terms'];  ?>
							</div>
						</div>
						<!--End: Return Policy Section -->
					</div>
				</div>
			</div>
		</div>
		<!--/*Vendor Coupon Terms & Conditions -->

		<!-- Slider Add Reviews Modal -->
		<div class="modal fade" id="reviewsModal" tabindex="-1" aria-labelledby="reviewsModal" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
				<div class="modal-content">
					<div class="row">
						<div class="col-9">
							<div class="display-6">
								<h3 class="mt-4 ms-4">Share Your Experience</h3>
							</div>
						</div>
						<div class="col-3">
							<div class="modal-header border-0 pb-0">
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
						</div>
					</div>
					<div class="modal-body submit-comment product-details-page1" style="margin-top: -10px;">
						<!--Start: Submit Comment Section -->
						<section>
							<div class="container" style="max-width:1344px;">
								<div class="row">
									<div class="col-xl-12 p-0">
										<div class="become-seller p-0">
											<form id="review_form" class="form row g-3">
												<div class="col-md-12">
													<label class="form-label">Rate this product</label>
												</div>
												<div class="col-md-12">
													<label class="form-label">Title </label>
													<input type="text" class="form-control" name="reviewtitle" id="reviewtitle" placeholder="Title" />
												</div>
												<div class="col-md-12">
													<label class="form-label">Comment</label>
													<textarea class="form-control" name="ProductReview" id="ProductReview" rows="5" placeholder="Comments here..."></textarea>
												</div>

												<div class="col-md-12 mt-0">
													<br>
													<div id="half-stars-example">
														<div class="rating-group">
															<input class="rating-input rating-input-none" checked name="rating1" id="rating2-0" value="0" type="radio">
															<label aria-label="0.5 stars" class="rating-label rating-label-half" for="rating2-05"><i class="rating-icon rating-icon-star fa fa-star-half"></i></label>
															<input class="rating-input" name="rating1" id="rating2-05" value="0.5" type="radio">
															<label aria-label="1 star" class="rating-label" for="rating2-10"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
															<input class="rating-input" name="rating1" id="rating2-10" value="1" type="radio">
															<label aria-label="1.5 stars" class="rating-label rating-label-half" for="rating2-15"><i class="rating-icon rating-icon-star fa fa-star-half"></i></label>
															<input class="rating-input" name="rating1" id="rating2-15" value="1.5" type="radio">
															<label aria-label="2 stars" class="rating-label" for="rating2-20"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
															<input class="rating-input" name="rating1" id="rating2-20" value="2" type="radio">
															<label aria-label="2.5 stars" class="rating-label rating-label-half" for="rating2-25"><i class="rating-icon rating-icon-star fa fa-star-half"></i></label>
															<input class="rating-input" name="rating1" id="rating2-25" value="2.5" type="radio">
															<label aria-label="3 stars" class="rating-label" for="rating2-30"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
															<input class="rating-input" name="rating1" id="rating2-30" value="3" type="radio">
															<label aria-label="3.5 stars" class="rating-label rating-label-half" for="rating2-35"><i class="rating-icon rating-icon-star fa fa-star-half"></i></label>
															<input class="rating-input" name="rating1" id="rating2-35" value="3.5" type="radio">
															<label aria-label="4 stars" class="rating-label" for="rating2-40"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
															<input class="rating-input" name="rating1" id="rating2-40" value="4" type="radio">
															<label aria-label="4.5 stars" class="rating-label rating-label-half" for="rating2-45"><i class="rating-icon rating-icon-star fa fa-star-half"></i></label>
															<input class="rating-input" name="rating1" id="rating2-45" value="4.5" type="radio">
															<label aria-label="5 stars" class="rating-label" for="rating2-50"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
															<input class="rating-input" name="rating1" id="rating2-50" value="5" type="radio">
														</div>
													</div>
												</div>
												<button class="btn btn-radious" type="submit" style="background-color: #ff6600; color:white">Add Review</button>
											</form>
										</div>
									</div>
								</div>
							</div>
						</section>
						<!--End: Submit Comment Section -->
					</div>
				</div>
			</div>
		</div>
		<!--/*Slider Add Reviews Modal -->

		<!--Trending Section -->
		<section class="trending-section mt-5 ms-1">
			<div class="ms-md-2">
				<?php if (!empty($related_product)) { ?>
					<h4 style="font-size : 20px;">Related Items</h4>
				<?php } ?>
				<div class="slider slider-trending mx-5" id="related_product">

				</div>
			</div>
		</section>
		<!--/*Trending Section -->

		<!--Trending Section -->
		<section class="trending-section mb-5 ms-1 mt-5">
			<div class="ms-md-2">
				<?php if (!empty($upsell_product)) { ?>
					<h4 style="font-size : 20px;">People Who Bought This Also Bought</h4>
				<?php } ?>
				<div class="slider slider-trending1 mx-5" id="upsell_product">

				</div>
			</div>
		</section>
		<!--/*Trending Section -->
		
		<section class="trending-section pt-5 mb-5">
			<div class="container-fluids">
				<div class="row">
					<div class="col-12">
						<h4>Recently View</h4>
					</div>
				</div>
				<div class="slider row row-cols-2 row-cols-md-3 row-cols-xl-5 mx-5">
					<?php $count = 0;
					
					foreach ($recent_product as $recent_product_data) {
						
						$ratingHTML = '';
						if ($recent_product_data['product_total_rating'] > 0) {
							$rating = round(($recent_product_data['product_total_rating'] * 2) / 2,1);
							$wholeNumber = floor($rating);
							$fractionalPart = $rating - $wholeNumber;
							for ($i = 0; $i < $wholeNumber; $i++) {
								$ratingHTML .= '<i class="fa-solid fa-star fa-lg" style="color: #162b75;"></i>';
							}
							if ($fractionalPart >= 0.5) {
								$emptyStars = 5 - $wholeNumber - 1;
								$ratingHTML .= '<i class="fa-solid fa-star-half-stroke fa-lg" style="color: #162b75;"></i>';
							} else {
								$emptyStars = 5 - $wholeNumber;
							}
							
							for ($i = 0; $i < $emptyStars; $i++) {
								$ratingHTML .= '<i class="fa-solid fa-star fa-lg"></i>';
							}
							
						}
						
					?>
							<div class="col p-3">
								<?php if ($recent_product_data['stock_status'] == 'Out of Stock' || $recent_product_data['stock'] <= 0) { ?>
									<img class="outof_stock" alt="<?php echo website_name; ?>" src="<?php echo weburl . '/assets/img/out_of_stock.png'; ?>">
								<?php } ?>
								<a onclick="redirect_to_link('<?php echo base_url .'product/'. $recent_product_data['sku']; ?>')" class="card h-100 d-flex flex-column justify-content-between" id="product_link_card">
									<div>
										<div class="d-flex justify-content-between align-items-center" style="margin-top:-25px;">
											<span class="ribbon3"><span class="text-white"><?php echo $recent_product_data['offpercent']; ?></span></span>
											<span class="wishlist"><i class="fa fa-heart-o"></i></span>
										</div>
										<div class="image-container mt-3 me-5 zoom-img">
											<img src="<?php echo base_url.'media/' .$recent_product_data['imgurl']; ?>" alt="<?php echo $recent_product_data['name']; ?>" class="rounded zoom-img thumbnail-image">
										</div>
										<div class="product-detail-container p-2 mb-3">
											<div class="justify-content-between align-items-center">
												<p class="dress-name fs-5 mb-0 fs-5"><?php echo $recent_product_data['name']; ?></p>
												<div class="d-flex justify-content-start flex-row mt-2" style="width: 100%;">
													<span class="new-price mx-1" style="color: #ff6600;"><?php echo $recent_product_data['price']; ?></span>
													<small class="old-price text-right mx-1" style="color: #ff6600;"><?php echo $recent_product_data['mrp']; ?></small>
												</div>
											</div>
											<div class="d-flex justify-content-between align-items-center pt-1">
												<div>
													<?php echo $ratingHTML; ?>
												</div>
												<button class="text-center card_buy_btn btn-radious" type="button" onclick="add_to_cart_product_buy(event,'<?php echo $recent_product_data['id'] ?>','<?php echo $recent_product_data['sku'] ?>','<?php echo $recent_product_data['vendor_id'] ?>','<?php echo $this->session->userdata('user_id'); ?>',1,'',2,'<?php echo $this->session->userdata('qoute_id'); ?>')">BUY</button>
											</div>
										</div>
									</div>
								</a>
							</div>
					<?php } ?>
				</div>
			</div>
			
			<!-- Review of Product -->
		<?php if (!empty($product_review)) { ?>
			<div class="mt-5 mx-5" id="review_of_product">
				<h4 class="mt-5" style="font-size : 20px;">Reviews for this Product</h4>
				<!--<div class="add-reviews btn-wrap d-block">
					<a href="#" class="btn btn-radious" data-bs-toggle="modal" data-bs-target="#reviewsModal" style="background-color: #ff6600; color:white">Add Reviews</a>
				</div>-->
				<br>

				<?php foreach ($product_review as $riview) { 
				
					$ratingHTML = '';
						if ($riview->rating > 0) {
							$rating = round(($riview->rating * 2) / 2,1);
							$wholeNumber = floor($rating);
							$fractionalPart = $rating - $wholeNumber;
							for ($i = 0; $i < $wholeNumber; $i++) {
								$ratingHTML .= '<i class="fa-solid fa-star fa-lg" style="color: #162b75;"></i>';
							}
							if ($fractionalPart >= 0.5) {
								$emptyStars = 5 - $wholeNumber - 1;
								$ratingHTML .= '<i class="fa-solid fa-star-half-stroke fa-lg" style="color: #162b75;"></i>';
							} else {
								$emptyStars = 5 - $wholeNumber;
							}
							
							for ($i = 0; $i < $emptyStars; $i++) {
								$ratingHTML .= '<i class="fa-solid fa-star fa-lg"></i>';
							}
							
						}
				
				?>
					<div class="review-details mx-5">
						<div class="rate">
							<div class="bg-orange w-100 ms-2 mb-2">
								<?php echo $ratingHTML; ?>
							</div>
							<div class="rating-details ms-2">
								<span><?= $riview->review_title;
								?></span>
								<p><?= $riview->review_comment;
								?></p>
								<span><?= $riview->user_name; ?> | </span>
								<span><?= date('d M Y', strtotime($riview->review_date)); ?></span>
								<hr>
							</div>
								
							
						</div>
						
					</div>
				<?php } ?>
			</div>
		<?php } ?>
			
		</section>

		
		<!-- Slider Modal -->
		<div class="modal fade" id="sliderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-lg">
				<div class="modal-content">
					<div class="modal-header border-0 pb-0">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="text-center">
							<iframe width="100%" height="500" src="https://www.youtube.com/embed/GhRNksWxUSk?autoplay=1&mute=1">
							</iframe>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--/*Slider Modal -->

		<!-- Share Modal -->
		<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header align-items-center" style="border-bottom: 0;">
						<h5 class="mb-0">Share this product on social media platforms</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="d-flex flex-wrap justify-content-center post_social">
							<i onclick="copy_link()" class="fa-solid fa-link fa-3x pe-2" style="color: #ff6600;font-size:2.5rem"></i>
							<a target="_blank" href="http://www.facebook.com/sharer.php?u=<?= $actual_link ?>" title="Facebook Share"><i class="fa-brands fa-square-facebook pe-4" style="font-size: 3rem; color:#ff6600;"></i></a>
							<a target="_blank" href="http://twitter.com/share?text=<?= $productdetails['name']; ?>&amp;url=<?= $actual_link ?>" title="Twitter Share"><i class="fa-brands fa-square-twitter pe-4" style="font-size: 3rem; color:#ff6600;"></i></a>
							<a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=<?= $actual_link ?>" title="LinkedIn Share"><i class="fa-brands fa-linkedin pe-4" style="font-size: 3rem; color:#ff6600;"></i></a>

						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Share Modal -->
		<!-- <div class="btn-wrap btn-mb pBtns0 <?= $product_custom_cloth == 10 ? 'justify-content-end' : '' ?>" id="btn-mb0">
			<div id="cart_btns1"></div>
		</div> -->
	</main>

	<div class="mobile_buy_cart_btn">
		<div class="bg-white d-flex justify-content-center my-2 w-100">
			<div class="btn-mb btn-wrap d-flex py-2 my-1 w-100 pBtns1 <?= $product_custom_cloth == 10 ? 'justify-content-end' : '' ?>" id="btn-mb" style="position: fixed; bottom: 0; background-color: white;">
				<?php if ($productdetails['stock'] != '0' && $productdetails['stock_status'] != 'Out of Stock') { ?>
					<a href="#" onclick="add_to_cart_product_buynow(event,'<?= $productdetails['id'] ?>','<?= $productdetails['sku'] ?>','<?= $productdetails['vendor_id'] ?>','<?= $this->session->userdata('user_id'); ?>',1,'',2,'<?= $this->session->userdata('qoute_id'); ?>')" class="btn btn-default mx-2 w-100">Buy Now</a>
					<a href="#" onclick="add_to_cart_products(event,'<?= $productdetails['id'] ?>','<?= $productdetails['sku'] ?>','<?= $productdetails['vendor_id'] ?>','<?= $this->session->userdata('user_id'); ?>',1,'',2,'<?= $this->session->userdata('qoute_id'); ?>')" class="btn btn-secondary mx-2 w-100">Add to Cart</a>
				<?php } else { ?>
					<a class="btn btn-default" disabled><?= 'Out of Stock'; ?></a>
				<?php } ?>
			</div>
		</div>
	</div>


	<?php
	include("include/footer.php")
	?>

	<?php
	include("include/script.php")
	?>
	<script src="<?= base_url(); ?>assets_web/js/product_details.js"></script>

	<script>
		function shareLink(url) {
			if (navigator.share) {
				navigator.share({
						title: document.title,
						url: url
					})
					.then(() => console.log('Link shared successfully.'))
					.catch((error) => console.log('Error sharing link:', error));
			} else {
				console.log('Sharing not supported on this device.');
			}
		}

		// function to convert hex color to RGB
		function hexToRgb(hex) {
			// remove the "#" symbol
			hex = hex.replace("#", "");

			// convert to RGB
			const r = parseInt(hex.substring(0, 2), 16);
			const g = parseInt(hex.substring(2, 4), 16);
			const b = parseInt(hex.substring(4, 6), 16);

			return {
				r,
				g,
				b
			};
		}

		$(document).ready(function() {
			$('#qty_input').prop('disabled', true);
			$('#plus-btn').click(function() {
				$('#qty_input').val(parseInt($('#qty_input').val()) + 1);
			});
			$('#minus-btn').click(function() {
				$('#qty_input').val(parseInt($('#qty_input').val()) - 1);
				if ($('#qty_input').val() == 0) {
					$('#qty_input').val(1);
				}

			});
		});
	</script>

	<!-- For Cart Delete and Quantity addition and substraction -->
	<script>
		var csrfName = $(".txt_csrfname").attr("name"); //
		var csrfHash = $(".txt_csrfname").val(); // CSRF hash
		var site_url = $(".site_url").val(); // CSRF hash

		function delete_cart(prod_id, user_id, qouteid) {
			$.ajax({
				method: "post",
				url: site_url + "deleteProductCart",
				data: {
					language: default_language,
					pid: prod_id,
					devicetype: 2,
					user_id: user_id,
					qouteid: qouteid,
					[csrfName]: csrfHash,
				},
				success: function(response) {
					//hideloader();
					//$(".table").load(location.href + " .table");
					location.reload();
				},
			});
		}

		function add_product_qty(
			prod_id,
			sku,
			vendor_id,
			user_id,
			qty,
			referid,
			devicetype,
			qouteid
		) {
			$.ajax({
				method: "post",
				url: site_url + "addProductCart",
				data: {
					language: default_language,
					pid: prod_id,
					sku: sku,
					sid: vendor_id,
					user_id: user_id,
					qty: qty,
					referid: referid,
					devicetype: 2,
					qouteid: qouteid,
					[csrfName]: csrfHash,
				},
				success: function(response) {
					//hideloader();
					//$(".table").load(location.href + " .table");
					//alert(response.msg);
					// alert(response.status);
					//location.reload();
					if (response.status == 1) {
						location.reload();
						/*Swal.fire({
							position: "center",
							title: response.msg,
							showConfirmButton: false,
							confirmButtonColor: '#ff5400',
							timer: 3000
						})
						setTimeout(function() {
							location.reload();
						}, 2000);*/
					} else {
						Swal.fire({
							position: "center",
							title: response.msg,
							showConfirmButton: false,
							confirmButtonColor: '#ff5400',
							timer: 3000
						})

					}

				},
			});
		}
	</script>



</body>

</html>