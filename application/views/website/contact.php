<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "Contact Us";
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
		<?php
   // include("include/navForMobile.php")
    ?>
	
<main class="cart-page">

	
	<section id="privacy">

        <div class="container">
		
			<h2 class="title">Contact Us</h2><br>
			
<div class="row">
<div class="col-6">
<?php echo html_entity_decode($page_content); ?>
</div>

<div class="col-6">
<form action="<?php echo base_url('Home/contactsave'); ?>" method="post" class="p-3 border rounded shadow-sm bg-light">
       <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" 
           value="<?php echo $this->security->get_csrf_hash(); ?>" />

<div class="mb-3">
<label for="name" class="form-label">Name</label>
<input type="text" name="name" id="name" class="form-control" required>
</div>

<div class="mb-3">
<label for="email" class="form-label">Email</label>
<input type="email" name="email" id="email" class="form-control" required>
</div>

<div class="mb-3">
<label for="mobile" class="form-label">Mobile</label>
<input type="text" name="mobile" id="mobile" class="form-control" required>
</div>

<div class="mb-3">
<label for="message" class="form-label">Message</label>
<textarea name="message" id="message" class="form-control" rows="4" required></textarea>
</div>

<button type="submit" class="btn btn-primary w-100">Submit</button>
</form>
</div>
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
	
</body>
	
</html>
