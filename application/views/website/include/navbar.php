<!-- New Navbar -->
<?php $theme_color = "#ff6600"; ?>
<header class="navbar-light navbar-sticky" id="main_navbar" style="position: sticky; top: 0; z-index: 999;">
<nav class="navbar-expand-lg navbar-light bg-light shadow-sm bg-white">
<!-- Part 1 Navbar (Logo, Search, Cart and User Details) -->
<!-- Navbar for Desktop -->
<div class="navbar flex" id="navbar_for_desktop" style="background: linear-gradient(to right, #ff6600 , #FD7F2B); padding:0px;">
<a class="navbar-brand-2 logo_div text-center" href="<?php echo base_url; ?>" style="margin:auto;">
<img src="<?php echo base_url; ?>assets_web/images/Bussinesshub_logo_new.png" class="img-fluid navbar_logo_image" alt="Navbar Logo">
</a>
<div class="col content_div" style="padding:0px;">
<div class="d-flex justify-content-end" style="border-bottom-left-radius: 60px; background-color: white;">
<ul class="navbar-nav second_top_right_item me-10">
<li class="nav-item list_content_right">
<a href="javascript:void(0);" class="search-popup me-2" onclick="openSearchBar()">
<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 28 28" fill="black">
<path d="M12.283,0A12.283,12.283,0,1,0,24.566,12.283,12.3,12.3,0,0,0,12.283,0Zm0,22.3A10.016,10.016,0,1,1,22.3,12.283,10.027,10.027,0,0,1,12.283,22.3Z"></path>
<g transform="translate(18.948 18.948)">
<path d="M359.755,358.1l-6.711-6.711a1.17,1.17,0,1,0-1.655,1.655l6.711,6.711a1.17,1.17,0,0,0,1.655-1.655Z" transform="translate(-351.046 -351.046)"></path>
</g>
</svg>
<span class="text-dark position-relative top-2" style="top: 2px">&nbsp;Search</span>
</a>
</li>
<li class="nav-item list_content_right">
<p class="mb-0 fw-bold d-inline-flex align-items-center m-0">
<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
<path fill="currentColor" d="M4 20q-.825 0-1.412-.587Q2 18.825 2 18V6q0-.825.588-1.412Q3.175 4 4 4h10.1q-.1.5-.1 1t.1 1H4v12h16V9.9q.575-.125 1.075-.35q.5-.225.925-.55v9q0 .825-.587 1.413Q20.825 20 20 20ZM4 6v12V6Zm15 2q-1.25 0-2.125-.875T16 5q0-1.25.875-2.125T19 2q1.25 0 2.125.875T22 5q0 1.25-.875 2.125T19 8Zm-7 3l3.65-2.275q.35.325.763.562q.412.238.862.413l-4.75 2.975q-.25.15-.525.15t-.525-.15L4 8V6Z" />
</svg>
<span class="ms-1" style="font-weight: 600;">&nbsp;admin@bznesshub.com</span>
</p>
</li>
<li class="nav-item list_content_right">
<a class="nav-link" href="<?php echo base_url ?>cart" title="Cart">
<span class="d-inline-flex align-items-end position-relative">
<i class="bx bx-cart bx-sm me-1"></i>Cart
<!-- &nbsp;<span id="cart_count">0</span> -->
<div class="icon-count">
<span id="cart_count">0</span>
</div>
</span>
</a>
</li>
<?php if (empty($this->session->userdata("user_id"))) { ?>
<li id="login_btn_navbar" class="right_side_list nav-item list_content_right">
<a class="nav-link" onclick="openLoginModal()">
<span class="d-inline-flex align-items-end">
<i class="bx bx-log-in bx-sm me-2"></i>Login
</span>
</a>
</li>
<?php  }  ?>


<?php if (!empty($this->session->userdata("user_id"))) { ?>
<li class="nav-item right_side_list list_content_right">
<div class="dropdown">
<button class="btn btn-light dropdown-toggle user_toggle_button" title="Profile" type="button" data-bs-toggle="dropdown" aria-expanded="false">
<i class="bx bx-user-circle bx-sm"></i>
</button>
<input type="text" style="display:none" id="refers_name" value="<?php echo $this->session->userdata("referral_code") ?>">
<ul class="dropdown-menu position-absolute dropdown-menu-end shadow-lg">
<?php if (!empty($this->session->userdata("user_id"))) { ?>
<li class="fw-bold text-center my-2 text-blue"><a href="<?php base_url ?>personal_info"> Hello! <b><?php echo $this->session->userdata("user_name") ?></b></a></li>

<li>
<hr class="dropdown-divider">
</li>

<li class="fw-bold text-center text-blue"><b>Refer & Earn :</b></li>
<li class="fw-bold text-center  text-orange"><?php echo $this->session->userdata("referral_code") ?>
<svg class="" onclick="copy_refer_code()" style="cursor:pointer;" width="18" height="18" viewBox="-11 0 173 173" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0)">
<path d="M30.9231 153.398C25.9082 153.062 21.2595 152.78 16.6153 152.431C13.3686 152.186 10.2997 151.464 7.57825 149.459C3.00684 146.09 1.56856 141.264 1.45752 136.007C1.29453 128.332 1.3601 120.646 1.56139 112.971C1.76659 105.186 2.08738 97.3959 2.65361 89.6298C3.85945 73.0868 4.37958 56.5257 4.83867 39.947C5.16774 31.9356 6.64051 24.0128 9.21208 16.4196C11.3588 9.78579 15.6757 5.67804 22.6329 4.53533C24.2764 4.26477 25.9218 3.95521 27.579 3.81993C50.8387 1.97287 74.0726 -0.472549 97.4629 0.405459C102.453 0.593417 107.451 0.999201 112.406 1.62356C118.56 2.39881 121.757 5.86334 121.976 12.0576C122.154 17.1357 121.886 22.2301 121.81 27.7778C122.815 27.7778 124.008 27.6887 125.186 27.7947C128.943 28.1322 132.725 28.3527 136.439 28.9654C142.402 29.9513 146.049 33.544 147.63 39.4325C148.915 44.4993 149.683 49.6836 149.923 54.9056C150.962 71.9558 149.786 88.9202 148.223 105.895C147.611 112.529 147.573 119.228 147.435 125.902C147.297 132.576 147.5 139.263 147.258 145.933C147.13 149.71 146.673 153.467 145.891 157.163C144.143 165.312 138.661 170.196 130.151 171.171C124.199 171.921 118.213 172.362 112.215 172.494C94.7719 172.676 77.3226 172.758 59.8815 172.485C54.1516 172.396 48.3809 171.399 42.7387 170.278C36.1316 168.965 32.0471 163.932 31.3101 157.17C31.1769 155.969 31.0621 154.766 30.9231 153.398ZM42.1303 105.059H41.7043C41.4796 112.397 41.2545 119.735 41.029 127.073C40.7536 135.633 40.44 144.191 40.1932 152.752C40.1523 154.189 40.3926 155.633 40.4588 157.076C40.5887 159.93 42.1549 161.708 44.8231 162.227C49.3899 163.117 53.9848 164.166 58.6069 164.406C68.2512 164.906 77.9245 165.201 87.5784 165.067C99.5655 164.9 111.549 164.269 123.526 163.708C126.073 163.54 128.597 163.116 131.059 162.443C134.088 161.671 136.161 159.649 136.683 156.506C137.389 152.801 137.843 149.051 138.043 145.284C138.262 137.614 138.034 129.932 138.177 122.261C138.285 116.482 138.437 110.684 139.001 104.936C140.466 89.9771 141.451 75.0022 140.733 59.9668C140.468 54.4224 140.112 48.8753 138.642 43.4636C137.98 41.0305 136.759 39.5275 134.086 39.4781C127.658 39.359 121.224 38.9747 114.801 39.0996C103.697 39.3149 92.6057 39.8527 81.5077 40.2214C73.6252 40.4816 65.7382 40.6117 57.8595 40.9538C54.3244 41.1072 50.7127 41.2972 47.4906 43.0057C46.3829 43.591 44.8608 44.551 44.69 45.5422C44.2323 48.6629 43.4542 51.7279 42.3679 54.6885C42.1903 55.4482 42.1426 56.2326 42.227 57.0083C42.1861 59.5663 42.1374 62.1248 42.1355 64.6827C42.1259 78.1396 42.1242 91.5985 42.1303 105.059ZM30.7977 143.928C30.923 141.672 31.0432 139.9 31.1166 138.126C31.4936 129.01 31.8649 119.894 32.2303 110.777C32.8101 96.6584 33.3426 82.5381 33.9984 68.4236C34.4114 59.539 34.6984 50.6261 36.6036 41.8935C36.9547 40.4047 37.6251 39.0103 38.5686 37.8072C41.2356 34.4555 45.0749 32.2443 49.3088 31.6215C54.8914 30.6969 60.5238 30.1038 66.1765 29.8454C80.6044 29.169 95.044 28.7541 109.478 28.2195C110.341 28.1876 111.198 28.0243 112.384 27.8851C112.736 22.5832 112.797 17.4317 111.688 11.8788C106.128 11.5341 100.604 11.0605 95.0706 10.8706C73.5895 10.1324 52.229 12.3483 30.8335 13.6744C28.2958 13.8311 25.788 14.4314 23.2555 14.7325C20.3237 15.0818 18.7822 16.8625 17.9277 19.5213C15.7651 26.07 14.4364 32.8659 13.9731 39.748C13.0069 55.9592 12.0153 72.1737 11.4237 88.4019C10.8802 103.295 10.8166 118.213 10.6257 133.121C10.656 135.122 10.8955 137.114 11.34 139.066C11.8549 141.637 13.2809 142.885 15.9147 143.141C19.34 143.474 22.7764 143.702 26.2114 143.913C27.6257 144.003 29.0516 143.928 30.7977 143.928Z" fill="#000000" />
</g>
<defs>
<clipPath id="clip0">
<rect width="150" height="173" fill="white" transform="translate(0.777344)" />
</clipPath>
</defs>
</svg>
</li>
    <li>
    <hr class="dropdown-divider">
    </li>



<?php if($this->session->userdata("is_seller") == 1) { ?>
<li class="fw-bold text-blue  text-center">
<span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><circle cx="12" cy="12" r="0" fill="currentColor"><animate id="svgSpinnersPulse20" fill="freeze" attributeName="r" begin="0;svgSpinnersPulse21.begin+0.6s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="0;11"/><animate fill="freeze" attributeName="opacity" begin="0;svgSpinnersPulse21.begin+0.6s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="1;0"/></circle><circle cx="12" cy="12" r="0" fill="currentColor"><animate id="svgSpinnersPulse21" fill="freeze" attributeName="r" begin="svgSpinnersPulse20.begin+0.6s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="0;11"/><animate fill="freeze" attributeName="opacity" begin="svgSpinnersPulse20.begin+0.6s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="1;0"/></circle></svg> <b>IS Partner</b></span>
</li>
<li class=" text-center"><a class="align-items-center" href="<?php echo base_url ?>upgrade_plan">Upgrade Plan</a></li>

<?php } else { ?>
<li class="fw-bold text-blue mb-4 text-center">
<a class="down_link_pages" href="<?php echo base_url ?>become-seller">Virtual Partner</a>
</li>
<?php } ?>

</li>
<li>
<hr class="dropdown-divider">
</li>
<?php } ?>
<li><a class="dropdown-item d-inline-flex align-items-center" href="<?php echo base_url ?>personal_info"><i class="bx bx-user me-2"></i>My Profile</a></li>
<?php if (empty($this->session->userdata("user_id"))) { ?>
<li><a class="dropdown-item d-inline-flex align-items-center" onclick="openLoginModal()"><i class="bx bx-log-in me-2"></i>Log In</a></li>
<li><a class="dropdown-item d-inline-flex align-items-center" href="<?php echo base_url ?>track"><i class="bx bx-time me-2"></i>Track orders</a></li>
<?php } else { ?>
<li><a class="dropdown-item d-inline-flex align-items-center" href="<?php echo base_url ?>notification"><i class="bx bx-bell me-2"></i>Notification</a></li>
<li><a class="dropdown-item d-inline-flex align-items-center" href="<?php echo base_url ?>myaddress"><i class="bx bx-map me-2"></i>My Address</a></li>
<li><a class="dropdown-item d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#codeshareModal"><i class="bx bx-share me-2"></i>Share Refer Code</a></li>
<li><a class="dropdown-item d-inline-flex align-items-center" href="<?php echo base_url ?>offers"><i class="bx bx-line-chart-down me-2"></i>Offers for you</a></li>
<li><a class="dropdown-item d-inline-flex align-items-center" href="<?php echo base_url ?>order"><i class="bx bx-package me-2"></i>My orders</a></li>
<li><a class="dropdown-item d-inline-flex align-items-center" href="<?php echo base_url ?>user-wallet"><i class="bx bx-wallet me-2"></i>My Wallet</a></li>
<li><a class="dropdown-item d-inline-flex align-items-center" href="<?php echo base_url ?>track"><i class="bx bx-time me-2"></i>Track orders</a></li>
<li><a class="dropdown-item d-inline-flex align-items-center" href="<?php echo base_url ?>wishlist"><i class="bx bx-heart me-2"></i>Wishlist</a></li>
<li><a class="dropdown-item d-inline-flex align-items-center" href="<?php echo base_url; ?>logout"><i class="bx bx-log-out me-2"></i>Logout</a></li>
<?php } ?>
</ul>
</div>
</li>
<?php } ?>
</ul>
</div>
<div class="navbar-menu-scroll-horizontal">
<ul class="menu-items-top"> 
<?php foreach ($header_cat as $maincat) : ?>
<li>
<a onclick="view_subcat(<?= $maincat['cat_id'] ?>)" class="menu-item-top" id="link_underline<?= $maincat['cat_id'] ?>"><?= $maincat['cat_name'] ?></a>
</li>
<?php endforeach; ?>
</ul>
</div>
</div>
</div>

<div class="modal fade" id="codeshareModal" style="z-index:99"  tabindex="-1" aria-labelledby="codeshareModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header align-items-center" style="border-bottom: 0;">
<h5 class="mb-0">Share this Refer Code on social media platforms</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<?php $data_txt = 'hi'; 
$share_code = 'Hey, I am using BznessHub App.  Use my Refer code to get 💯CASHBACK on every order 🛍.  🎁Code: '.$this->session->userdata("referral_code").'   📲Download the BznessHub App from Google Play Store:  https://play.google.com/store/apps/details?id=com.bussinesshub   Happy Shopping with Us.'; ?>
<div class="modal-body">
<div class="d-flex flex-wrap justify-content-center post_social">
<i onclick="copy_code_link()" class="fa-solid fa-link fa-3x pe-2" style="color: #ff6600;font-size:2.5rem"></i>
<a target="_blank" href="http://www.facebook.com/sharer.php?text=<?= $share_code ?>" title="Facebook Share"><i class="fa-brands fa-square-facebook pe-4" style="font-size: 3rem; color:#ff6600;"></i></a>
<a target="_blank" href="http://twitter.com/share?text=<?= $share_code ?>" title="Twitter Share"><i class="fa-brands fa-square-twitter pe-4" style="font-size: 3rem; color:#ff6600;"></i></a>
<a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&text=<?= $share_code ?>" title="LinkedIn Share"><i class="fa-brands fa-linkedin pe-4" style="font-size: 3rem; color:#ff6600;"></i></a>

</div>
</div>
</div>
</div>
</div>

<!-- Mobile Navbar -->
<div class="row p-0 m-0" id="navbar_for_mobile" style="background: linear-gradient(to right, #fb6519 , #ff7e3d); padding:0px;">
<div class="col-2 d-flex-center px-0">
<button type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample" class="btn btn-primary mt-1">
<i class="fas fa-bars fa-lg"></i>
</button>
</div>
<div class="col-5 px-0 pt-2">
<a class="navbar-brand" href="<?php echo base_url; ?>" style="margin:auto;">
<img src="<?php echo base_url; ?>assets_web/images/Bussinesshub_logo.png" class="navbar_logo_image" alt="Navbar Logo">
</a>
</div>
<div class="col-5 text-end" style="padding:0px;">
<div class="d-flex px-2" style="border-bottom-left-radius: 60px; background-color: white; height: 50px;">
<a href="javascript:void(0);" class="search-popup" onclick="openSearchBarMobile()">
<svg xmlns="http://www.w3.org/2000/svg" width="18" height="19" viewBox="0 0 28 28" fill="black">
<path d="M12.283,0A12.283,12.283,0,1,0,24.566,12.283,12.3,12.3,0,0,0,12.283,0Zm0,22.3A10.016,10.016,0,1,1,22.3,12.283,10.027,10.027,0,0,1,12.283,22.3Z"></path>
<g transform="translate(18.948 18.948)">
<path d="M359.755,358.1l-6.711-6.711a1.17,1.17,0,1,0-1.655,1.655l6.711,6.711a1.17,1.17,0,0,0,1.655-1.655Z" transform="translate(-351.046 -351.046)"></path>
</g>
</svg>
</a>
<ul class="second_top_right_item login_user_btn ms-auto ps-0 mt-1">
<?php if (empty($this->session->userdata("user_id"))) { ?>
<li id="login_btn_navbar" class="right_side_list">
<a class="nav-link mt-2" onclick="openLoginModalMobile()">
<i class="bx bx-log-in bx-sm"></i>
<span class="position-relative" style="top: -6px;">
Login
</span>
</a>
</li>
<?php  }  ?>


<?php if (!empty($this->session->userdata("user_id"))) { ?>
<li class="nav-item right_side_list">
<div class="dropdown">
<button class="btn btn-light dropdown-toggle" title="Profile" type="button" data-bs-toggle="dropdown" aria-expanded="false">
<i class="bx bx-user-circle bx-sm"></i>
</button>
<ul class="dropdown-menu dropdown-menu-end shadow-lg position-absolute">
<?php if (!empty($this->session->userdata("user_id"))) { ?>
<li class="fw-bold ps-4 my-2 text-blue">Hello! <b><?php echo $this->session->userdata("user_name") ?></b></li>
<li class="fw-bold ps-4  text-blue"><b>Refer & Earn :</b></li>
<li class="fw-bold ps-4 mb-4 text-orange"><?php echo $this->session->userdata("referral_code") ?>
<svg class="" onclick="copy_refer_code()" style="cursor:pointer;" width="18" height="18" viewBox="-11 0 173 173" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0)">
<path d="M30.9231 153.398C25.9082 153.062 21.2595 152.78 16.6153 152.431C13.3686 152.186 10.2997 151.464 7.57825 149.459C3.00684 146.09 1.56856 141.264 1.45752 136.007C1.29453 128.332 1.3601 120.646 1.56139 112.971C1.76659 105.186 2.08738 97.3959 2.65361 89.6298C3.85945 73.0868 4.37958 56.5257 4.83867 39.947C5.16774 31.9356 6.64051 24.0128 9.21208 16.4196C11.3588 9.78579 15.6757 5.67804 22.6329 4.53533C24.2764 4.26477 25.9218 3.95521 27.579 3.81993C50.8387 1.97287 74.0726 -0.472549 97.4629 0.405459C102.453 0.593417 107.451 0.999201 112.406 1.62356C118.56 2.39881 121.757 5.86334 121.976 12.0576C122.154 17.1357 121.886 22.2301 121.81 27.7778C122.815 27.7778 124.008 27.6887 125.186 27.7947C128.943 28.1322 132.725 28.3527 136.439 28.9654C142.402 29.9513 146.049 33.544 147.63 39.4325C148.915 44.4993 149.683 49.6836 149.923 54.9056C150.962 71.9558 149.786 88.9202 148.223 105.895C147.611 112.529 147.573 119.228 147.435 125.902C147.297 132.576 147.5 139.263 147.258 145.933C147.13 149.71 146.673 153.467 145.891 157.163C144.143 165.312 138.661 170.196 130.151 171.171C124.199 171.921 118.213 172.362 112.215 172.494C94.7719 172.676 77.3226 172.758 59.8815 172.485C54.1516 172.396 48.3809 171.399 42.7387 170.278C36.1316 168.965 32.0471 163.932 31.3101 157.17C31.1769 155.969 31.0621 154.766 30.9231 153.398ZM42.1303 105.059H41.7043C41.4796 112.397 41.2545 119.735 41.029 127.073C40.7536 135.633 40.44 144.191 40.1932 152.752C40.1523 154.189 40.3926 155.633 40.4588 157.076C40.5887 159.93 42.1549 161.708 44.8231 162.227C49.3899 163.117 53.9848 164.166 58.6069 164.406C68.2512 164.906 77.9245 165.201 87.5784 165.067C99.5655 164.9 111.549 164.269 123.526 163.708C126.073 163.54 128.597 163.116 131.059 162.443C134.088 161.671 136.161 159.649 136.683 156.506C137.389 152.801 137.843 149.051 138.043 145.284C138.262 137.614 138.034 129.932 138.177 122.261C138.285 116.482 138.437 110.684 139.001 104.936C140.466 89.9771 141.451 75.0022 140.733 59.9668C140.468 54.4224 140.112 48.8753 138.642 43.4636C137.98 41.0305 136.759 39.5275 134.086 39.4781C127.658 39.359 121.224 38.9747 114.801 39.0996C103.697 39.3149 92.6057 39.8527 81.5077 40.2214C73.6252 40.4816 65.7382 40.6117 57.8595 40.9538C54.3244 41.1072 50.7127 41.2972 47.4906 43.0057C46.3829 43.591 44.8608 44.551 44.69 45.5422C44.2323 48.6629 43.4542 51.7279 42.3679 54.6885C42.1903 55.4482 42.1426 56.2326 42.227 57.0083C42.1861 59.5663 42.1374 62.1248 42.1355 64.6827C42.1259 78.1396 42.1242 91.5985 42.1303 105.059ZM30.7977 143.928C30.923 141.672 31.0432 139.9 31.1166 138.126C31.4936 129.01 31.8649 119.894 32.2303 110.777C32.8101 96.6584 33.3426 82.5381 33.9984 68.4236C34.4114 59.539 34.6984 50.6261 36.6036 41.8935C36.9547 40.4047 37.6251 39.0103 38.5686 37.8072C41.2356 34.4555 45.0749 32.2443 49.3088 31.6215C54.8914 30.6969 60.5238 30.1038 66.1765 29.8454C80.6044 29.169 95.044 28.7541 109.478 28.2195C110.341 28.1876 111.198 28.0243 112.384 27.8851C112.736 22.5832 112.797 17.4317 111.688 11.8788C106.128 11.5341 100.604 11.0605 95.0706 10.8706C73.5895 10.1324 52.229 12.3483 30.8335 13.6744C28.2958 13.8311 25.788 14.4314 23.2555 14.7325C20.3237 15.0818 18.7822 16.8625 17.9277 19.5213C15.7651 26.07 14.4364 32.8659 13.9731 39.748C13.0069 55.9592 12.0153 72.1737 11.4237 88.4019C10.8802 103.295 10.8166 118.213 10.6257 133.121C10.656 135.122 10.8955 137.114 11.34 139.066C11.8549 141.637 13.2809 142.885 15.9147 143.141C19.34 143.474 22.7764 143.702 26.2114 143.913C27.6257 144.003 29.0516 143.928 30.7977 143.928Z" fill="#000000" />
</g>
<defs>
<clipPath id="clip0">
<rect width="150" height="173" fill="white" transform="translate(0.777344)" />
</clipPath>
</defs>
</svg>
</li>

<li class="fw-bold text-blue mb-4 text-center">
<?php if($this->session->userdata("is_seller") == 1) { ?>
<span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><circle cx="12" cy="12" r="0" fill="currentColor"><animate id="svgSpinnersPulse20" fill="freeze" attributeName="r" begin="0;svgSpinnersPulse21.begin+0.6s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="0;11"/><animate fill="freeze" attributeName="opacity" begin="0;svgSpinnersPulse21.begin+0.6s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="1;0"/></circle><circle cx="12" cy="12" r="0" fill="currentColor"><animate id="svgSpinnersPulse21" fill="freeze" attributeName="r" begin="svgSpinnersPulse20.begin+0.6s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="0;11"/><animate fill="freeze" attributeName="opacity" begin="svgSpinnersPulse20.begin+0.6s" calcMode="spline" dur="1.2s" keySplines=".52,.6,.25,.99" values="1;0"/></circle></svg> <b>Is Seller</b></span>
<?php } else { ?>

<a class="down_link_pages" href="<?php echo base_url ?>become-seller">Virtual Partner</a>

<?php } ?>
</li>
<li>
<hr class="dropdown-divider">
</li>
<?php } ?>
<li><a class="dropdown-item d-inline-flex align-items-center" href="<?php echo base_url ?>personal_info"><i class="bx bx-user me-2"></i>My Profile</a></li>
<?php if (empty($this->session->userdata("user_id"))) { ?>
<li><a class="dropdown-item d-inline-flex align-items-center mt-1" onclick="openLoginModal()"><i class="bx bx-log-in me-2"></i>Log In</a></li>
<li><a class="dropdown-item d-inline-flex align-items-center mt-1" href="<?php echo base_url ?>track"><i class="bx bx-time me-2"></i>Track orders</a></li>
<?php } else { ?>
<li><a class="dropdown-item d-inline-flex align-items-center mt-1" href="<?php echo base_url ?>notification"><i class="bx bx-bell me-2"></i>Notification</a></li>
<li><a class="dropdown-item d-inline-flex align-items-center mt-1" href="<?php echo base_url ?>myaddress"><i class="bx bx-map me-2"></i>My Address</a></li>
<li><a class="dropdown-item d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#codeshareModal"><i class="bx bx-share me-2"></i>Share Refer Code</a></li>
<li><a class="dropdown-item d-inline-flex align-items-center mt-1" href="<?php echo base_url ?>offers"><i class="bx bx-line-chart-down me-2"></i>Offers for you</a></li>
<li><a class="dropdown-item d-inline-flex align-items-center mt-1" href="<?php echo base_url ?>order"><i class="bx bx-package me-2"></i>My orders</a></li>
<li><a class="dropdown-item d-inline-flex align-items-center mt-1" href="<?php echo base_url ?>user-wallet"><i class="bx bx-wallet me-2"></i>My Wallet</a></li>
<li><a class="dropdown-item d-inline-flex align-items-center mt-1" href="<?php echo base_url ?>track"><i class="bx bx-time me-2"></i>Track orders</a></li>
<li><a class="dropdown-item d-inline-flex align-items-center mt-1" href="<?php echo base_url ?>wishlist"><i class="bx bx-heart me-2"></i>Wishlist</a></li>
<li><a class="dropdown-item d-inline-flex align-items-center mt-1" href="<?php echo base_url; ?>logout"><i class="bx bx-log-out me-2"></i>Logout</a></li>
<?php } ?>
</ul>
</div>
</li>
<?php } ?>
</ul>
</div>
</div>

<!-- Mobile Category -->
<div class="offcanvas offcanvas-start w-70" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel" style="overflow: scroll;">
<div class="offcanvas-header">
<!-- <h5 class="offcanvas-title" id="offcanvasExampleLabel"></h5> -->
<a href="javascript:void(0);" class="search-popup" onclick="openSearchBarMobile()" style="display:none;">
<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 28 28" fill="#707070">
<path d="M12.283,0A12.283,12.283,0,1,0,24.566,12.283,12.3,12.3,0,0,0,12.283,0Zm0,22.3A10.016,10.016,0,1,1,22.3,12.283,10.027,10.027,0,0,1,12.283,22.3Z"></path>
<g transform="translate(18.948 18.948)">
<path d="M359.755,358.1l-6.711-6.711a1.17,1.17,0,1,0-1.655,1.655l6.711,6.711a1.17,1.17,0,0,0,1.655-1.655Z" transform="translate(-351.046 -351.046)"></path>
</g>
</svg>
</a>
<h5 class="offcanvas-title text-center" id="offcanvasExampleLabel">BussinessHub</h5>
<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="mobile_view_main_div">
<div class="container">
<div class="row">
<div class="col-12">
<!-- Accordian Start -->
<div class="accordion accordion-icon accordion-bg-light" id="accordionExample2">
<?php $i = 1; /* for ($i = 1; $i <= 1; $i++) { */
foreach ($header_cat_mobile as $header_cat_mobile_data) {
?>
<!-- Item -->
<div class="accordion-item">
<h6 class="accordion-header font-base" id="heading-">
<button class="accordion-button fw-bold rounded collapsed mt-1 px-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $i ?>" aria-expanded="false" aria-controls="collapse-<?= $i ?>">
<span class="first_level_category"><?= $header_cat_mobile_data['cat_name'] ?></span>
</button>
</h6>
<!-- Body -->
<div id="collapse-<?= $i ?>" class="accordion-collapse collapse" aria-labelledby="heading-1" data-bs-parent="#accordionExample2">
<div class="">
<ul class="ps-0 m-0">
<li class="my-1 sub_category_item">
<!-- Nested Accordian -->
<?php $j = 1;
foreach ($header_cat_mobile_data['subcat_1'] as $subcat_1_data) { ?>
<div class="accordion accordion-icon accordion-bg-light my-1 py-1" id="accordionExamplesub_subcategory-<?= $j ?>">
<div class="accordion-item">
<p class="accordion-header font-base" id="heading-1">
<a class="sub_category_item_nested w-100 accordion-button collapsed p-0 ps-3" data-bs-toggle="collapse" data-bs-target="#collapse_sub-subcate-<?= $j ?>" aria-expanded="true" aria-controls="collapse_sub-subcate-<?= $j ?>">
<span class="second_level_category" style="margin-right: 10px;"><?= $subcat_1_data['cat_name'] ?></span>
<!-- <span class="icon" style="font-size: 18px;">+</span> -->
</a>
</p>
<!-- Body -->
<div id="collapse_sub-subcate-<?= $j ?>" class="accordion-collapse collapse " aria-labelledby="heading-1" data-bs-parent="#accordionExamplesub_subcategory-<?= $j ?>">
<div class="pt-0">
<ul class="ps-5">
<li class="my-1 sub_category_item">
<!-- Sub Sub-subcategory 4 layer -->
<!-- Double Nested Accordian -->
<?php $k = 1;
foreach ($subcat_1_data['subsubcat_2'] as $subcat_2_data) { ?>
<div class="accordion accordion-icon accordion-bg-light" id="accordionExamplesub_sub_subcategory-<?= $k; ?>">
<div class="accordion-item">
<p class="accordion-header font-base" id="heading-1">
<a href="<?= base_url('sub-category/' . $subcat_2_data['cat_slug']) ?>" class="sub_category_item_nested w-100 collapsed accordion-button ps-3 p-0" data-bs-toggle="collapse" data-bs-target="#collapse_sub_sub-subcate-<?= $k; ?>" aria-expanded="true" aria-controls="collapse_sub_sub-subcate-<?= $k; ?>">
<span class="third_level_category" style="margin-right: 10px;">
<?php echo $subcat_2_data['cat_name']; ?>
</span>
<!-- <span class="icon" style="font-size: 18px;">+</span> -->
</a>
</p>
<!-- Body -->
<?php $l = 1;
foreach ($subcat_2_data['subsubcat_3'] as $subcat_3_data) { ?>
<div id="collapse_sub_sub-subcate-<?= $k; ?>" class="accordion-collapse collapse " aria-labelledby="heading-1" data-bs-parent="#accordionExamplesub_sub_subcategory-<?= $k; ?>">
<div class="pt-0 pb-3">
<ul class="ps-5">
<li class="my-1 sub_category_item">
    <a href="<?= base_url('sub-category/' . $subcat_3_data['cat_slug']) ?>" class="last_level_category"><?php echo $subcat_3_data['cat_name']; ?></a>
</li>

</ul>
</div>
</div>
<?php $l++;
} ?>
</div>
</div>
<?php $k++;
} ?>
</li>

</ul>
</div>
</div>
</div>
</div>
<?php $j++;
} ?>
</li>
</ul>
</div>
</div>
</div>
<hr class="ruler">
<?php $i++;
} ?>
</div>

<ul class="category_one categories">
<!-- <li class="nav-item mt-5 py-1">
<a class="down_link_pages d-inline-flex align-items-center" href="<?php echo base_url ?>all-category">
<svg width="18" height="18" viewBox="0 0 24 24" fill="#162b75" xmlns="http://www.w3.org/2000/svg">
<path d="M10 3H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM9 9H5V5h4v4zm11-6h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm-1 6h-4V5h4v4zm-9 4H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1zm-1 6H5v-4h4v4zm8-6c-2.206 0-4 1.794-4 4s1.794 4 4 4 4-1.794 4-4-1.794-4-4-4zm0 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2z" />
</svg>
All Categories
</a>
</li>-->
<li class="nav-item py-1">
<a class="down_link_pages" href="<?php echo base_url ?>">
<i class="fa-regular fa-building" style="color:#162b75;"></i>
Brands
</a>
</li>
<li class="nav-item py-1">
<a class="down_link_pages" href="<?php echo base_url ?>user-wallet">
<i class="bx bx-wallet" style="color:#162b75;"></i>
My Wallet
</a>
</li>
<li class="nav-item py-1">
<a class="down_link_pages" href="<?php echo base_url ?>order">
<i class="bx bx-cart"></i>
My Orders
</a>
</li>
<li class="nav-item py-1">
<a class="down_link_pages" href="<?php echo base_url ?>">
<i class="bx bx-home" style="color:#162b75;"></i>
My Address
</a>
</li>
</ul>
<hr>
<ul class="category_two categories">
<?php if($this->session->userdata("is_seller") == 0) { ?>
<li class="nav-item py-1">
<a class="down_link_pages" href="<?php echo base_url ?>become-seller">Virtual Partner</a>
</li>
<?php } ?>
<li class="nav-item py-1">
<a class="down_link_pages" href="<?php echo base_url ?>about">About Us</a>
</li>
<li class="nav-item py-1">
<a class="down_link_pages" href="<?php echo base_url ?>contact">Contact Us</a>
</li>
<li class="nav-item py-1">
<a class="down_link_pages" href="<?php echo base_url ?>privacy">Privacy Policy</a>
</li>
<li class="nav-item py-1">
<a class="down_link_pages" href="<?php echo base_url ?>term_and_conditions">Terms &amp; Condition</a>
</li>
<li class="nav-item py-1">
<a class="down_link_pages" href="<?php echo base_url ?>refund">Refund Policy</a>
</li>
<li class="nav-item py-1">
<a class="down_link_pages" href="">Download Our App</a>
</li>
</ul>
<!-- Accordian END -->
</div>
</div>
</div>
</div>
</div>
</div>
</nav>

<hr style="margin: 0; opacity:1;">

<!-- Part 2 Navbar (Categories) -->
<nav class="navbar-expand-lg navbar-light bg-light shadow-sm bg-white category-navbar" id="category_navbar">
<div class="container position-relative">
<div class="navbar-collapse w-100" id="navbarCollapse2">
<!-- <ul class="navbar-nav mr-auto flex-grow-1 p-1 mx-5">
<?php foreach ($header_cat as $maincat) : ?>
<div class="dropdown explore btn_align" onhov>
<button onclick="window.location.href='<?= base_url('sub_category/' . $maincat['cat_slug']) ?>'" class=" btn btn-light dropdown-toggle category_btn" id="category_btn" type="button" aria-expanded="false">
<?= $maincat['cat_name'] ?>
</button>
<?php if (count($maincat['subcat_1']) > 0) : ?>
<div class="main_dropdown_position">
<div class="dropdown-menu border dropdown-fullwidth" style="width: 82.4vw;">
<div class="row px-4 g-4">
<?php for ($i = 0; $i < 4; $i++) : ?>
<div class="col-2 py-5">
<?php if (!empty($maincat['subcat_1'][($i * 2)])) : ?>
<a href="<?= base_url($maincat['subcat_1'][($i * 2)]['cat_slug']) ?>" class="mb-2" style="color: <?= $theme_color ?>; font-weight:bold;"><?= $maincat['subcat_1'][($i * 2)]['cat_name'] ?></a>
<ul class="list-unstyled">
<?php foreach ($maincat['subcat_1'][($i * 2)]['subsubcat_2'] as $subsubcat_2) : ?>
<li> <a href="<?= base_url($subsubcat_2['cat_slug']) ?>" class="dropdown-item" href="#"><?= $subsubcat_2['cat_name'] ?></a> </li>
<?php endforeach; ?>
<?php if (count($maincat['subcat_1'][($i * 2)]['subsubcat_2']) > 0) : ?>
<div class="dropdown-item-link">
<li> <a href="<?= base_url($subsubcat_2['cat_slug']) ?>" class="dropdown-item-link-tag" href="#">view all <i class="fa-solid fa-arrow-right" style="color: #ff6600;"></i></a> </li>
</div>
<?php endif; ?>
</ul>
<hr class="ruler">
<?php endif; ?>
<?php if (!empty($maincat['subcat_1'][($i * 2) + 1])) : ?>
<a href="<?= base_url($maincat['subcat_1'][($i * 2) + 1]['cat_slug']) ?>" class="mb-2" style="color: <?= $theme_color ?>; font-weight:bold;"><?= $maincat['subcat_1'][($i * 2) + 1]['cat_name'] ?></a>
<ul class="list-unstyled">
<?php foreach ($maincat['subcat_1'][($i * 2) + 1]['subsubcat_2'] as $subsubcat_2) : ?>
<li> <a href="<?= base_url($subsubcat_2['cat_slug']) ?>" class="dropdown-item" href="#"><?= $subsubcat_2['cat_name'] ?></a> </li>
<?php endforeach; ?>
<?php if (count($maincat['subcat_1'][($i * 2) + 1]['subsubcat_2']) > 0) : ?>
<div class="dropdown-item-link">
<li> <a href="<?= base_url($subsubcat_2['cat_slug']) ?>" class="dropdown-item-link-tag" href="#">view all <i class="fa-solid fa-arrow-right" style="color: #ff6600;"></i></a> </li>
</div>
<?php endif; ?>
</ul>
<?php endif; ?>
</div>
<?php endfor; ?>
<div class="col-4 py-5">
<img src="assets/images/element/14.svg" alt="">

<div class=" g-2 justify-content-center mt-3">
<div class="col-6 col-sm-4 col-xxl-6">
<a href="#">
<img src="<?= base_url('media/' . $maincat['imgurl']) ?>" class="btn-transition" alt="google-store">
</a>
</div>
<br>
<div class="col-6 col-sm-4 col-xxl-6">
<a href="#">
<img src="<?= base_url('media/' . $maincat['web_banner']) ?>" class="btn-transition" alt="app-store">
</a>
</div>
</div>
</div>
</div>
</div>
</div>
<?php endif; ?>
</div>
<?php endforeach; ?>
</ul> -->
<ul class="menu-items mb-0 px-0 w-100 justify-content-around" id="subcats">
<?php $runloop = true;
echo '<script>
var id = localStorage.getItem("curr_underline_link");
if (id) {
console.log("ID found in localStorage: " + id);
' . $runloop = false . '
} 
</script>'
/* base_url('sub_category/' . $maincat['cat_slug']) */
?>
<?php if ($runloop) {
foreach ($header_default as $maincat) : ?>
<li class="menu-li">
<a href="<?= base_url('shop/'.$maincat['cat_slug']) ?>" class="menu-item py-3" onclick="openMengaMenu()"><?= $maincat['cat_name'] ?>
<svg id="down_arrow_navbar" class="bob-down-arrow-svg" xmlns="http://www.w3.org/2000/svg" width="12" height="7" viewBox="0 0 13.088 7.731" fill="#162b75">
<path d="M12.879,101.344l-.429-.432a.718.718,0,0,0-1.013,0L6.547,105.8l-4.9-4.9a.718.718,0,0,0-1.013,0l-.429.429a.717.717,0,0,0,0,1.012l5.83,5.851a.732.732,0,0,0,.508.23h0a.732.732,0,0,0,.506-.23l5.824-5.835a.727.727,0,0,0,0-1.02Z" transform="translate(0 -100.698)"></path>
</svg>
</a>
<?php if (count($maincat['subcat_1']) > 0) : ?>
<div class="mega-menu">
<div class="content box-shadow-0">
<div class="d-flex w-100 p-10 row_container_nav_items">
<?php foreach ($maincat['subcat_1'] as $subcat_1_data) {
?>
<div class="bg-white w-100 " style="padding: 20px;">
<div class="col px-2 py-4">
<section>
<a href="<?= base_url('shop/'.$subcat_1_data['cat_slug']) ?>"><?php echo $subcat_1_data['cat_name'] ?></a>
<ul class="mega-links px-0">
<?php foreach ($subcat_1_data['subsubcat_2'] as $subsubcat_2_data) { ?>
<li><a href="<?= base_url('shop/'. $subsubcat_2_data['cat_slug']) ?>"><?php echo $subsubcat_2_data['cat_name']; ?></a></li>
<?php } ?>
</ul>
</section>
</div>
</div>
<?php } ?>
</div>
</div>
</div>
<?php endif; ?>
</li>
<?php endforeach;
} ?>
</ul>
</div>
</div>
</nav>
</header>

<!-- Search Bar Desktop -->
<header id="hidden_navbar_search">
<div class="navbar">
<a class="navbar-brand d-flex-center" href="<?php echo base_url; ?>" style="padding-left:20px; padding-right-20px; width: 19%;">
<img src="<?php echo base_url; ?>assets_web/images/Bussinesshub_logo.png" class="img-fluid navbar_logo_image" alt="Navbar Logo">
</a>
<ul class="flex-grow-1 d-flex mb-0">
<!-- Search Box -->
<li class="w-80 ms-2" id="display_search_bar">
<form action="<?php echo base_url ?>search/s" class="d-flex" role="search" style="background: #ff6600;">
<div class="input-group dropdown" style="background-color: #fff; height: 50px; border-radius:160px; color: #333;">
<input class="form-control rounded-start search_btn_web dropdown-toggle" autocomplete="off" id="search" type="search" name="search" value="<?= isset($_REQUEST['search']) ? $_REQUEST['search'] : '' ?>" data-bs-toggle="dropdown" placeholder="Search" data-toggle="dropdown">
<button class="btn rounded-start me-6" type="submit" id="search_bar_hidden">
<i class="fa-solid fa-magnifying-glass fa-lg" style="color: black;"></i>
</button>
<ul class="dropdown-menu w-500 shadow-lg">
<span id="search_div"></span>
</ul>
</div>
<!-- <button class="btn rounded-start" type="submit" id="search_bar_hidden">
<i class="fa-solid fa-magnifying-glass fa-lg" style="color: black;"></i>
</button> -->
</form>
</li>
<li class="" onclick="closeSearchBar()" style="margin: auto;">
<img class="closeBtn" src="<?php echo base_url; ?>assets_web/images/icons/close.png" style="height: 30px;" />
</li>
</ul>
</div>
</header>

<!-- Search Bar mobile -->
<header id="hidden_navbar_search_mobile">
<div class="navbar">
<ul class="flex-grow-1 d-flex mb-0 p-0">
<!-- Search Box -->
<li class="w-90" id="">
<form action="<?php echo base_url ?>search/s" class="d-flex mobile_form_search" role="search">
<div class="input-group dropdown" style="background-color: #fff; height: 50px; color: #333;">
<input class="form-control rounded-start search_btn_web dropdown-toggle" autocomplete="off" id="search" type="search" name="search" value="<?= isset($_REQUEST['search']) ? $_REQUEST['search'] : '' ?>" data-bs-toggle="dropdown" placeholder="Search" data-toggle="dropdown">
<button class="btn rounded-start me-6" type="submit" id="search_bar_hidden">
<i class="fa-solid fa-magnifying-glass fa-lg" style="color: black;"></i>
</button>
<ul class="dropdown-menu shadow-lg p-0" style="width: 92vw">
<span id="search_div_mob"></span>
</ul>
</div>
</form>
</li>
<li onclick="closeSearchBarMobile()" style="margin: auto;">
<img class="closeBtn" src="<?php echo base_url; ?>assets_web/images/icons/close.png" style="height: 30px;" />
</li>
</ul>
</div>
</header>

<!-- User Auth -->
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
<a class="nav-link d-inline-flex align-items-center" href="<?php echo base_url ?>all-category"><svg class="me-2" width="18" height="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="M10 3H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM9 9H5V5h4v4zm11-6h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm-1 6h-4V5h4v4zm-9 4H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1zm-1 6H5v-4h4v4zm8-6c-2.206 0-4 1.794-4 4s1.794 4 4 4 4-1.794 4-4-1.794-4-4-4zm0 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2z" />
</svg>All Categories</a>
</li>
<li class="nav-item">
<a class="nav-link d-inline-flex align-items-center" href="<?php echo base_url ?>explore-sub/10"><svg fill="#000000" class="me-2" width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<title />
<g data-name="Layer 2" id="Layer_2">
<path d="M13.68,3.79a1.77,1.77,0,0,1-3.37,0l-.73-2.2L2,5.38V12H5V22H19V12h3V5.38L14.42,1.59Zm1.9.63h0L20,6.62V10H17V20H7V10H4V6.62L8.42,4.41h0a3.77,3.77,0,0,0,7.16,0Z" />
<rect height="2" width="3" x="13" y="10" />
</g>
</svg>Design your own custom clothing</a>
</li>
<li class="nav-item">
<a class="nav-link d-inline-flex align-items-center" href="<?php echo base_url ?>become-seller"><svg class="me-2" fill="#000000" width="18" height="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="M22,7.82a1.25,1.25,0,0,0,0-.19v0h0l-2-5A1,1,0,0,0,19,2H5a1,1,0,0,0-.93.63l-2,5h0v0a1.25,1.25,0,0,0,0,.19A.58.58,0,0,0,2,8H2V8a4,4,0,0,0,2,3.4V21a1,1,0,0,0,1,1H19a1,1,0,0,0,1-1V11.44A4,4,0,0,0,22,8V8h0A.58.58,0,0,0,22,7.82ZM13,20H11V16h2Zm5,0H15V15a1,1,0,0,0-1-1H10a1,1,0,0,0-1,1v5H6V12a4,4,0,0,0,3-1.38,4,4,0,0,0,6,0A4,4,0,0,0,18,12Zm0-10a2,2,0,0,1-2-2,1,1,0,0,0-2,0,2,2,0,0,1-4,0A1,1,0,0,0,8,8a2,2,0,0,1-4,.15L5.68,4H18.32L20,8.15A2,2,0,0,1,18,10Z" />
</svg>Become a Seller</a>
</li>
<hr class="ruler">
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
<a class="nav-link d-inline-flex align-items-center" href="<?php echo base_url ?>coupon-list"><svg class="me-2" fill="#000000" width="18" height="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" d="M15,6 C15,6.55228475 14.5522847,7 14,7 C13.4477153,7 13,6.55228475 13,6 L3,6 L3,7.99946819 C4.2410063,8.93038753 5,10.3994926 5,12 C5,13.6005074 4.2410063,15.0696125 3,16.0005318 L3,18 L13,18 C13,17.4477153 13.4477153,17 14,17 C14.5522847,17 15,17.4477153 15,18 L21,18 L21,16.0005318 C19.7589937,15.0696125 19,13.6005074 19,12 C19,10.3994926 19.7589937,8.93038753 21,7.99946819 L21,6 L15,6 Z M23,18 C23,19.1045695 22.1045695,20 21,20 L3,20 C1.8954305,20 1,19.1045695 1,18 L1,14.8880798 L1.49927404,14.5992654 C2.42112628,14.0660026 3,13.0839642 3,12 C3,10.9160358 2.42112628,9.93399737 1.49927404,9.40073465 L1,9.11192021 L1,6 C1,4.8954305 1.8954305,4 3,4 L21,4 C22.1045695,4 23,4.8954305 23,6 L23,9.11192021 L22.500726,9.40073465 C21.5788737,9.93399737 21,10.9160358 21,12 C21,13.0839642 21.5788737,14.0660026 22.500726,14.5992654 L23,14.8880798 L23,18 Z M14,16 C13.4477153,16 13,15.5522847 13,15 C13,14.4477153 13.4477153,14 14,14 C14.5522847,14 15,14.4477153 15,15 C15,15.5522847 14.5522847,16 14,16 Z M14,13 C13.4477153,13 13,12.5522847 13,12 C13,11.4477153 13.4477153,11 14,11 C14.5522847,11 15,11.4477153 15,12 C15,12.5522847 14.5522847,13 14,13 Z M14,10 C13.4477153,10 13,9.55228475 13,9 C13,8.44771525 13.4477153,8 14,8 C14.5522847,8 15,8.44771525 15,9 C15,9.55228475 14.5522847,10 14,10 Z" />
</svg>Coupons</a>
</li>
<li class="nav-item">
<a class="nav-link d-inline-flex align-items-center" href="<?php echo base_url ?>offers"><svg class="me-2" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M8 16L16 8M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12ZM17 15C17 16.1046 16.1046 17 15 17C13.8954 17 13 16.1046 13 15C13 13.8954 13.8954 13 15 13C16.1046 13 17 13.8954 17 15ZM11 9C11 10.1046 10.1046 11 9 11C7.89543 11 7 10.1046 7 9C7 7.89543 7.89543 7 9 7C10.1046 7 11 7.89543 11 9Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
</svg>Offers for you</a>
</li>
<hr class="ruler">
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
<hr class="ruler">
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
<li class="py-1"><a href="<?php echo base_url ?>term_and_conditions" class="text-decoration-none text-dark">Terms & Condition</a></li>
<li class="py-1"><a href="<?php echo base_url ?>refund" class="text-decoration-none text-dark">Refund Policy</a></li>
</ul>
<hr class="ruler">
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
<!-- <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
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
</div> -->

<div class="modal fade" id="loginModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content rounded-0">
<div class="modal-body position-relative p-0">
<!-- Cover Box -->
<div id="cover">
<!-- Sign Up Section -->
<h1 class="sign-up">Hello, Friend!</h1>
<p class="sign-up">Enter your personal details<br> and start a journey with us</p>
<a class="btn_cover button sign-up" href="#cover">Sign Up</a>
<!-- Sign In Section -->
<h1 class="sign-in">Welcome Back!</h1>
<p class="sign-in">To keep connected with us please<br> login with your personal info</p>
<br>
<a class="btn_cover button sub sign-in" href="#">Sign In</a>
</div>

<!-- Login Box -->
<div id="login" class="px-3">
<h1>Sign In</h1>
<form action="" class="col-md-12">
<div class="input-group">
<input type="text" class="form-control border-top-0 border-end-0 border-start-0 border-bottom " id="log_mobileno1" onkeypress="return AllowOnlyNumbers(event);" maxlength="10" placeholder="Enter Phone Number" aria-label="Enter Phone Number">
</div>
<span id="phonevl_errors" style="color:red;"></span>
<a class="input-group-text text-primary text-decoration-none bg-transparent border-0 mb-2" onclick="call_login_mob(); return false;" id="otp-with-change-addon">Get OTP ?</a>
<style>
.otp-box {
height: 33px;
text-align: center;
font-size: 20px;
margin: 0 5px;
}
</style>
<div class="input-group">
<input type="text" maxlength="1" class="form-control otp-box" id="otp1">
<input type="text" maxlength="1" class="form-control otp-box" id="otp2">
<input type="text" maxlength="1" class="form-control otp-box" id="otp3">
<input type="text" maxlength="1" class="form-control otp-box" id="otp4">
<input type="text" maxlength="1" class="form-control otp-box" id="otp5">
<input type="text" maxlength="1" class="form-control otp-box" id="otp6">

<!-- <input class="form-control border-top-0 border-end-0 border-start-0 border-bottom" type="text" id="otp_login1" placeholder="Enter OTP Sent to Mobile" aria-label="Enter OTP Sent to Mobile"> -->
</div>
<a class="input-group-text text-primary text-decoration-none bg-transparent border-0"><span style="color:red" id="error_msg1"></span></a>

<button class="btn btn-primary mt-6 mt-lg-4 w-90 fw-bold text-light btn-radious" onclick="call_login_otp_mob(); return false;" id="sendOtpLogInBtn" >Verify</button>
<p class="text-muted mt-5 mt-lg-10 mb-0">By continue, you agree to <a href="" class="text-decoration-none">BznessHub Terms of Use</a> and <a href="" class="text-decoration-none">Privacy Policy</a>.</p>
</form>
</div>

<!-- Register Box -->
<div id="register" class="px-3">
<h1>Create Account</h1>
<form action="" class="my-3">
<input class="form-control border" type="text" id="fullname" placeholder="Enter Full Name" aria-label="Enter Full Name" required>
<span id="fullname_error" style="color:red;"></span>
<select id="country" name="country" class="form-control mt-2 border">
<option value="OMN">Oman (+968)</option>
<option value="CA">Canada (+1)</option>
<option value="GB">United Kingdom (+44)</option>
<option value="AU">Australia (+61)</option>
<option value="DE">Germany (+49)</option>
<option value="FR">France (+33)</option>
<option value="IT">Italy (+39)</option>
<option value="JP">Japan (+81)</option>
<option value="MX">Mexico (+52)</option>
<option value="BR">Brazil (+55)</option>
<option value="RU">Russia (+7)</option>
<option value="IN" default selected>India (+91)</option>
<option value="CN">China (+86)</option>
<option value="KR">South Korea (+82)</option>
<option value="ZA">South Africa (+27)</option>
<option value="EG">Egypt (+20)</option>
<option value="AR">Argentina (+54)</option>
<option value="ES">Spain (+34)</option>
<option value="NL">Netherlands (+31)</option>
<option value="SE">Sweden (+46)</option>
</select>
<input class="form-control border  mt-2 w-100 " onkeypress="return AllowOnlyNumbers(event);" maxlength="10" type="text" id="mobileno" placeholder="Enter Mobile Number" aria-label="Enter Phone Number">
<span id="phonev_error" style="color:red;text-align:left"></span>
<input class="form-control border  mt-2 w-100 mb-2" type="text" id="refer_code" placeholder="Refer code" aria-label="Enter Refer code">
<label>Enter OTP Sent to Mobile</label>
<div class="input-group">
<input type="text" maxlength="1" class="form-control otp-box si_otp" id="otp1">
<input type="text" maxlength="1" class="form-control otp-box si_otp" id="otp2">
<input type="text" maxlength="1" class="form-control otp-box si_otp" id="otp3">
<input type="text" maxlength="1" class="form-control otp-box si_otp" id="otp4">
<input type="text" maxlength="1" class="form-control otp-box si_otp" id="otp5">
<input type="text" maxlength="1" class="form-control otp-box si_otp" id="otp6">


</div>

<!-- <input type="text" class="form-control border-top-0 border-end-0 border-start-0 border-bottom" id="otp" placeholder="Enter OTP Sent to Mobile" aria-label="OPT Sent to Mobile" aria-describedby="otp-with-change-addon"> -->


<span style="color:red" id="error_msg_reg"></span>
<a class="input-group-text text-primary text-decoration-none bg-transparent border-0" onclick="call_register(); return false;" id="otp-with-change-addon">Get OTP ?</a>

<p class="text-muted mt-lg-2 mb-0">By continue, you agree to <a href="" class="text-decoration-none">BznessHub Terms of Use</a> and <a href="" class="text-decoration-none">Privacy Policy</a>.</p>
<button onclick="verify_otp(); return false;" class="btn btn-primary  mt-2 mt-lg-1 w-100 fw-bold text-light btn-radious" id="sendOtpSignUpBtn">Continue</button>
</form>
</div>
</div>
</div>
</div>
</div>

<!-- Log in and Sign up Modal Desktop -->
<!-- <div class="modal fade" id="loginModa" tabindex="-1" aria-labelledby="openLoginModal" aria-hidden="true">
<div id="container">
<div class="modal-dialog modal-dialog-centered" style="width: inherit; height: 447px;">
<div class="modal-content rounded-0" style="padding: 0; height: 504px;">
<div class="modal-body p-0">
<div class="p-0">


<div id="cover">

<h1 class="sign-up">Hello, Friend!</h1>
<p class="sign-up">Enter your personal details<br> and start a journey with us</p>
<a class="btn_cover button sign-up" href="#cover">Sign Up</a>

<h1 class="sign-in">Welcome Back!</h1>
<p class="sign-in">To keep connected with us please<br> login with your personal info</p>
<br>
<a class="btn_cover button sub sign-in" href="#">Sign In</a>
</div>


<div id="login" class="px-2">
<h1>Sign In</h1>
<form action="" class="col-md-12">
<div class="input-group">
<input type="text" class="form-control border-top-0 border-end-0 border-start-0 border-bottom  me-4" id="log_mobileno1" onkeypress="return AllowOnlyNumbers(event);" maxlength="10" placeholder="Enter Phone Number" aria-label="Enter Phone Number">
</div>
<span id="phonevl_errors" style="color:red;"></span>
<a class="input-group-text text-primary text-decoration-none bg-transparent border-0 mb-2" onclick="call_login_mob(); return false;" id="otp-with-change-addon">Send OTP ?</a>

<div class="input-group">
<input class="form-control border-top-0 border-end-0 border-start-0 border-bottom  me-4" type="text" id="otp_login1" placeholder="Enter OTP Sent to Mobile" aria-label="Enter OTP Sent to Mobile">
</div>
<a class="input-group-text text-primary text-decoration-none bg-transparent border-0"><span style="color:red" id="error_msg1"></span></a>

<button class="btn btn-primary mt-6 mt-lg-4 w-90 fw-bold text-light btn-radious me-5" onclick="call_login_otp_mob(); return false;" id="sendOtpLogInBtn" style="margin-right: 40px;">Verify</button>
<p class="text-muted mt-5 mt-lg-10 mb-0">By continue, you agree to <a href="" class="text-decoration-none">Bussinesshub Terms of Use</a> and <a href="" class="text-decoration-none">Privacy Policy</a>.</p>
</form>
</div>


<div id="register" class="px-2">
<h1>Create Account</h1>
<form action="" class="my-3 me-3 ms-2">
<input class="form-control border ms-2 me-6" type="text" id="fullname" placeholder="Enter Full Name" aria-label="Enter Full Name" required>
<span id="fullname_error" style="color:red;"></span>
<select id="country" name="country" class="form-control ms-2 mt-2 border">
<option value="OMN">Oman (+968)</option>
<option value="CA">Canada (+1)</option>
<option value="GB">United Kingdom (+44)</option>
<option value="AU">Australia (+61)</option>
<option value="DE">Germany (+49)</option>
<option value="FR">France (+33)</option>
<option value="IT">Italy (+39)</option>
<option value="JP">Japan (+81)</option>
<option value="MX">Mexico (+52)</option>
<option value="BR">Brazil (+55)</option>
<option value="RU">Russia (+7)</option>
<option value="IN" default selected>India (+91)</option>
<option value="CN">China (+86)</option>
<option value="KR">South Korea (+82)</option>
<option value="ZA">South Africa (+27)</option>
<option value="EG">Egypt (+20)</option>
<option value="AR">Argentina (+54)</option>
<option value="ES">Spain (+34)</option>
<option value="NL">Netherlands (+31)</option>
<option value="SE">Sweden (+46)</option>
</select>
<input class="form-control border  mt-2 w-100 ms-2 me-2" onkeypress="return AllowOnlyNumbers(event);" maxlength="10" type="text" id="mobileno" placeholder="Enter Mobile Number" aria-label="Enter Phone Number">
<span id="phonev_error" style="color:red;text-align:left"></span>
<input class="form-control border  mt-2 w-100 mb-2 ms-2 me-2" type="text" id="refer_code" placeholder="Refer code" aria-label="Enter Refer code">



<input type="text" class="form-control border-top-0 border-end-0 border-start-0 border-bottom  ms-2" id="otp" placeholder="Enter OTP Sent to Mobile" aria-label="OPT Sent to Mobile" aria-describedby="otp-with-change-addon">
<span style="color:red" id="error_msg_reg"></span>
<a class="input-group-text text-primary text-decoration-none bg-transparent border-0" onclick="call_register(); return false;" id="otp-with-change-addon">Get OTP ?</a>

<p class="text-muted mt-lg-2 mb-0">By continue, you agree to <a href="" class="text-decoration-none">Bussinesshub Terms of Use</a> and <a href="" class="text-decoration-none">Privacy Policy</a>.</p>
<button onclick="verify_otp(); return false;" class="btn btn-primary ms-2 mt-2 mt-lg-1 w-100 fw-bold text-light btn-radious" id="sendOtpSignUpBtn">Continue</button>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div> -->

<!-- Login Modal Mobile -->
<div class="modal fade" id="loginModalMobile" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered d-flex-center">
<div class="modal-content rounded-0 w-90 ms-2">
<div class="modal-body p-0">
<div class="container-fluid px-2">
<div class="row">
<div class="col-12 col-lg-5 col-xl-4 p-6 py-lg-14 px-lg-14 p-xl-10 h-auto d-flex flex-column justify-content-between bg-primary py-8 mx-auto auth_banner_img auth_banner_img_mobile">
<h2 class="text-center fw-bold text-light mt-5 mb-0">Login</h2>
<p class="mb-0 text-center fw-semibold text-light mt-4">Get access to your Orders, Wishlist and Recommendations</p>
</div>
<div class="col-12 col-lg-7 col-xl-8 p-6 p-md-10 py-lg-16 px-lg-16 h-auto d-flex flex-column justify-content-between py-12" id="enterNumberSignUp">
<form action="" class="col-md-12">
<div class="input-group">
<input type="text" class="form-control border-top-0 border-end-0 border-start-0 border-bottom  me-4" id="log_mobileno" onkeypress="return AllowOnlyNumbers(event);" maxlength="10" placeholder="Enter Phone Number" aria-label="Enter Phone Number">
</div>
<span id="phonev_errors0" style="color:red;"></span>
<a class="input-group-text text-primary text-decoration-none bg-transparent border-0 mb-2" onclick="call_login(); return false;" id="otp-with-change-addon">Get OTP ?</a>

<div class="input-group">
<input class="form-control border-top-0 border-end-0 border-start-0 border-bottom  me-4" type="text" id="otp_login" placeholder="Enter OTP Sent to Mobile" aria-label="Enter OTP Sent to Mobile">
</div>
<a class="input-group-text text-primary text-decoration-none bg-transparent border-0"><span style="color:red" id="error_msg"></span></a>

<button class="btn btn-primary mt-6 mt-lg-4 w-90 fw-bold text-light btn-radious me-5" onclick="call_login_otp(); return false;" id="sendOtpLogInBtn" style="margin-right: 40px;">Verify</button>
<p class="text-muted mt-5 mt-lg-10 mb-0">By continue, you agree to <a href="" class="text-decoration-none">BznessHub Terms of Use</a> and <a href="" class="text-decoration-none">Privacy Policy</a>.</p>
</form>
<a class="text-decoration-none mt-8 text-center d-block mb-lg-16" onclick="openSignUpModal()">New User? Sign Up Now</a>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<!-- Sign Up Modal Mobile -->
<div class="modal fade" id="signUpModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-centered d-flex-center">
<div class="modal-content rounded-0 w-90 ms-2">
<div class="modal-body p-0">
<div class="container-fluid px-2">
<div class="row">
<div class="col-12 col-lg-5 col-xl-4 p-6 py-lg-14 px-lg-14 p-xl-10 h-auto d-flex flex-column justify-content-between bg-primary py-8 auth_banner_img">
<h2 class="text-center fw-bold text-light mt-5 mb-0">Sign Up</h2>
<p class="mb-0 text-center fw-semibold text-light mt-4">Join the place to make yourself beautiful00</p>
</div>
<div class="col-12 col-lg-7 col-xl-8 p-6 p-md-10 py-lg-16 px-lg-16 h-auto d-flex flex-column justify-content-between py-12" id="enterNumberSignUp">
<form action="" class="my-3 me-3 ms-2">
<!--Name  -->
<input class="form-control border ms-2 me-6" type="text" id="fullname1" placeholder="Enter Full Name" aria-label="Enter Full Name" required>
<span id="fullname1_error" style="color:red;"></span>
<!-- Mobile Number -->
<div class="form-group">
<select id="country" name="country" class="form-control ms-2 mt-2 border">
<option value="OMN">Oman (+968)</option>
<option value="CA">Canada (+1)</option>
<option value="GB">United Kingdom (+44)</option>
<option value="AU">Australia (+61)</option>
<option value="DE">Germany (+49)</option>
<option value="FR">France (+33)</option>
<option value="IT">Italy (+39)</option>
<option value="JP">Japan (+81)</option>
<option value="MX">Mexico (+52)</option>
<option value="BR">Brazil (+55)</option>
<option value="RU">Russia (+7)</option>
<option value="IN" default selected>India (+91)</option>
<option value="CN">China (+86)</option>
<option value="KR">South Korea (+82)</option>
<option value="ZA">South Africa (+27)</option>
<option value="EG">Egypt (+20)</option>
<option value="AR">Argentina (+54)</option>
<option value="ES">Spain (+34)</option>
<option value="NL">Netherlands (+31)</option>
<option value="SE">Sweden (+46)</option>
</select>
<input class="form-control border  mt-2 w-100 ms-2 me-2" onkeypress="return AllowOnlyNumbers(event);" maxlength="10" type="text" id="mobileno1" placeholder="Enter Mobile Number" aria-label="Enter Phone Number">
</div>

<span id="phonev1_error" style="color:red;text-align:left"></span>
<input class="form-control border  mt-2 w-100 mb-2 ms-2 me-2" type="text" id="refer_code1" placeholder="Refer code" aria-label="Enter Refer code">

<input type="text" class="form-control border-top-0 border-end-0 border-start-0 border-bottom  ms-2" id="otp1" placeholder="Enter OTP Sent to Mobile" aria-label="OPT Sent to Mobile" aria-describedby="otp-with-change-addon">
<span style="color:red" id="error_msg_reg1"></span>

<a class="input-group-text text-primary text-decoration-none bg-transparent border-0" onclick="call_register_mob(); return false;" id="otp-with-change-addon">Get OTP ?</a>

<p class="text-muted mt-lg-2 mb-0">By continue, you agree to <a href="" class="text-decoration-none">BznessHub Terms of Use</a> and <a href="" class="text-decoration-none">Privacy Policy</a>.</p>
<button onclick="verify_otp_mob(); return false;" class="btn btn-primary ms-2 mt-2 mt-lg-1 w-100 fw-bold text-light btn-radious" id="sendOtpSignUpBtn">Continue</button>
</form>
<a class="text-decoration-none mt-8 text-center d-block mb-lg-16" onclick="openLoginModalMobile()">Existing User? Log In</a>
</div>
<!-- <div class="col-12 col-lg-7 col-xl-8 p-6 p-md-10 py-lg-16 px-lg-16 h-auto d-none flex-column justify-content-between py-12" id="enterOTPSignUp">
<form action="">
<div class="input-group">
<input type="text" class="form-control border-top-0 border-end-0 border-start-0 border-bottom rounded-0" id="otp" placeholder="Enter OTP Sent to Mobile" aria-label="OPT Sent to Mobile" aria-describedby="otp-with-change-addon">
<a class="input-group-text text-primary text-decoration-none bg-transparent border-0" id="otp-with-change-addon">Change ?</a>
</div>
<div class="text-right me-5 mt-4">
<button class="btn btn-sm btn-link float-end" onclick="call_register(); return false;">Resend OTP</button>
</div>
<span style="color:red" id="error_msg_reg"></span>
<button class="btn btn-primary mt-8 mt-lg-8 w-100 fw-bold text-light rounded-0" onclick="verify_otp(); return false;">Continue</button>
</form>
<a class="text-decoration-none mt-8 text-center d-block mb-lg-16" onclick="openLoginModalMobile()">Existing User? Log In</a>
</div> -->
</div>
</div>
</div>
</div>
</div>
</div>


<input type="hidden" class="txt_csrfname" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
<input type="hidden" class="site_url" value="<?php echo site_url(); ?>">
<input type="hidden" name="website_name" value="<?php echo website_name; ?>" id="website_name">
<input type="text" class="d-none" value="<?= $share_code; ?>" name="myCodes" id="myCodes">

<!-- JQuery CDN -->	
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

<script>


function testLogout() {
console.log("Done Log Out")
}

function openLoginModal() {
$("#loginModal").modal("show")
$("#signUpModal").modal("hide")
}

function openSignUpModal() {
$("#signUpModal").modal("show")
$("#loginModalMobile").modal("hide")
// var modalBackdrop = document.querySelector(".modal-backdrop");
// // modalBackdrop.style.position="inherit";
// modalBackdrop.classList.remove("modal-backdrop");
}

function copy_refer_code() {

var copyText = document.getElementById("refers_name");
copyText.select();
copyText.setSelectionRange(0, 99999); /* For mobile devices */

navigator.clipboard.writeText(copyText.value);


Toastify({
text: "Refer Code Copied!",
duration: 1500,
newWindow: false,
close: false,
gravity: "bottom", // `top` or `bottom`
position: "center", // `left`, `center` or `right`
stopOnFocus: true, // Prevents dismissing of toast on hover
style: {
background: "linear-gradient(to right, #ff6600, #ff6600)",
},
onClick: function() {} // Callback after click
}).showToast();



}


function openLoginModalMobile() {
$("#loginModalMobile").modal("show")
$("#signUpModal").modal("hide")
// var modalBackdrop = document.querySelector(".modal-backdrop");
// // modalBackdrop.classList.remove("modal-backdrop");
// modalBackdrop.style.position = "inherit"
// modalBackdrop.style.opacity = "0.5"
}


window.onscroll = function() {
var divElements = document.getElementsByClassName("main_dropdown_position");
var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
for (var i = 0; i < divElements.length; i++) {
if (scrollTop === 0) {
console.log(scrollTop + " if")
divElements[i].style.marginTop = "5px";
} else if (1 <= scrollTop && scrollTop < 6) {
console.log(scrollTop + " if else")
divElements[i].style.marginTop = "-2px";
} else if (6 <= scrollTop && scrollTop <= 15) {
console.log(scrollTop + " if else")
divElements[i].style.marginTop = "-7px";
} else if (16 <= scrollTop && scrollTop <= 18) {
console.log(scrollTop + " if else")
divElements[i].style.marginTop = "-12px";
} else if (19 <= scrollTop && scrollTop <= 22) {
console.log(scrollTop + " if else")
divElements[i].style.marginTop = "-15px";
} else if (23 <= scrollTop && scrollTop <= 25) {
console.log(scrollTop + " if else")
divElements[i].style.marginTop = "-20px";
} else if (26 <= scrollTop && scrollTop <= 28) {
console.log(scrollTop + " if else")
divElements[i].style.marginTop = "-23px";
} else {
console.log(scrollTop + " else")
divElements[i].style.marginTop = "-25px";
}

}
// divElement.style.marginTop = "-20px";
};

$(document).ready(function() {
var dropdown = $('.menu-items .menu-li');
var overlay = $('.dropdown-overlay');

dropdown.hover(
function() {
overlay[0].style.display = "block";
},
function() {
overlay[0].style.display = "none";
}
);
});
</script>

<script>
const searchInput = document.getElementById('search');
const searchResults = document.getElementById('search_results');

searchInput.addEventListener('focus', function() {
searchResults.classList.add('show');
});

searchInput.addEventListener('blur', function() {
setTimeout(function() {
searchResults.classList.remove('show');
}, 200);
});
</script>

<script>
function toggleSearchBar() {
const searchBar = document.getElementById('search_bar_mobile');
searchBar.style.display = (searchBar.style.display === 'none') ? 'block' : 'none';
//   searchBar.style.width="50%";
}

function hideSearchBar() {
const searchBar = document.getElementById('searchBar');
searchBar.style.display = 'none';
}
</script>

<!-- Search Bar Script -->
<script>
function openSearchBar() {
document.getElementById('hidden_navbar_search').style.display = "block"
document.getElementById('main_navbar').style.display = "none"
}

function closeSearchBar() {
document.getElementById('hidden_navbar_search').style.display = "none"
document.getElementById('main_navbar').style.display = "block"
}

// For Mobile
function openSearchBarMobile() {
document.getElementById('hidden_navbar_search_mobile').style.display = "block"
document.getElementById('main_navbar').style.display = "none"
}

function closeSearchBarMobile() {
document.getElementById('hidden_navbar_search_mobile').style.display = "none"
document.getElementById('main_navbar').style.display = "block"
}
</script>

<!-- Mega Menu -->
<script>
function setDivWidths() {
$(document).ready(function() {
var superParentWidth = $('#category_navbar').width();
$('.mega-menu').width(superParentWidth);
});
}

window.addEventListener('DOMContentLoaded', setDivWidths);
window.addEventListener('resize', setDivWidths);

// Script for Paddong on Scroll
function setPadding() {
let scroll_count = window.scrollY
console.log(scroll_count)
}

window.addEventListener("load", setPadding())
</script>