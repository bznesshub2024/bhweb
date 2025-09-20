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
	
	<!--Start: 404-error Section -->
	<section>
		<div class="container">
			<div class="wrap box-shadow">
				<img src="assets/images/error-img.png" alt=""  class="empty-cart-img" />
				<h6>Unfortunately the page you are looking for has been moved or deleted</h6>
				<a href="javascript:void(0);" class="btn btn-default">GO TO HOMEPAGE</a>
			</div>
		</div>
	</section>
	<!--End: 404-error Section -->


</main>

 <?php
    include("includes/footer.php")
    ?>

    <?php
    include("includes/script.php")
    ?>
	
</body>
	
</html>
