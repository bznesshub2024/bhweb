<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "My Orders";
    include("include/headTag.php") ?>
</head>

<body>

	<?php
        include("include/topbar.php")
        ?>
        <?php
        include("include/navbar.php")
        ?>
	<?php // print_r($order); ?>
<main class="my-order-page cart-page"> 
	
	<!--Start: My Orders Section -->
	<section style="min-height:700px;">
		<div class="container" style="max-width:1344px;">
			<div class="row">
				<?php
				if (!empty($this->session->userdata("user_id"))) {
					include("include/sidebar.php");
				}
				?>
				<div class="col-lg-8">
					<div class="left-block box-shadow" id="MyProfile">
						<h5 class="title">My Orders <span class="d-lg-none">
						<?php if (!empty($this->session->userdata("user_id"))) { ?><a class="accordion-button collapsed" id="heading1" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">My Profile</a><?php } ?></span></h5>

						<?php
						if (!empty($this->session->userdata("user_id"))) {
							include("include/mobile_sidebar.php");
						}
						?>
						
						
						<?php foreach ($order as $order_history) { ?>
						<div class="cart-details">
							<a href="<?php echo base_url; ?>orderDetails/<?php echo $order_history['order_id']; ?>/<?php echo $order_history['prod_id']; ?>"><img src="<?php echo weburl . 'media/' . $order_history['prod_img']; ?>" class="product-thumb" /></a>
							<div class="cart-body">
								<h6 onclick="redirect_to_link('<?php echo base_url; ?>orderDetails/<?php echo $order_history['order_id']; ?>/<?php echo $order_history['prod_id']; ?>')"><?php echo $order_history['prod_name']; ?></h6>
								<div class="row">
									<div class="col-md-7 col-sm-6">
										<!--<div class="rate">
											<div class="rating">5.0 <img src="<?php // echo base_url;?>/assets_web/images/icons/star.png" /></div>
											<div class="rating-details">Excellent</div>
										</div>-->
										<div class="wrap-details">
											<div class="rate">
												<h5><?php echo $order_history['prod_price']; ?></h5>
												<!--<div class="old-price">₹1749</div>
												<div class="off-price">60% off</div>-->
											</div>
											<div class="qty">Qty: <?php echo $order_history['prod_qty']; ?></div>
											<div class="order-id"><span>Order ID:</span> <?php echo $order_history['order_id']; ?></div>
										</div>
									</div>
									<div class="col-md-5 col-sm-6">
										<div class="order-id"><span>Order Date:</span> <?php echo date('d-m-Y',strtotime($order_history['create_date']));  ?></div>
										<div class="order-id"><span>Order Status:</span> <?php echo $order_history['prod_status']; ?></div>
										<h6 class="track-order"><a href="<?php echo base_url; ?>orderDetails/<?php echo $order_history['order_id']; ?>/<?php echo $order_history['prod_id']; ?>">See Details</a></h6>
									</div>
								</div>
							</div>
						</div>
						<?php } ?>
						

					</div>
				</div>

			</div>
		</div>
	</section>
	<!--End: My Orders Section -->

</main>

 <?php
    include("include/footer.php")
    ?>

    <?php
    include("include/script.php")
    ?>
	<script>
	var csrfName = $('.txt_csrfname').attr('name');
 var csrfHash = $('.txt_csrfname').val();
 var site_url = $('.site_url').val();


function cancel_order(pid,order_id) {
	
	Swal.fire({
		 position: "center",
		 title: 'Are you Sure to Cancelled Order?',
		 showConfirmButton: true,
		 showCancelButton: true,
		 confirmButtonText: 'Confirm',
		 cancelButtonText: 'Cancel',
		 confirmButtonColor: '#f42525'
	 }).then((result) => {
		 if (result.isConfirmed) {
			 $.ajax({
				method: 'post',
				url: site_url+'cancelOrder',
				data: {language : 1 , pid : pid , order_id: order_id , [csrfName]: csrfHash},
				success: function(response){
					
					location.reload();
				}
		   });
			
		 }
	 })
	
}
	</script>
</body>
	
</html>
