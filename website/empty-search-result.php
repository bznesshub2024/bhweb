<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "No Search Result";
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
	
	<!--Start: Empty Search Result Section -->
	<section>
		<div class="container">
			<div class="wrap box-shadow">
				<img src="assets/images/empty-search-result.png" alt=""  class="empty-cart-img" />
				<h5>Sorry, no results found!</h5>
				<p>Please check the spelling or try searching for something else</p>
			</div>
		</div>
	</section>
	<!--End: Empty Search Result Section -->

</main>

 <?php
    include("includes/footer.php")
    ?>

    <?php
    include("includes/script.php")
    ?>
	
</body>
	
</html>
