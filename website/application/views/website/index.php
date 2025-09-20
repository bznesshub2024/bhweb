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

        <section id="homeTopCategoryMobile" class="d-md-none mt-4">
            <div class="container-fluid homeTopCategoryMobileContainer">
                 <?php
					foreach($home_section5 as $home_section5_data){
						
						$img_decode1 = json_decode($home_section5_data->image);
						$img_url = MEDIA_URL . $img_decode1->{'470-720'};
					?>
				<div onclick="redirect_to_link('<?php echo base_url.$home_section5_data->cat_slug; ?>')" class="a-homeTopCategoryMobileCard me-4">
                    <div class="card">
                        <img src="<?php echo $img_url; ?>" alt="">
                        <div class="card-body p-0">
                            <p class="mb-0 mt-2 fs-small fw-semibold"><?php echo $home_section5_data->cat_name; ?></p>
                        </div>
                    </div>
                </div>
				
				<?php } ?>
                <!--<div class="a-homeTopCategoryMobileCard me-4">
                    <div class="card">
                        <img src="assets/images/placeholders/top-cats-2.jpg" alt="">
                        <p class="mb-0 mt-2 fs-small fw-semibold">Top selling</p>
                    </div>
                </div>-->
                
            </div>
        </section>
		
		<section id="heroHomeSlider" class="mt-6 mt-md-0">
		<?php foreach ($header_banner as $section1) { ?>
            <a  href="<?php echo $section1->link; ?>">
                <div class="a-slider-hero" style="background-image:url(<?php echo $section1->image; ?>);"></div>
            </a>
			 <?php } ?>
            
        </section>

       

        <section id="homeTopCategory" class="d-none d-md-block mt-6">
            <div class="container-fluid">
                <div class="col-12">
                    <h3 class="mb-md-4 fw-bold">Shop Our Top Categories</h3>
                </div>
				
                <div class="row">
					<?php
					foreach($home_section5 as $home_section5_data){
						
						$img_decode1 = json_decode($home_section5_data->image);
						$img_url = MEDIA_URL . $img_decode1->{'470-720'};
					?>
                    <div class="col-md-6 col-lg-3 mb-6">
                        <a href="<?php echo base_url.$home_section5_data->cat_slug; ?>">
                            <div class="card position-relative">
                                <img src="<?php echo $img_url; ?>" alt="" class="img-fluid">
                                <div class="card-overlay position-absolute top-0 start-0 p-4 p-4 py-lg-5 px-lg-5">
                                    <h5 class="fw-bold text-white"><?php echo $home_section5_data->cat_name; ?></h5>
                                    <p class="fw-bold text-primary mb-0"><?php echo $home_section5_data->sub_title; ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
					<?php } ?>
                    
                </div>
            </div>
        </section>
 
        <section id="homeTopSelling" class="mt-6">
            <div class="container-fluid">
                <div class="row mb-md-4">
                    <div class="col-8">
                        <h3 class=" fw-bold">New Products</h3>
                    </div>
                    <!--<div class="col-4 d-flex align-items-center justify-content-end">
                        <a href="" class="text-primary float-end fw-semibold text-decoration-none">Explore All</a>
                    </div>-->
                </div>
                <div class="a-homeTopSellingContainer">
				<?php foreach ($new_product as $new_product_data) {
					
					/*$img_decode1 = json_decode($new_product_data->imgurl);
					echo $img_url = MEDIA_URL . $img_decode1->{'600-600'};*/
					?>
                    <a href="<?php echo base_url.$new_product_data['sku'].'?pid='.$new_product_data['id'].'&sku='.$new_product_data['sku'].'&sid='.$new_product_data['vendor_id']; ?>" class="text-decoration-none me-2 me-md-3 me-xl-4">
                        <div class="card h-b position-relative">
                            <img src="<?php echo $new_product_data['imgurl']; ?>" class="card-img-top" alt="...">
                            <div class="favourite shadow">
                                <i class="bx bx-heart text-primary"></i>
                            </div>
                            <div class="card-body p-2 p-md-3 p-xl-4">
                                <h5 class="card-title fw-bold fs-6 fs-lg-5"><?php echo $new_product_data['name']; ?></h5>
                                <div class="d-flex w-100 justify-content-between">
                                    <div class="w-40 h-auto d-flex flex-column justify-content-between">
                                        <p class="my-md-2  mb-0 fw-semibold"><strike><?php echo $new_product_data['mrp']; ?></strike></p>
                                        <h5 class="mb-0 fw-bold"><?php echo $new_product_data['price']; ?></h5>
                                    </div>
                                    <div class="w-60">
                                        <p class="mb-1 text-end fw-bold text-primary"><?php echo $new_product_data['offpercent']; ?></p>
                                        <button class="btn btn-primary float-end fs-small fs-xl-6 px-2 py-1 px-md-3 py-md-2 px-xl-4">Buy Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
				<?php } ?>
					<!--<a href="/" class="text-decoration-none me-2 me-md-3 me-xl-4">
                        <div class="card h-100 position-relative">
                            <img src="assets/images/placeholders/top-cats.jpg" class="card-img-top" alt="...">
                            <div class="favourite shadow">
                                <i class="bx bx-heart text-primary"></i>
                            </div>
                            <div class="card-body p-2 p-md-3 p-xl-4">
                                <h5 class="card-title fw-bold fs-6 fs-lg-5">Banasari Saree Blue soft Silk 1</h5>
                                <div class="d-flex w-100 justify-content-between">
                                    <div class="w-40 h-auto d-flex flex-column justify-content-between">
                                        <p class="my-md-2  mb-0 fw-semibold"><strike>$1229</strike></p>
                                        <h5 class="mb-0 fw-bold">$729</h5>
                                    </div>
                                    <div class="w-60">
                                        <p class="mb-1 text-end fw-bold text-primary">37% Off</p>
                                        <button class="btn btn-primary float-end fs-small fs-xl-6 px-2 py-1 px-md-3 py-md-2 px-xl-4">Buy Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>-->
					
                </div>
            </div>
        </section>
		<?php

    $section4_image1 = $section4_link1 = '';


    foreach ($home_section4 as $section4) {
		

        $section4_image1 = $section4->image;

        $section4_link1 = $section4->link;

    }

    ?>

        <section id="homeOffers" class="mt-6">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <h3 class="mb-md-4 fw-bold">Offers</h3>
                    </div>
                </div>
				<div onclick="redirect_to_link('<?php echo $section4_link1; ?>')" class="a-homeOffers" style="background-image: url(<?php echo $section4_image1; ?>);"></div>
            </div>
        </section>

        <section id="homeFeaturedItem" class="mt-6">
            <div class="container-fluid">
                <div class="row mb-md-4">
                    <div class="col-8">
                        <h3 class=" fw-bold">Popular Items</h3>
                    </div>
                    <!--<div class="col-4 d-flex align-items-center justify-content-end">
                        <a href="" class="text-primary float-end fw-semibold text-decoration-none">Explore All</a>
                    </div>-->
                </div>
                <div class="a-homeFeaturedItemContainer">
					<?php foreach ($popular_product as $popular_product_data) {
					
					/*$img_decode1 = json_decode($new_product_data->imgurl);
					echo $img_url = MEDIA_URL . $img_decode1->{'600-600'};*/
					?>
                    <a href="<?php echo base_url.$popular_product_data['sku'].'?pid='.$popular_product_data['id'].'&sku='.$popular_product_data['sku'].'&sid='.$popular_product_data['vendor_id']; ?>" class="text-decoration-none me-2 me-md-3 me-xl-4">
                        <div class="card h-b position-relative">
                            <img src="<?php echo $popular_product_data['imgurl']; ?>" class="card-img-top" alt="...">
                            <div class="favourite shadow">
                                <i class="bx bx-heart text-primary"></i>
                            </div>
                            <div class="card-body p-2 p-md-3 p-xl-4">
                                <h5 class="card-title fw-bold fs-6 fs-lg-5"><?php echo $popular_product_data['name']; ?></h5>
                                <div class="d-flex w-100 justify-content-between">
                                    <div class="w-40 h-auto d-flex flex-column justify-content-between">
                                        <p class="my-md-2  mb-0 fw-semibold"><strike><?php echo $popular_product_data['mrp']; ?></strike></p>
                                        <h5 class="mb-0 fw-bold"><?php echo $popular_product_data['price']; ?></h5>
                                    </div>
                                    <div class="w-60">
                                        <p class="mb-1 text-end fw-bold text-primary"><?php echo $popular_product_data['offpercent']; ?></p>
                                        <button class="btn btn-primary float-end fs-small fs-xl-6 px-2 py-1 px-md-3 py-md-2 px-xl-4">Buy Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
				<?php } ?>
				
                    <!--<a href="/" class="text-decoration-none me-2 me-md-3 me-xl-4">
                        <div class="card h-100 position-relative">
                            <img src="assets/images/placeholders/top-cats.jpg" class="card-img-top" alt="...">
                            <div class="favourite shadow">
                                <i class="bx bx-heart text-primary"></i>
                            </div>
                            <div class="card-body p-2 p-md-3 p-xl-4">
                                <h5 class="card-title fw-bold fs-6 fs-lg-5">Banasari Saree Blue soft Silk 1</h5>
                                <div class="d-flex w-100 justify-content-between">
                                    <div class="w-40 h-auto d-flex flex-column justify-content-between">
                                        <p class="my-md-2  mb-0 fw-semibold"><strike>$1229</strike></p>
                                        <h5 class="mb-0 fw-bold">$729</h5>
                                    </div>
                                    <div class="w-60">
                                        <p class="mb-1 text-end fw-bold text-primary">37% Off</p>
                                        <button class="btn btn-primary float-end fs-small fs-xl-6 px-2 py-1 px-md-3 py-md-2 px-xl-4">Buy Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>-->
					
                </div>
            </div>
        </section>
		
		<?php

    $section6_image1 = $section6_link1 = '';


    foreach ($home_section6 as $section6) {
		

        $section6_image1 = $section6->image;

        $section6_link1 = $section6->link;

    }

    ?>

        <section id="homeOffers" class="mt-6">
            <div class="container-fluid">
                
				<div onclick="redirect_to_link('<?php echo $section6_link1; ?>')" class="a-homeOffers" style="background-image: url(<?php echo $section6_image1; ?>);"></div>
            </div>
        </section>
		
		
		 <section id="homeFeaturedItem" class="mt-6">
            <div class="container-fluid">
                
                <div class="a-homeFeaturedItemContainer">
					<?php foreach ($home_bottom_product as $home_bottom_product_data) {
					
					/*$img_decode1 = json_decode($new_product_data->imgurl);
					echo $img_url = MEDIA_URL . $img_decode1->{'600-600'};*/
					?>
                    <a href="<?php echo base_url.$home_bottom_product_data['sku'].'?pid='.$home_bottom_product_data['id'].'&sku='.$home_bottom_product_data['sku'].'&sid='.$home_bottom_product_data['vendor_id']; ?>" class="text-decoration-none me-2 me-md-3 me-xl-4">
                        <div class="card h-b position-relative">
                            <img src="<?php echo $home_bottom_product_data['imgurl']; ?>" class="card-img-top" alt="...">
                            <div class="favourite shadow">
                                <i class="bx bx-heart text-primary"></i>
                            </div>
                            <div class="card-body p-2 p-md-3 p-xl-4">
                                <h5 class="card-title fw-bold fs-6 fs-lg-5"><?php echo $home_bottom_product_data['name']; ?></h5>
                                <div class="d-flex w-100 justify-content-between">
                                    <div class="w-40 h-auto d-flex flex-column justify-content-between">
                                        <p class="my-md-2  mb-0 fw-semibold"><strike><?php echo $home_bottom_product_data['mrp']; ?></strike></p>
                                        <h5 class="mb-0 fw-bold"><?php echo $home_bottom_product_data['price']; ?></h5>
                                    </div>
                                    <div class="w-60">
                                        <p class="mb-1 text-end fw-bold text-primary"><?php echo $home_bottom_product_data['offpercent']; ?></p>
                                        <button class="btn btn-primary float-end fs-small fs-xl-6 px-2 py-1 px-md-3 py-md-2 px-xl-4">Buy Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
				<?php } ?>
				
                    <!--<a href="/" class="text-decoration-none me-2 me-md-3 me-xl-4">
                        <div class="card h-100 position-relative">
                            <img src="assets/images/placeholders/top-cats.jpg" class="card-img-top" alt="...">
                            <div class="favourite shadow">
                                <i class="bx bx-heart text-primary"></i>
                            </div>
                            <div class="card-body p-2 p-md-3 p-xl-4">
                                <h5 class="card-title fw-bold fs-6 fs-lg-5">Banasari Saree Blue soft Silk 1</h5>
                                <div class="d-flex w-100 justify-content-between">
                                    <div class="w-40 h-auto d-flex flex-column justify-content-between">
                                        <p class="my-md-2  mb-0 fw-semibold"><strike>$1229</strike></p>
                                        <h5 class="mb-0 fw-bold">$729</h5>
                                    </div>
                                    <div class="w-60">
                                        <p class="mb-1 text-end fw-bold text-primary">37% Off</p>
                                        <button class="btn btn-primary float-end fs-small fs-xl-6 px-2 py-1 px-md-3 py-md-2 px-xl-4">Buy Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>-->
					
                </div>
            </div>
        </section>

        <section id="homeMasonry" class="mt-6">
            <div class="container-fluid">
                <div class="a-Masonry">
				
					
                    <div onclick="redirect_to_link('<?php echo $home_bottom_banner[0]->link; ?>')" class="a-Masonry-1" style="background-image: url(<?php echo $home_bottom_banner[0]->image; ?>);"></div>
                    <div onclick="redirect_to_link('<?php echo $home_bottom_banner[1]->link; ?>')" class="a-Masonry-2" style="background-image: url(<?php echo $home_bottom_banner[1]->image; ?>);"></div>
                    <div onclick="redirect_to_link('<?php echo $home_bottom_banner[2]->link; ?>')" class="a-Masonry-3" style="background-image: url(<?php echo $home_bottom_banner[2]->image; ?>);"></div>
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
		function redirect_to_link(link) {
		  location.href = link;
		}
	</script>
</body>

</html>