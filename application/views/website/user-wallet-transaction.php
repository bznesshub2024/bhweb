<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "User Wallet";
    include("include/headTag.php") ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets_web/style/css/shipping-price-calculator.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <style>
        .money_cards {
            width: 40px;
            height: 40px;
        }

        .fix_month_height {
            overflow-x: auto;
            white-space: nowrap;
            overflow: unset;
        }

        .fix_month_height::-webkit-scrollbar-track {
            background-color: #f1f1f1;
            border-radius: 5px;
        }

        .fix_month_height::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 5px;
        }

        .fix_month_height::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }

        .search-container {
            display: flex;
            align-items: center;
            padding: 3px;
            width: 100%;
            background-color: #f5f5f6;
            border-radius: 3px;
            border: 0.5px solid #cdcdcd;
        }

        .search-input {
            flex: 1;
            outline: none;
            padding: 5px;
            background-color: #f5f5f6;
            border: none;
        }

        .search-icon {
            fill: #888;
            width: 16px;
            height: 16px;
            margin-right: 5px;
        }

        .month {
            background-color: #ffb481;
            position: sticky;
            top: 0;
        }

        .data-div {
            margin-bottom: 20px;
        }
		
		.transac_remarks{
			white-space: normal;
		}
    </style>

    <style>
        button:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            outline-width: 0;
        }

        .datepicker {
            background-color: #fff;
            border: none;
            border-radius: 0 !important;
        }

        .datepicker-dropdown {
            top: 0;
            left: 0;
        }

        .datepicker table tr td.today,
        span.focused {
            border-radius: 50% !important;
            background-image: linear-gradient(#FFF3E0, #FFE0B2);
        }

        .datepicker table tr td.today.range {
            background-image: linear-gradient(#ff6600, #ff6600) !important;
            border-radius: 0 !important;
        }
		
		.display_data
		{
			color : red;
			font-size : 10px;
		}

        /*Weekday title*/
        thead tr:nth-child(3) th {
            font-weight: bold !important;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .dow,
        .old-day,
        .day,
        .new-day {
            width: 40px !important;
            height: 40px !important;
            border-radius: 0px !important;
        }

        .old-day:hover,
        .day:hover,
        .new-day:hover,
        .month:hover,
        .year:hover,
        .decade:hover,
        .century:hover {
            border-radius: 50% !important;
            background-color: #eee;
        }

        .active {
            border-radius: 50% !important;
            background-image: linear-gradient(#90CAF9, #64B5F6) !important;
            color: #fff !important;
        }

        .range-start,
        .range-end {
            border-radius: 50% !important;
            background-image: linear-gradient(#ff6600, #ff6601) !important;
        }

        .prev,
        .next,
        .datepicker-switch {
            border-radius: 0 !important;
            padding: 10px 10px 10px 10px !important;
            text-transform: uppercase;
            font-size: 14px;
            opacity: 0.8;
        }

        .prev:hover,
        .next:hover,
        .datepicker-switch:hover {
            background-color: inherit !important;
            opacity: 1;
        }

        .btn-black {
            background-color: #37474F !important;
            color: #fff !important;
            width: 100%;
        }

        .btn-black:hover {
            color: #fff !important;
            background-color: #000 !important;
        }
		.back_arrow {
			position: fixed;
			background: #fff8f3;
			width: 100%;
			padding-left: 0 !important;
			margin-top: -44px;
			height: 30px;
			margin-left: 15px;
			z-index: 9;
			padding-top: 5px;
		}
    </style>

</head>

<body>
    <?php include("include/loader.php") ?>
    <?php include("include/topbar.php") ?>
    <?php include("include/navbar.php") ?>
	<?php if($this->session->userdata("user_name") == '') { redirect('', 'refresh'); }  ?>

    <main>
        <section class="px-sm-0 px-md-4">
			<div class="back_arrow">
				<a href="javascript:history.go(-1)"><i class="fa-solid fa-arrow-left mb-5 5x" style="font-size:18px" style="color: #ff6600;"></i> Back</a>
			</div>
            <div class="col-sm-12 col-md-12 mt-7">
                <div class="mt-11 px-2">
					
                    <div class="row mx-1 mt-0">
						
						

                        <div class="col-md-7 col-sm-12 px-1">
                            <div class="searc-container mb-5 d-flex">
                                <input type="text" class="search-input w-100" name="title" id="title" placeholder="Search" style="border:none;">
                                <!-- <i class="fa-solid fa-magnifying-glass search-icon"></i> -->
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12 px-1">
                            <div class="">
                                <form id="search_data" method="post" autocomplete="off">
                                    <div class="flex-sm-row flex-column d-flex">
										<div class="row w-100 mx-0">
											<div class="col-sm-12 col-md-8 col-lg-8 px-0">
												<div class="input-group input-daterange">
													<input type="text" class="form-control search-input" id="start_date" placeholder="Start Date" readonly>&nbsp;&nbsp;
													<input type="text" class="form-control search-input" id="end_date" placeholder="End Date" readonly>&nbsp;&nbsp;
												</div>
											</div>
											<div class="col-sm-12 col-md-4 col-lg-4 px-0">
												<button class="btn btn-default btn-radious w-100 py-1 mt-2 mt-md-0 mt-sm-2" onclick="search_data()" id="name" name="submit">Search</button>
											</div>
										</div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="main_container mt-3 border">
                        <div class="container my-2 data-div">
                            <div class="fix_month_height" id="history_data">
                                <?php foreach ($wallet_summery as $wallet_summery_data) {
									
									$display_data = '';
										if($wallet_summery_data->payment_type == '1')
										{
											$display_data = " (can't Withdraw)";
										}
									
                                    if ($wallet_summery_data->transaction_type == 'credit') {
										
                                ?>
                                        <div class="row">
                                            <div class="col-2">
                                                <img src="<?php echo base_url; ?>assets_web/images/5.png" class="money_cards">
                                            </div>
                                            <div class="col-6 p-0">
                                                <span class="fw-bolder transac_remarks"><?php echo $wallet_summery_data->remark; ?></span>
                                                <p class="text-muted"><?php echo date('d M Y h:i A', strtotime($wallet_summery_data->created_at)); ?><span class="display_data"><?php echo $display_data; ?></span>

<br/>
<span>
Transaction ID : <?php echo $wallet_summery_data->transaction_id; ?>
</span>
                                                </p>
                                            </div>
                                            <div class="col-3 p-0 text-end">
                                                <span class="fw-bolder text-success">+ Rs <?php echo $transaction_type . ' ' . $wallet_summery_data->amount; ?></span>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="row">
                                            <div class="col-2">
                                                <img src="<?php echo base_url; ?>assets_web/images/6.png" class="money_cards">
                                            </div>
                                            <div class="col-6 p-0">
                                                <span class="fw-bolder transac_remarks"><?php echo $wallet_summery_data->remark; ?></span>
                                                <p class="text-muted"><?php echo date('d M Y h:i A', strtotime($wallet_summery_data->created_at)); ?><span class="display_data"><?php echo $display_data; ?><span></p>
                                            </div>
                                            <div class="col-3 p-0 text-end">
                                                <span class="fw-bolder text-danger">- Rs <?php echo $transaction_type . ' ' . $wallet_summery_data->amount; ?></span>
                                            </div>
                                        </div>
                                <?php }
                                } ?>
                                <div class="row" style="display:none">
                                    <div class="col-2">
                                        <img src="<?php echo base_url; ?>assets_web/images/5.png" class="money_cards">
                                    </div>
                                    <div class="col-6 p-0">
                                        <span class="fw-bolder transac_remarks"><?php echo $wallet_summery_data->remark; ?>dwd</span>
                                        <p class="text-muted"><?php echo date('d M Y h:i A', strtotime($wallet_summery_data->created_at)); ?></p>
                                    </div>
                                    <div class="col-3 p-0 text-end">
                                        <span class="fw-bolder text-success">+ Rs 34<?php echo $transaction_type . ' ' . $wallet_summery_data->amount; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>


    <?php include("include/script.php") ?>
    <script>
        var csrfName = $(".txt_csrfname").attr("name");
        var csrfHash = $(".txt_csrfname").val();
        var site_url = $(".site_url").val();


        function search_data() {
            event.preventDefault();
            var title = $("#title").val();
            var start_date = $("#start_date").val();
            var end_date = $("#end_date").val();


            $.ajax({
                method: "post",
                url: site_url + "search_wallet_data",
                data: {
                    language: default_language,
                    title: title,
                    start_date: start_date,
                    end_date: end_date,
                    [csrfName]: csrfHash,
                },
                success: function(response) {
                    //hideloader();
                    var parsedJSON = JSON.parse(response);
                    var product_html = "";


                    $(parsedJSON).each(function() {
						var display_data = '';
						if(this.payment_type == '1')
						{
							display_data += " (can't Withdraw)";
						}
                        if (this.transaction_type == 'credit') {
                            product_html += `<div class="row">
                                        <div class="col-2">
                                            <img src="${site_url}assets_web/images/credited.png" class="money_cards">
                                        </div>
                                        <div class="col-6 p-0">
                                            <span class="fw-bolder">${this.remark}</span>
                                            <p class="text-muted">${this.created_at}<span class="display_data">${display_data}</span></p>
                                        </div>
                                        <div class="col-3 p-0 text-end">
                                            <span class="fw-bolder text-success">+ Rs ${this.amount}</span>
                                        </div>
                                    </div>`;
                        } else {
                            product_html += `<div class="row">
                                        <div class="col-2">
                                            <img src="${site_url}assets_web/images/debited1.png" class="money_cards">
                                        </div>
                                        <div class="col-6 p-0">
                                            <span class="fw-bolder">${this.remark}</span>
                                            <p class="text-muted">${this.created_at}<span class="display_data">${display_data}</span></p>
                                        </div>
                                        <div class="col-3 p-0 text-end">
                                            <span class="fw-bolder text-danger">- Rs ${this.amount}</span>
                                        </div>
                                    </div>`;
                        }
                        product_html += ``;

                    });
                    $("#history_data").html(product_html);
                },
            });
        }

        $("#search_data").submit(function(event) {

        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        function addMoneyToWalletField(amount) {
            document.getElementById('moneyinputBox').value = "Rs " + amount
        }

        // $(function() {
        //     $("#datepicker").datepicker({
        //         autoclose: true,
        //         todayHighlight: true,
        //     }).datepicker('update', new Date());
        // });

        $(document).ready(function() {

            $('.input-daterange').datepicker({
                format: 'dd-mm-yyyy',
                todayHighlight: true,
            });

        });

        setTimeout(() => {
            document.querySelector('.datepicker').style.cssText = "top: 210.188px;left: 12px;z-index: 10;display: block;"
        }, 500);

        window.addEventListener('load', function() {
            var datepicker = document.querySelector('.datepicker');
            datepicker.style.top = "210px";
        });
    </script>

</body>

</html>