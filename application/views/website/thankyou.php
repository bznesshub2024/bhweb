<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "Thanks You";
    include("include/headTag.php") ?>
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
   // include("include/navForMobile.php")
    ?>
	
<main class="thanks-page product-details-page">
	
	<!--Start: Thanks Section -->
	<section>
		<div class="container">
			<div class="block d-md-none">
				<img src="<?php echo base_url; ?>assets_web/images/icons/thanks-icon.png" alt="" class="thanks-img" />
				<h5>Your Order has been placed  Successfully.</h5>
			</div>
			<div class="wrap box-shadow">
				<div class="block d-none d-md-block">
					<img src="<?php echo base_url; ?>assets_web/images/icons/thanks-icon.png" alt=""  class="thanks-img" />
					<h5>Your Order has been placed  Successfully.</h5>
				</div>
				<h6>Thank you for Purchasing.</h6>
				<h6>Your Order is confirmed.</h6>
				<h4>YOUR ORDER ID IS <?php echo $order_id; ?></h4>
				<p>You will get update about your order, on your registered email and phone number.</p>
				<a href="<?php echo base_url; ?>" class="btn btn-default d-none d-md-block btn-radious">CONTINUE SHOPPING</a>
			</div>
			<div class="btn-wrap"><a href="<?php echo base_url; ?>" class="btn btn-default d-md-none btn-radious">CONTINUE SHOPPING</a></div>
		</div>
	</section>
	<!--End: Thanks Section -->

	<!--Trending Section -->
	<section class="trending-section"> 
		<div class="container-fluid">
			<h4>Featured Items</h4>
			<div class="slider row row-cols-2 row-cols-md-3  row-cols-xl-5"> 
				<!--Block-->
				<?php foreach($recommended_product as $new_product_data) { 
				
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
				
				?>
				
				<div class="col p-3" >
							<?php if ($new_product_data['stock_status'] == 'Out of Stock' || $new_product_data['stock'] <= 0) { ?>
								<img class="outof_stock" alt="<?php echo website_name; ?>" src="<?php echo weburl . '/assets/img/out_of_stock.png'; ?>">
							<?php } ?>
							<a onclick="redirect_to_link('<?php echo base_url .'product/'. $new_product_data['sku']; ?>')" class="card h-100 d-flex flex-column justify-content-between" id="product_link_card">
								<div>
									<div class="d-flex justify-content-between align-items-center" style="margin-top:-25px;">
										<span class="ribbon3"><span class="text-white"><?php echo $new_product_data['offpercent']; ?></span></span>
										<span class="d-flex justify-content-between align-items-right whishlist_all" onclick="add_to_wishlist(event,'<?= $new_product_data['id'] ?>','<?= $new_product_data['sku'] ?>','<?= $new_product_data['vendor_id'] ?>','<?= $this->session->userdata('user_id'); ?>',1,'',2)"><i class="fa-regular fa-heart" <?php if($new_product_data['product_wishlist'] == 0) { ?>style="color: #162b75;" <?php } ?>></i></span>
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
				
				<?php } ?>
				<!--/*Block-->

			</div>
		</div>
	</section>
	<!--/*Trending Section -->

</main>

 <?php
    include("include/footer.php")
    ?>

    <?php
    include("include/script.php")
    ?>
	
	<script type="text/javascript">
		$('.slider-trending').slick({
			slidesToShow: 4,
			slidesToScroll: 1,
			arrows: true,
			infinite: false,
			autoplay: false,
			responsive: [
				{
				breakpoint: 1199,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1
				}
				},
				{
				breakpoint: 767,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1
				}
				},
				{
				breakpoint: 575,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1
				}
				}
				// You can unslick at a given breakpoint now by adding:
				// settings: "unslick"
				// instead of a settings object
			]
		});
	</script>
	
</body>
	
</html>
