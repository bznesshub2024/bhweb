<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "Top Category";
    include("include/headTag.php") ?>
</head>
<style>
    @media (max-width: 767.98px) {
        .top-category .card {
            height: 200px;
        }
    }
</style>

<body>
    <?php
    include("include/loader.php")
    ?>
    <?php
    include("include/topbar.php")
    ?>
    <?php
    include("include/navbar.php");
    ?>

    <style>
        .image_container_cate {
            position: relative;
        }

        .dynamic_image {
            object-fit: fill;
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
		
		.cat_img
		{
			height : 400px;
		}

        @media (max-width: 420px) and (min-width: 200px) {
            .image_text {
                font-size: 12px;
            }
        }

        @media (max-width: 767px) and (min-width: 421px) {
            .image_text {
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
        <section class="pt-md-2 pt-2 top-category" style="min-height:700px">
            <div class="container-fluid">
                   <h5 class="mb-md-4" style="font-size:13px;">Category >> <?php echo $sub_cat[0]['cat_name']; ?></h5>
                <div class="row">
                    <?php foreach ($sub_cat as $maincat) {  ?>
                        <?php
                        if (!empty($maincat['subcat_1'])) {
                            foreach ($maincat['subcat_1'] as $subcat_1) {

                        ?>
                                <!-- <div class="col-6 col-md-6 col-lg-3 mb-1 px-1">
                                    <a href="<?php echo base_url() . 'sub-category/' . $subcat_1['cat_slug']; ?>">
                                        <div class="card position-relative" style="border: 0.5px solid #ccc;">
                                            <img src="<?php echo MEDIA_URL . $subcat_1['imgurl']; ?>" alt="<?php echo $subcat_1['cat_name']; ?>" class="img-fluid">
                                            <div class="card-overlay position-absolute top-0 start-0 p-4 p-4 py-lg-5 px-lg-5">
                                                <p class="fw-bold text-primary mb-0">Min. 40% Off</p>
                                            </div>
                                        </div>
                                    </a>
                                    <h5 class="fw-bolder text-center text-dark mt-2"><?php echo $subcat_1['cat_name']; ?></h5>
                                </div> -->

                                <a href="<?php echo base_url() . 'sub-category/' . $subcat_1['cat_slug']; ?>" class="col-6 col-sm-4 col-lg-3 my-3 rounded py-2">
                                    <div class="border rounded border-secondary cat_img">
                                        <div class="image_container_cate h-100">
                                            <div class="fix_image">
                                                <img src="<?= base_url ?>assets_web/images/all_category.png" alt="">
                                                <div class="image_text">
                                                    <?php echo $subcat_1['cat_name']; ?>
                                                </div>
                                            </div>
                                            <div class="dynamic_image h-100">
                                                <img src="<?php echo MEDIA_URL . $subcat_1['imgurl']; ?>" alt="" style="object-fit:fill; width:100%; height:100%">
                                            </div>
                                        </div>
                                    
                                </div>
								</a>
                        <?php } 
                        } else {
                            redirect(base_url . $maincat['cat_slug']);
                        }

                        ?>
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