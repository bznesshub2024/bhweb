<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	$title = "Home";
	include("include/headTag.php") ?>

	<style>
		.container-fluid {
			max-width: 97.9% !important;
		}
		#homeTopCategory0 .card {
			border-radius: 50%;
			height: 100px;
			margin: 0 auto;
			overflow: hidden;
			width: 100px;
			object-fit: cover;
		}
		#homeTopCategory0 .round
		{
			width:115px;
		}
		
		/*.five-card
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
		}*/
	</style>

</head>

<body>
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
	include("include/navForMobile.php")
	?>

	<main>
		<input type="hidden" id="user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
		<input type="hidden" id="qoute_id" value="<?php echo $this->session->userdata('qoute_id'); ?>">
		<input type="hidden" name="whatsapp_number" value="<?php echo whatsapp_number; ?>" id="whatsapp_number">
		<section id="homeTopCategoryMobile" class="d-md-none mt-2">
			<div class="container-fluid homeTopCategoryMobileContainer">
				<?php
				foreach ($header_cat as $maincat_top) {
					/*foreach ($home_section5 as $home_section5_data) {

					$img_decode1 = json_decode($home_section5_data->image);
					$img_url = MEDIA_URL . $img_decode1->{'470-720'};*/
				?>
					<div onclick="redirect_to_link('<?php echo base_url .'shop/'. $maincat_top['cat_slug']; ?>')" class="a-homeTopCategoryMobileCard me-2">
						<div class="card">
							<img src="<?php echo 'media/' . $maincat_top['imgurl']; ?>" alt="<?php echo $maincat_top['cat_name']; ?>">
							<div class="card-body p-0">
								<p class="mb-0 mt-2 fs-small fw-semibold mobile_top_cate"><?php echo $maincat_top['cat_name']; ?></p>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</section>

		<section id="heroHomeSlider" class="mt-2 mt-md-0">
			<?php foreach ($header_banner as $section1) { ?>
				<a href="<?php echo $section1->link; ?>">
					<div class="a-slider-hero" style="">
						<img src="<?php echo $section1->image; ?>" class="img-fluid" srcset="" alt="<?php echo website_name; ?>" style="object-fit: cover; width: 100%;">
					</div>
				</a>
			<?php } ?>
		</section>

		<?php
		$section6_image1 = $section6_link1 = '';
		foreach ($home_section6 as $section6) {
			$section6_image1 = $section6->image;
			$section6_link1 = $section6->link;
		}
		if ($section6_link1 != '') {
		?>
			<section id="homeOffers" class="mt-3">
				<div class="container-fluid">
					<div onclick="redirect_to_link('<?php echo $section6_link1; ?>')" class="a-homeOffers" style="">
						<img src="<?php echo $section6_image1; ?>" alt="<?php echo website_name; ?>" srcset="">
					</div>
				</div>
			</section>
		<?php } ?>

		<section id="homeTopCategory0" class="d-md-block mt-3">
			<div class="container-fluid">
				<div class="col-12">
					<h4>Shop Our Top Categories</h4>
				</div>
				<div class="row homeShopCategoryMobileContainer">
					<?php
					foreach ($home_section5 as $home_section5_data) {

						$img_decode1 = json_decode($home_section5_data->image);
						$img_url = MEDIA_URL . $img_decode1->{'470-720'};
					?>
						<div class="round mb-0">
							<a href="<?php echo base_url .'shop/'. $home_section5_data->cat_slug; ?>">
								<div class="card position-relative" style="border: 0.5px solid #ccc;">
									<img src="<?php echo $img_url; ?>" alt="<?php echo $home_section5_data->cat_name; ?>" class="img-fluid">
								</div>
							</a>
							<h5 class="fw-bolder text-center text-dark my-2"><?php echo $home_section5_data->cat_name; ?></h5>
						</div>
					<?php } ?>
					
				</div>
			</div>
		</section>

		<section class="trending-section mb-5 pt-3">
			<div class="container-fluid">
				<h4>Today's Deal</h4>
				<div class="slider slider-trending_New" id="New_products">
				</div>
			</div>
		</section>




		<section class="trending-section mb-5">
			<div class="container-fluid">
				<h4>Top Selling</h4>
				<section id="homeOffers" class="mt-4">
					<div class="container-fluid" style="padding: 0 !important;" id="section4_banner">

					</div>
				</section>
				<div class="slider slider-trending_Popular" id="Popular_products">

				</div>
			</div>
		</section>



		<section class="trending-section mb-5">
			<div class="container-fluid">
				<h4>Trending Products </h4>
				<section id="homeOffers" class="mt-4">
					<div class="container-fluid" style="padding: 0 !important;" id="section10_banner">

					</div>
				</section>
				<div class="slider slider-trending_Recommended" id="Recommended_products">

				</div>
			</div>
		</section>

		<section id="homeMasonry" class="mt-6">
			<div class="container-fluid">
				<div class="a-Masonry" id="home_bottom_banner">


				</div>
			</div>
		</section>



		<section class="trending-section may_like mt-5 mb-5">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<h4>You May Like</h4>
					</div>
				</div>
				<div class="slider slider-trending_Offers" id="Offers_products">

				</div>
			</div>
		</section>




		<section class="trending-section may_like_mob pt-5 mb-5">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<h4>You May Like</h4>
					</div>
				</div>
				<div class="slider may_you_like_mob">
					<?php $count = 0;
					
					foreach ($offers_product as $new_product_data) {
						
						$ratingHTML = '';
						if ($new_product_data['product_total_rating'] > 0) {
							$rating = round(($new_product_data['product_total_rating'] * 2) / 2,1);
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
						
						if ($count < 4) {

					?>
							<div class="p-3">
								<?php if ($new_product_data['stock_status'] == 'Out of Stock' || $new_product_data['stock'] <= 0) { ?>
									<img class="outof_stock" alt="<?php echo website_name; ?>" src="<?php echo weburl . '/assets/img/out_of_stock.png'; ?>">
								<?php } ?>
								<a onclick="redirect_to_link('<?php echo base_url .'product/'. $new_product_data['sku']; ?>')" class="card h-100 d-flex flex-column justify-content-between" id="product_link_card">
									<div>
										<div class="d-flex justify-content-between align-items-center">
											<span class="ribbon3"><span class="text-white"><?php echo $new_product_data['offpercent']; ?></span></span>
											<span class="d-flex justify-content-between align-items-right whishlist_all" onclick="add_to_wishlist(event,'<?php echo $new_product_data['id'] ?>','<?php echo $new_product_data['sku'] ?>','<?php echo $new_product_data['vendor_id'] ?>','<?php echo $this->session->userdata('user_id'); ?>',1,'',2)"><i class="fa-regular fa-heart" <?php if($new_product_data['product_wishlist'] == 0) { ?>style="color: #162b75;" <?php } ?>></i></span>
										</div>
										<div class="image-container mt-3 me-5 zoom-img">
											<img src="<?php echo $new_product_data['imgurl']; ?>" alt="<?php echo $new_product_data['name']; ?>" class="rounded zoom-img thumbnail-image">
										</div>
										<div class="product-detail-container p-2 mb-3">
											<div class="justify-content-between align-items-center">
												<p class="dress-name fs-5 mb-0 fs-5"><?php echo $new_product_data['name']; ?></p>
												<div class="d-flex justify-content-start flex-row mt-2" style="width: 100%;">
													<span class="new-price mx-1" style="color: #ff6600;"><?php echo $new_product_data['price']; ?></span>
													<small class="old-price text-right mx-1" style="color: #ff6600;"><?php echo $new_product_data['mrp']; ?></small>
												</div>
											</div>
											<div class="d-flex justify-content-between align-items-center pt-1">
												<div>
													<?php echo $ratingHTML; ?>
												</div>
												<button class="text-center card_buy_btn btn-radious" type="button" onclick="add_to_cart_product(event,'<?php echo $new_product_data['id'] ?>','<?php echo $new_product_data['sku'] ?>','<?php echo $new_product_data['vendor_id'] ?>','<?php echo $this->session->userdata('user_id'); ?>',1,'',2,'<?php echo $this->session->userdata('qoute_id'); ?>')">Add To Cart</button>
											</div>
										</div>
									</div>
								</a>
							</div>
					<?php $count++;
						}
					} ?>
				</div>
			</div>
		</section>


		<section class="trending-section mb-5">
			<div class="container-fluid">
				<h4>Most Popular</h4>
				<section id="homeOffers" class="mt-4">
					<div class="container-fluid" style="padding: 0 !important;" id="section11_banner">

					</div>
				</section>
				<div class="slider slider-trending_Most" id="Most_products">

				</div>
			</div>
		</section>
		
		<section class="trending-section pt-5 mb-5">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<h4>Recently View</h4>
					</div>
				</div>
				<div class="slider row row-cols-2 row-cols-md-3 row-cols-xl-5">
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
										<div class="d-flex justify-content-between align-items-center">
											<span class="ribbon3"><span class="text-white"><?php echo $recent_product_data['offpercent']; ?></span></span>
											<span class="d-flex justify-content-between align-items-right whishlist_all" onclick="add_to_wishlist(event,'<?php echo $recent_product_data['id'] ?>','<?php echo $recent_product_data['sku'] ?>','<?php echo $recent_product_data['vendor_id'] ?>','<?php echo $this->session->userdata('user_id'); ?>',1,'',2)"><i class="fa-regular fa-heart" <?php if($recent_product_data['product_wishlist'] == 0) { ?>style="color: #162b75;" <?php } ?>></i></span>
										</div>
										<div class="image-container mt-3 me-5 zoom-img">
											<img src="<?php echo 'media/' .$recent_product_data['imgurl']; ?>" alt="<?php echo $recent_product_data['name']; ?>" class="rounded zoom-img thumbnail-image">
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
												<button class="text-center card_buy_btn btn-radious" type="button" onclick="add_to_cart_product(event,'<?php echo $recent_product_data['id'] ?>','<?php echo $recent_product_data['sku'] ?>','<?php echo $recent_product_data['vendor_id'] ?>','<?php echo $this->session->userdata('user_id'); ?>',1,'',2,'<?php echo $this->session->userdata('qoute_id'); ?>')">Add To Cart</button>
											</div>
										</div>
									</div>
								</a>
							</div>
					<?php } ?>
				</div>
			</div>
		</section>



	</main>
	<?php
	include("include/footer.php")
	?>

	<?php
	include("include/script.php")
	?>
	<script src="<?php echo base_url(); ?>assets_web/js/index.js"></script>

	<script>
		document.querySelectorAll('img').forEach(image => {
			image.src = image.src.replace('-610-400', '')
		});
		document.querySelectorAll('img').forEach(image => {
			image.src = image.src.replace('-1930-150', '')
		});
		
		
		
		
	</script>
</body>

</html>