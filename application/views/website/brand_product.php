<!DOCTYPE html>
<html lang="en">

<head>
	<?php $title = "Brand Products";
	include("include/headTag.php") ?>

</head>
<style>
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
	.trending-section .card
	{
		padding: 10px;
		background: none;
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
	<input type="hidden" id="hidden_brandid" value="<?php echo $brand_id; ?>">
    <input type="hidden" id="user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
	
	<main>
		<div class="offcanvas offcanvas-start" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel" style="width: 65%">
			<div class="offcanvas-header bg-primary">
				<h5 class="offcanvas-title text-light mb-0" id="filterOffcanvasLabel">Filters</h5>
				<button type="button" class="btn-close text-reset text-light" data-bs-dismiss="offcanvas" aria-label="Close"></button>
			</div>
			<div class="offcanvas-body">
				<div class="row mt-1">
					<div class="col-12 px-3">
						<?php foreach ($product_filter as $p_weight) { ?>
							<div class="col-12 px-0">
								<h5 class="fw-bold"><?php echo $p_weight['name']; ?></h5>
								<?php
								foreach ($p_weight['value'] as $product_weight) {
								?>
									<div class="form-check mb-1">
										<input type="hidden" name="attr_name" id="attr_name" value="<?php echo $p_weight['name']; ?>">
										<input type="hidden" name="attr_id" id="attr_id" value="<?php echo $p_weight['attr_id']; ?>">
										<input class="form-check-input" type="checkbox" value="<?php echo $product_weight; ?>" id="flexCheckChecked">
										<label <?php if ($p_weight['name'] == 'Color') {
													echo 'style="background-color:' . $product_weight . '"';
												} ?> class="form-check-label <?php echo $p_weight['name']; ?>" for="flexCheckChecked"><?php if ($p_weight['name'] != 'Color') {
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
			<div class="container-fluid ps-md-10 pe-5 pe-md-10">
				<div class="row ps-2 pe-1">
					<div class="col-12 mb-5">
						<div class="d-flex justify-content-between">
							<h5 class="mt-3">Brand >> <?php echo $brand_product['brand_name']; ?></h5>
							<div class="row me-3">
								<div class="col-12">
									<select class="form-select ms-5  d-md-block" onchange="" id="sort_data_id" aria-label="Sort By option">
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
					
					
					<article class="col-12 col-md-12 col-lg-12 col-xxl-12 px-1" id="filterProducts0">
						<div class="container-fluid px-md-2 px-lg-4">
						<nav id="pListPagination" aria-label="Page navigation">
									<ul class="pagination d-flex justify-content-end pagingDiv">

									</ul>

								</nav>

						</div>

						<div class="trending-section filter empty-cart row" id="brand_product">

							<!--<div class="col-6 col-md-6 col-lg-4 px-2 mb-4 mb-5 "><a href="/" class="text-decoration-none me-2 me-md-3 me-xl-4"><div class="card h-100 position-relative"><img src="/assets_web/images/placeholders/top-cats.jpg" class="card-img-top" alt="..."><div class="favourite shadow"><i class="bx bx-heart text-primary"></i></div><div class="card-body p-2 p-md-3 p-xl-4"><h5 class="card-title fw-bold fs-6 fs-lg-5">Banasari Saree Blue soft Silk 1</h5><div class="d-flex w-100 justify-content-between"><div class="w-40 h-auto d-flex flex-column justify-content-between"><p class="my-md-2  mb-0 fw-semibold"><strike>$1229</strike></p><h5 class="mb-0 fw-bold">$729</h5></div><div class="w-60"><p class="mb-1 text-end fw-bold text-primary">37% Off</p><button class="btn btn-primary float-end fs-small fs-xl-6 px-2 py-1 px-md-3 py-md-2 px-xl-4">Buy Now</button></div></div></div></div></a></div>-->


							

							<!--<div class="col-12 mt-6 d-flex align-items-center justify-content-center">
                                    <a class="btn btn-primary text-white fs-5 fw-bold text-decoration-none d-inline-flex align-items-center"><i class='bx bx-loader me-1'></i>Load More</a>
                                </div>-->
						</div>
						<div class="col-12 mt-4">
								<nav id="pListPagination" aria-label="Page navigation">
									<ul class="pagination justify-content-center pagingDiv">

									</ul>

								</nav>

							</div>
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
	<script>
		var csrfName = $(".txt_csrfname").attr("name"); //
		var csrfHash = $(".txt_csrfname").val(); // CSRF hash
		var site_url = $(".site_url").val(); // CSRF hash
		var language = 1;
		var devicetype = 1;
		var selectVal = ""; //$("#sort_data_id option:selected").val();
		var hidden_brandid = $("#hidden_brandid").val();
		$(function () {
		  window.onload = get_brand_product(hidden_brandid, "", 0);
		});

		$(document).on('change', '#sort_data_id', function() {
		   var selectVal = $("#sort_data_id option:selected").val();
			var id = $(this).children(":selected").attr("id");
		  get_brand_product(hidden_brandid, id, 0);
		});
		// $("#sort_data_id").on("change", function () {

		  // var selectVal = $("#sort_data_id option:selected").val();
		  // get_brand_product(hidden_brandid, selectVal, 0);
		// });

		function get_brand_product(brand_id, sortby, pageno) {
		  $.ajax({
			method: "post",
			url: site_url + "brand_prod",
			data: {
			  brand_id: brand_id,
			  sortby: sortby,
			  pageno: pageno,
			  [csrfName]: csrfHash,
			  language: language,
			  devicetype: devicetype,
			},
			success: function (response) {
			  //hideloader();
			  var parsedJSON = response.Information;
			  var user_id = $("#user_id").val();
			  var order = parsedJSON.length;
			  var qoute_id = <?php echo "'" . $this->session->userdata('qoute_id') . "'"; ?>;
			  var product_html = "";
			  if (order != 0) {
				$("#brand_product").empty();
				$(parsedJSON).each(function () {
					
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
					
							if (this.stock_status == 'Out of Stock' || this.stock <= '0') {
								product_html += '<img alt="'+website_name+'" class="outof_stock" src="' + site_url + 'assets/img/out_of_stock.png" >';
							}
							product_html += `<div class="col-lg-3 col-sm-3 col-6 p-3">
									<a href="${site_url}product/${this.web_url}" class="card h-100 d-flex flex-column justify-content-between" id="product_link_card">
										<div>
											<div class="d-flex justify-content-between align-items-center" style="margin-top:-25px;">
												<span class="ribbon3"><span class="text-white">${this.offpercent}</span></span>
												<span class="wishlist"><i class="fa fa-heart-o"></i></span>
											</div>
											<div class="image-container mt-5 me-5 zoom-img">
												<img src="${site_url}/media/${this.imgurl}" class="rounded zoom-img thumbnail-image">
											</div>
											<div class="product-detail-container p-2 mb-3">
												<div class="justify-content-between align-items-center">
													<p class="dress-name fs-5 mb-0 fs-5">${this.name}</p>	
													<div class="d-flex justify-content-start flex-row mt-2" style="width: 100%;">
														<span class="new-price mx-1" style="color: #ff6600;">${this.price}</span>
														<small class="old-price text-right mx-1" style="color: #ff6600;">${this.mrp}</small>
													</div>
												</div>
												<div class="d-flex justify-content-between align-items-center pt-1">
													<div>
														${ratingHTML}
													</div>
													<button class="text-center card_buy_btn btn-radious" type="button" onclick="add_to_cart_product(event, '${this.id}', '${this.sku}', '${this.vendor_id}', '${user_id}', '1', '0', '2', '${qoute_id}')">Add To Cart</button>
												</div>
											</div>
										</div>
									</a>
								</div>`;
							
						/*	product_html0 += '<a href="' +
								site_url +
								this.web_url +
								"?pid=" +
								this.id +
								"&sku=" +
								this.sku +
								"&sid=" +
								this.vendor_id +
								'" ><div class="card"><div class="card-img zoom-img"><img src="' + site_url + 'media/' +
								this.imgurl +
								'" class="card-img-top" alt="'+this.name+'" /><div class="favorite"><a onclick="add_to_wishlist(event,' +
								"'" +
								this.id +
								"','" +
								this.sku +
								"','" +
								this.vendor_id +
								"','" +
								user_id +
								"','1','0','2'," +
								"'" +
								qoute_id +
								"'" + ')" href="javascript:void(0);"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.08109 12.7492L10.4543 18.7362C10.6465 18.9167 10.7425 19.0069 10.852 19.0412C10.9492 19.0716 11.0534 19.0716 11.1507 19.0412C11.2601 19.0069 11.3561 18.9167 11.5483 18.7362L17.9215 12.7492C19.7147 11.0647 19.9324 8.29271 18.4243 6.34889L18.1407 5.98339C16.3366 3.65802 12.7151 4.048 11.4474 6.70417C11.2683 7.07937 10.7343 7.07937 10.5552 6.70417C9.28748 4.048 5.66605 3.65802 3.86189 5.98339L3.57831 6.34888C2.07017 8.29271 2.28793 11.0647 4.08109 12.7492Z" stroke=""/></svg></a></div>';
							
							product_html0 += '</div><div class="card-body"><h6 class="pd-title">' +
								this.name +
								'</h6><div class="row"><div class="col-6"><h6 class="old-price">' + this.mrp + '</h6><h5 class="new-price">' + this.price + '/-</h5></div><div class="col-6"><div class="btn-by-now"><a href="#" onclick="add_to_cart_product_buy(event,' +
								"'" +
								this.id +
								"','" +
								this.sku +
								"','" +
								this.vendor_id +
								"','" +
								user_id +
								"','1','0','2'," +
								"'" +
								qoute_id +
								"'" +
								')" class="btn btn-default w-100">Buy Now</a></div></div></div></div></div></a></div>'; */



						});
				var result = Paging(
				  response.pageno,
				  32,
				  response.total_product,
				  "page-link shadow",
				  "myDisableClass page-link shadow"
				);
				$(".pagingDiv").html(result);
			  } else {
				product_html = "No Record Found.";
			  }
			  $("#brand_product").html(product_html);
			},
		  });
		}

		$(document).ready(function () {
		  $(".pagingDiv").on("click", "a", function () {
			var pages = $(this).attr("pn") - 1;
			get_brand_product(hidden_brandid, "", pages);
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