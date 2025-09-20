<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("./includes/head.php") ?>
</head>
<body>
    <?php include("./includes/topBar.php") ?>
    <div class="shadow-sm sticky-top">
        <?php include("./includes/header.php") ?>
    </div>

    <!-- product details starts -->
    <section id="product-details">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-sm-0">
                    <!-- first image  -->
                    <div class="show position-relative" href="1.jpg">
                        <img class="img-fluid" src="./images/products/1.png" id="show-img">
                        <div class="favourite shadow">
                            <i class="far fa-heart"></i>
                        </div>
                    </div>
                    <!-- slider images  -->
                    <div class="small-img">
                        <i class="fas fa-arrow-alt-circle-left icon-left" id="prev-img"></i>
                            <div class="small-container">
                                <div id="small-img-roll">
                                    <img src="./images/products/1.png" class="show-small-img" alt="">
                                    <img src="./images/products/2.png" class="show-small-img" alt="">
                                    <img src="./images/products/3.png" class="show-small-img" alt="">
                                    <img src="./images/products/4.png" class="show-small-img" alt="">
                                    <img src="./images/products/2.png" class="show-small-img" alt="">
                                    <img src="./images/products/2.png" class="show-small-img" alt="">
                                    <img src="./images/products/2.png" class="show-small-img" alt="">
                                </div>
                            </div>
                            <i class="fas fa-arrow-alt-circle-right icon-right" id="next-img"></i>
                    </div>
                </div>
                <div class="col-md-4 mb-4 mb-sm-0">
                    <h1 class="fs-2 mb-3 mb-lg-4" id="product_name">
                        Brown ECA Brick Jelly, For Construction, Packaging Type: Bag
                    </h1>
                    <div class="review mb-4 mb-lg-5">
                        <div class="review-pill shadow">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="review-text">
                            <span>4.8 Stars</span>
                        </div>
                    </div>
                    <div class="pDetails">
                        <div class="product-color mb-3 mb-lg-4">
                            <span class="fw-bold">Color</span>
                            <div class="w-75 line mb-3"></div>
                                <div class="change-color">
                                    <span class="white Active" name="white" picChange="url(./i)"></span>
                                    <span class="black" name="black" picChange="url(./i)"></span>
                                    <span class="blue" name="blue" picChange="url(./i)"></span>
                                    <span class="red" name="red" picChange="url(./i)"></span>
                                    <span class="green" name="green" picChange="url(./i)"></span>
                                </div>
                        </div>
                        <div class="product-size mb-3 mb-lg-4">
                            <span class="fw-bold">Size</span>
                            <div class="w-75 line mb-3"></div>
                                <div class="p-size">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="size-xs" value="size-xs" >
                                        <label class="form-check-label" for="size-xs">XS</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="size-s" value="size-s">
                                        <label class="form-check-label" for="size-s">S</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="size-m" value="size-m" checked>
                                        <label class="form-check-label" for="size-m">M</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="size-l" value="size-l" >
                                        <label class="form-check-label" for="size-l">L</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="size-xl" value="size-xl">
                                        <label class="form-check-label" for="size-xl">XL</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="size-xxl" value="size-xxl">
                                        <label class="form-check-label" for="inlineRadio1">XXL</label>
                                    </div>
                                </div>
                        </div>
                        <div class="product-avail mb-3 mb-lg-4">
                            <span class="fw-bold">Delivery</span>
                            <div class="w-75 line mb-3"></div>
                            <form class="d-flex" id="avail">
                                <input class="form-control me-2" type="search" placeholder="PIN Code" aria-label="Search">
                                <button class="btn btn-primary" type="submit">CHECK</button>
                            </form>   
                        </div>
                    </div> 
                </div>
                <div class="col-md-4 pPriceDetails">
                    <div class="pPrice">
                        <h2>MRP : <span id="product-price">$100.00</span></h2>
                        <p class="">$120.00</p>
                    </div>
                    <div class="offerCoupon">
                        <p>Total Savings : $20.00 (5% Discount)</p>
                        <form class="d-flex" id="coupon">
                            <input class="form-control me-2" type="search" placeholder="Coupon Code" aria-label="Search">
                            <button class="btn btn-primary" type="submit">Apply</button>
                        </form> 
                    </div>
                    <div class="available-offers">
                        <h3>Available Offers </h3>
                        <div class="allOffers">
                            <p>Bank Offer10% Instant Discount on Punjab National Bank Debit and Credit CardsT&C</p>
                            <p>Bank Offer5% Unlimited Cashback on Flipkart Axis Bank Credit CardT&C</p>
                            <p>Bank Offer20% off on 1st txn with Amex Network Cards issued by ICICI Bank,IndusInd Bank,SBI Cards and MobikwikT&C</p>
                            <p>Partner OfferBuy and Get Free 6 months Gaana Plus SubscriptionKnow More</p>
                            <p>Bank OfferFlat ₹75 off on first Flipkart Pay Later order of ₹500 and aboveT&C</p>
                        </div>
                    </div>

                    <div class="pBtns">
                        <a class="btn-solid" href="">Buy Now</a>
                        <a class="btn-border" href="">Add to Cart</a>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- product details ends -->
    
    <!-- product review and description starts -->
    <section class="container">
        <div class="section-title">
            <h2>Details</h2>
        </div>
        <div class="details">
            <p>
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
            </p>
        </div>
    </section>
    <!-- product review and description ends -->


    <?php include("./includes/script.php"); ?>
</body>
</html>