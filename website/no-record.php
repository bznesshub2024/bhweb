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
				<img src="assets/images/empty-search-result.png" alt=""  class="empty-cart-img" />
				<h5>Sorry, no record found!</h5>
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
