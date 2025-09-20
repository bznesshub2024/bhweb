<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "Prize Money Products";
    include("include/headTag.php") ?>
</head>
<style>
.five-card
{
	width : 20%;
}
@media (max-width: 1200px) and (min-width: 969px) {
	.five-card
	{
		width : 33.33%;
	}
}

@media (max-width: 970px) and (min-width: 768px) {
	.five-card
	{
		width : 50%;
	}
}
</style>
<body>

	<?php 
        include("include/topbar.php")
        ?>
        <?php
        include("include/navbar.php");
		//print_r($offers_product);
        ?>
	
<main class="search"> 
		<br>
		<section>
	<div class="trending-section mt-0 container-fluid">
			<div class="row mb-md-4">
                    <div class="col-8">
                        <h3 class=" fw-bold">Prize Money Products</h3>
                    </div>
                    <!--<div class="col-4 d-flex align-items-center justify-content-end">
                        <a href="" class="text-primary float-end fw-semibold text-decoration-none">Explore All</a>
                    </div>-->
                </div>
			<div class="slider row row-cols-2 row-cols-md-3  row-cols-xl-5 mx-2">
							<!--Block-->

				<?php foreach ($regarding_price_product as $new_product_data) { 
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
				
				<div class="col p-3">
							
							<a onclick="redirect_to_link('<?php echo base_url .'product/'. $new_product_data['sku']; ?>')" class="card h-100 d-flex flex-column justify-content-between" id="product_link_card">
								<div>
									<div class="d-flex justify-content-between align-items-center">
										<span class="ribbon3"><span class="text-white"><?php echo $new_product_data['offpercent']; ?></span></span>
										<span class="d-flex justify-content-between align-items-right whishlist_all" onclick="add_to_wishlist(event,'<?php echo $new_product_data['id'] ?>','<?php echo $new_product_data['sku'] ?>','<?php echo $new_product_data['vendor_id'] ?>','<?php echo $this->session->userdata('user_id'); ?>',1,'',2)"><i class="fa-regular fa-heart" <?php if($new_product_data['product_wishlist'] == 0) { ?>style="color: #162b75;" <?php } ?>></i></span>
									</div>
									<div class="image-container mt-3 me-5 zoom-img">
										<img src="<?php echo $new_product_data['imgurl']; ?>" alt="<?php echo $new_product_data['name']; ?>" class="rounded zoom-img thumbnail-image">
									</div>
									<div class="product-detail-container p-2">
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
					<!--<div class="col-12 mt-6 d-flex align-items-center justify-content-center">
                        <a class="btn btn-primary text-white fs-5 fw-bold text-decoration-none d-inline-flex align-items-center"><i class='bx bx-loader me-1'></i>Load More</a>
                    </div>-->		
							<!--/*Block-->
			
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
	
</body>
	
</html>
