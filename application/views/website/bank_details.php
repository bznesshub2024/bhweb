<!DOCTYPE html>
<html lang="en">

<head>
    <?php $title = "Bank Details";
    include("include/headTag.php") ?>

    <style>
        .form_div_ruler {
            margin: 1rem 0;
            color: black;
            border: 0;
            border-top: 1px solid #b0b0b0;
            opacity: 1;
        }
    </style>

</head>

<body>

    <?php
    include("include/topbar.php")
    ?>
    <?php
    include("include/navbar.php")
    ?>

    <main class="personal-info new-address my-order-page cart-page">
        <section>
            <div class="container" style="max-width:1344px;">
                <div class="row">
                    <?php
                    include("include/sidebar.php");
                    ?>
                    <div class="col-lg-8">
                        <div class="left-block box-shadow px-0" id="MyProfile">
                            <h5 class="title px-5">Bank Details <span class="d-lg-none"><a class="accordion-button collapsed" id="heading1" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">My Profile</a></span></h5>

                            <div class="px-5">
                                <?php
                                include("include/mobile_sidebar.php");
								
								$this->db->select('*');
								$this->db->where(array('user_id' => $this->session->userdata("user_id")));
								$query_bank = $this->db->get('bank_details');
								
								$get_data = $query_bank->result_object()[0];
								
                                ?>
                            </div>

                            <form class="mt-5" action="add_bank_details"  method="POST">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                <div class="form-group my-4 px-5">
                                    <label>Account Holder ame</label>
                                    <input type="text" name="ac_name" class="form-control my-1" value="<?php echo $get_data->ac_name; ?>">
                                </div>
								<div class="form-group my-4 px-5">
                                    <label>Account Number</label>
                                    <input type="password" name="ac_number" id="ac_number" class="form-control my-1" value="<?php echo $get_data->ac_number; ?>">
                                </div>
                                <div class="form-group my-4 px-5">
                                    <label>Confirm Account Number</label>
                                    <input type="text" name="conifrm_ac_number" id="conifrm_ac_number" value="<?php echo $get_data->ac_number; ?>"  class="form-control my-1">
									<span id="msg_data" style="color:red;"></span>
                                </div>
                                <div class="form-group my-4 px-5">
                                    <label>IFSC Code</label>
                                    <input type="text" name="ifsc_code" class="form-control my-1" value="<?php echo $get_data->ifsc_code; ?>">
                                </div>
                               
                                <div class="row ms-5">
                                    <hr class="form_div_ruler col-5">
                                    <span class="col-1 pt-1 text-cenet">OR</span>
                                    <hr class="form_div_ruler col-5">
                                </div>

                                <div class="form-group my-4 px-5">
                                    <label>Enter UPI Code</label>
                                    <img src="<?php base_url ?>assets_web/images/svgs/gpay.svg" style="height:20px">
                                    <img src="<?php base_url ?>assets_web/images/svgs/applepay.svg" style="height:20px">
                                    <input type="text" name="upi_id" class="form-control my-1" value="<?php echo $get_data->upi_id; ?>">
                                </div>

                                <div class="form-group d-flex-center">
                                    <button class="btn btn-primary btn-lg w-95" id="save" type="submit">Save</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>



    </main>

    <?php
    include("include/footer.php")
    ?>

    <?php
    include("include/script.php")
    ?>
	<script>
	var timeout = null;
	var ac_number = document.getElementById('ac_number');
	var conifrm_ac_number = document.getElementById('conifrm_ac_number');
	
	conifrm_ac_number.addEventListener('input', () => {
		check_password();
	});
	
	const check_password = () => {

			if(conifrm_ac_number.value != ac_number.value)
			{
				$('#msg_data').html('Password and Confirm password Not match.');
				$('#save').prop('disabled', true);
			}
			else
			{
				$('#msg_data').html('');
				$('#save').prop('disabled', false);

			}
	};
	
	</script>

</body>

</html>