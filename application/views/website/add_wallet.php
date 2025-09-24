<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "User Wallet";
    include("include/headTag.php") ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets_web/style/css/shipping-price-calculator.css') ?>">

    <style>
        .money_cards {
            width: 30px;
            height: 30px;
        } 

        .rounded-pill {
            width: 130px;
            margin-bottom: 10px;
        }

        .rounded-pill:nth-child(odd) {
            margin-right: 2px;
        }

        .add_money_box {
            height: 68%;
        }
		
		.no_trans_img{
			height: 400px;
			border-radius: 20px;
			padding: 10px;
		}
		
		#left_box {
            width: 47%;
        }

        .transaction_history {
            width: 49%;
        }

        @media (min-width: 700px) and (max-width: 964px) {
            #left_box {
                width: 47%;
            }

            .transaction_history {
                width: 48%;
            }
        }

        @media (min-width: 576px) and (max-width: 699px) {
            #left_box {
                width: 46%;
            }

            .transaction_history {
                width: 48%;
            }
        }

        @media (min-width: 200px) and (max-width: 580px) {
            #left_box {
                width: 96%;
            }

            .transaction_history {
                width: 96%;
            }
        }
		.display_data
		{
			color : red;
			font-size : 10px;
		}
		.unwithdraw_amount
		{
			color : #000;
			font-size : 14px;
		}
    </style>

</head>

<body>
    <?php include("include/loader.php") ?>
    <?php include("include/topbar.php") ?>
    <?php include("include/navbar.php") ?>
	<?php if($this->session->userdata("user_name") == '') { redirect('', 'refresh'); } ?>
	
	<?php
	$total_bonus = 0;
	foreach($wallet_bonus as $wallet_bonus)
	{
		
		if($wallet_bonus->payment_type == '1')
		{
			$total_bonus = $total_bonus + $wallet_bonus->amount;
		}
	}
	$unwithdraw_amount = '';
	if($total_bonus != 0)
	{
		$amount = $wallet['amount'] - $total_bonus;
		$unwithdraw_amount = " (".$total_bonus." New User Bonus + ".round($amount,2)." Virtual Partner/Order Commission)";
	}
	else
	{
		$amount = $wallet['amount'];
	}
	?>
	
	<input type="hidden" id="bank_details" value="<?php echo $bank_details['id']; ?>" >
    <main>
        <section class="px-0 px-md-4 mb-5">
            <div class="row">
                <div class="box-shadow-4 mt-3 rounded mx-2" id="left_box">
                    <div class="balance_box my-3 col-sm-12">
                        <div class="card box-shadow-4">
                            <div class="card-body">
                                <h4 class="card-title">Wallet Balance

<a class="btn btn-primary btn-xm rounded text-white" style="float:right" href="<?php echo base_url ?>user-wallet"><i class="bx bx-wallet me-2"></i>Withdrawal Money</a>

                                </h4>
                                <h3 class="card-title mb-2 fw-bolder">Rs <?php echo round($wallet['amount'],0); ?></h3>
								<b><span class="unwithdraw_amount"><?php echo $unwithdraw_amount; ?></span></b>
                               <input type="hidden" id="wallet_balance" value="<?php echo round($wallet['amount'],0); ?>" >
                               <input type="hidden" id="bonus_wallet_balance" value="<?php echo round($total_bonus,0); ?>" >
                                <p class="card-text">
									Use your Wallet amount to purchase the products and avail awesome discounts and offers.
								</p>
                            </div>
                        </div>
                    </div>

                    <div class="add_money_box my-4 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Add Money to your Wallet</h4>
                                <form id="formoid" action="" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                    <div class="form-group">
                                        <label>Enter Amount</label>
                                        <input class="form-control" placeholder="Rs 500" name="amount" id="moneyinputBox" required>
										<span class="mb-2" id="amount_error" style="color:red;"></span><br>
                                        <small class="form-text text-muted">You can Withdrawal any amount of your choice</small>
                                    </div>
                                    <div class="d-flex flex-wrap">
                                        <div class="">
                                            <button class="btn border rounded-pill" type="button" onclick="addMoneyToWalletField('500')">
                                                <span class="fw-bolder" id="500">Rs 500</span>
                                            </button>
                                        </div>
                                        <div class="">
                                            <button class="btn border rounded-pill" type="button" onclick="addMoneyToWalletField('1000')">
                                                <span class="fw-bolder" id="1000">Rs 1000</span>
                                            </button>
                                        </div>
                                        <div class="">
                                            <button class="btn border rounded-pill" type="button" onclick="addMoneyToWalletField('2000')">
                                                <span class="fw-bolder" id="2000">Rs 2000</span>
                                            </button>
                                        </div>
                                        <div class="">
                                            <button class="btn border rounded-pill" type="button" onclick="addMoneyToWalletField('5000')">
                                                <span class="fw-bolder" id="5000">Rs 5000</span>
                                            </button>
                                        </div>
                                    </div>
                                    <button class="btn btn-success btn-lg rounded w-100 my-5 text-white" name="submit" type="submit"><i class="bx bx-wallet me-2"></i> Add Money</button>
                                    <span class="text-success"><?= $this->session->flashdata("withdrow_success_msg");  ?></span>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="transaction_history mt-6 rounded box-shadow-4 mx-2">
                    <div class="card h-91" id="">
					<?php if(count($wallet_summery) > 0) { ?>
                        <div class="card-body px-3 py-0">
                            <h4 class="card-title p-2">Previous Transactions</h4>
                            <?php foreach ($wallet_summery as $wallet_summery_data) {
                                if ($wallet_summery_data->transaction_type == 'credit') {
                                    $transaction_type = '+';
                                    $transaction_class = 'text-success';
                                    $transaction_img = '5';
                                } else {
                                    $transaction_type = '-';
                                    $transaction_class = 'text-danger';
                                    $transaction_img = '6';
                                }
								$display_data = '';
								if($wallet_summery_data->payment_type == '1')
								{
									$display_data = " (can't Withdraw)";
								}

                            ?>

                                <div class="row d-flex">
                                    <div class="col-2">
                                        <img src="<?php echo base_url; ?>assets_web/images/<?= $transaction_img ?>.png" class="money_cards">
                                    </div>
                                    <div class="col-8 p-0">
                                        <span class="fw-bolder"><?php echo $wallet_summery_data->remark; ?></span>
                                        <p class="text-muted"><?php echo date('d M Y h:i A', strtotime($wallet_summery_data->created_at)); ?><span class="display_data"><?php echo $display_data; ?></span>
<br/>
<span>
Transaction ID : <?php echo $wallet_summery_data->transaction_id; ?>
</span>
                                     </p>       
                                    </div>
                                    <div class="col-2 p-0 justify-content-end">
                                        <span class="fw-bolder <?php echo $transaction_class; ?>"><?php echo $transaction_type . ' Rs ' . round($wallet_summery_data->amount); ?></span>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
					<?php } else { ?>
						<img src="<?= base_url ?>assets_web/images/no_transaction.png" class="no_trans_img">
						<h5 class="text-center">No Transactions Found<h5>
					<?php } ?>
                    </div>
					<?php if(count($wallet_summery) > 0) { ?>
						<div class="d-flex justify-content-end mx-3 my-2">
							<a href="<?php echo base_url ?>user-wallet-transactions" class="nav-link" style="color:#ff6600;">See all <i class="fa-solid fa-arrow-right" style="color: #ff6600;"></i></a>
						</div>
					<?php } ?>
                </div>
            </div>
        </section>
    </main>


    <?php include("include/footer.php") ?>
    <?php include("include/script.php") ?>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
		function addMoneyToWalletField(amount) {
            let sel = document.getElementById('moneyinputBox');
            let curr_val = sel.value
            if (curr_val == "") {
                sel.value = amount;
            } else{
				// console.log(curr_val)
                let t_money = parseInt(curr_val) + parseInt(amount);
                sel.value = t_money;
            }
        }


var csrfName = $(".txt_csrfname").attr("name"); // CSRF token name
var csrfHash = $(".txt_csrfname").val();        // CSRF hash

$("#formoid").submit(function (event) {
    event.preventDefault(); // stop normal form submission
    $("#amount_error").empty();

    var amount = $("#moneyinputBox").val();
    var wallet_balance = $("#wallet_balance").val();
    var bank_details = $("#bank_details").val();
    var bonus_wallet_balance = $("#bonus_wallet_balance").val();
    var refer_bonus = 0;

    // ✅ Validation
    if (amount == "" || amount == null) {
        $("#amount_error").text("Please Add Amount.");
        return;
    } else if (amount == 0) {
        $("#amount_error").text("Amount Cannot Be 0");
        return;
    }

    // ✅ Create Razorpay Order (via CodeIgniter Controller)
    $.ajax({
        url: "<?php echo base_url('add_wallet_create'); ?>",
        type: "POST",
        data: {
            amount: amount,
            [csrfName]: csrfHash // send CSRF
        },
        dataType: "json",
        success: function (order) {
            // update CSRF token for next request
var csrfName = $(".txt_csrfname").attr("name"); // CSRF token name
var csrfHash = $(".txt_csrfname").val();        // CSRF hash

            var options = {
                //"key": "rzp_test_qYpWkw3GxxEIPA", 
                "key": "rzp_live_oVzpJnJRDQttrF",
                "amount": amount * 100, // Amount in paise
                "currency": "INR",
                "name": "Bznesshub",
                "description": "Wallet Topup",
                "order_id": order.id, // Razorpay order_id from backend
                "handler": function (response) {
                    console.log(response);

                    // ✅ Verify Payment
                     $.ajax({
                        url: "<?php echo base_url('add_wallet_verify'); ?>",
                        type: "POST",
                        data: {
                            razorpay_payment_id: response.razorpay_payment_id,
                            //razorpay_order_id: response.razorpay_order_id,
                            //razorpay_signature: response.razorpay_signature,
                            //full_razorpay_response: JSON.stringify(response),
                            amount: amount,
                            [csrfName]: csrfHash
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data.status === "success") {
                                alert("Successful Add Money to your Wallet!");
                            } else {
                                alert("Failed!");
                            }
                            location.reload();

                            // refresh CSRF token
                            $(".txt_csrfname").val(data.csrfHash);
                        },
                        error: function(xhr, status, error) {
                            console.error("Verify Error:", error);
                        }
                    });
                },
                "prefill": {
                    "name": "<?php echo $this->session->userdata('user_name') ?>",
                    "email": "<?php echo $this->session->userdata('user_email') ?>",
                    "contact": "<?php echo $this->session->userdata('user_phone') ?>",
                },
                "theme": {
                    "color": "#3399cc"
                }
            };

            var rzp1 = new Razorpay(options);
            rzp1.open();
        },
        error: function (xhr, status, error) {
            console.error("Order creation failed:", error);
        }
    });
});

</script>

	



</body>

</html>