<!DOCTYPE html>
<html lang="en">

<head>
	<?php $title = "Home";
	include("include/headTag.php") ?>
	<link rel="stylesheet" href="<?= base_url('assets_web/style/nouislider.min.css') ?>">
</head>
<style>
	#attr_div
	{
		width: 100%;
		overflow:hidden;
		height:200px;
	    overflow-y:scroll;
		margin-left : -5px;
	}
	hr {
			width: 97% !important;
			margin-left: 3px;
		}

	label.Color {
		height: 30px;
		width: 30px;
		border-radius: 50%;
		margin-top: -3px;
	}

	img.outof_stock {
		position: absolute;
		z-index: 1;
		margin-left: 10px;
		margin-top: 3px;
	}

	@media (max-width: 767.98px) {
		img.outof_stock {
			width: 70px;
			margin-left: -3px;
			margin-top: 5px;
		}

		h5 {
			font-size: 13px;
		}
	}

	.rating_label {
		position: absolute;
		bottom: 20px;
		padding: 0 5px;
		color: #fff;
		background-color: rgb(244 37 37);
		text-transform: uppercase;
		font-weight: 900;
	}
	
	.noUi-handle:after, .noUi-handle:before
	{
		background : none;
	}
	
	.noui-slider-range.noUi-target {
		background: #ff6600;
		border: none;
		box-shadow: none;
	}
	.noUi-base, .noUi-connects {
		width: 100%;
		height: 100%;
		position: relative;
		z-index: 1;
	}
	.noui-slider-range .noUi-connect {
		background: var(--bs-primary);
	}
	
	.noUi-handle {
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    position: absolute;
}

    will-change: transform;
    position: absolute;
    z-index: 1;
    top: 0;
    /* right: 0; */
    height: 100%;
    width: 100%;
    -ms-transform-origin: 0 0;
    -webkit-transform-origin: 0 0;
    -webkit-transform-style: preserve-3d;
    transform-origin: 0 0;
    transform-style: flat;
}

	
	.noui-slider-div {
		padding-left: 0.75rem;
		padding-right: 0.60rem;
	}
	
	.noUi-horizontal {
		height : 13px;
	}
	
	.noui-slider-range .noUi-handle {
		height: 24px;
		width: 24px;
		top: -6px;
		right: -9px;
		border: 2px solid #fff;
		border-radius: 50%;
		box-shadow: none;
		background: #162b75;
	}
	.noUi-touch-area {
		height: 100%;
		width: 100%;
	}
	
	label.btn.btn-sm.btn-outline-primary.btn-primary-soft-check
	{
		border-color: #162b75;
	}
	#filtersContainer .fa-solid.fa-star {
		color: #162b75;
		font-size: 11px;
	}
	#filtersContainer .container-fluid {
		border: solid 1px #ccc;
	}
	#category_product {
		margin-left: 0;
	}	
		
		
	</style>

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
	include("include/navForMobile.php");
	//print_r($cat_details);
	?>
	<input type="hidden" id="hidden_catid" value="<?php echo $cat_details->cat_id; ?>">
	<input type="hidden" id="user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
	<main class="mb-5">
		<div class="offcanvas offcanvas-start" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel" style="width: 65%">
			<div class="offcanvas-header bg-primary">
				<h5 class="offcanvas-title text-light mb-0" id="filterOffcanvasLabel">Filters</h5>
				<button type="button" class="btn-close text-reset text-light" data-bs-dismiss="offcanvas" aria-label="Close"></button>
			</div>
			<div class="offcanvas-body">
				<div class="row mt-1">
					<div class="col-12 px-3">
					
					<?php if (!empty($brand_filter)) : ?>
					<div class="py-3">
						<h6 class="mb-2">Brands</h6>
						<div class="attribute-values ps-2 me-2">
							<?php foreach ($brand_filter as $brand) : ?>
								<div class="form-check brand-checkbox">
									<input type="hidden" name="brand_name" id="brand_name" value="<?= $brand['brand_name']; ?>">
									<input class="form-check-input checkbox-sync" type="checkbox" value="<?= $brand['brand_id']; ?>" id="flexCheckbrand">
									<label for="mobbrand<?= $brand['brand_id'] ?>" class="form-check-label m-0"><?= $brand['brand_name'] ?></label>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<hr class="my-0 me-3">
				<?php endif; ?>
					
						<?php if (!empty($price_filter['min_price']) && !empty($price_filter['max_price'])) :  ?>
					<?php if ($price_filter['min_price'] != $price_filter['max_price']) :  ?>
						<!-- Prize Slider -->
						<div class="py-3">
							<div class="px-0 pe-3">
								<h6 class="mb-2">Price Range</h6>
								<div>
									<div class="noui-wrapper">
										<div class="d-flex justify-content-between mb-3">
											<input type="text" class="form-control me-4 text-center" readonly>
											<input type="text" class="form-control me-1 text-center" readonly>
										</div>
										<div class="noui-slider-div">
											<div class="noui-slider-range mt-2" data-range-min='<?= $price_filter['min_price'] ?>' data-range-max='<?= $price_filter['max_price'] ?>' data-range-selected-min='<?= $price_filter['min_price'] ?>' data-range-selected-max='<?= $price_filter['max_price'] ?>'></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php endif; ?>
				
				<div class="py-3">
					<h6 class="mb-3">Ratings</h6>	
					<div class="mb-0 g-3">
						<div class="mb-2">
							<input type="radio" name="rating-radio-mb" class="btn-check" id="btn-mb-check-c1" value="1">
							<label class="btn btn-sm btn-outline-primary btn-primary-soft-check" for="btn-mb-check-c1">
								<div class="ratings-filter"><i class="fa-solid fa-star"></i></div>
							</label>
						</div>
						<div class="mb-2">
							<input type="radio" name="rating-radio-mb" class="btn-check" id="btn-mb-check-c2" value="2">
							<label class="btn btn-sm btn-outline-primary btn-primary-soft-check" for="btn-mb-check-c2">
								<div class="ratings-filter"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
							</label>
						</div>
						<div class="mb-2">
							<input type="radio" name="rating-radio-mb" class="btn-check" id="btn-mb-check-c3" value="3">
							<label class="btn btn-sm btn-outline-primary btn-primary-soft-check" for="btn-mb-check-c3">
								<div class="ratings-filter"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
							</label>
						</div>
						<div class="mb-2">
							<input type="radio" name="rating-radio-mb" class="btn-check" id="btn-mb-check-c4" value="4">
							<label class="btn btn-sm btn-outline-primary btn-primary-soft-check" for="btn-mb-check-c4">
								<div class="ratings-filter"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
							</label>
						</div>
						<div class="mb-2">
							<input type="radio" name="rating-radio-mb" class="btn-check" id="btn-mb-check-c5" value="5">
							<label class="btn btn-sm btn-outline-primary btn-primary-soft-check" for="btn-mb-check-c5">
								<div class="ratings-filter"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
							</label>
						</div>
					</div>
				</div>

						
						<?php foreach ($product_filter as $p_weight) { ?>
							<div class="col-12 px-0">
								<h6 class="mb-3"><?php echo $p_weight['name']; ?></h6>
								<?php
								foreach ($p_weight['value'] as $product_weight) {
								?>
									<div class="form-check mb-1">
										<input type="hidden" name="attr_name" id="attr_name" value="<?php echo $p_weight['name']; ?>">
										<input type="hidden" name="attr_id" id="attr_id" value="<?php echo $p_weight['attr_id']; ?>">
										<input class="form-check-input" type="checkbox" value="<?php echo $product_weight; ?>" id="flexCheckChecked">
										<label <?php if ($p_weight['name'] == 'Color') {
													echo 'style="background-color:' . $product_weight . '"';
												} ?> class="form-check-label <?php echo $p_weight['name']; ?>" for="flexCheckChecked0"><?php if ($p_weight['name'] != 'Color') {
																																			echo $product_weight;
																																		} ?></label>


									</div>
								<?php  } ?>

								<!--<div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" value="" id="brandName2" checked>
                                        <label class="form-check-label fw-semibold" for="brandName2">
                                            Checked checkbox
                                        </label>
                                    </div>-->

							</div>
							<hr>
						<?php  } ?>

					</div>
					<hr>
				</div>
			</div>
		</div>
		<section class="mt-2">
			<div class="container-fluid ps-8 pe-11">
				<div class="row ps-2 pe-1">
					<div class="col-12">
						<div class="d-flex justify-content-between">
							<h5><a style="color:black" href="<?php echo base_url.'fashion'; ?>">Category</a> >> <?php echo $cat_details->cat_name; ?></h5>
							<div class="row me-3">
								<div class="col-12">
									<select class="form-select ms-5 d-none d-md-block" onchange="" id="sort_data_id" aria-label="Sort By option">
										<option value=""><?php if ($default_language == 1) {
																echo 'ترتيب حسب';
															} else {
																echo 'Sort By';
															} ?></option>
										<?php
										foreach ($product_short_by as $short_product) {
										?>
											<option id="<?php echo $short_product['sort_id']; ?>" value="<?php echo $short_product['sort_id']; ?>"><?php echo $short_product['name']; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 mb-5">
						<div class="d-flex justify-content-between">

							<select class="form-select d-md-none" onchange="" id="sort_data_id" aria-label="Sort By option">
								<option value=""><?php if ($default_language == 1) {
														echo 'ترتيب حسب';
													} else {
														echo 'Sort By';
													} ?></option>
								<?php
								foreach ($product_short_by as $short_product) {
								?>
									<option id="<?php echo $short_product['sort_id']; ?>" value="<?php echo $short_product['sort_id']; ?>"><?php echo $short_product['name']; ?></option>
								<?php } ?>
							</select>

							<a class="btn btn-primary btn-sm text-white ms-5 fs-6 fw-bold text-decoration-none d-md-none float-end d-inline-flex align-items-center" id="applyFilterBtn" data-bs-toggle="offcanvas" href="#filterOffcanvas" role="button" aria-controls="filterOffcanvas" style="white-space: nowrap;"><i class='bx bx-filter me-1'></i>Apply Filters</a>
						</div>
					</div>
					<aside class="col-12 col-md-5 col-lg-2 col-xxl-2 d-none d-md-block" id="filtersContainer">
						<div class="container-fluid px-lg-2">
							<div class="row align-items-center gap-0">
								<div class="col-7 ms-0 mt-3 w-100">
									<h5 class="fw-bold"><b>Filters</b><a class="text-right" id="clear-all-filter" style="float :right;font-size:14px;">Clear All</a></h5>
									
								</div>
								<hr class="my-0 me-3">
								<!--<div class="col-5 px-0">
                                    <button class="btn p-0 btn-light bg-light border-0 text-primary float-end">Clear All</button>
                                </div>-->
							</div>
							<div class="row mt-1">
								<?php if (!empty($brand_filter)) : ?>
					<div class="py-3">
						<h6 class="mb-2">Brands</h6>
						<div class="attribute-values ps-2 me-2">
							<?php foreach ($brand_filter as $brand) : ?>
								<div class="form-check brand-checkbox">
									<input type="hidden" name="brand_name" id="brand_name" value="<?= $brand['brand_name']; ?>">
									<input class="form-check-input checkbox-sync" type="checkbox" value="<?= $brand['brand_id']; ?>" id="flexCheckbrand">
									<label for="mobbrand<?= $brand['brand_id'] ?>" class="form-check-label m-0"><?= $brand['brand_name'] ?></label>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<hr class="my-0 me-3">
				<?php endif; ?>
				
				<?php if (!empty($price_filter['min_price']) && !empty($price_filter['max_price'])) :  ?>
					<?php if ($price_filter['min_price'] != $price_filter['max_price']) :  ?>
						<!-- Prize Slider -->
						<div class="py-3">
							<div class="px-0 pe-3">
								<h6 class="mb-2">Price Range</h6>
								<div>
									<div class="noui-wrapper">
										<div class="d-flex justify-content-between mb-3 px-1 pe-1">
											<input type="text" class="form-control me-1 text-center" readonly>
											<input type="text" class="form-control me-1 text-center" readonly>
										</div>
										<div class="noui-slider-div px-4 pe-0">
											<div class="noui-slider-range mt-2" data-range-min='<?= $price_filter['min_price'] ?>' data-range-max='<?= $price_filter['max_price'] ?>' data-range-selected-min='<?= $price_filter['min_price'] ?>' data-range-selected-max='<?= $price_filter['max_price'] ?>'></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php endif; ?>
				<hr class="my-0 me-3 mt-3">
				<div class="py-3">
					<h6 class="mb-3">Ratings</h6>
					<div class="mb-0 g-3">
						<div class="mb-2">
							<input type="radio" name="rating-radio-mb" class="btn-check" id="btn-mb-check-c1" value="1">
							<label class="btn btn-sm btn-outline-primary btn-primary-soft-check" for="btn-mb-check-c1">
								<div class="ratings-filter"><i class="fa-solid fa-star"></i></div>
							</label>
						</div>
						<div class="mb-2">
							<input type="radio" name="rating-radio-mb" class="btn-check" id="btn-mb-check-c2" value="2">
							<label class="btn btn-sm btn-outline-primary btn-primary-soft-check" for="btn-mb-check-c2">
								<div class="ratings-filter"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
							</label>
						</div>
						<div class="mb-2">
							<input type="radio" name="rating-radio-mb" class="btn-check" id="btn-mb-check-c3" value="3">
							<label class="btn btn-sm btn-outline-primary btn-primary-soft-check" for="btn-mb-check-c3">
								<div class="ratings-filter"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
							</label>
						</div>
						<div class="mb-2">
							<input type="radio" name="rating-radio-mb" class="btn-check" id="btn-mb-check-c4" value="4">
							<label class="btn btn-sm btn-outline-primary btn-primary-soft-check" for="btn-mb-check-c4">
								<div class="ratings-filter"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
							</label>
						</div>
						<div class="mb-2">
							<input type="radio" name="rating-radio-mb" class="btn-check" id="btn-mb-check-c5" value="5">
							<label class="btn btn-sm btn-outline-primary btn-primary-soft-check" for="btn-mb-check-c5">
								<div class="ratings-filter"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
							</label>
						</div>
					</div>
				</div>
				<hr class="my-0 me-3">
				
								<?php
								$i = 0;
								$len = count($product_filter);
								foreach ($product_filter as $p_weight) { ?>
									<div class="col-12 pt-3 px-3 ps-4" id="attr_div">
										<h6 class="mb-3"><?php echo $p_weight['name']; ?></h6>
										<?php
										

										foreach ($p_weight['value'] as $product_weight) {
										?>
											<div class="form-check mb-1">
												<input type="hidden" name="attr_name" id="attr_name" value="<?php echo $p_weight['name']; ?>">
												<input type="hidden" name="attr_id" id="attr_id" value="<?php echo $p_weight['attr_id']; ?>">
												<input class="form-check-input" type="checkbox" value="<?php echo $product_weight; ?>" id="flexCheckChecked">
												<label <?php if ($p_weight['name'] == 'Color') {
															echo 'style="background-color:' . $product_weight . '"';
														} ?> class="form-check-label <?php echo $p_weight['name']; ?>" for="flexCheckChecked0"><?php if ($p_weight['name'] != 'Color') {
																																					echo $product_weight;
																																				} ?></label>


											</div>
										<?php  } ?>

										<!--<div class="form-check mb-1">
                                        <input class="form-check-input" type="checkbox" value="" id="brandName2" checked>
                                        <label class="form-check-label fw-semibold" for="brandName2">
                                            Checked checkbox
                                        </label>
                                    </div>-->

									</div>
									<?php if ($i != $len - 1) { ?>
									<hr class="my-0 me-0 mt-0">
								<?php } $i++; } ?>
							</div>
						</div>
					</aside>
					<article class="col-12 col-md-7 col-lg-10 col-xxl-10 px-1" id="filterProducts0">
						<div class="container-fluid px-md-2 px-lg-4">
							<!--<nav id="pListPagination" aria-label="Page navigation">
									<ul class="pagination justify-content-end pagingDiv">

									</ul>

								</nav>-->
						</div>


						<!--<div class="col-md-4"><div class="card"><div class="card-img zoom-img"><img src="<?php // base_url;
																												?>assets_web/images/featured-img-2.png" class="card-img-top" alt="..." /><div class="favorite"><a href="javascript:void(0);"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.08109 12.7492L10.4543 18.7362C10.6465 18.9167 10.7425 19.0069 10.852 19.0412C10.9492 19.0716 11.0534 19.0716 11.1507 19.0412C11.2601 19.0069 11.3561 18.9167 11.5483 18.7362L17.9215 12.7492C19.7147 11.0647 19.9324 8.29271 18.4243 6.34889L18.1407 5.98339C16.3366 3.65802 12.7151 4.048 11.4474 6.70417C11.2683 7.07937 10.7343 7.07937 10.5552 6.70417C9.28748 4.048 5.66605 3.65802 3.86189 5.98339L3.57831 6.34888C2.07017 8.29271 2.28793 11.0647 4.08109 12.7492Z" stroke=""/></svg></a></div></div><div class="card-body"><h6>Banasari Saree Blue soft Silk</h6><h6 class="price-off text-danger">37% OFF<h6><div class="row"><div class="col-6"><h6 class="old-price">₹1229</h6><h5 class="new-price">₹749/-</h5></div><div class="col-6"><div class="btn-by-now"><a href="#" class="btn btn-default w-100">Buy Now</a></div></div></div></div></div></div>-->

						<div class="trending-section filter empty-cart row" id="category_sponsor_product">


						</div>
						<div class="trending-section filter empty-cart row" id="category_product">

							<!--<div class="col-6 col-md-6 col-lg-4 px-2 mb-4 mb-5 "><a href="/" class="text-decoration-none me-2 me-md-3 me-xl-4"><div class="card h-100 position-relative"><img src="/assets_web/images/placeholders/top-cats.jpg" class="card-img-top" alt="..."><div class="favourite shadow"><i class="bx bx-heart text-primary"></i></div><div class="card-body p-2 p-md-3 p-xl-4"><h5 class="card-title fw-bold fs-6 fs-lg-5">Banasari Saree Blue soft Silk 1</h5><div class="d-flex w-100 justify-content-between"><div class="w-40 h-auto d-flex flex-column justify-content-between"><p class="my-md-2  mb-0 fw-semibold"><strike>$1229</strike></p><h5 class="mb-0 fw-bold">$729</h5></div><div class="w-60"><p class="mb-1 text-end fw-bold text-primary">37% Off</p><button class="btn btn-primary float-end fs-small fs-xl-6 px-2 py-1 px-md-3 py-md-2 px-xl-4">Buy Now</button></div></div></div></div></a></div>-->




							<!--<div class="col-12 mt-6 d-flex align-items-center justify-content-center">
                                    <a class="btn btn-primary text-white fs-5 fw-bold text-decoration-none d-inline-flex align-items-center"><i class='bx bx-loader me-1'></i>Load More</a>
                                </div>-->
						</div>
						<!--<div class="col-12 mt-4">
								<nav id="pListPagination" aria-label="Page navigation">
									<ul class="pagination justify-content-center pagingDiv">

									</ul>

								</nav>

							</div>-->
				</div>
				</article>
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
	<script src="<?= base_url('assets_web/js/nouislider.min.js') ?>"></script>
	<script>
		var csrfName = $(".txt_csrfname").attr("name"); //
		var csrfHash = $(".txt_csrfname").val(); // CSRF hash
		var site_url = $(".site_url").val(); // CSRF hash
		var user_id = $("#user_id").val();
		var website_name = $("#website_name").val();

		var functionDelayTimeout;
		var language = 1;
		var devicetype = 1;
		var selectVal = ""; //$("#sort_data_id option:selected").val();
		var hidden_catid = $("#hidden_catid").val();
		var brand_filter_array = [];
		var filter_array = [];
		var sort_id = '';
		var rating = '';
		var pages = 1;
		var pageNo = 0;
		var rangeSlider = document.getElementsByClassName('noui-slider-range');
		var price_object = {
			'min_price': '',
			'max_price': ''
		};
		var pageLoadCount = 0;
		var radioButtonGroup = document.querySelectorAll('.btn-check');


		$(function() {
			window.onload = get_category_product(hidden_catid, "", 0);
			window.onload = get_category_sponsor_product(hidden_catid, "", 0);
			window.onload = initilalizeRangeSlider();
		});
		
		
		
		
		
		radioButtonGroup.forEach(function (radioButton) {
		radioButton.addEventListener('change', function () {
			var selectedValue = this.value;

			const correspondingRadioButtons = document.querySelectorAll(`.btn-check[value="${selectedValue}"]`);

			correspondingRadioButtons.forEach(element => {
				element.checked = true;
			});

			rating = selectedValue;
			get_category_product(hidden_catid, sort_id, 0);
		});
	});

	function clear_all_filter() {
			alert('ddd');
			$('#flexCheckbrand input[type="checkbox"]').prop('checked', false);
			/*$('#formoid input[type="text"], #formoid input[type="email"], #formoid input[type="number"]').val('');
			$('#formoid select').val($('select option:first').val());*/
		}


		
		// $("#sort_data_id").on("change", function () {
		// var selectVal = $("#sort_data_id option:selected").val();

		// get_category_product(hidden_catid, selectVal, 0);
		// });
		$(document).on('change', '#sort_data_id', function() {
			var selectVal = $("#sort_data_id option:selected").val();
			sort_id = $(this).children(":selected").attr("id");
			get_category_product(hidden_catid, sort_id, 0);
			get_category_sponsor_product(hidden_catid, sort_id, 0);
		});

		/* $(document).on('load', '#flexCheckChecked', function() {
			if (this.checked) {
				var check_val = $(this).val();
				var attr_id = $(this).closest('div').find('#attr_id').val();
				var attr_name = $(this).closest('div').find('#attr_name').val();
				filter_array.push({
					"attr_id": attr_id,
					"attr_name": attr_name,
					"attr_value": check_val
				});
				//alert(JSON.stringify(filter_array));

			} else {
				var check_val = $(this).val();
				var parsedJSON = filter_array;
				//  alert("before " +parsedJSON);                                        

				for (var i = 0; i < parsedJSON.length; i++) {
					var counter = parsedJSON[i];
					// var name = counter.url;
					if (counter.attr_value.includes(check_val)) {
						//alert("remove it " +parsedJSON[i]);
						//delete parsedJSON[i];
						parsedJSON.splice(i, 1);

					}

				}
				// alert(JSON.stringify(filter_array));
			}
			get_category_product(hidden_catid, sort_id, 0);
		}); */

		$(document).on('change', '#flexCheckChecked', function() {
			if (this.checked) {
				var check_val = $(this).val();
				var attr_id = $(this).closest('div').find('#attr_id').val();
				var attr_name = $(this).closest('div').find('#attr_name').val();
				filter_array.push({
					"attr_id": attr_id,
					"attr_name": attr_name,
					"attr_value": check_val
				});
				//alert(JSON.stringify(filter_array));

			} else {
				var check_val = $(this).val();
				var parsedJSON = filter_array;
				//  alert("before " +parsedJSON);                                        

				for (var i = 0; i < parsedJSON.length; i++) {
					var counter = parsedJSON[i];
					// var name = counter.url;
					if (counter.attr_value.includes(check_val)) {
						//alert("remove it " +parsedJSON[i]);
						//delete parsedJSON[i];
						parsedJSON.splice(i, 1);

					}

				}
				// alert(JSON.stringify(filter_array));
			}
			get_category_product(hidden_catid, sort_id, 0);
			get_category_sponsor_product(hidden_catid, sort_id, 0);
		});
		
		$(document).on('change', '#flexCheckbrand', function() {
			if (this.checked) {
				var check_val = $(this).val();
				var brand_name = $(this).closest('div').find('#brand_name').val();
				brand_filter_array.push({
					"brand_name": brand_name,
					"brand_id": check_val
				});
				//alert(JSON.stringify(filter_array));

			} else {
				
				const index = brand_filter_array.findIndex(item => item.brand_id === this.value);
                if (index !== -1) {
                    brand_filter_array.splice(index, 1);
                }
				
				
				// alert(JSON.stringify(filter_array));
			}
			get_category_product(hidden_catid, sort_id, 0);
			get_category_sponsor_product(hidden_catid, sort_id, 0);
		});

		//$(".flexCheckChecked input").click(function () {
		// alert('ss');
		//$(".rating span").removeClass("checked");
		//$(this).parent().addClass("checked");
		//});
		
		function initilalizeRangeSlider() {
    if (rangeSlider.length > 0) {
        var rangeSliders = Array.from(rangeSlider);
        rangeSliders.forEach(slider => {
            var nouiMin = priceMin = price_object['min_price'] = parseFloat(slider.getAttribute('data-range-min'));
            var nouiMax = priceMax = price_object['max_price'] = parseFloat(slider.getAttribute('data-range-max'));
            var nouiSelectedMin = parseFloat(slider.getAttribute('data-range-selected-min'));
            var nouiSelectedMax = parseFloat(slider.getAttribute('data-range-selected-max'));
            var rangeText = slider.parentElement.previousElementSibling;
            var imin = rangeText.firstElementChild;
            var imax = rangeText.lastElementChild;
            var inputs = [imin, imax];

            noUiSlider.create(slider, {
                start: [nouiSelectedMin, nouiSelectedMax],
                connect: true,
                step: 1,
                range: {
                    min: nouiMin,
                    max: nouiMax
                }
            });

            slider.noUiSlider.on("update", function (values, handle) {
                inputs[handle].value = values[handle];
                // Update the other slider
                var otherSlider = rangeSliders.find(s => s !== slider);
				if (pageLoadCount > 0) {
                    clearTimeout(functionDelayTimeout);
                    functionDelayTimeout = setTimeout(function () {
                        price_object['min_price'] = values[0];
                        price_object['max_price'] = values[1];
						get_category_product(hidden_catid, sort_id, 0);
                    }, 500);
				}
            });

            $(document).on('click', '#clear-all-filter', function () {
                slider.noUiSlider.set([nouiMin, nouiMax]);
                imin.value = nouiMin;
                imax.value = nouiMax;
                price_object['min_price'] = nouiMin;
                price_object['max_price'] = nouiMax;
                clearTimeout(functionDelayTimeout);
                functionDelayTimeout = setTimeout(function () {
                    document.querySelectorAll('input[type="checkbox"]').forEach(function (checkbox) {
                        checkbox.checked = false;
                    });
                    document.querySelectorAll('input[type="radio"]').forEach(function (radio) {
                        radio.checked = false;
                    });
                    rating = '';
                    brand_filter_array = [];
                    filter_array = [];

                    get_category_product(hidden_catid, sort_id, 0);
                }, 500);
            });
        });
    } else {
        $(document).on('click', '#clear-all-filter', function () {
            document.querySelectorAll('input[type="checkbox"]').forEach(function (checkbox) {
                checkbox.checked = false;
            });
            document.querySelectorAll('input[type="radio"]').forEach(function (radio) {
                radio.checked = false;
            });
            rating = '';
            filter_array = [];
            brand_filter_array = [];

            isFetching = true;
            get_category_product(hidden_catid, 0, () => {
                isFetching = false;
            });
        });
    }
}

		function get_category_product(catid, sortby, pageno) {
			pageNo = pageno;
			$.ajax({
				method: "post",
				url: site_url + "getCategoryProduct",
				data: {
					catid: catid,
					sortby: sortby,
					pageno: pageno,
					[csrfName]: csrfHash,
					language: default_language,
					devicetype: devicetype,
					config_attr: JSON.stringify(filter_array),
					config_brand: JSON.stringify(brand_filter_array),
					min_price: price_object['min_price'],
					max_price: price_object['max_price'],
					rating: rating

				},
				success: function(response) {
					//hideloader();

					var parsedJSON = response.Information;

					var qoute_id = <?php echo "'" . $this->session->userdata('qoute_id') . "'"; ?>;

					var order = parsedJSON.length;
					var product_html = "";
					config_attr1 = JSON.stringify(filter_array);
					var check_datas = config_attr1.length
					if (order != 0) {

						/*if($('input.form-check-input:checked').length > 0 && pageno <= 0 || $('#sort_data_id').val() != '' && pageno <= 0 || check_datas == '2')
						{
							
							$("#category_product").empty();
						}*/

						if (pageno == 0) {
							$("#category_product").empty();
						}

						$(parsedJSON).each(function() {
							
							var ratingHTML = '';
							if (this.product_total_rating > 0) {
								var rating = Math.round(this.product_total_rating * 2) / 2;
								const wholeNumber = Math.floor(rating);
								const fractionalPart = rating - wholeNumber;
								for (let i = 0; i < wholeNumber; i++) {
									ratingHTML += '<i class="fa-solid fa-star fa-lg" style="color: #162b75;"></i>';
								}
								if (fractionalPart >= 0.5) {
									emptyStars = 5 - wholeNumber - 1;
									ratingHTML += '<i class="fa-solid fa-star-half-stroke fa-lg" style="color: #162b75;"></i>';
								} else {
									emptyStars = 5 - wholeNumber;
								}
								
								for (let i = 0; i < emptyStars; i++) {
									ratingHTML += '<i class="fa-solid fa-star fa-lg"></i>';
								}
								
							}


							// product_html += '<div class="col-lg-4 col-md-6 col-sm-4 col-6 p-1">';
							// if (this.stock_status == 'Out of Stock' || this.stock <= '0') {
							// 	product_html += '<img alt="' + website_name + '" class="outof_stock" src="' + site_url + 'assets/img/out_of_stock.png" >';
							// }
							// product_html += '<a href="' +
							// 	site_url +
							// 	this.web_url +
							// 	"?pid=" +
							// 	this.id +
							// 	"&sku=" +
							// 	this.sku +
							// 	"&sid=" +
							// 	this.vendor_id +
							// 	'" ><div class="card"><div class="card-img zoom-img"><img src="' + site_url + 'media/' +
							// 	this.imgurl +
							// 	'" class="card-img-top" alt="' + this.name + '" /><div class="favorite"><a onclick="add_to_wishlist(event,' +
							// 	"'" +
							// 	this.id +
							// 	"','" +
							// 	this.sku +
							// 	"','" +
							// 	this.vendor_id +
							// 	"','" +
							// 	user_id +
							// 	"','1','0','2'," +
							// 	"'" +
							// 	qoute_id +
							// 	"'" + ')" href="javascript:void(0);"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.08109 12.7492L10.4543 18.7362C10.6465 18.9167 10.7425 19.0069 10.852 19.0412C10.9492 19.0716 11.0534 19.0716 11.1507 19.0412C11.2601 19.0069 11.3561 18.9167 11.5483 18.7362L17.9215 12.7492C19.7147 11.0647 19.9324 8.29271 18.4243 6.34889L18.1407 5.98339C16.3366 3.65802 12.7151 4.048 11.4474 6.70417C11.2683 7.07937 10.7343 7.07937 10.5552 6.70417C9.28748 4.048 5.66605 3.65802 3.86189 5.98339L3.57831 6.34888C2.07017 8.29271 2.28793 11.0647 4.08109 12.7492Z" stroke=""/></svg></a></div>';
							// if (this.product_total_rating != '') {
							// 	product_html += '<a href="' +
							// 		site_url +
							// 		this.web_url +
							// 		"?pid=" +
							// 		this.id +
							// 		"&sku=" +
							// 		this.sku +
							// 		"&sid=" +
							// 		this.vendor_id +
							// 		'" ><div class="rating_label">' + this.product_total_rating + '&nbsp;<img alt="' + website_name + '" src="' + site_url + 'assets_web/images/icons/star.png"></div></a>';
							// }
							// product_html += '</div><div class="card-body"><h6 class="pd-title">' +
							// 	this.name +
							// 	'</h6><div class="row"><div class="col-6"><h6 class="old-price">' + this.mrp + '</h6><h5 class="new-price">' + this.price + '/-</h5></div><div class="col-6"><div class="btn-by-now"><a href="#" onclick="add_to_cart_product_buy(event,' +
							// 	"'" +
							// 	this.id +
							// 	"','" +
							// 	this.sku +
							// 	"','" +
							// 	this.vendor_id +
							// 	"','" +
							// 	user_id +
							// 	"','1','0','2'," +
							// 	"'" +
							// 	qoute_id +
							// 	"'" +
							// 	')" class="btn btn-default w-100">Buy Now</a></div></div></div></div></div></a></div>';

							var wishlist_html = '';
							if(this.product_wishlist == 0)
							{
								wishlist_html += `<span class="d-flex justify-content-between align-items-right whishlist_all" onclick="add_to_wishlist(event,'${this.id}', '${this.sku}', '${this.vendor_id}', '${user_id}',1,'',2)"><i class="fa-regular fa-heart" style="color: #162b75;"></i></span>`;
							}
							else
							{
								wishlist_html += `<span class="d-flex justify-content-between align-items-right whishlist_all" onclick="add_to_wishlist(event,'${this.id}', '${this.sku}', '${this.vendor_id}', '${user_id}',1,'',2)"><i class="fa-regular fa-heart"></i></span>`;
							}


							product_html += `<div class="col-lg-3 col-sm-3 col-6 p-3">
									<a href="${site_url}product/${this.web_url}" class="card h-100 d-flex flex-column justify-content-between" id="product_link_card">
										<div>
											<div class="d-flex justify-content-between align-items-center">
												<span class="ribbon3"><span class="text-white">${this.offpercent}</span></span>
												${wishlist_html}
											</div>
											<div class="image-container mt-3 me-5 zoom-img">
												<img src="${site_url}/media/${this.imgurl}" class="rounded zoom-img thumbnail-image">
											</div> 
											<div class="product-detail-container p-2 mb-3">
												<div class="justify-content-between align-items-center">
													<p class="dress-name mb-0" >${this.name}</p>	
													<div class="d-flex justify-content-start flex-row mt-2" style="width: 100%;">
														<span class="new-price mx-1" style="color: #ff6600;">${this.price}</span>
														<small class="old-price text-right mx-1" style="color: #ff6600;">${this.mrp}</small>
													</div>
												</div>
												<div class="d-flex justify-content-between align-items-center pt-1">
													<div>
														${ratingHTML}
													</div>
													<button class="text-center  card_buy_btn btn-radious" type="button" onclick="add_to_cart_product(event, '${this.id}', '${this.sku}', '${this.vendor_id}', '${user_id}', '1', '0', '2', '${qoute_id}')">Add To Cart</button>
												</div>
											</div>
										</div>
									</a>
								</div>`;



						});
						pages = Math.ceil(response.total_products / 12);
						/* var result = Paging(
							response.pageno,
							12,
							response.productCount,
							"page-link shadow",
							"myDisableClass page-link shadow"
						);
						$(".pagingDiv").html(result); */
					} else {
						/*product_html = "No Record Found.";*/
						if (pageno == 0) {
							$("#category_product").empty();
							product_html = '<div class="wrap box-shadow"><img src="' + site_url + 'assets_web/images/empty-search-result.png" alt="' + website_name + '" class="empty-cart-img"><h5>Sorry, no record found!</h5><a href="' + site_url + '" class="btn btn-default btn-radious">GO TO HOMEPAGE</a></div>';
						}
					}
					$("#category_product").append(product_html);
					pageLoadCount = 1;
				},
			});
		}

		function get_category_sponsor_product(catid, sortby, pageno) {
			$.ajax({
				method: "post",
				url: site_url + "getCategorysponsorProduct",
				data: {
					catid: catid,
					sortby: sortby,
					pageno: pageno,
					[csrfName]: csrfHash,
					language: default_language,
					devicetype: devicetype,
					config_attr: JSON.stringify(filter_array),
				},
				success: function(response) {
					//hideloader();

					var parsedJSON = response.Information;

					var qoute_id = <?php echo "'" . $this->session->userdata('qoute_id') . "'"; ?>;

					var order = parsedJSON.length;
					var product_html = "";
					if (order != 0) {
						$("#category_sponsor_product").empty();
						$(parsedJSON).each(function() {


							// product_html += '<div class="col-lg-4 col-md-6 col-sm-4 col-6 p-1"><a href="' +
							// 	site_url +
							// 	this.web_url +
							// 	"?pid=" +
							// 	this.id +
							// 	"&sku=" +
							// 	this.sku +
							// 	"&sid=" +
							// 	this.vendor_id +
							// 	'" ><div class="card"><div class="card-img zoom-img"><img src="' + site_url + 'media/' +
							// 	this.imgurl +
							// 	'" class="card-img-top" alt="' + this.name + '" /><div class="favorite"><a onclick="add_to_wishlist(event,' +
							// 	"'" +
							// 	this.id +
							// 	"','" +
							// 	this.sku +
							// 	"','" +
							// 	this.vendor_id +
							// 	"','" +
							// 	user_id +
							// 	"','1','0','2'," +
							// 	"'" +
							// 	qoute_id +
							// 	"'" + ')" href="javascript:void(0);"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.08109 12.7492L10.4543 18.7362C10.6465 18.9167 10.7425 19.0069 10.852 19.0412C10.9492 19.0716 11.0534 19.0716 11.1507 19.0412C11.2601 19.0069 11.3561 18.9167 11.5483 18.7362L17.9215 12.7492C19.7147 11.0647 19.9324 8.29271 18.4243 6.34889L18.1407 5.98339C16.3366 3.65802 12.7151 4.048 11.4474 6.70417C11.2683 7.07937 10.7343 7.07937 10.5552 6.70417C9.28748 4.048 5.66605 3.65802 3.86189 5.98339L3.57831 6.34888C2.07017 8.29271 2.28793 11.0647 4.08109 12.7492Z" stroke=""/></svg></a></div>';
							// if (this.product_total_rating != '') {
							// 	product_html += '<a href="' +
							// 		site_url +
							// 		this.web_url +
							// 		"?pid=" +
							// 		this.id +
							// 		"&sku=" +
							// 		this.sku +
							// 		"&sid=" +
							// 		this.vendor_id +
							// 		'" ><div class="rating_label">' + this.product_total_rating + '&nbsp;<img alt="' + website_name + '" src="' + site_url + 'assets_web/images/icons/star.png"></div></a>';
							// }
							// product_html += '</div><div class="sponsor_label">Sponsor Product</div><div class="card-body"><h6 class="pd-title">' +
							// 	this.name +
							// 	'</h6><div class="row"><div class="col-6"><h6 class="old-price">' + this.mrp + '</h6><h5 class="new-price">' + this.price + '/-</h5></div><div class="col-6"><div class="btn-by-now"><a href="#" onclick="add_to_cart_product_buy(event,' +
							// 	"'" +
							// 	this.id +
							// 	"','" +
							// 	this.sku +
							// 	"','" +
							// 	this.vendor_id +
							// 	"','" +
							// 	user_id +
							// 	"','1','0','2'," +
							// 	"'" +
							// 	qoute_id +
							// 	"'" +
							// 	')" class="btn btn-default w-100">Buy Now</a></div></div></div></div></div></a></div>';

							product_html += `<div class="mx-2 py-2 mb-2" style="width:20rem;">
									<a href="${site_url}product/${this.web_url}" class="card h-100 d-flex flex-column justify-content-between" id="product_link_card">
										<div>
											<div class="d-flex justify-content-between align-items-center" style="margin-top:-25px;">
												<span class="ribbon3"><span class="text-white">-25%</span></span>
												<span class="wishlist"><i class="fa fa-heart-o"></i></span>
											</div>
											<div class="image-container mt-3 me-5 zoom-img">
												<img src="${site_url}/media/${this.imgurl}" class="rounded zoom-img thumbnail-image">
											</div>
											<div class="product-detail-container p-2 mb-3">
												<div class="justify-content-between align-items-center">
													<p class="dress-name mb-0">${this.name}</p>	
													<div class="d-flex justify-content-start flex-row mt-2" style="width: 100%;">
														<span class="new-price mx-1">${this.mrp}</span>
														<small class="old-price text-right mx-1">${this.price}</small>
													</div>
												</div>
												<div class="d-flex justify-content-between align-items-center pt-1">
													<div>
														<i class="fa-solid fa-star fa-lg" style="color: #ff6600;"></i>
														<span class="rating-number">4.8</span>
													</div>
													<button class="text-center card_buy_btn" type="button" onclick="add_to_cart_product_buy(event, '${this.id}', '${this.sku}', '${this.vendor_id}', '${user_id}', '1', '0', '2', '${qoute_id}')">BUY</button>
												</div>
											</div>
										</div>
									</a>
								</div>`;


						});
						var result = Paging(
							response.pageno,
							32,
							response.productCount,
							"page-link shadow",
							"myDisableClass page-link shadow"
						);
						$(".pagingDiv").html(result);
					}
					$("#category_sponsor_product").html(product_html);
				},
			});
		}

		var count = 0;
		var less_height = '100';
		/*window.addEventListener('scroll', () => {
			const { scrollHeight, scrollTop, clientHeight } = document.documentElement;
			var selectVal_id = $("#sort_data_id option:selected").val();
			if (scrollTop + clientHeight >= scrollHeight - less_height) {
				if (pageNo < total_pages - 1) {
					pageNo++;
					get_category_product(hidden_catid, selectVal_id, pageNo);
				}
			}
		})*/

		window.addEventListener('scroll', () => {
			const {
				scrollHeight,
				scrollTop,
				clientHeight
			} = document.documentElement;
			if (scrollTop + clientHeight >= scrollHeight - 450) {
				if (pageNo < pages - 1) {
					pageNo++;
					sort_id = $("#sort_data_id").val();
					get_category_product(hidden_catid, sort_id, pageNo);
				}
			}
		});

		$(document).ready(function() {
			$(".pagingDiv").on("click", "a", function() {
				pages = $(this).attr("pn") - 1;
				get_category_product(hidden_catid, sort_id, pages);
				get_category_sponsor_product(hidden_catid, sort_id, pages);
			});
		});

		function Paging(
			PageNumber,
			PageSize,
			TotalRecords,
			ClassName,
			DisableClassName
		) {
			var ReturnValue = "";

			var TotalPages = Math.ceil(TotalRecords / PageSize);
			if (+PageNumber > 1) {
				if (+PageNumber == 2)
					ReturnValue =
					ReturnValue +
					"<li class='page-item'><a pn='" +
					(+PageNumber - 1) +
					"' class='" +
					ClassName +
					"' aria-label='Previous'><i aria-hidden='true' class='fas fa-angle-left'></i></a> </li>  ";
				else {
					ReturnValue = ReturnValue + "<li class='page-item'><a pn='";
					ReturnValue =
						ReturnValue +
						(+PageNumber - 1) +
						"' class='" +
						ClassName +
						"' aria-label='Previous'><i aria-hidden='true' class='fas fa-angle-left'></i></a> </li>  ";
				}
			} else
				ReturnValue =
				ReturnValue +
				"<li class='page-item'><span class='" +
				DisableClassName +
				"' aria-label='Previous'><i aria-hidden='true' class='fas fa-angle-left'></i></span></a>   ";
			if (+PageNumber - 3 > 1)
				ReturnValue =
				ReturnValue +
				"<li class='page-item'><a pn='1' class='" +
				ClassName +
				"'>1</a></li> ...  ";
			for (var i = +PageNumber - 3; i <= +PageNumber; i++)
				if (i >= 1) {
					if (+PageNumber != i) {
						ReturnValue = ReturnValue + "<li class='page-item'><a pn='";
						ReturnValue =
							ReturnValue + i + "' class='" + ClassName + "'>" + i + "</a> </li> ";
					} else {
						ReturnValue =
							ReturnValue +
							"<li class='page-item active'><span class='" +
							DisableClassName +
							"'>" +
							i +
							"</span> </li>";
					}
				}
			for (var i = +PageNumber + 1; i <= +PageNumber + 3; i++)
				if (i <= TotalPages) {
					if (+PageNumber != i) {
						ReturnValue = ReturnValue + "<li class='page-item'><a pn='";
						ReturnValue =
							ReturnValue + i + "' class='" + ClassName + "'>" + i + "</a> </li> ";
					} else {
						ReturnValue =
							ReturnValue +
							"<li class='page-item active'><span class='" +
							DisableClassName +
							"'>" +
							i +
							"</span> </li>";
					}
				}
			if (+PageNumber + 3 < TotalPages) {
				ReturnValue = ReturnValue + "...<li class='page-item'> <a pn='";
				ReturnValue =
					ReturnValue +
					TotalPages +
					"' class='" +
					ClassName +
					"'>" +
					TotalPages +
					"</a> </li>";
			}
			if (+PageNumber < TotalPages) {
				ReturnValue = ReturnValue + "   <li class='page-item'><a pn='";
				ReturnValue =
					ReturnValue +
					(+PageNumber + 1) +
					"' class='" +
					ClassName +
					"' aria-label='Next'><i aria-hidden='true' class='fas fa-angle-right'></i></a> </li>";
			} else
				ReturnValue =
				ReturnValue +
				"   <span class='" +
				DisableClassName +
				"' aria-label='Next'><i aria-hidden='true' class='fas fa-angle-right'></i></span>";

			return ReturnValue;
		}
	</script>
</body>

</html>