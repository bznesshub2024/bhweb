<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "Home";
    include("include/headTag.php") ?>

</head>

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

    <main> 

        
    </main>
    <?php
    include("include/footer.php")
    ?>

    <?php
    include("include/script.php")
    ?>
	<script>
		function redirect_to_link(link) {
		  location.href = link;
		}
	</script>
</body>

</html>