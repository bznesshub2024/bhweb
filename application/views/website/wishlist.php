<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "Wishlist";
    include("include/headTag.php") ?>
</head>

<body>

	<?php
        include("include/topbar.php")
        ?>
        <?php
        include("include/navbar.php")
        ?>
	
<main class="wishlist-page my-order-page cart-page">
	<?php // print_r($wishlist); ?>
	<!--Start: Wishlist Section -->
	<section>
		<div class="container" style="max-width:1344px;">
			<div class="row">
				<?php
				include("include/sidebar.php");
				?>
				<div class="col-lg-8">
					<div class="left-block box-shadow" id="MyProfile">
						<h5 class="title">My Wishlist (<?php echo $wishlist['total_item']; ?>) <span class="d-lg-none"><a class="accordion-button collapsed" id="heading1" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">My Profile</a></span></h5>

						<?php
						include("include/mobile_sidebar.php");
						?>
						<?php foreach ($wishlist['cart_full'] as $wishlist_product) { ?>
						<div class="cart-details">
							<a href="<?php echo base_url .'product/'. $wishlist_product['web_url']; ?>"><img src="<?php echo weburl . 'media/' . $wishlist_product['imgurl']; ?>" class="product-thumb" /></a>
							<div class="cart-body">
								<h6 onclick="redirect_to_link('<?php echo base_url .'product/'. $wishlist_product['web_url']; ?>')"><?php echo $wishlist_product['name']; ?></h6>
								<div class="row">
									<div class="col-md-6">
										<!--<div class="rate">
											<div class="rating">5.0 <img src="<?php // echo base_url;?>/assets_web/images/icons/star.png" /></div>
											<div class="rating-details">Excellent</div>
										</div>-->
										<div class="wrap-details">
											<div class="rate">
												<h5><?php echo $wishlist_product['price']; ?></h5>
												<div class="old-price"><?php echo $wishlist_product['mrp']; ?></div>
												<div class="off-price"><?php if($wishlist_product['totaloff'] != 0) { echo $wishlist_product['offpercent']; } ?></div>
											</div>
											<p>Stock : <?php echo $wishlist_product['available_stock']; ?></p>
											<div class="d-flex my-1">
												<a class="d-flex border btn btn-primary p-1" onclick="add_to_cart_product('<?php echo $wishlist_product['prodid']; ?>','<?php echo $wishlist_product['sku']; ?>','<?php echo $wishlist_product['vendor_id']; ?>','<?php echo $this->session->userdata('user_id'); ?>',1,'',2,'<?php echo $this->session->userdata('qoute_id'); ?>')" href="javascript:void(0);">
													<div class="d-flex justify-content-center align-items-center h-100">
														<i class="fa-solid fa-cart-shopping"></i>
														<div class="mx-2 mt-1 fw-bolder text-uppercase">Add to Cart</div>
													</div>
												</a>
												<a class="mx-2 p-2 border" onclick="delete_wishlist('<?php echo $wishlist_product['prodid']; ?>','<?php echo $this->session->userdata('user_id'); ?>',2)">
													<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="" class="bi bi-trash" viewBox="0 0 16 16">
														<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
														<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
													</svg>
												</a>
											</div>
										</div>
									</div>
								</div>
								<!-- <div style="margin-right:17px;">
								<a  onclick="delete_wishlist('<?php echo $wishlist_product['prodid']; ?>','<?php echo $this->session->userdata('user_id'); ?>',2)" class="remove d-sm-none0">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg>
									</a>
								</div> -->
							</div>
								

							
							<!-- <div class="favorite active"><a onclick="add_to_cart_product('<?php echo $wishlist_product['prodid']; ?>','<?php echo $wishlist_product['sku']; ?>','<?php echo $wishlist_product['vendor_id']; ?>','<?php echo $this->session->userdata('user_id'); ?>',1,'',2,'<?php echo $this->session->userdata('qoute_id'); ?>')" href="javascript:void(0);"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.08109 12.7492L10.4543 18.7362C10.6465 18.9167 10.7425 19.0069 10.852 19.0412C10.9492 19.0716 11.0534 19.0716 11.1507 19.0412C11.2601 19.0069 11.3561 18.9167 11.5483 18.7362L17.9215 12.7492C19.7147 11.0647 19.9324 8.29271 18.4243 6.34889L18.1407 5.98339C16.3366 3.65802 12.7151 4.048 11.4474 6.70417C11.2683 7.07937 10.7343 7.07937 10.5552 6.70417C9.28748 4.048 5.66605 3.65802 3.86189 5.98339L3.57831 6.34888C2.07017 8.29271 2.28793 11.0647 4.08109 12.7492Z" stroke=""/></svg></a></div>
							-->
						</div>
						<?php } ?>

						

						

					</div>
				</div>

			</div>
		</div>
	</section>
	<!--End: Wishlist Section -->

</main>

 <?php
    include("include/footer.php")
    ?>

    <?php
    include("include/script.php")
    ?>
	<script>
		 var csrfName = $('.txt_csrfname').attr('name'); // 
		 var csrfHash = $('.txt_csrfname').val(); // CSRF hash
		 var site_url = $('.site_url').val(); // CSRF hash


		function delete_wishlist(prod_id,user_id) {
			$.ajax({
				method: 'post',
				url: site_url+'deleteProductWishlist',
				data: {language : 1 , pid : prod_id , user_id: user_id , devicetype : 2  , [csrfName]: csrfHash},
				success: function(response){
					//hideloader();
						location.reload();
				}
		   });
		}


		function add_to_cart_product(pid,sku,vendor_id,user_id,qty,referid,devicetype,qouteid) {
			  event.preventDefault();
			$.ajax({
				method: 'post',
				url: site_url+'addProductCart',
				data: {language : 1 , pid : pid , sku : sku , sid : vendor_id , user_id: user_id , qty : qty , referid : referid , devicetype : 2 , qouteid : qouteid , [csrfName]: csrfHash},
				success: function(response){
					
				if (response.msg == 'Please select color / size')
				  {

					location.href =

					  site_url +

					  "product/" +

					  sku 

					;

				  }
					
					//alert(response.msg);Cart added
					/*Swal.fire({
						 position: "center",
						 icon: "success",
						 title: response.msg,
						 showConfirmButton: false,
						 confirmButtonColor: '#ff5400',
						 confirmButtonText: 'View Cart',
						 timer: 3000
					 });*/
					 if(response.msg == 'Cart added')
					 {
						 addto_cart_count();
						 delete_wishlist(pid,user_id);
					 }
					
					
					//delete_wishlist(pid,user_id);

					
				}
		   });
		}
	</script>
	
</body>
	
</html>
