<!DOCTYPE html>
<html lang="en">

<head>
<?php $title = "Track Order";
include("include/headTag.php") ?>
</head>
<style>
.cart-page .right-block .price-details ul
{
padding : 0;
}
.cart-page .right-block .total
{
padding : 10px 0;
}
label.Color {
height: 24px;
width: 24px;
border-radius: 50%;
}
.attributes tr {
height: 30px;
}
</style>
<body>

<?php
include("include/topbar.php")
?>
<?php
include("include/navbar.php");

/* echo '<pre>';
print_r($order_details);
exit;*/
?>

<main class="track-order-page my-order-page cart-page product-details-page">
<input type="hidden" name="pid" value="<?php echo $order_details['product_details'][0]['prod_id']; ?>" id="pid">
<input type="hidden" name="user_id" value="<?= $this->session->userdata("user_id"); ?>" id="user_id">
<!--Start: Track Order Section -->
<section>
<div class="container" style="max-width:1344px;">
<div class="row">

<div class="col-lg-9">
<div class="left-block box-shadow">
<h5 class="title">Track Order </h5>

<div class="row">
<div class="col-md-6">
<div class="cart-details">
<img onclick="redirect_to_link('<?php echo base_url .'product/'. $order_details['product_details'][0]['prod_sku']; ?>')" src="<?php echo weburl . 'media/' . $order_details['product_details'][0]['prod_img']; ?>" class="product-thumb" />
<div class="cart-body">
<h6 onclick="redirect_to_link('<?php echo base_url .'product/'. $order_details['product_details'][0]['prod_sku']; ?>')"><?php echo $order_details['product_details'][0]['prod_name']; ?></h6>
<!--<div class="rate">
<div class="rating">5.0 <img src="<?php // echo base_url;
?>/assets_web/images/icons/star.png" /></div>
<div class="rating-details">Excellent</div>
</div>-->
<p class="text-muted mt-5">
<table class="attributes mb-3">
<tbody>
<?php foreach ($order_details['order_summery']['prod_attr'] as $conf_data) { ?>
<tr>
<td class="attr-name"><b><?= $conf_data->attr_name ?></td>
<?php if (preg_match('/^#[0-9A-Fa-f]{6}$/', $conf_data->item)) :
$style = getDarkColorStyle($conf_data->item);
endif; ?></b>
<td>
<div class="d-flex align-items-center">
<label for="" <?= preg_match('/^#[0-9A-Fa-f]{6}$/', $conf_data->item) ? 'style="' . $style . '"' : '' ?> class="<?= $conf_data->attr_name ?> attr-des ms-3 ms-md-5">
<?= !preg_match('/^#[0-9A-Fa-f]{6}$/', $conf_data->item) ? $conf_data->item : '' ?>
</label>
</div>
</td>
</tr>
<?php } ?>
</tbody>
</table>

</p>
<div class="wrap-details">
<div class="rate">
<h5><?php echo $order_details['product_details'][0]['prod_price']; ?></h5>
<div class="old-price"><?php echo $order_details['product_details'][0]['prod_mrp']; ?></div>
<!--<div class="off-price">60% off</div>-->
</div>
<div class="qty">Qty: <?php echo $order_details['product_details'][0]['qty']; ?></div>
<div class="order-id"><span>Order ID:</span> <?php echo $order_details['order_summery']['order_id']; ?></div>
<?php if ($order_details['product_details'][0]['tracking_id']) { ?>
<div class="order-id"><span>Tracking ID:</span> <?php echo $order_details['product_details'][0]['tracking_id']; ?></div>
<?php } if ($order_details['product_details'][0]['tracking_url']) { ?>
<a href="<?= $order_details['product_details'][0]['tracking_url'] ?>" class="text-primary" target="_blank" rel="noopener noreferrer">Track Your Order</a>
<?php } ?>
</div>
</div>
</div>
</div>
<div class="col-md-6">
<div class="order-progress">
<ul class="step-progress">
<li class="step-progress-item is-done">
<h6>Order Confirmed</h6>
<p><?php echo date('d-M-Y h:i:sa', strtotime($order_details['order_summery']['create_date'])); ?></p>
</li>
<!--<li class="step-progress-item is-done">
<h6>Shipped</h6>
<p>Order Confirmed at 12:57 PM, 27, Jan</p>
</li>
<li class="step-progress-item current">
<h6>Out for Delivery</h6>
<p>Order Confirmed at 12:57 PM, 27, Jan</p>
</li>-->
<li class="step-progress-item <?php if($order_details['product_details'][0]['status'] == 'Delivered') { echo 'is-done'; }  ?>">
<h6><?php echo $order_details['product_details'][0]['status']; ?></h6>
<!--<p>Order Confirmed at 12:57 PM, 27, Jan</p>-->
</li>
</ul>
</div>
</div>
</div>

<div class="row">
<div class="col-md-6">
<h6>Delivery Address</h6>
<div class="address-details box-shadow">
<span class="badge"><?php echo $order_details['shipping_address']['addresstype']; ?></span>
<ul class="name">

<li>
<h6><?php echo $order_details['shipping_address']['fullname']; ?></h6>
</li>

</ul>
<div class="address">
<h6><?php echo $order_details['shipping_address']['mobile']; ?><br><?php echo $order_details['shipping_address']['email']; ?><br>
<?php echo $order_details['shipping_address']['fulladdress'] . ',' .$order_details['shipping_address']['city'] . ',' . $order_details['shipping_address']['state'] . '-' . $order_details['shipping_address']['pincode']; ?> </h6>
</div>
<div>
<h5>Seller Details</h5>
<span>Name  : <?php echo $seller_data['seller_name']; ?></span><br>
<span>City   &nbsp;&nbsp;&nbsp;  : <?php echo $seller_data['state_name']; ?></span>, 
<span>State : <?php echo $seller_data['city_name']; ?></span>
</div>

</div>

<!--<div class="download-invoice">
<h6>More Action</h6>
<a href="javascript:void(0);"><svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 17.5L14.2929 18.2071L15 18.9142L15.7071 18.2071L15 17.5ZM16 6.25C16 5.69772 15.5523 5.25 15 5.25C14.4477 5.25 14 5.69772 14 6.25L16 6.25ZM8.04289 11.9571L14.2929 18.2071L15.7071 16.7929L9.45711 10.5429L8.04289 11.9571ZM15.7071 18.2071L21.9571 11.9571L20.5429 10.5429L14.2929 16.7929L15.7071 18.2071ZM16 17.5L16 6.25L14 6.25L14 17.5L16 17.5Z" fill="" class="fill" /><path d="M6.25 20L6.25 21.25C6.25 22.6307 7.36929 23.75 8.75 23.75L21.25 23.75C22.6307 23.75 23.75 22.6307 23.75 21.25V20" stroke="" stroke-width="2" class="stroke" /></svg> Download Invoice
</a>

</div>-->

<?php if($order_details['product_details'][0]['tracking_id'] != '' && $order_details['product_details'][0]['pickup_type'] == 2) { ?>
<div class="col-md-12"><br>
<strong>Tracking ID: </strong><br>
<p><?php echo $order_details['product_details'][0]['tracking_id']; ?></p>
<strong>Tracking Url: </strong><br> 
<a style="color:green;" target="_blank" href="<?php echo $order_details['product_details'][0]['tracking_id']; ?>"><span style="word-wrap: break-word;"><?php echo $order_details['product_details'][0]['tracking_id']; ?></span></a>
</div>
<?php } else if($order_details['product_details'][0]['tracking_id'] != '' && $order_details['product_details'][0]['pickup_type'] == 1) { ?>
<div class="row"><br>
<div class="col-md-12"><br>
<strong>Tracking ID: </strong><br>
<p><?php echo $order_details['product_details'][0]['tracking_id']; ?></p>
<strong>Tracking Url: </strong><br> 
<a style="color:green;" target="_blank" href="<?php echo $order_details['product_details'][0]['tracking_url']; ?>"><span style="word-wrap: break-word;"><?php echo $order_details['product_details'][0]['tracking_url']; ?></span></a>
</div>
</div>
<?php } ?>

<?php if($order_details['product_details'][0]['status'] == 'Delivered') { ?>
<?php if($order_review == 0) { ?>
<a href="#" class="btn btn-radious mt-5" data-bs-toggle="modal" data-bs-target="#reviewsModal" style="background-color: #ff6600; color:white">Add Reviews</a>
<?php } ?>
<a class="btn btn-dark mt-5 text-light btn-radious" onclick="return_order('<?php echo $order_details['product_details'][0]['prod_id']; ?>','<?php echo $order_details['order_summery']['order_id']; ?>')">Return Order</a>
<a class="btn btn-radious mt-5" style="background-color: #ff6600; color:white" onclick="generate_invoice('<?php echo $order_details['product_details'][0]['prod_id']; ?>','<?php echo $order_details['order_summery']['order_id']; ?>')">Generate Invoice</a>

<?php } else if($order_details['product_details'][0]['status'] != 'Cancelled' && $order_details['product_details'][0]['status'] != 'Return Request' && $order_details['product_details'][0]['status'] != 'Return Completed' && $order_details['product_details'][0]['status'] != 'Return Rejected') { ?>
<a class="btn btn-success mt-5 text-light btn-radious" onclick="cancel_order('<?php echo $order_details['product_details'][0]['prod_id']; ?>','<?php echo $order_details['order_summery']['order_id']; ?>')">Cancel Order</a>
<?php } ?>
<?php if($order_return_track->seller_reason != '') { ?>
<h6 class="mt-5">Return Order Details</h6>
<p><?php echo $order_return_track->seller_reason;  ?></p>
<?php } ?>
</div>
<div class="col-md-6">
<h6>Order Summary</h6>
<div class="right-block box-shadow">
<ul class="px-0">
<label for="" class="text-dark fw-bolder">Ordered Products</label>
<?php foreach ($order_details['order_summery']['ordered_products'] as $ordered_product) : ?>
<li>
<a class="dropdown-item" href="<?= base_url('orderDetails/' . $order_details['order_summery']['order_id'] . '/' . $ordered_product['prod_id']) ?>">
<div class="card search-card">
<div class="d-flex ">
<div class="d-flex-center search-card_image" style="background-image: url(<?= base_url('media/' . $ordered_product['prod_img']) ?>); width: 60px; height: 60px;margin: 10px 0px; background-position: center; background-repeat: no-repeat; background-size: cover; border-radius: 0.5rem; overflow: hidden;"></div>
<div class="w-100">
<div class="card-body py-2 h-100 d-flex flex-column justify-content-evenly">
<div class="w-100 d-flex justify-content-between">
<h6 class="card-title mt-0" style="white-space: normal;"><?= $ordered_product['prod_name'] ?></h6>
</div>
<div class="d-flex">
<p class="card-text m-0"><small class="text-dark">₹ <?= $ordered_product['prod_price'] ?></small></p>
<p class="card-text mb-0 ms-3"><small class="text-muted text-decoration-line-through">₹ <?= $ordered_product['prod_price'] + $ordered_product['discount'] ?></small></p>
</div>
<p class="card-text m-0"><small class="text-muted">Qty: <?= $ordered_product['qty'] ?></small></p>
</div>
</div>
</div>
</div>
</a>
</li>
<?php endforeach; ?>
</ul>

<?php
$cartValue=0;
$discount=0;
$bhCustomer=0;
$couponDiscount=0;
$tax=0;
$deliveryCharges=0;
$deliveryCharges=0;
$bonus_virtual_price=0;
$totalAmount=0;
if(!empty($order_details['order_summery']['globalJson'])){
$globalJson=json_decode($order_details['order_summery']['globalJson'])->Information;

$cartValue= str_replace(['₹', ' '], '', $globalJson->total_mrp);
$discount=str_replace(['₹', ' '], '', $globalJson->total_discount);
$bhCustomer=str_replace(['₹', ' '], '', $globalJson->default_discount);
$coupon_code=$globalJson->coupon_code;
$couponDiscount=str_replace(['₹', ' '], '', $globalJson->coupon_discount);
$tax=str_replace(['₹', ' '], '', $globalJson->tax_payable);
$deliveryCharges=str_replace(['₹', ' '], '', $globalJson->shipping_fee);
$bonus_virtual=$globalJson->bonus_virtual;
$bonus_virtual_price=str_replace(['₹', ' '], '', $globalJson->bonus_virtual_price);
$totalAmount=str_replace(['₹', ' '], '', $globalJson->payable_amount);
}
?>

<?php
if(!empty($order_details['order_summery']['globalJson'])){
?>

<div class="price-details">

<ul class="price pt-0">
	<li><h6>Cart Value (<?php echo $order_details['order_summery']['total_qty']; ?> items)</h6></li>
	<li><h6>₹ <?php echo $cartValue; ?></h6></li>
</ul>
<?php if($discount > 0){ ?>
<ul class="discount">
<li><h6>Discount</h6></li>
<li><h6>- ₹ <?php echo $discount; ?></h6></li>
</ul>
<?php } ?>
<?php if($bhCustomer > 0){ ?>
<ul class="discount">
<li><h6>BH Customer Discount</h6></li>
<li><h6>- ₹ <?php echo $bhCustomer; ?></h6></li>
</ul>
<?php } ?>
<?php if($couponDiscount > 0){ ?>
<ul class="discount">
<li><h6>Coupon Discount(<?php echo $coupon_code; ?>)</h6></li>
<li><h6>- ₹ <?php echo $couponDiscount; ?></h6></li>
</ul>
<?php } ?>
<?php if($tax > 0){ ?>
<ul class="price pt-0">
<li><h6>Total GST(Included)</h6></li>
<li><h6>₹ <?php echo $tax; ?></h6></li>
</ul>
<?php } ?>
<?php if($deliveryCharges > 0){ ?>
<ul class="price pt-0">
<li><h6>Delivery Charges</h6></li>
<li><h6>₹ <?php echo $deliveryCharges; ?></h6></li>
</ul>
<?php } ?>
<?php if($bonus_virtual_price > 0){ ?>
<ul class="discount">
<li><h6>
<?php
if($bonus_virtual == 1){
echo 'New User Bonus';
}elseif($bonus_virtual == 2){
echo 'Virtual Partner/Order Commission';
}
?>
</h6></li>
<li><h6>- ₹ <?php echo $bonus_virtual_price; ?></h6></li>
</ul>
<?php } ?>



</div>

<ul class="total">
<li>
<h5>Total Amount</h5>
</li>
<li>
<h5><?php echo $totalAmount; ?></h5>
</li>
</ul>






<?php
}else{
?>
<div class="price-details">
<ul class="price pt-0">
<li>
<h6>Cart Value (<?php echo $order_details['order_summery']['total_qty']; ?> items)</h6>
</li>
<li>
<h6><?php echo $order_details['order_summery']['total_mrp']; ?></h6>
</li>
</ul>
<ul class="discount">
<li>
<h6>Discount</h6>
</li>
<li>
<h6>-<?php echo $order_details['order_summery']['discount']; ?></h6>
</li>
</ul>
<ul class="discount">
<li>
<h6>Total GST(Included)</h6>
</li>
<li>
<h6><?php echo $order_details['product_details'][0]['total_gst']; ?></h6>
</li>
</ul>
<?php if($order_details['order_summery']['default_discount'] != '') { ?>
<ul class="discount">
<li>
<h6>BH Customer Discount</h6>
</li>
<li>
<h6>-<?php echo $order_details['order_summery']['default_discount']; ?></h6>
</li>
</ul>
<?php } ?> 
<?php if($order_details['order_summery']['coupon_value'] != 0) { ?>
<ul class="discount">
<li><h6>Coupon Discount</h6></li>
<li><h6>-<?php echo $order_details['order_summery']['coupon_value']; ?></h6></li>
</ul>
<?php } ?>
</div>
<ul class="total">
<li>
<h5>Total Amount</h5>
</li>
<li>
<h5><?php echo ($order_details['order_summery']['total_price']); ?></h5>
</li>
</ul>
<?php
}
?>





</div>

</div>
</div>

</div>
</div>

<div class="col-lg-3">
<div class="right-block p-0">
<h5 class="mb-4 mx-5">You may like</h5>
<div class="trending-section mt-0">
<!--Block-->
<?php foreach ($offers_product as $new_product_data) {

$ratingHTML = '';
if ($new_product_data['product_total_rating'] > 0) {
$rating = round(($new_product_data['product_total_rating'] * 2) / 2,1);
$wholeNumber = floor($rating);
$fractionalPart = $rating - $wholeNumber;
for ($i = 0; $i < $wholeNumber; $i++) {
$ratingHTML .= '<i class="fa-solid fa-star fa-lg" style="color: #162b75;"></i>';
}
if ($fractionalPart >= 0.5) {
$emptyStars = 5 - $wholeNumber - 1;
$ratingHTML .= '<i class="fa-solid fa-star-half-stroke fa-lg" style="color: #162b75;"></i>';
} else {
$emptyStars = 5 - $wholeNumber;
}

for ($i = 0; $i < $emptyStars; $i++) {
$ratingHTML .= '<i class="fa-solid fa-star fa-lg"></i>';
}

}



?>

<div class="p-3 mx-5" >
<?php if ($new_product_data['stock_status'] == 'Out of Stock' || $new_product_data['stock'] <= 0) { ?>
<img class="outof_stock" alt="<?php echo website_name; ?>" src="<?php echo weburl . '/assets/img/out_of_stock.png'; ?>">
<?php } ?>
<a onclick="redirect_to_link('<?php echo base_url .'product/'. $new_product_data['sku']; ?>')" class="card h-100 d-flex flex-column justify-content-between" id="product_link_card">
<div>
<div class="d-flex justify-content-between align-items-center">
<span class="ribbon3"><span class="text-white"><?php echo $new_product_data['offpercent']; ?></span></span>
<span class="d-flex justify-content-between align-items-right whishlist_all" onclick="add_to_wishlist(event,'<?php echo $new_product_data['id'] ?>','<?php echo $new_product_data['sku'] ?>','<?php echo $new_product_data['vendor_id'] ?>','<?php echo $this->session->userdata('user_id'); ?>',1,'',2)"><i class="fa-regular fa-heart" <?php if($new_product_data['product_wishlist'] == 0) { ?>style="color: #162b75;" <?php } ?>></i></span>
</div>



<div class="image-container mt-3 me-5 zoom-img">
<img src="<?php echo $new_product_data['imgurl']; ?>" alt="<?php echo $new_product_data['name']; ?>" class="rounded zoom-img thumbnail-image">
</div>
<div class="product-detail-container p-2 mb-3">
<div class="justify-content-between align-items-center">
<p class="dress-name fs-5 mb-0 fs-5"><?php echo $new_product_data['name']; ?></p>	
<div class="d-flex justify-content-start flex-row mt-2" style="width: 100%;">
<span class="new-price mx-1" style="color: #ff6600;"><?php echo $new_product_data['price']; ?></span>
<small class="old-price text-right mx-1" style="color: #ff6600;"><?php echo $new_product_data['mrp']; ?></small>
</div>
</div>
<div class="d-flex justify-content-between align-items-center pt-1">
<div>
<?php echo $ratingHTML; ?>
</div>
<button class="text-center card_buy_btn btn-radious" type="button" onclick="add_to_cart_product(event,'<?php echo $new_product_data['id'] ?>','<?php echo $new_product_data['sku'] ?>','<?php echo $new_product_data['vendor_id'] ?>','<?php echo $this->session->userdata('user_id'); ?>',1,'',2,'<?php echo $this->session->userdata('qoute_id'); ?>')">Add To Cart</button>
</div>
</div>
</div>
</a>
</div>


<?php } ?>

<!--/*Block-->
</div>
</div>
</div>

</div>
</div>
</section>
<!--End: Track Order Section -->
<!-- Slider Add Reviews Modal -->
<div class="modal fade" id="reviewsModal" tabindex="-1" aria-labelledby="reviewsModal" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
<div class="modal-content">
<div class="row">
<div class="col-9">
<div class="display-6">
<h3 class="mt-4 ms-4">Share Your Experience</h3>
</div>
</div>
<div class="col-3">
<div class="modal-header border-0 pb-0">
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
</div>
</div>
<div class="modal-body submit-comment product-details-page1" style="margin-top: -10px;">
<!--Start: Submit Comment Section -->
<section>
<div class="container" style="max-width:1344px;">
<div class="row">
<div class="col-xl-12 p-0">
<div class="become-seller p-0">
<form id="review_form" class="form row g-3">
<div class="col-md-12">
<label class="form-label">Rate this product</label>
</div>
<div class="col-md-12">
<label class="form-label">Title </label>
<input type="text" class="form-control" name="reviewtitle" id="reviewtitle" placeholder="Title" />
</div>
<div class="col-md-12">
<label class="form-label">Comment</label>
<textarea class="form-control" name="ProductReview" id="ProductReview" rows="5" placeholder="Comments here..."></textarea>
</div>

<div class="col-md-12 mt-0">
<br>
<div id="half-stars-example">
<div class="rating-group">
<input class="rating-input rating-input-none" checked name="rating1" id="rating2-0" value="0" type="radio">
<label aria-label="0.5 stars" class="rating-label rating-label-half" for="rating2-05"><i class="rating-icon rating-icon-star fa fa-star-half"></i></label>
<input class="rating-input" name="rating1" id="rating2-05" value="0.5" type="radio">
<label aria-label="1 star" class="rating-label" for="rating2-10"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
<input class="rating-input" name="rating1" id="rating2-10" value="1" type="radio">
<label aria-label="1.5 stars" class="rating-label rating-label-half" for="rating2-15"><i class="rating-icon rating-icon-star fa fa-star-half"></i></label>
<input class="rating-input" name="rating1" id="rating2-15" value="1.5" type="radio">
<label aria-label="2 stars" class="rating-label" for="rating2-20"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
<input class="rating-input" name="rating1" id="rating2-20" value="2" type="radio">
<label aria-label="2.5 stars" class="rating-label rating-label-half" for="rating2-25"><i class="rating-icon rating-icon-star fa fa-star-half"></i></label>
<input class="rating-input" name="rating1" id="rating2-25" value="2.5" type="radio">
<label aria-label="3 stars" class="rating-label" for="rating2-30"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
<input class="rating-input" name="rating1" id="rating2-30" value="3" type="radio">
<label aria-label="3.5 stars" class="rating-label rating-label-half" for="rating2-35"><i class="rating-icon rating-icon-star fa fa-star-half"></i></label>
<input class="rating-input" name="rating1" id="rating2-35" value="3.5" type="radio">
<label aria-label="4 stars" class="rating-label" for="rating2-40"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
<input class="rating-input" name="rating1" id="rating2-40" value="4" type="radio">
<label aria-label="4.5 stars" class="rating-label rating-label-half" for="rating2-45"><i class="rating-icon rating-icon-star fa fa-star-half"></i></label>
<input class="rating-input" name="rating1" id="rating2-45" value="4.5" type="radio">
<label aria-label="5 stars" class="rating-label" for="rating2-50"><i class="rating-icon rating-icon-star fa fa-star"></i></label>
<input class="rating-input" name="rating1" id="rating2-50" value="5" type="radio">
</div>
</div>
</div>
<button class="btn btn-radious" type="submit" style="background-color: #ff6600; color:white">Add Review</button>
</form>
</div>
</div>
</div>
</div>
</section>
<!--End: Submit Comment Section -->
</div>
</div>
</div>
</div>
<!--/*Slider Add Reviews Modal -->
</main>

<?php
include("include/footer.php")
?>

<?php
include("include/script.php")
?>
<script>
var csrfName = $('.txt_csrfname').attr('name');
var csrfHash = $('.txt_csrfname').val();
var site_url = $('.site_url').val();

function generate_invoice(prod_id, ordersno) {
/*location.href = site_url +'admin/generate_invoice.php?orderid=' + ordersno + '&product_id=' + prod_id;*/

$.ajax({
method: "post",
url: site_url + "generate_invoice",
data: {
language: default_language,
orderid: ordersno,
product_id: prod_id,
[csrfName]: csrfHash,
},
success: function (response) {

window.open(response, '_blank');

},
});


}


$("#review_form").submit(function (event) {
event.preventDefault();

var ProductReview = $("#ProductReview").val();
var reviewtitle = $("#reviewtitle").val();
var pid = $("#pid").val();
var user_id = $("#user_id").val();
var rating = $("input[name='rating1']:checked").val();
if (rating == undefined || rating == 0) {
//alert('dddd'+rating);
$("#error_msg").html('Please Select Rating Stars.');

Swal.fire({
position: "center",
//icon: "success",
title: "Please Select Rating Stars.",
showConfirmButton: false,
confirmButtonColor: "#f42525",
timer: 3000,
});
}
else {
$.ajax({
method: "post",
url: site_url + "addProductReview",
data: {
language: default_language,
pid: pid,
user_id: user_id,
review_title: reviewtitle,
review_comment: ProductReview,
review_rating: rating,
[csrfName]: csrfHash,
},
success: function (response) {

$("#error_msg").html(response.msg);
//hideloader();
//alert(response.msg);
//location.reload();
Swal.fire({
position: "center",
//icon: "success",
title: response.msg,
showConfirmButton: false,
confirmButtonColor: "#f42525",
timer: 3000,
});
setTimeout(function () {
location.reload();
}, 2000);
},
});
}
});


function cancel_order(pid,order_id) {

Swal.fire({
position: "center",
title: 'Are you sure you want to cancel this order?',
showConfirmButton: true,
showCancelButton: true,
confirmButtonText: 'Confirm',
cancelButtonText: 'Cancel',
confirmButtonColor: '#f42525'
}).then((result) => {
if (result.isConfirmed) {
$.ajax({
method: 'post',
url: site_url+'cancelOrder',
data: {language : 1 , pid : pid , order_id: order_id , [csrfName]: csrfHash},
success: function(response){

location.reload();
}
});

}
})

}
function return_order(pid,order_id) {

Swal.fire({
position: "center",
title: 'Are you sure want to return this product?',
showConfirmButton: true,
showCancelButton: true,
confirmButtonText: 'Confirm',
cancelButtonText: 'Cancel',
confirmButtonColor: '#f42525'
}).then((result) => {
if (result.isConfirmed) {
$.ajax({
method: 'post',
url: site_url+'returnOrder',
data: {language : 1 , pid : pid , order_id: order_id , [csrfName]: csrfHash},
success: function(response){

location.reload();
}
});

}
})

}
</script>

</body>

</html>