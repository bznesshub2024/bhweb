<!DOCTYPE html>
<html lang="en">

<head>
	<?php $title = "Cart";
	include("include/headTag.php") ?>

</head>
<style>
label#Color {
     height: 30px;
    width: 30px;
    border-radius: 50%;
    margin-bottom: -10px;
}
label#Color {
		height: 22px;
		width: 22px;
		border-radius: 50%;
		margin-bottom: -7px;
	}
@media (max-width: 767.98px)
{
	p.text-muted.mt-2
	{
		height : 95px;
		font-size : 12px;
			
	}
	
	svg.bi.bi-trash {
		margin: 12px 5px 5px;
	}
}

@media (max-width: 991.98px){
	.right-block{
		background-color: transparent !important;
		padding: 0px !important;
	}
	.right_div{
		padding: 0px !important;
	}
	.total {
		margin: 0px !important;
	}
	.amount_continue{
		margin-top: 50px;
		background-color: white;
		padding: 13px;
	}
	.price-details, .continue{
		padding: 0px 22px;
	}
}

</style>


<body class="cart-body">

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
	//include("include/navForMobile.php")
	/*print_r($cart['total_item'])*/;
	?>

	<?php if ($cart['total_item'] == 0) { ?>
		<main class="empty-cart mt-0">
			<div class="d-flex align-items-center h-100 responsive_nav d-block d-sm-none">
				<svg class="fa-angle-left ms-3" onclick="history.back(-1)" width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M15.5 19.5 8 12l7.5-7.5" stroke="#303030" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
				</svg>
				<h4 class="text-dark ms-2 mb-0 fw-bold">You Shopping Cart</h4>
			</div>

			<!--Start: Empty Cart Section -->
			<section class="mt-5">
				<div class="container">
					<div class="wrap box-shadow">
						<img src="<?php echo base_url; ?>assets_web/images/empty-cart.png" alt="<?php echo website_name; ?>" class="empty-cart-img" />
						<h5>Your cart is empty!</h5>
						<p>Add items to it now.</p>
						<a href="<?php echo base_url; ?>" class="btn btn-default btn-radious">Shop Now</a>
					</div>
				</div>
			</section>
			<!--End: Empty Cart Section -->

		</main>
	<?php } else { ?>
		<main class="cart-page mt-0">

			<?php // print_r($cart); 
			?>
			<div class="d-flex align-items-center h-100 responsive_nav d-block d-sm-none">
				<svg class="fa-angle-left ms-3" onclick="history.back(-1)" width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M15.5 19.5 8 12l7.5-7.5" stroke="#303030" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
				</svg>
				<h4 class="text-dark ms-2 mb-0 fw-bold">Your Bucket</h4>
			</div>

			<!--Start: Cart Section -->
			<section class="mt-5">
				<div class="container" style="max-width:1344px;">

					<div class="row">
						<div class="col-lg-8">
							<div class="left-block box-shadow">
								<h5 class="title">Your cart is ready (<?php echo $cart['total_item']; ?>)</h5>

								<?php foreach ($cart['cart_full'] as $cart_product) { ?>
									<div class="cart-details mb-2 mb-lg-0 bg-white">
										<a class="ms-3" href="<?php echo base_url .'product/'. $cart_product['web_url']; ?>"><img src="<?php echo weburl . 'media/' . $cart_product['imgurl']; ?>" alt="<?php echo $cart_product['name']; ?>"  class="product-thumb" /></a>
										<div class="cart-body">

<a href="javascript:void(0);" class="d-sm-none0" onclick="add_to_wishlist(event,'<?php echo $cart_product['prodid'] ?>','<?php echo $cart_product['sku'] ?>','<?php echo $cart_product['vendor_id'] ?>','<?php echo $this->session->userdata('user_id'); ?>',1,'',2)" style="    float: right;
    margin-top: 7px;
    margin-right: 12px;">
    <?php
if(check_wishlist($cart_product['prodid'], $this->session->userdata('user_id')))
{
	echo '<i class="fa fa-heart"></i>';
}else{
	echo '<i class="far fa-heart"></i>';
}
?>
 Add to Wishlist</a>

											<!-- Delete Cart Button -->
											<a onclick="delete_cart('<?php echo $cart_product['prodid']; ?>','','<?php echo $cart['qoute_id']; ?>')" class="remove d-sm-none0" style="position:relative;top:6px;right:11px;">
												<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="" class="bi bi-trash" viewBox="0 0 16 16">
													<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
													<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
												</svg>
											</a>
											<h6 onclick="redirect_to_link('<?php echo base_url .'product/'. $cart_product['web_url']; ?>')"><?php echo $cart_product['name']; ?></h6>
											<p class="text-muted mt-2">
											<?php foreach ($cart_product['configure_attr'] as $conf_data) {
												
												echo '<span class="me-1"><b>'.$conf_data['attr_name'] .':</b></span><label';
												if($conf_data['attr_name'] == 'Color') 
												{
													echo ' style="background-color:' . $conf_data['item'] . '"' ;
												}
												echo ' class="ms-1 " id="'.$conf_data['attr_name'].'" >';
												if($conf_data['attr_name'] != 'Color') 
												{
													echo $conf_data['item'];
												}
												echo '</label>&nbsp;,&nbsp;'; } ?>
											</p>
											<div class="wrap">
												<div class="rate">
													<h5 class="new_price"><?php echo $cart_product['price']; ?></h5>
													<div class="old-price"><?php  if($cart_product['price'] != $cart_product['mrp']) { echo $cart_product['mrp']; } ?></div>
													<div class="off-price"><?php if ($cart_product['totaloff'] != 0) {
																				echo $cart_product['offpercent'];
																			} ?></div>
												</div>
												<div class="quantity-delete">
													<div class="quantity">
														<?php if($cart_product['qty'] == 1)
														{ ?>	
															<a  class="minus">
															<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M9 18C13.9706 18 18 13.9706 18 9C18 4.02944 13.9706 0 9 0C4.02944 0 0 4.02944 0 9C0 13.9706 4.02944 18 9 18ZM4 8C3.44772 8 3 8.44771 3 9C3 9.55229 3.44772 10 4 10H14C14.5523 10 15 9.55229 15 9C15 8.44771 14.5523 8 14 8H4Z" fill="" />
															</svg>
														</a>&nbsp;&nbsp;
														<?php } else { ?>
															<a onclick="add_product_qty('<?php echo $cart_product['prodid']; ?>','<?php echo $cart_product['sku']; ?>','<?php echo $cart_product['vendor_id']; ?>','<?php echo $this->session->userdata('user_id'); ?>',<?php echo $cart_product['qty']; ?>-1,'',2,'<?php echo $cart['qoute_id']; ?>')" class="minus">
															<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M9 18C13.9706 18 18 13.9706 18 9C18 4.02944 13.9706 0 9 0C4.02944 0 0 4.02944 0 9C0 13.9706 4.02944 18 9 18ZM4 8C3.44772 8 3 8.44771 3 9C3 9.55229 3.44772 10 4 10H14C14.5523 10 15 9.55229 15 9C15 8.44771 14.5523 8 14 8H4Z" fill="" />
															</svg>
														</a>&nbsp;&nbsp;
														<?php } ?>
														
														<span><input type="text" class="form-control" value="<?php echo $cart_product['qty']; ?>" /></span>
														<a onclick="add_product_qty('<?php echo $cart_product['prodid']; ?>','<?php echo $cart_product['sku']; ?>','<?php echo $cart_product['vendor_id']; ?>','<?php echo $this->session->userdata('user_id'); ?>',<?php echo $cart_product['qty'] + 1; ?>,'',2,'<?php echo $cart['qoute_id']; ?>')" class="plus">&nbsp;&nbsp;
															<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
																<path fill-rule="evenodd" clip-rule="evenodd" d="M18 9C18 13.9706 13.9706 18 9 18C4.02944 18 0 13.9706 0 9C0 4.02944 4.02944 0 9 0C13.9706 0 18 4.02944 18 9ZM9 15C8.44771 15 8 14.5523 8 14V10H4C3.44772 10 3 9.55229 3 9C3 8.44771 3.44772 8 4 8H8V4C8 3.44772 8.44771 3 9 3C9.55228 3 10 3.44772 10 4V8H14C14.5523 8 15 8.44771 15 9C15 9.55229 14.5523 10 14 10H10V14C10 14.5523 9.55229 15 9 15Z" fill="" />
															</svg>
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="right_div col-lg-4">
							<?php if (empty($cart['cart_full'])) { ?>
								<h4 class="fs-5 text-center mb-0"><?php if ($default_language == 1) {
																		echo 'البطاقه خاليه.';
																	} else {
																		echo 'Cart Is Empty.';
																	} ?></h4>
							<?php } else { ?>
								<div class="right-block box-shadow">
									<div class="price-details">
										<h5 class="text-start">Order Summary</h5>
										<p class="text-muted">Your order summary are below. We will deliver all the items at your doorstep with safety.</p>
										<ul class="price">
											<li>
												<h6 class="mt-0">Cart Value (<?php echo $cart['total_item']; ?> items)</h6>
											</li>
											<li>
												<h6><?php echo $cart['total_mrp']; ?></h6>
											</li>
										</ul>
										<ul class="discount py-0">
											<li>
												<h6 class="mt-0">Discount</h6>
											</li>
											<li>
												<h6>-<?php echo $cart['total_discount']; ?></h6>
											</li>
										</ul>
									</div>
									
									<!-- HIDDEN DISPLAY NONE -->
									<h5 class="save d-none">You will save <?php echo $cart['total_discount']; ?> on this order</h5>
									<ul class="proceed d-none">
										<li>
											<h6>Total</h6>
											<h5 class="tax"><?php echo $cart['payable_amount']; ?></h5>
										</li>
										<li><a href="javascript:void(0);" class="btn btn-default">Proceed</a></li>
									</ul>
									<!-- HIDDEN DISPLAY NONE -->
									
									<div class="amount_continue position-sticky w-100">
										<ul class="total">
											<li>
												<h5>Total Amount</h5>
											</li>
											<li>
												<h5><?php echo $cart['payable_amount']; ?></h5>
											</li>
										</ul>
										<a href="<?php echo base_url; ?>checkout" id="cart-continue-btn" class="btn btn-block btn-default w-100 btn-radious" style="bottom:10px;">Continue</a>
									</div>
									<div class="continue text-center">
										<h6 class="text-center">You will save <?php echo $cart['total_discount']; ?> on this order</h6>
									</div>
								</div>

								<div class="mb-block d-none">
									<h4>Order Summary</h4>
									<div class="wrap">
										<ul class="price">
											<li>
												<h6>Cart Value (<?php echo $cart['total_item']; ?> items)</h6>
											</li>
											<li>
												<h6><?php echo $cart['total_mrp']; ?></h6>
											</li>
										</ul>
										<ul class="price">
											<li>
												<h6>Discount</h6>
											</li>
											<li>
												<h6 class="discount">-<?php echo $cart['total_discount']; ?></h6>
											</li>
										</ul>
									</div>
									<ul class="price">
										<li>
											<h6>Total</h6>
											<h5 class="tax"><?php echo $cart['payable_amount']; ?></h5>
										</li>
										<li><a href="javascript:void(0);" class="btn btn-secondary">Proceed</a></li>
									</ul>
								</div>
							<?php } ?>
						</div>
					</div>

				</div>
			</section>
			<!--End: Cart Section -->

		</main>
	<?php } ?>

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