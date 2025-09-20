<nav class="py-3 navbar-expand-lg d-md-none bg-light fixed-bottom shadow-lg a-mobileNav" style="width: 100%;">
    <div class="container-fluid justify-content-center px-2">
        <div class="row row-cols-5 d-flex justify-content-evenly">
            <a href="<?php echo base_url ?>" class="p-0">
                <div class="col">
                    <div class="w-100 d-flex justify-content-center">
                        <i class='bx bx-home' style="color:#162b75;"></i>
                    </div>
                    <div class="w-100 d-flex justify-content-center">
                        <p class="mb-0 fs-xs fw-semibold">Home</p>
                    </div>
                </div>
            </a>
            <!-- <a data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop" class="p-0">
                <div class="col">
                    <div class="w-100 d-flex justify-content-center">
                        <i class='bx bx-compass'></i>
                    </div>
                    <div class="w-100 d-flex justify-content-center">
                        <p class="mb-0 fs-xs fw-semibold">Explore</p>
                    </div>
                </div>
            </a> -->
            <div class="offcanvas offcanvas-start" style="padding:0" tabindex="-1" id="offcanvasWithBackdrop" aria-labelledby="offcanvasWithBackdropLabel" class="p-0">
                <div class="offcanvas-header bg-primary">
                    <h5 class="offcanvas-title text-light fw-bold" id="offcanvasWithBackdropLabel">Explore</h5>
                    <button type="button" class="btn-close text-reset text-light" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <hr>
                    <a class="" href="<?php echo base_url(); ?>explore-sub/10"><svg fill="#000000" class="me-2" width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">

                            <title />

                            <g data-name="Layer 2" id="Layer_2">

                                <path d="M13.68,3.79a1.77,1.77,0,0,1-3.37,0l-.73-2.2L2,5.38V12H5V22H19V12h3V5.38L14.42,1.59Zm1.9.63h0L20,6.62V10H17V20H7V10H4V6.62L8.42,4.41h0a3.77,3.77,0,0,0,7.16,0Z" />

                                <rect height="2" width="3" x="13" y="10" />

                            </g>

                        </svg>Custom Clothing</a>
                    <hr>
                    <a class="" href="<?php echo base_url(); ?>offers"><svg class="me-2" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 16L16 8M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12ZM17 15C17 16.1046 16.1046 17 15 17C13.8954 17 13 16.1046 13 15C13 13.8954 13.8954 13 15 13C16.1046 13 17 13.8954 17 15ZM11 9C11 10.1046 10.1046 11 9 11C7.89543 11 7 10.1046 7 9C7 7.89543 7.89543 7 9 7C10.1046 7 11 7.89543 11 9Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>Offers for you</a>
                    <hr>
                    <a class="" href="<?php echo base_url(); ?>become-seller"><svg class="me-2" fill="#000000" width="18" height="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22,7.82a1.25,1.25,0,0,0,0-.19v0h0l-2-5A1,1,0,0,0,19,2H5a1,1,0,0,0-.93.63l-2,5h0v0a1.25,1.25,0,0,0,0,.19A.58.58,0,0,0,2,8H2V8a4,4,0,0,0,2,3.4V21a1,1,0,0,0,1,1H19a1,1,0,0,0,1-1V11.44A4,4,0,0,0,22,8V8h0A.58.58,0,0,0,22,7.82ZM13,20H11V16h2Zm5,0H15V15a1,1,0,0,0-1-1H10a1,1,0,0,0-1,1v5H6V12a4,4,0,0,0,3-1.38,4,4,0,0,0,6,0A4,4,0,0,0,18,12Zm0-10a2,2,0,0,1-2-2,1,1,0,0,0-2,0,2,2,0,0,1-4,0A1,1,0,0,0,8,8a2,2,0,0,1-4,.15L5.68,4H18.32L20,8.15A2,2,0,0,1,18,10Z" />
                        </svg>Become a Seller</a>
                    <hr>
                </div>
            </div>

            <!--<a href="<?php echo base_url ?>all-category" class="p-0">
                <div class="col">
                    <div class="w-100 d-flex justify-content-center">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="#162b75" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 3H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zM9 9H5V5h4v4zm11-6h-6a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm-1 6h-4V5h4v4zm-9 4H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-6a1 1 0 0 0-1-1zm-1 6H5v-4h4v4zm8-6c-2.206 0-4 1.794-4 4s1.794 4 4 4 4-1.794 4-4-1.794-4-4-4zm0 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2z" />
                        </svg>
                    </div>
                    <div class="w-100 d-flex justify-content-center">
                        <p class="mb-0 fs-xs fw-semibold">Category</p>
                    </div>
                </div>
            </a>-->
            <!-- <?php if (!empty($this->session->userdata("user_id"))) { ?>
                <a href="<?php echo base_url(); ?>notification" class="p-0">
                    <div class="col">
                        <div class="w-100 d-flex justify-content-center">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.146 3.248a2 2 0 0 1 3.708 0A7.003 7.003 0 0 1 19 10v4.697l1.832 2.748A1 1 0 0 1 20 19h-4.535a3.501 3.501 0 0 1-6.93 0H4a1 1 0 0 1-.832-1.555L5 14.697V10c0-3.224 2.18-5.94 5.146-6.752zM10.586 19a1.5 1.5 0 0 0 2.829 0h-2.83zM12 5a5 5 0 0 0-5 5v5a1 1 0 0 1-.168.555L5.869 17H18.13l-.963-1.445A1 1 0 0 1 17 15v-5a5 5 0 0 0-5-5z" fill="#0D0D0D" />
                            </svg>
                        </div>
                        <div class="w-100 d-flex justify-content-center">
                            <p class="mb-0 fs-xs fw-semibold">Notification</p>
                        </div>
                    </div>
                </a>
            <?php } else { ?>
                <a href="" data-bs-toggle="modal" data-bs-target="#modalLogIn">
                    <div class="col">
                        <div class="w-100 d-flex justify-content-center">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.146 3.248a2 2 0 0 1 3.708 0A7.003 7.003 0 0 1 19 10v4.697l1.832 2.748A1 1 0 0 1 20 19h-4.535a3.501 3.501 0 0 1-6.93 0H4a1 1 0 0 1-.832-1.555L5 14.697V10c0-3.224 2.18-5.94 5.146-6.752zM10.586 19a1.5 1.5 0 0 0 2.829 0h-2.83zM12 5a5 5 0 0 0-5 5v5a1 1 0 0 1-.168.555L5.869 17H18.13l-.963-1.445A1 1 0 0 1 17 15v-5a5 5 0 0 0-5-5z" fill="#0D0D0D" />
                            </svg>
                        </div>
                        <div class="w-100 d-flex justify-content-center">
                            <p class="mb-0 fs-xs fw-semibold">Notification</p>
                        </div>
                    </div>
                </a>
            <?php } ?> -->
            <?php if (!empty($this->session->userdata("user_id"))) { ?>
                <a href="<?php echo base_url(); ?>user-wallet" class="p-0">
                    <div class="col">
                        <div class="w-100 d-flex justify-content-center">
                            <i class='bx bx-wallet' style="color:#162b75;"></i>
                        </div>
                        <div class="w-100 d-flex justify-content-center">
                            <p class="mb-0 fs-xs fw-semibold">My Earning</p>
                        </div>
                    </div>
                </a>
            <?php } else { ?>
                <a href="" data-bs-toggle="modal" data-bs-target="#modalLogIn" class="p-0">
                    <div class="col">
                        <div class="w-100 d-flex justify-content-center">
                            <i class='bx bx-wallet' style="color:#162b75;"></i>
                        </div>
                        <div class="w-100 d-flex justify-content-center">
                            <p class="mb-0 fs-xs fw-semibold">My Earning</p>
                        </div>
                    </div>
                </a>
            <?php } ?>
			<a href="<?php echo base_url(); ?>cart" class="p-0">
                    <div class="col" style="position: relative;">
                        <div class="w-100 d-flex justify-content-center">
                            <i class='bx bx-cart fa-3x' style="color:#162b75;"></i>
                        </div>
                        <div class="w-100 d-flex justify-content-center">
                            <p class="mb-0 fs-xs fw-semibold">Cart</p>
                        </div>
						<div class="icon-count">
							<div id="badge-cart-count">0</div>
						</div>
                    </div>
                </a>
        </div>
    </div>
</nav>