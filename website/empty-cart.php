<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "Shopping Cart";
    include("includes/headTag.php") ?>
</head>

<body>

	<?php
        include("includes/topbar.php")
        ?>
        <?php
        include("includes/navbar.php")
        ?>
	
<main class="empty-cart">
	
	<!--Start: Empty Cart Section -->
	<section>
		<div class="container">
			<div class="wrap box-shadow">
				<img src="assets/images/empty-cart.png" alt=""  class="empty-cart-img" />
				<h5>Your cart is empty!</h5>
				<p>Add items to it now.</p>
				<a href="javascript:void(0);" class="btn btn-default">Shop Now</a>
			</div>
		</div>
	</section>
	<!--End: Empty Cart Section -->

</main>

 <?php
    include("includes/footer.php")
    ?>

    <?php
    include("includes/script.php")
    ?>
	
</body>
	
</html>
