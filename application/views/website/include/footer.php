<footer class="py-4 desktop-footer">
    <div class="container-fluid">
        <hr>
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 my-4 footer justify-content-around">
            <div class="col">
                <div class="footer_logo">
                    <a href="/">
                        <img src="<?php echo base_url; ?>assets_web/images/BusinessHub_footer_new.png" class="img-fluid footer_logo_image" alt="Footer Logo" style="height: 48px">
                    </a>
                </div>
                <p class="fw-semibold fs-xl-6 mb-3">
                    <!-- Experience the rich culture of Oman at your doorstep with our exquisite collection of traditional posak.
					Shop now on our online marketplace and let the magic of Oman come alive!. -->
					
					The perfect one-stop shop for all your cravings. BznessHub 
                    has simplified the shopping experience for its value-conscious buyers. Shop now on our online store and 
                    and bring the world at your doorsteps.
                </p>
                
            </div>

            <div class="col mt-4 mt-md-4 mt-lg-4">
                <h3 class="fw-bold text-xl-center ">About Us</h3>
                <ul class="list-unstyled mb-0">
                    <li><a href="<?php echo base_url ?>faq" class="text-decoration-none text-dark fw-semibold d-xl-block text-center">FAQ</a></li>
                    <li><a href="<?php echo base_url ?>feedback" class="text-decoration-none text-dark fw-semibold d-xl-block text-center">Feedback</a></li>
                    <li><a href="<?php echo base_url ?>contact" class="text-decoration-none text-dark fw-semibold d-xl-block text-center">Contact Us</a></li>
                    <li><a href="<?php echo base_url ?>help" class="text-decoration-none text-dark fw-semibold d-xl-block text-center">Help & Support</a></li>
                </ul>
            </div>
            <div class="col mt-4 mt-md-4 mt-lg-4">
                <h3 class="fw-bold text-xl-center ">Services</h3>
                <ul class="list-unstyled mb-0">

                    <li><a href="<?php echo base_url ?>offers" class="text-decoration-none text-dark fw-semibold d-xl-block text-center">Offers for you</a></li>
					<?php if($this->session->userdata("is_seller") == 0) { ?>
					<li><a href="<?php echo base_url(); ?>become-seller" class="text-decoration-none text-dark fw-semibold d-xl-block text-center">Virtual Partner</a></li>
					<?php } ?>
					<li><a href="<?php echo base_url ?>newarrival" class="text-decoration-none text-dark fw-semibold d-xl-block text-center">New Arrival</a></li>
					<li><a href="<?php echo base_url ?>high_discount" class="text-decoration-none text-dark fw-semibold d-xl-block text-center">50% Products</a></li>
					<li><a href="<?php echo base_url ?>regarding_price" class="text-decoration-none text-dark fw-semibold d-xl-block text-center">Prize Money Products</a></li>
                </ul>
            </div>
            <div class="col mt-4 mt-md-4 mt-lg-4">
                <h3 class="fw-bold text-xl-center ">Our Policy</h3>
                <ul class="list-unstyled mb-0">
                    <li><a href="<?php echo base_url ?>refund" class="text-decoration-none text-dark fw-semibold d-xl-block text-center">Returns Policy</a></li>
                    <li><a href="<?php echo base_url ?>privacy" class="text-decoration-none text-dark fw-semibold d-xl-block text-center">Privacy Policy</a></li>
                    <li><a href="<?php echo base_url(); ?>shipping_policy" class="text-decoration-none text-dark fw-semibold d-xl-block text-center">Shipping Policy</a></li>
                    <li><a href="<?php echo base_url ?>term_and_conditions" class="text-decoration-none text-dark fw-semibold d-xl-block text-center">Terms and Condition</a></li>
                </ul>
            </div>
        </div>

                <div style="    padding-left: 30px;">

<h4 class="fw-bold mb-3">
                    Accepted Payments
                </h4>             
                    <div class="footer_payment_logo">
                        <!-- <img src="<?php echo base_url; ?>assets_web/images/svgs/stripe.svg" class="mb-2 mb-xl-0" alt="Stripe"> -->
                        <img src="<?php echo base_url; ?>assets_web/master.jpeg" class="mb-2 mb-xl-0" alt="Mastercard"  style="
background: #fff;
border: 1px solid #ccc;
border-radius: 4px;
padding: 2px;">
                        <img src="<?php echo base_url; ?>assets_web/images/svgs/visa.svg" class="mb-2 mb-xl-0" alt="Visa">
                        <img src="<?php echo base_url; ?>assets_web/images/svgs/gpay.svg" class="mb-2 mb-xl-0" alt="Google Pay">
<img src="<?php echo base_url; ?>assets_web/rupay.jpeg" class="mb-2 mb-xl-0" alt="Rupay" style="
background: #fff;
border: 1px solid #ccc;
border-radius: 4px;
padding: 2px;">
                        <img src="<?php echo base_url; ?>assets_web/paytm.jpeg" class="mb-2 mb-xl-0" alt="Paytm"  style="
background: #fff;
border: 1px solid #ccc;
border-radius: 4px;
padding: 2px;">
                        <!-- <img src="<?php echo base_url; ?>assets_web/images/svgs/applepay.svg" class="mb-2 mb-xl-0" alt="Apple Pay"> -->
                    </div>
                </div>

        <hr>
        <p class="mb-0 fw-semibold text-center">&copy; <?php echo Date("Y") ?> - Copyright BznessHub All Right Reserved</p>
    </div>
</footer>

<!-- Mobile Footer -->

<div class="mobile-footer" style="">
    <div class="px-0">
        <button class="btn w-100 text-dark" id="toggle-btn">
            <span class="button-text">More about BznessHub</span>
            <i class="fa-solid fa-angle-down icon"></i>
        </button>
    </div>
    <div class="mobile-footer-content" id="toggle-footer" style="height:0px;">
        <div class="container-fluid">
            <hr style="border-color: #fff; opacity:1">
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 my-4 footer justify-content-around">
                <div class="col p-0">
                    <p class="fw-semibold fs-xl-6 mb-3">
                        The perfect one-stop shop for all your cravings. BznessHub has simplified the shopping experience for its value-conscious buyers. Shop now on our online store and and bring the world at your doorsteps.

                    </p>
                    <h4 class="fw-bold text-light mb-3">
                        Accepted Payments
                    </h4>
                    <div>
                        <div class="footer_payment_logo">
                            <!-- <img src="<?php echo base_url; ?>assets_web/images/svgs/stripe.svg" class="mb-2 mb-xl-0" alt="Stripe"> -->
                            <img src="<?php echo base_url; ?>assets_web/images/svgs/mastercard.svg" class="mb-2 mb-xl-0" alt="Mastercard">
                            <img src="<?php echo base_url; ?>assets_web/images/svgs/visa.svg" class="mb-2 mb-xl-0" alt="Visa">
                            <img src="<?php echo base_url; ?>assets_web/images/svgs/gpay.svg" class="mb-2 mb-xl-0" alt="Google Pay">
                            <!-- <img src="<?php echo base_url; ?>assets_web/images/svgs/applepay.svg" class="mb-2 mb-xl-0" alt="Apple Pay"> -->
                        </div>
                    </div>
                </div>

                <div class="col p-0 mt-4 mt-md-4 mt-lg-4">
                    <h3 class="fw-bold text-light text-xl-center ">About Us</h3>
                    <ul class="list-unstyled mb-0">
                        <li><a href="<?php echo base_url ?>faq" class="text-decoration-none text-light fw-semibold d-xl-block text-center">FAQ</a></li>
                        <li><a href="<?php echo base_url ?>feedback" class="text-decoration-none text-light fw-semibold d-xl-block text-center">Feedback</a></li>
                        <li><a href="<?php echo base_url ?>contact" class="text-decoration-none text-light fw-semibold d-xl-block text-center">Contact Us</a></li>
                        <li><a href="<?php echo base_url ?>help" class="text-decoration-none text-light fw-semibold d-xl-block text-center">Help & Support</a></li>
                    </ul>
                </div>

                <div class="col p-0 mt-4 mt-md-4 mt-lg-4">
                    <h3 class="fw-bold text-light text-xl-center ">Services</h3>
                    <ul class="list-unstyled mb-0">

                        <li><a href="<?php echo base_url ?>offers" class="text-decoration-none text-light fw-semibold d-xl-block text-center">Offers for you</a></li>
                        <li><a href="<?php echo base_url(); ?>become-seller" class="text-decoration-none text-light fw-semibold d-xl-block text-center">Virtual Partner</a></li>
                    </ul>
                </div>

                <div class="col p-0 mt-4 mt-md-4 mt-lg-4">
                    <h3 class="fw-bold text-light text-xl-center ">Our Policy</h3>
                    <ul class="list-unstyled mb-0">
                        <li><a href="<?php echo base_url ?>refund" class="text-decoration-none text-light fw-semibold d-xl-block text-center">Returns Policy</a></li>
                        <li><a href="<?php echo base_url ?>privacy" class="text-decoration-none text-light fw-semibold d-xl-block text-center">Privacy Policy</a></li>
                        <li><a href="<?php echo base_url(); ?>shipping_policy" class="text-decoration-none text-light fw-semibold d-xl-block text-center">Shipping Policy</a></li>
                        <li><a href="<?php echo base_url(); ?>term_and_conditions" class="text-decoration-none text-light fw-semibold d-xl-block text-center">Terms and Condition</a></li>
                    </ul>
                </div>
            </div>
            <hr style="border-color: #fff; opacity:1">
            <p class="mb-0 pb-4 fw-semibold text-center">&copy; <?php echo Date("Y") ?> - Copyright BznessHub All Right Reserved</p>
        </div>
    </div>
</div>


<script>
    var toggleBtn = document.getElementById('toggle-btn');
    var toggleFooter = document.getElementById('toggle-footer');
    var faIcon = document.querySelector('.fa-angle-down');

    toggleBtn.addEventListener('click', function() {
        var footerHeight = toggleFooter.scrollHeight;

        if (toggleFooter.style.height === '0px') {
            toggleFooter.style.height = footerHeight + 'px';
            toggleFooter.scrollIntoView({
                behavior: 'smooth'
            });
            faIcon.style.transform = "rotate(-180deg)";
            setTimeout(() => {
                window.scrollTo({
                    top: document.documentElement.scrollHeight,
                    behavior: 'smooth'
                });
            }, 300)
        } else {
            toggleFooter.style.height = '0';
            faIcon.style.transform = "rotate(0deg)";
        }
    });

    function scrollToBottom() {
        var currentPosition = window.pageYOffset;
        var targetPosition = document.body.scrollHeight;
        var distance = targetPosition - currentPosition;
        var step = Math.ceil(distance / 40); // Adjust the value for desired scrolling speed

        function scrollStep() {
            currentPosition += step;
            window.scrollTo(0, currentPosition);

            if (currentPosition < targetPosition) {
                requestAnimationFrame(scrollStep);
            }
        }

        if (currentPosition < targetPosition) {
            window.scrollTo(0, targetPosition);
            requestAnimationFrame(scrollStep);
        } else {
            scrollStep();
        }
    }

    var currentURL = window.location.href;
    var button = document.getElementById('download-app-btn');
    var mobileFooter = document.querySelector('.mobile-footer');

    if (currentURL === '<?= base_url ?>') {
        button.style.display = 'block';
        mobileFooter.style.cssText = 'margin-bottom:3.8rem;';
    } else {
        button.style.display = 'none';
        mobileFooter.style.cssText = '';
    }
</script>