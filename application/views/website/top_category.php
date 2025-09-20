<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "Top Category";
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

    <style>
        .image_container_cate {
            position: relative;
        }
        
        .dynamic_image{
            object-fit:fill;
        }

        .fix_image {
            position: absolute;
            bottom: 0;
            left: 0;
        }

        .image_text {
            position: absolute;
            bottom: 5px;
            left: 10px;
            color: white;
            font-size: 16px;
            font-weight: bold;
        }
		
		.all_category_div{
			width: 28%;
		}
		
		.cat_img
		{
			height : 400px;
		}
		
		@media (max-width: 500px) and (min-width: 200px){
            .all_category_div{
				width: 40%;
			}
        }

        @media (max-width: 420px) and (min-width: 200px){
            .image_text{
                font-size: 12px;
            }
        }
        
        @media (max-width: 767px) and (min-width: 421px){
            .image_text{
                font-size: 14px;
            }
        }
		
		@media (max-width: 767px)
		{
			.cat_img
			{
				height : 200px;
			}
		}

    </style>

    <main>

        <!-- Top Category section starts here  -->
        <section class="pt-md-2 pt-2 top-category">
            <div class="container-fluid">
                <div class="col-12">
                    <h5 class="mb-md-4" style="font-size:18px;">All Categories</h5>
                </div>
                <div class="row">
                    <?php foreach ($header_cat as $maincat1) { ?>
                        <div class="all_category_div my-3 border p-0 mx-3 border p-2 rounded border-secondary">
                            <a href="<?php echo base_url() . 'sub-category/' . $maincat1['cat_slug']; ?>" class="cat_img">
                                <div class="image_container_cate h-100">
                                    <div class="fix_image">
                                        <img src="<?= base_url ?>assets_web/images/all_category.png" alt="">
                                        <div class="image_text">
                                            <?php echo $maincat1['cat_name']; ?>    
                                        </div>
                                    </div>
                                    <div class="dynamic_image h-100">
                                        <img src="<?php echo MEDIA_URL . $maincat1['imgurl']; ?>" alt="" class="cat_img" style="object-fit:fill; width:100%;">
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
        <!-- Top Category section ends here  -->

        <!-- Trending Category section starts here  -->
        <!-- <section class="trending-category">
            <div class="container-fluid">
                <div class="col-12">
                    <h3 class="mb-md-4 fw-bold">Trending</h3>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 mb-4 mb-lg-6 mb-xxl-8">
                        <a href="/">
                            <div class="card position-relative">
                                <img src="<?php // echo base_url;
                                            ?>/assets_web/images/placeholders/top-cats-2.jpg" alt="" class="img-fluid">
                                <div class="card-overlay position-absolute top-0 start-0 p-4 py-lg-5 px-lg-5">
                                    <h5 class="fw-bold text-white">WINTER COLLECTION</h5>
                                    <p class="fw-bold text-primary mb-0">Min. 40% Off</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-md-6 mb-4 mb-lg-6 mb-xxl-8">
                        <a href="/">
                            <div class="card position-relative">
                                <img src="<?php // echo base_url;
                                            ?>/assets_web/images/placeholders/top-cats-1.jpg" alt="" class="img-fluid">
                                <div class="card-overlay position-absolute top-0 start-0 p-4 py-lg-5 px-lg-5">
                                    <h5 class="fw-bold text-white">GYM COLLECTION</h5>
                                    <p class="fw-bold text-primary mb-0">Min. 15% Off</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Trending Category section ends here  -->

    </main>

    <?php
    include("include/footer.php")
    ?>

    <?php
    include("include/script.php")
    ?>
</body>

</html>