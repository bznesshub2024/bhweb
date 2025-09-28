<!DOCTYPE html>
<html lang="en">

<head>
	<?php $title = "Upgrade Plan";
	include("include/headTag.php") ?>
</head>
<style>
	#progressbar
	{
		padding-left : 0;
	}
	.spinner-border {
		height: 19px;
		width: 19px;
		margin-right: 4px;
	}
	 table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px 0;
            display : inline-table;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
</style> 
<body>

	<?php
	include("include/topbar.php")
	?>
	<?php
	include("include/navbar.php")
	?>

	<main class="become-seller-page">

		<!--Start: Become a Seller Section -->
		<section class="become-seller box-shadow">
			<div class="container">

				<?php if (!empty($this->session->flashdata("seller_form_msg"))) : ?>
					<div class="alert alert-success alert-dismissible fade show text-start" role="alert">
						<?= $this->session->flashdata("seller_form_msg");  ?>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				<?php endif; ?>
				<div class="row">
					<div class="wrap">
						<h4>Upgrade Plan</h4>
					</div>



<div class="plans">

<?php foreach ($get_plans as $plans_data) { ?>
   	<?php 
if($plans_data['plan_value'] > 0){
	?>
  <div class="plan">
    <input type="radio" name="selectplan" id="selectplan<?php echo $plans_data['plan_id']; ?>" value="<?php echo $plans_data['plan_id']; ?>/<?php echo $plans_data['plan_value']; ?>">
    <label for="selectplan<?php echo $plans_data['plan_id']; ?>">
      <h3><?php echo $plans_data['plan_name']?></h3>
      <p>
      	<?php 
if($plans_data['plan_value'] > 0){
echo' ₹' . $plans_data['plan_value'] ;
}else{
echo 'Free';
}
 ?></p>
      <span><?php echo $plans_data['duration']; ?> Days</span>
    </label>
  </div>
<?php } }?>



</div>

<div class=" ">
<button class="btn btn-outline-primary btn-sm" onclick="update_plan()" style="width:100%">Upgrade Plan</button>
</div>

				</div>


<div class="row">

<div class="container mt-5">
  <div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-primary text-white rounded-top-4">
      <h5 class="mb-0 text-white">Your Current Plan Details</h5>
    </div>
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-md-6">
          <strong>Plan Name:</strong> <?php echo $current_plans->plan_id?>
        </div>
        <div class="col-md-6 ">
          <span class="badge bg-success">Active</span>
        </div>
      </div>
      <div class="row mb-2">
<?php if(!empty($current_plans->plan_duration)){ ?>
<div class="col-md-6">
<strong>Duration:</strong> <?php echo $current_plans->plan_duration; ?> Days
</div>
<?php }?>
<div class="col-md-6 ">
          <strong>Price:</strong> ₹ <?php echo $current_plans->plan_value?>
        </div>
       
      </div>
      <div class="row mb-2">
      	<?php if(!empty($current_plans->plan_start_date)){ ?>  
         <div class="col-md-6 ">
          <strong>Start Date:</strong> <?php echo $current_plans->plan_start_date; ?>
        </div>
           <?php }?>
<?php if(!empty($current_plans->plan_end_date)){ ?>  	
        <div class="col-md-6">
          <strong>End Date:</strong> <?php echo $current_plans->plan_end_date; ?>
        </div>
        <?php }?>

      </div>
    </div>
  
  </div>
</div>
</div>






			</div>
		</section>
		<!--End: Become a Seller Section -->

	</main>

	<?php
	include("include/footer.php")
	?>

	<?php
	include("include/script.php")
	?>
	<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var csrfName = $('.txt_csrfname').attr('name'); // 
var csrfHash = $('.txt_csrfname').val(); // CSRF hash
var site_url = $('.site_url').val(); // CSRF hash

function update_plan() {
let selected = document.querySelector('input[name="selectplan"]:checked');

let plan_id = null;
let amount = null;

if (selected) {
    let planValue = selected.value; // e.g. "1/2"
    let parts = planValue.split('/'); 
    plan_id = parts[0];  // "1"
    amount = parts[1];   // "2"
} else {
    alert("⚠️ No plan selected");
    return;
}

// now plan_id & amount are available here
var form_data = new FormData();
form_data.set('plan_id', plan_id);
form_data.set('amount', amount);

var options = {
key: 'rzp_live_oVzpJnJRDQttrF',//'rzp_test_R6HPHmrG7B2oge',
amount: amount * 100, // Amount in paise
currency: 'INR',
name: 'Bznesshub',
description: 'Place Order',
capture: 1,
prefill: {
name: $("#fullname_a").val(),
email: $("#email").val(),
contact: $("#mobile").val(),
},
handler: function (response) {
if (response.razorpay_payment_id) {
const proxyUrl = site_url + 'Razorpay/capturePayment?payment_id=' + response.razorpay_payment_id + '&amount=' + amount * 100;

fetch(proxyUrl)
.then(response => {
if (!response.ok) {
throw new Error('Network response was not ok');
}
return response.text();
})
.then(data => {
console.log(data); // Output: "Payment Captured" if successful
})
.catch(error => {
console.error('There was a problem with the fetch operation:', error);
});

form_data.set('payment_id', response.razorpay_payment_id);
form_data.append([csrfName], csrfHash);
$.ajax({
method: 'post',
url: site_url + 'planupgrade',
cache: false,
contentType: false,
processData: false,
data: form_data,

success: function(response) {


window.location.reload();

}
});
} else {
	Swal.fire({
	text: 'Payment failed or was canceled.',
	type: "error",
	showCancelButton: true,
	showCloseButton: true,
	confirmButtonColor: theme_colour,
	});
}
},
modal: {
ondismiss: function () {
window.location.reload();
}
}
};

var rzp = new Razorpay(options);
rzp.open();

}

</script>


<style>
 

  .plans {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    justify-content: center;
  }

  .plan {
    flex: 1 1 200px;
    border: 2px solid #ddd;
    border-radius: 8px;
    padding: 5px;
    background: #fff;
    text-align: center;
    cursor: pointer;
    transition: 0.2s;
  }

  .plan:hover {
    border-color: #007bff;
    background: #e9f2ff;
    transform: translateY(-3px);
  }

  .plan input[type="radio"] {
    display: none;
  }

 
  /* highlight selected */
  .plan input[type="radio"]:checked + label {
    border-color: #007bff;
    background: #e9f2ff;
  }

  label {
    display: block;
    cursor: pointer;
  }
</style>
</body>

</html>