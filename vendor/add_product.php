<?php
include('session.php');

if (!isset($_SESSION['admin'])) {
	header("Location: index.php");
}

?>

<?php include("header.php");

$no_of_products = 0;
$stmt_user = $conn->prepare("SELECT no_of_products FROM `sellerlogin` WHERE seller_unique_id= '" . $_SESSION['admin'] . "'");
$stmt_user->execute();
$data8 = $stmt_user->bind_result($no_of_products);
while ($stmt_user->fetch()) {
	$no_of_products = $no_of_products;
	
}

$total_product = 0;

$query_total = $conn->query("SELECT pd.product_unique_id FROM product_details pd,brand , vendor_product vp WHERE vp.product_id =pd.product_unique_id AND vp.vendor_id = '" . $_SESSION['admin'] . "'  AND brand.brand_id  = pd.brand_id ");
$total_product = $query_total->num_rows;


 ?>

<style>
	.bank-statement-panel {
		border: 1px solid #ced4da;
		border-radius: 5px;
		color: rgba(0, 0, 0, 1);
		margin-bottom: 0px !important;
	}

	.bank-statement-panel h6 {
		padding: 8px;
	}

	table {
		border-collapse: collapse;
		width: 100%;
	}

	.bank-statement-panel td {
		font-size: 14px;
	}

	.bank-statement-panel tr td:nth-child(2) {
		text-align: right;
	}

	td {
		border: noen;
		padding: 8px;
		text-align: left;
	}

	.toggle-btn {
		background-color: #fff;
		border: none;
		color: #fff;
		cursor: pointer;
		font-size: 16px;
		padding: 10px;
		position: relative;
		transition: background-color 0.2s ease-in-out;
	}

	.toggle-btn:hover {
		background-color: #fff;
	}

	.fa-info {
		color: #ccc;
		font-size: 10px;
		border: 1px solid #ccc;
		border-radius: 50%;
		padding: 2px 5px;
	}

	.info-icon {
		background-color: rgba(255, 255, 255, 0.8);
		border-radius: 50%;
		color: #000000;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		font-size: 12px;
		height: 20px;
		position: absolute;
		right: 10px;
		top: 50%;
		transform: translateY(-50%);
		width: 20px;
		cursor: pointer;
		position: relative;
	}

	.hover-card {
		background-color: #000;
		border: 1px solid #000;
		border-radius: 5px;
		color: #fff;
		display: none;
		font-size: 12px;
		padding: 10px;
		position: absolute;
		bottom: calc(100% + 10px);
		left: 50%;
		transform: translateX(-50%);
		width: 200px;
		z-index: 1;
	}

	.dotted-border {
		border-top: 1px dashed #333;
	}

	.arrow {
		position: absolute;
		bottom: -10px;
		left: calc(50% - 10px);
		width: 0;
		height: 0;
		border-left: 10px solid transparent;
		border-right: 10px solid transparent;
		border-top: 10px solid #000;
	}


	.info-icon:hover .hover-card {
		display: block;
	}

	#total-bank-settlement {
		font-size: 12px;
		font-weight: 600;
	}

	#customer-price-breakdown {
		border-radius: 0.5em;
		margin-bottom: 5px;
	}

	#customer-price-breakdown .panel-body {
		padding: 8px;
		margin-bottom: 0px;
	}

	.fa-arrow-right {
		transition: transform 0.3s ease-in-out;
	}

	#image-viewer {
		max-height: 100px;
	}

	#rendered-image {
		display: block;
		max-width: 100%;
		max-height: 100px;
		box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
		border-radius: 4px;
	}
	#myUL , .subList {
		list-style-type: none;
	}
	.mainList
	{
		font-weight : 400;
	}
</style>


<!-- main content start-->
<div class="content-page">
	<!-- Start content -->
	<div class="content">
		<div class="container-fluid">

			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box">
						<h4 class="page-title">Add Product</h4>
					</div>
				</div>
			</div>
			<!-- end page title -->
			


			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<?php 
								if($total_product >= $no_of_products) :
									
									echo '<h4 class="ml-3"><b>Add Product Limit is Over</b></h4>';
								
								else :
									include('product_all_data.php');
								endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="clearfix"> </div>

	</div>





	<div class="clearfix"> </div>

</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Configurations</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body p-2">
				<form class="form-horizontal" id="myform_attr">
					<div class="form-group mb-0">
						<div class="col-sm-12">
							<div class="attributes">
								<table class="table table-sm table-borderless mb-0">
									<tbody id="selectattrs_div"></tbody>
								</table>
								<br>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-dark" id="manage_configurations_btn" onclick=" return manage_configurations();">Add Configurations</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="col_1">


	<div class="clearfix"> </div>

</div>

<?php include("footernew.php"); ?>
<script src="<?php echo BASEURL; ?>assets/tinymce/tinymce.min.js"></script>
<script src="js/admin/add-product.js"></script>
<script>
	var timeout = null;

	var seller_price = document.getElementById('seller_price');
	var marurang_price = document.getElementById('marurang_price');
	var commision_fee = document.getElementById('commision_fee');
	var totalTax = document.getElementById('total-tax');
	var gst = document.getElementById('gst');
	var tcs = document.getElementById('tcs');
	var tds = document.getElementById('tds');
	var totalBankSettlement = document.getElementById('total-bank-settlement');
	var selecttaxclass = document.getElementById('selecttaxclass');

	const toggleBtn = document.querySelector('.toggle-btn');
	const toggleTableBtn = document.getElementById('toggle-table');
	const priceBreakdowns = document.querySelectorAll('.price-table-breakdown');
	const icon = document.querySelector(".fa-arrow-right");

	const infoBtns = document.querySelectorAll('.info-btn');

	seller_price.addEventListener('input', () => {
		calculatePrice();
	});

	selecttaxclass.addEventListener('change', () => {
		if (seller_price.value !== '')
			calculatePrice();
	});

	const calculatePrice = () => {
		clearTimeout(timeout);

		timeout = setTimeout(function() {
			$.ajax({
				method: "post",
				url: "get_price_calculation.php",
				data: {
					seller_price: seller_price.value
				},
			}).done(function(response) {
				$('#prod_price').val(response);
				var taxValue = document.getElementById('selecttaxclass').options[document.getElementById('selecttaxclass').selectedIndex].text.match(/\d+/)[0];

				if (seller_price.value === '') {
					marurang_price.innerText = "";
					commision_fee.innerText = "";
				} else {
					marurang_price.innerText = "₹" + String(seller_price.value);
					var commision_fee_value = parseInt(response) - parseInt(seller_price.value);
					var taxableValue = parseInt(response) * (100 / (100 + parseInt(taxValue)));
					var gstValue = (parseInt(response) - parseInt(seller_price.value)) * 0.18;
					var tcsAndTcsVal = parseInt(taxableValue) * 0.01;
					commision_fee.innerText = "₹" + String(0);
					totalTax.innerText = "-₹" + String((gstValue + 2 * tcsAndTcsVal).toFixed(2));
					gst.innerText = "-₹" + String(gstValue.toFixed(2));
					tcs.innerText = "-₹" + String(tcsAndTcsVal.toFixed(2));
					tds.innerText = "-₹" + String(tcsAndTcsVal.toFixed(2));
					totalBankSettlement.innerText = "₹" + String((seller_price.value - (gstValue + 2 * tcsAndTcsVal)).toFixed(2))
				}


			});


		}, 500);
	}

	infoBtns.forEach(infoBtn => {
		const infoTooltip = document.createElement('div');
		infoTooltip.classList.add('info-tooltip');
		infoTooltip.textContent = infoBtn.dataset.info;
		infoBtn.parentElement.appendChild(infoTooltip);
	});

	toggleTableBtn.addEventListener('click', () => {
		console.log(priceBreakdowns);
		for (let index = 0; index < priceBreakdowns.length; index++) {
			const element = priceBreakdowns[index];
			if (element.style.display === 'none') {
				element.style.display = '';
				icon.style.transform = "rotate(90deg)";
				totalTax.style.display = 'none';
			} else {
				element.style.display = 'none';
				icon.style.transform = "rotate(-0deg)";
				totalTax.style.display = '';
			}
		}
	});

	const reader = new FileReader();

	document.addEventListener("change", function(e) {
		if (e.target.tagName.toLowerCase() === 'input' && e.target.type === 'file') {
			var file = event.target.files[0];
			var parent = e.target.parentElement;
			var imgViewer = parent.querySelector('#image-viewer');

			reader.onload = function(event) {
				imgViewer.style.cssText = "margin-top: 10px;"
				imgViewer.innerHTML = `<img id="rendered-image" src="${event.target.result}" style="margin-right:20px;">`;
			};

			reader.readAsDataURL(file);
		}

	})
	
	function expand(list, view) {
    var listElement = document.getElementById('ul' + list);
    var defaultView = '[+]';

    if (view.innerHTML == defaultView) {
        listElement.style.display = "block";
        view.innerHTML = '[-]';
    } else {
        listElement.style.display = "none";
        view.innerHTML = '[+]';
    }
}
	
</script>