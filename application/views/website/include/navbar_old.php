<style>
    .icon-count {
        position: absolute;
        top: -8px;
        right: -8px;
        background-color: red;
        color: white;
        font-size: 10px;
        font-weight: bold;
        padding: 0.5px 5px;
        border-radius: 50%;
    }

    .dropdown-menu li {
        position: relative;
    }

    .dropdown-menu .dropdown-submenu {
        display: none;
        position: absolute;
        left: 99.5%;
        top: -7px;
    }

    .dropdown-menu .dropdown-submenu-left {
        right: 100%;
        left: auto;
    }

    .dropdown-menu>li:hover>.dropdown-submenu {
        display: block;
    }
</style>
<!-- Offcanvas Navbar  -->
<nav class="navbar navbar-expand-lg bg-light shadow-sm">
    <div class="container-fluid">
        <div class="d-flex">
            <button class="navbar-toggler ps-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMarurang" aria-controls="offcanvasMarurang" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar_logo">
                <a href="/">
                    <img src="<?php echo base_url; ?>assets_web/images/Bussinesshub_logo.png" class="img-fluid navbar_logo_image" alt="Navbar Logo">
                </a>
            </div>
        </div>

        <div class="d-lg-none">
            <!--<a class="text-dark text-decoration-none me-2" href="#" data-bs-toggle="modal" data-bs-target="#searchModal">-->
            <a class="text-dark text-decoration-none me-2" href="#mbsearch" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="search">
                <i class="bx bx-search-alt-2 bx-sm"></i>
            </a>

            <?php if (!empty($this->session->userdata("user_id"))) { ?>
                <a href="<?php echo base_url; ?>/wishlist" class="text-dark text-decoration-none me-2">
                    <i class="bx bx-heart bx-sm"></i>
                </a>
            <?php } else { ?>
                <a href="" data-bs-toggle="modal" data-bs-target="#modalLogIn" class="text-dark text-decoration-none me-2">
                    <i class="bx bx-heart bx-sm"></i>
                </a>
            <?php } ?>

            <a href="<?php echo base_url; ?>cart" class="text-dark text-decoration-none position-relative d-inline-block">
                <i class="bx bx-cart bx-sm"></i>
                <span class="icon-count" id="badge-cart-count">0</span>
            </a>
        </div>


        <!--Start: Search -->

        <div class="collapse search-mb" id="mbsearch">
            <div class="p-2 d-flex align-items-center">
                <form action="<?php echo base_url ?>search/s" class="d-flex" role="search">
                    <input id="search" type="search" autocomplete="off" name="search" value="<?php if (isset($_REQUEST['search'])) {

                                                                                                    echo $_REQUEST['search'];
                                                                                                } ?>" class="form-control" placeholder="Search Product" />
                    <button class="btn" type="submit">
                        <i class="bx bx-search-alt-2 bx-sm"></i>
                    </button>
                    <img class="closeBtn" src="<?php echo base_url; ?>assets_web/images/icons/close.png" data-bs-toggle="collapse" href="#mbsearch" role="button" aria-expanded="false" aria-controls="search" />

                </form>
            </div>
            <ul class="dropdown-menu0 w-100 shadow-lg mb-0">
                <span id="search_div_mob"></span>

            </ul>
        </div>

        <!--End: Search -->

        <div class="collapse navbar-collapse d-none d-lg-flex">
            <ul class="navbar-nav w-lg-100 justify-content-lg-between ms-lg-4 ms-xl-10 ms-xxl-16 mb-2 mb-lg-0">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                    </button>

                    <!-- <ul class="dropdown-menu shadow-lg">
                        <?php foreach ($header_cat as $maincat) { ?>
                            <li><a class="dropdown-item" href="<?php echo base_url . 'sub_category/'; ?><?php echo $maincat['cat_slug']; ?>"><?php echo $maincat['cat_name']; ?></a></li>
                            <?php foreach ($maincat['subcat_1'] as $subcat_1) { ?>
                                <li><a class="dropdown-item" href="<?php echo base_url; ?><?php echo $subcat_1['cat_slug']; ?>"><?php echo $subcat_1['cat_name'] ?></a></li>
                        <?php }
                        } ?>
                        <li><a class="dropdown-item text-primary fw-bold text-center" href="<?php echo base_url; ?>/all_category">See All</a></li>

                    </ul> -->

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <?php foreach ($header_cat as $maincat) { ?>
                            <li>
                                <a class="dropdown-item" href="<?php echo base_url . 'sub_category/'; ?><?php echo $maincat['cat_slug']; ?>">
                                    <?= $maincat['cat_name'] ?><?= count($maincat['subcat_1']) > 0 ? '<span class="float-end">&raquo</span>' : '' ?>
                                </a>
                                <?php if (count($maincat['subcat_1']) > 0) : ?>
                                    <ul class="dropdown-menu dropdown-submenu">
                                        <?php foreach ($maincat['subcat_1'] as $subcat_1) { ?>
                                            <li>
                                                <a class="dropdown-item" href="<?php echo base_url; ?><?php echo $subcat_1['cat_slug']; ?>">
                                                    <?php echo $subcat_1['cat_name'] ?>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php } ?>
                        <li><a class="dropdown-item text-primary fw-bold text-center" href="<?php echo base_url; ?>/all_category">See All</a></li>
                    </ul>

                </div>
                <li class="nav-item">
                    <a class="nav-link" title="Deals" href="<?php echo base_url(); ?>all_category">Top</a>
                </li>
                <!--<li class="nav-item">
                    <a class="nav-link" title="Explore" href="<?php // echo base_url(); 
                                                                ?>explore">Explore</a>
                </li>-->
                <div class="dropdown explore">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Explore
                    </button>

                    <ul class="dropdown-menu shadow-lg">
                        <li><a class="dropdown-item" href="<?php echo base_url(); ?>explore_sub/10">Design Your Own Custom Clothing</a></li>
                        <li><a class="dropdown-item" href="<?php echo base_url(); ?>offers">Offers for you</a></li>
                        <li><a class="dropdown-item" href="<?php echo base_url(); ?>coupon_list">Coupons</a></li>
                        <li><a class="dropdown-item" href="<?php echo base_url(); ?>become_seller">Become a Seller</a></li>

                    </ul>
                </div>

                <li class="w-100 w-lg-45 w-xl-60">
                    <form action="<?php echo base_url ?>search/s" class="d-flex" role="search">
                        <div class="dropdown d-flex w-100">
                            <input class="form-control me-2 dropdown-toggle" autocomplete="off" id="search" type="search" name="search" value="<?php if (isset($_REQUEST['search'])) {

                                                                                                                                                    echo $_REQUEST['search'];
                                                                                                                                                } ?>" placeholder="Search" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Search">
                            <ul class="dropdown-menu w-100 shadow-lg">
                                <!--<li><a class="dropdown-item" href="#">
                                        <span class="d-inline-flex align-items-center"><i class="bx bx-search me-2"></i>Skirt</span>
                                    </a></li>
                                <li><a class="dropdown-item" href="#">
                                        <span class="d-inline-flex align-items-center"><i class="bx bx-search me-2"></i>Mini Skirt</span>
                                    </a></li>-->
                                <span id="search_div"></span>

                                <!--<li><a class="dropdown-item" href="#">
                                        <div class="card search-card">
                                            <div class="d-flex ">
                                                <div class="d-flex-center search-card_image" style="background-image: url(<?php // echo base_url; 
                                                                                                                            ?>assets_web/images/placeholders/top-cats-1.jpg);"></div>
                                                <div class="w-100">
                                                    <div class="card-body py-2 h-100 d-flex flex-column justify-content-evenly">
                                                        <div class="w-100 d-flex justify-content-between">
                                                            <h6 class="card-title">Mini Skirt Black</h6>
                                                            <div class="card-rating">
                                                                <i class="bx bxs-star"></i>
                                                                <i class="bx bxs-star"></i>
                                                                <i class="bx bxs-star"></i>
                                                                <i class="bx bxs-star-half"></i>
                                                                <i class="bx bx-star"></i>
                                                            </div>
                                                        </div>
                                                        <p class="card-text"><small class="text-muted">In Skirt</small></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li><a class="dropdown-item" href="#">
                                        <div class="card search-card">
                                            <div class="d-flex ">
                                                <div class="d-flex-center search-card_image" style="background-image: url(<?php // echo base_url; 
                                                                                                                            ?>assets_web/images/placeholders/top-cats-2.jpg);"></div>
                                                <div class="w-100">
                                                    <div class="card-body py-2 h-100 d-flex flex-column justify-content-evenly">
                                                        <div class="w-100 d-flex justify-content-between">
                                                            <h6 class="card-title">Mini Skirt Black</h6>
                                                            <div class="card-rating">
                                                                <i class="bx bxs-star"></i>
                                                                <i class="bx bxs-star"></i>
                                                                <i class="bx bxs-star"></i>
                                                                <i class="bx bxs-star-half"></i>
                                                                <i class="bx bx-star"></i>
                                                            </div>
                                                        </div>
                                                        <p class="card-text"><small class="text-muted">In Skirt</small></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>-->


                            </ul>
                            <button class="btn" type="submit">
                                <i class="bx bx-search"></i>
                            </button>
                        </div>
                    </form>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url(); ?>cart" title="Cart">
                        <span class="d-inline-flex align-items-end">
                            <i class="bx bx-cart bx-sm me-1"></i>Cart
                            &nbsp;<span id="cart_count"></span>
                        </span>
                    </a>
                </li>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" title="Profile" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-user-circle bx-sm"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg">
                        <?php if (!empty($this->session->userdata("user_id"))) { ?>
                            <li class="fw-bold text-center my-2">Hello <?php echo $this->session->userdata("user_name") ?></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        <?php } ?>

                        <?php if (empty($this->session->userdata("user_id"))) { ?>
                            <li><a class="dropdown-item d-inline-flex align-items-center" href="" data-bs-toggle="modal" data-bs-target="#modalLogIn"><i class="bx bx-log-in me-2"></i>Log In</a></li>
                            <li><a class="dropdown-item d-inline-flex align-items-center" href="<?php echo base_url ?>track"><i class="bx bx-time me-2"></i>Track orders</a></li>
                        <?php } else { ?>
                            <li><a class="dropdown-item d-inline-flex align-items-center" href="<?php echo base_url ?>notification"><i class="bx bx-bell me-2"></i>Notification</a></li>
                            <li><a class="dropdown-item d-inline-flex align-items-center" href="<?php echo base_url ?>myaddress"><i class="bx bx-map me-2"></i>My Address</a></li>
                            <li><a class="dropdown-item d-inline-flex align-items-center" href="<?php echo base_url ?>offers"><i class="bx bx-line-chart-down me-2"></i>Offers for you</a></li>
                            <li><a class="dropdown-item d-inline-flex align-items-center" href="<?php echo base_url ?>order"><i class="bx bx-package me-2"></i>My orders</a></li>
                            <li><a class="dropdown-item d-inline-flex align-items-center" href="<?php echo base_url ?>track"><i class="bx bx-time me-2"></i>Track orders</a></li>
                            <li><a class="dropdown-item d-inline-flex align-items-center" href="<?php echo base_url ?>wishlist"><i class="bx bx-heart me-2"></i>Wishlist</a></li>
                            <!--&nbsp;<span id="wishlist_count"></span>-->

                            <li><a class="dropdown-item d-inline-flex align-items-center" href="<?php echo base_url; ?>logout"><i class="bx bx-log-out me-2"></i>Logout</a></li>
                        <?php } ?>


                    </ul>
                </div>
            </ul>
        </div>
    </div>
</nav>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMarurang" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header bg-primary">
        <div class="d-flex flex-column">
            <?php if (!empty($this->session->userdata("user_id"))) { ?>
                <h5 class="offcanvas-title text-light fw-bold" id="offcanvasMarurangLabel">Hello <?php echo $this->session->userdata("user_name") ?></h5>
                <p class="mb-0 text-light fw-semibold">+91 <?php echo $this->session->userdata("user_phone") ?></p>
            <?php } else { ?>
                <h5 class="offcanvas-title text-light fw-bold" id="offcanvasMarurangLabel">Guest</h5>
            <?php } ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">

            <li class="nav-item">
                <a class="nav-link d-inline-flex align-items-center" href="<?php echo base_url ?>"><svg class="me-2" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.336 2.253a1 1 0 0 1 1.328 0l9 8a1 1 0 0 1-1.328 1.494L20 11.45V19a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-7.55l-.336.297a1 1 0 0 1-1.328-1.494l9-8zM6 9.67V19h3v-5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v5h3V9.671l-6-5.333-6 5.333zM13 19v-4h-2v4h2z" fill="#0D0D0D" />
                    </svg>Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-inline-flex align-items-center" href="<?php echo base_url ?>all_category"><svg class="me-2" width="18" height="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 3H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM9 9H5V5h4v4zm11-6h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm-1 6h-4V5h4v4zm-9 4H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1zm-1 6H5v-4h4v4zm8-6c-2.206 0-4 1.794-4 4s1.794 4 4 4 4-1.794 4-4-1.794-4-4-4zm0 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2z" />
                    </svg>All Categories</a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-inline-flex align-items-center" href="<?php echo base_url ?>explore_sub/10"><svg fill="#000000" class="me-2" width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">

                        <title />

                        <g data-name="Layer 2" id="Layer_2">

                            <path d="M13.68,3.79a1.77,1.77,0,0,1-3.37,0l-.73-2.2L2,5.38V12H5V22H19V12h3V5.38L14.42,1.59Zm1.9.63h0L20,6.62V10H17V20H7V10H4V6.62L8.42,4.41h0a3.77,3.77,0,0,0,7.16,0Z" />

                            <rect height="2" width="3" x="13" y="10" />

                        </g>

                    </svg>Design your own custom clothing</a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-inline-flex align-items-center" href="<?php echo base_url ?>become_seller"><svg class="me-2" fill="#000000" width="18" height="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22,7.82a1.25,1.25,0,0,0,0-.19v0h0l-2-5A1,1,0,0,0,19,2H5a1,1,0,0,0-.93.63l-2,5h0v0a1.25,1.25,0,0,0,0,.19A.58.58,0,0,0,2,8H2V8a4,4,0,0,0,2,3.4V21a1,1,0,0,0,1,1H19a1,1,0,0,0,1-1V11.44A4,4,0,0,0,22,8V8h0A.58.58,0,0,0,22,7.82ZM13,20H11V16h2Zm5,0H15V15a1,1,0,0,0-1-1H10a1,1,0,0,0-1,1v5H6V12a4,4,0,0,0,3-1.38,4,4,0,0,0,6,0A4,4,0,0,0,18,12Zm0-10a2,2,0,0,1-2-2,1,1,0,0,0-2,0,2,2,0,0,1-4,0A1,1,0,0,0,8,8a2,2,0,0,1-4,.15L5.68,4H18.32L20,8.15A2,2,0,0,1,18,10Z" />
                    </svg>Become a Seller</a>
            </li>
            <hr>
            <li class="nav-item">
                <a class="nav-link d-inline-flex align-items-center" href="<?php echo base_url ?>/cart"><svg class="me-2" width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M16.5131 6L7.48727 6C7.29999 6 7.11329 6.02105 6.9307 6.06274C5.58464 6.37013 4.74263 7.71051 5.05002 9.05657L5.96345 13.0566C6.2231 14.1936 7.23443 15 8.40071 15L15.5996 15C16.7659 15 17.7772 14.1936 18.0369 13.0566L18.9503 9.05657C18.992 8.87398 19.0131 8.68729 19.0131 8.5C19.0131 7.11929 17.8938 6 16.5131 6ZM7.37596 8.01255C7.41248 8.00421 7.44982 8 7.48727 8L16.5131 8C16.7892 8 17.0131 8.22386 17.0131 8.5C17.0131 8.53746 17.0089 8.5748 17.0005 8.61131L16.0871 12.6113C16.0352 12.8387 15.8329 13 15.5996 13L8.40071 13C8.16745 13 7.96519 12.8387 7.91326 12.6113L6.99982 8.61131C6.93835 8.3421 7.10675 8.07403 7.37596 8.01255Z" fill="#000000" />
                        <path d="M3.49044 2L2 2C1.44772 2 1 1.55228 1 1C1 0.447715 1.44772 0 2 0L4.28977 0C4.75718 0 5.16223 0.323776 5.2652 0.779696L7.97543 12.7797C8.0971 13.3184 7.75902 13.8538 7.2203 13.9754C6.68159 14.0971 6.14624 13.759 6.02457 13.2203L3.49044 2Z" fill="#000000" />
                        <path d="M10 17.25C10 18.2165 9.2165 19 8.25 19C7.2835 19 6.5 18.2165 6.5 17.25C6.5 16.2835 7.2835 15.5 8.25 15.5C9.2165 15.5 10 16.2835 10 17.25Z" fill="#000000" />
                        <path d="M17 17.25C17 18.2165 16.2165 19 15.25 19C14.2835 19 13.5 18.2165 13.5 17.25C13.5 16.2835 14.2835 15.5 15.25 15.5C16.2165 15.5 17 16.2835 17 17.25Z" fill="#000000" />
                    </svg>My Cart</a>
            </li>
            <?php if (!empty($this->session->userdata("user_id"))) { ?>
                <li class="nav-item">
                    <a class="nav-link d-inline-flex align-items-center" href="<?php echo base_url ?>notification"><svg class="me-2" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.146 3.248a2 2 0 0 1 3.708 0A7.003 7.003 0 0 1 19 10v4.697l1.832 2.748A1 1 0 0 1 20 19h-4.535a3.501 3.501 0 0 1-6.93 0H4a1 1 0 0 1-.832-1.555L5 14.697V10c0-3.224 2.18-5.94 5.146-6.752zM10.586 19a1.5 1.5 0 0 0 2.829 0h-2.83zM12 5a5 5 0 0 0-5 5v5a1 1 0 0 1-.168.555L5.869 17H18.13l-.963-1.445A1 1 0 0 1 17 15v-5a5 5 0 0 0-5-5z" fill="#0D0D0D" />
                        </svg>Notifications</a>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link d-inline-flex align-items-center" href="" data-bs-toggle="modal" data-bs-target="#modalLogIn"><svg class="me-2" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.146 3.248a2 2 0 0 1 3.708 0A7.003 7.003 0 0 1 19 10v4.697l1.832 2.748A1 1 0 0 1 20 19h-4.535a3.501 3.501 0 0 1-6.93 0H4a1 1 0 0 1-.832-1.555L5 14.697V10c0-3.224 2.18-5.94 5.146-6.752zM10.586 19a1.5 1.5 0 0 0 2.829 0h-2.83zM12 5a5 5 0 0 0-5 5v5a1 1 0 0 1-.168.555L5.869 17H18.13l-.963-1.445A1 1 0 0 1 17 15v-5a5 5 0 0 0-5-5z" fill="#0D0D0D" />
                        </svg>Notifications</a>
                </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link d-inline-flex align-items-center" href="<?php echo base_url ?>coupon_list"><svg class="me-2" fill="#000000" width="18" height="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M15,6 C15,6.55228475 14.5522847,7 14,7 C13.4477153,7 13,6.55228475 13,6 L3,6 L3,7.99946819 C4.2410063,8.93038753 5,10.3994926 5,12 C5,13.6005074 4.2410063,15.0696125 3,16.0005318 L3,18 L13,18 C13,17.4477153 13.4477153,17 14,17 C14.5522847,17 15,17.4477153 15,18 L21,18 L21,16.0005318 C19.7589937,15.0696125 19,13.6005074 19,12 C19,10.3994926 19.7589937,8.93038753 21,7.99946819 L21,6 L15,6 Z M23,18 C23,19.1045695 22.1045695,20 21,20 L3,20 C1.8954305,20 1,19.1045695 1,18 L1,14.8880798 L1.49927404,14.5992654 C2.42112628,14.0660026 3,13.0839642 3,12 C3,10.9160358 2.42112628,9.93399737 1.49927404,9.40073465 L1,9.11192021 L1,6 C1,4.8954305 1.8954305,4 3,4 L21,4 C22.1045695,4 23,4.8954305 23,6 L23,9.11192021 L22.500726,9.40073465 C21.5788737,9.93399737 21,10.9160358 21,12 C21,13.0839642 21.5788737,14.0660026 22.500726,14.5992654 L23,14.8880798 L23,18 Z M14,16 C13.4477153,16 13,15.5522847 13,15 C13,14.4477153 13.4477153,14 14,14 C14.5522847,14 15,14.4477153 15,15 C15,15.5522847 14.5522847,16 14,16 Z M14,13 C13.4477153,13 13,12.5522847 13,12 C13,11.4477153 13.4477153,11 14,11 C14.5522847,11 15,11.4477153 15,12 C15,12.5522847 14.5522847,13 14,13 Z M14,10 C13.4477153,10 13,9.55228475 13,9 C13,8.44771525 13.4477153,8 14,8 C14.5522847,8 15,8.44771525 15,9 C15,9.55228475 14.5522847,10 14,10 Z" />
                    </svg>Coupons</a>
            </li>
            <li class="nav-item">
                <a class="nav-link d-inline-flex align-items-center" href="<?php echo base_url ?>offers"><svg class="me-2" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 16L16 8M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12ZM17 15C17 16.1046 16.1046 17 15 17C13.8954 17 13 16.1046 13 15C13 13.8954 13.8954 13 15 13C16.1046 13 17 13.8954 17 15ZM11 9C11 10.1046 10.1046 11 9 11C7.89543 11 7 10.1046 7 9C7 7.89543 7.89543 7 9 7C10.1046 7 11 7.89543 11 9Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>Offers for you</a>
            </li>
            <hr>
            <?php if (!empty($this->session->userdata("user_id"))) { ?>
                <li class="nav-item">
                    <a class="nav-link d-inline-flex align-items-center" href="<?php echo base_url ?>order"><svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="16.5" y1="9.4" x2="7.5" y2="4.21" />
                            <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" />
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                            <line x1="12" y1="22.08" x2="12" y2="12" />
                        </svg>My Orders</a>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link d-inline-flex align-items-center" href="" data-bs-toggle="modal" data-bs-target="#modalLogIn"><svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="16.5" y1="9.4" x2="7.5" y2="4.21" />
                            <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" />
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                            <line x1="12" y1="22.08" x2="12" y2="12" />
                        </svg>My Orders</a>
                </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link d-inline-flex align-items-center" href="<?php echo base_url ?>track"><svg class="me-2" fill="#000000" width="17" height="17" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M12,23 C5.92486775,23 1,18.0751322 1,12 C1,5.92486775 5.92486775,1 12,1 C18.0751322,1 23,5.92486775 23,12 C23,18.0751322 18.0751322,23 12,23 Z M12,21 C16.9705627,21 21,16.9705627 21,12 C21,7.02943725 16.9705627,3 12,3 C7.02943725,3 3,7.02943725 3,12 C3,16.9705627 7.02943725,21 12,21 Z M13,11 L17,11 L17,13 L11,13 L11,6 L13,6 L13,11 Z" />
                    </svg>Track Orders</a>
            </li>
            <?php if (!empty($this->session->userdata("user_id"))) { ?>
                <li class="nav-item">
                    <a class="nav-link d-inline-flex align-items-center" href="<?php echo base_url ?>myaddress"><svg class="me-2" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2c-4.4 0-8 3.6-8 8 0 5.4 7 11.5 7.3 11.8.2.1.5.2.7.2.2 0 .5-.1.7-.2.3-.3 7.3-6.4 7.3-11.8 0-4.4-3.6-8-8-8zm0 17.7c-2.1-2-6-6.3-6-9.7 0-3.3 2.7-6 6-6s6 2.7 6 6-3.9 7.7-6 9.7zM12 6c-2.2 0-4 1.8-4 4s1.8 4 4 4 4-1.8 4-4-1.8-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z" fill="#0D0D0D" />
                        </svg>My Address</a>
                </li>
            <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link d-inline-flex align-items-center" href="" data-bs-toggle="modal" data-bs-target="#modalLogIn"><svg class="me-2" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2c-4.4 0-8 3.6-8 8 0 5.4 7 11.5 7.3 11.8.2.1.5.2.7.2.2 0 .5-.1.7-.2.3-.3 7.3-6.4 7.3-11.8 0-4.4-3.6-8-8-8zm0 17.7c-2.1-2-6-6.3-6-9.7 0-3.3 2.7-6 6-6s6 2.7 6 6-3.9 7.7-6 9.7zM12 6c-2.2 0-4 1.8-4 4s1.8 4 4 4 4-1.8 4-4-1.8-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z" fill="#0D0D0D" />
                        </svg>My Address</a>
                </li>
            <?php } ?>
            <hr>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url ?>about">About Us</a>
            </li>

            <li>
                <div class="accordion accordion-flush bg-light" id="accordionMarurangNavbar">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed px-0 py-2" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                Contact Us
                            </button>
                        </h2>

                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionMarurangNavbar">
                            <div class="accordion-body p-0 bg-white">
                                <ul class="list-unstyled ps-4">
                                    <li><a href="<?php echo base_url ?>faq" class="text-decoration-none text-dark">FAQ</a></li>
                                    <li><a href="<?php echo base_url ?>feedback" class="text-decoration-none text-dark">Feedback</a></li>
                                    <li><a href="<?php echo base_url ?>contact" class="text-decoration-none text-dark">Contact Us</a></li>
                                    <li><a href="<?php echo base_url ?>help" class="text-decoration-none text-dark">Help & Support</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="">Download Our App</a>
            </li>
            <li class="py-1"><a href="<?php echo base_url ?>privacy" class="text-decoration-none text-dark">Privacy Policy</a></li>
            <li class="py-1"><a href="<?php echo base_url ?>tearm" class="text-decoration-none text-dark">Terms & Condition</a></li>
            <li class="py-1"><a href="<?php echo base_url ?>refund" class="text-decoration-none text-dark">Refund Policy</a></li>
        </ul>
        <hr>
    </div>
    <?php if (!empty($this->session->userdata("user_id"))) { ?>
        <div class="offcanvas-footer p-3 bg-primary" onclick="testLogout()">
            <a href="<?php echo base_url; ?>logout">
                <h6 class="text-light fw-bold text-center d-inline-flex align-items-center mb-0 w-100 justify-content-center"><i class="bx bx-log-out bx-sm me-2"></i>Logout</h6>
            </a>
        </div>
    <?php } else { ?>
        <div class="offcanvas-footer p-3 bg-primary" onclick="testLogout()">
            <a href="" data-bs-toggle="modal" data-bs-target="#modalLogIn">
                <h6 class="text-light fw-bold text-center d-inline-flex align-items-center mb-0 w-100 justify-content-center"><i class="bx bx-log-out bx-sm me-2"></i>Log In</h6>
            </a>
        </div>
    <?php } ?>
</div>



<!-- Mobile Search Modal  -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="searchModalLabel"></h5>
                <button type="button" class="btn-close bg-light rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body w-100 h-100 d-flex align-items-center justify-content-center">
                <div class=" container">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-10 col-lg-8 col-xl-6 mx-auto">
                            <form action="<?php echo base_url ?>search/s" class="d-flex" role="search">
                                <input class="form-control me-2" autocomplete="off" id="search" type="search" name="search" value="<?php if (isset($_REQUEST['search'])) {

                                                                                                                                        echo $_REQUEST['search'];
                                                                                                                                    } ?>" type="search" placeholder="Search" aria-label="Search">
                                <button class="btn btn-primary d-flex text-light d-flex-center" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Log in Modal -->
<div class="modal fade" id="modalLogIn" tabindex="-1" aria-labelledby="modalLogInLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-0">
            <div class="modal-body p-0">
                <div class="container-fluid px-3">
                    <div class="row">
                        <div class="col-12 col-lg-5 col-xl-4 p-6 py-lg-14 px-lg-14 p-xl-10 h-auto d-flex flex-column justify-content-between bg-primary py-8">
                            <h2 class="text-center fw-bold text-light mb-0">Log In</h2>
                            <p class="mb-0 text-center fw-semibold text-light mt-4">Get access to your Orders, Wishlist and Recommendations</p>
                        </div>
                        <!-- when change the visiblility change d-flex class to  d-none -->
                        <!-- demo on global.js -->
                        <div class="col-12 col-lg-7 col-xl-8 p-6 p-md-10 py-lg-16 px-lg-16 h-auto d-flex flex-column justify-content-between py-12" id="enterNumberLogin">
                            <form action="">
                                <input class="form-control border-top-0 border-end-0 border-start-0 border-bottom rounded-0" type="text" onkeypress="return AllowOnlyNumbers(event);" maxlength="10" type="text" id="log_mobileno" placeholder="Enter Mobile Number" aria-label="Enter Phone Number">
                                <span id="phonevl_error" style="color:red;"></span>
                                <p class="text-muted mt-8 mt-lg-10 mb-0">By continue, you agree to <a href="" class="text-decoration-none">Bussinesshub`s Terms of Use</a> and <a href="" class="text-decoration-none">Privacy Policy</a>.</p>
                                <button class="btn btn-primary mt-6 mt-lg-4 w-100 fw-bold text-light rounded-0" onclick="call_login(); return false;" id="sendOtpLogInBtn">SEND OTP</button>
                            </form>
                            <a href="" class="text-decoration-none mt-8 text-center d-block mb-lg-16" data-bs-toggle="modal" data-bs-target="#modalSignUp">New to Bussinesshub? Create an Account</a>
                        </div>
                        <!-- when change the visiblility change d-none class to d-flex  -->
                        <!-- demo on global.js -->
                        <div class="col-12 col-lg-7 col-xl-8 p-6 p-md-10 py-lg-16 px-lg-16 h-auto d-none flex-column justify-content-between py-12" id="enterOtpLogin">
                            <p class="text-muted mb-8 mb-lg-10 text-center">Please enter the OTP sent to Your Mobile. <a href="" class="text-decoration-none">Change ?</a></p>
                            <form action="">
                                <input class="form-control border-top-0 border-end-0 border-start-0 border-bottom rounded-0" type="text" id="otp_login" placeholder="Enter OTP Sent to Mobile" aria-label="Enter OTP Sent to Mobile">
                                <span style="color:red" id="error_msg"></span>
                                <button class="btn btn-primary mt-8 mt-lg-8 w-100 fw-bold text-light rounded-0" onclick="call_login_otp(); return false;">Verify</button>
                            </form>
                            <!--<p class="mb-0 mt-8 text-center mb-lg-16">
                                Not Received your code? <a href="" class="text-decoration-none">Resend</a>
                            </p>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sign Up Modal -->
<div class="modal fade" id="modalSignUp" tabindex="-1" aria-labelledby="modalSignUpLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-0">
            <div class="modal-body p-0">
                <div class="container-fluid px-3">
                    <div class="row">
                        <div class="col-12 col-lg-5 col-xl-4 p-6 py-lg-14 px-lg-14 p-xl-10 h-auto d-flex flex-column justify-content-between bg-primary py-8">
                            <h2 class="text-center fw-bold text-light mb-0">Sign Up</h2>
                            <p class="mb-0 text-center fw-semibold text-light mt-4">Get access to your Orders, Wishlist and Recommendations</p>
                        </div>
                        <!-- when change the visiblility change d-flex class to  d-none -->
                        <!-- demo on global.js -->
                        <div class="col-12 col-lg-7 col-xl-8 p-6 p-md-10 py-lg-16 px-lg-16 h-auto d-flex flex-column justify-content-between py-12" id="enterNumberSignUp">
                            <form action="">
                                <input class="form-control border-top-0 border-end-0 border-start-0 border-bottom rounded-0" type="text" id="fullname" placeholder="Enter Full Name" aria-label="Enter Full Name">
                                <span id="fullname_error" style="color:red;"></span>
                                <input class="form-control border-top-0 border-end-0 border-start-0 border-bottom rounded-0" onkeypress="return AllowOnlyNumbers(event);" maxlength="10" type="text" id="mobileno" placeholder="Enter Mobile Number" aria-label="Enter Phone Number">
                                <span id="phonev_error" style="color:red;"></span>
                                <p class="text-muted mt-8 mt-lg-10 mb-0">By continue, you agree to <a href="" class="text-decoration-none">Bussinesshub`s Terms of Use</a> and <a href="" class="text-decoration-none">Privacy Policy</a>.</p>
                                <button onclick="call_register(); return false;" class="btn btn-primary mt-6 mt-lg-4 w-100 fw-bold text-light rounded-0" id="sendOtpSignUpBtn">Continue</button>
                            </form>
                            <a href="" class="text-decoration-none mt-8 text-center d-block mb-lg-16" data-bs-toggle="modal" data-bs-target="#modalLogIn">Existing User? Log In</a>
                        </div>
                        <!-- when change the visiblility change d-none class to d-flex  -->
                        <!-- demo on global.js -->
                        <div class="col-12 col-lg-7 col-xl-8 p-6 p-md-10 py-lg-16 px-lg-16 h-auto d-none flex-column justify-content-between py-12" id="enterOTPSignUp">
                            <form action="">
                                <!--<div class="input-group mb-4">
                                    <input type="text" class="form-control border-top-0 border-end-0 border-start-0 border-bottom rounded-0" placeholder="Enter Mobile Number" aria-label="Mobile Number" aria-describedby="phone-number-with-change-addon">
                                    <a class="input-group-text text-primary text-decoration-none bg-transparent border-0" id="phone-number-with-change-addon">Change ?</a>
                                </div>-->
                                <div class="input-group">
                                    <input type="text" class="form-control border-top-0 border-end-0 border-start-0 border-bottom rounded-0" id="otp" placeholder="Enter OTP Sent to Mobile" aria-label="OPT Sent to Mobile" aria-describedby="otp-with-change-addon">
                                    <a class="input-group-text text-primary text-decoration-none bg-transparent border-0" id="otp-with-change-addon">Change ?</a>
                                </div>
                                <span style="color:red" id="error_msg_reg"></span>
                                <button class="btn btn-primary mt-8 mt-lg-8 w-100 fw-bold text-light rounded-0" onclick="verify_otp(); return false;">Continue</button>
                            </form>
                            <a href="" class="text-decoration-none mt-8 text-center d-block mb-lg-16" data-bs-toggle="modal" data-bs-target="#modalLogIn">Existing User? Log In</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
<input type="hidden" class="site_url" value="<?php echo site_url(); ?>">
<input type="hidden" name="website_name" value="<?php echo website_name; ?>" id="website_name">

<script>
    function testLogout() {
        console.log("Done Log Out")
    }
</script>