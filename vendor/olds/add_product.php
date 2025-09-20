<?php
include('session.php');

if (!isset($_SESSION['admin'])) {
	header("Location: index.php");
}

?>
<?php include("header.php"); ?>
<style>
	.bank-statement-panel {
		border: 2px solid rgba(62, 62, 62, 0.6);
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
</style>
<script src="<?php echo BASEURL; ?>assets/tinymce/tinymce.min.js"></script>
<script src="js/admin/add-product.js"></script>

<!-- main content start-->
<div id="page-wrapper">
	<div class="main-page">

		<div>

			<div class="bs-example widget-shadow" data-example-id="hoverable-table">
				<h4 style="padding: 15px; height: 4px">
					<button type="submit" onclick="back_page('manage_product.php')" id="back_btn" class="btn  btn-default" style="margin-right:10px; margin-top:-4px;"><i class="fa fa-arrow-left"></i> Back</button>

					<span><b>Add New Product :</b></span>
				</h4>

				<div class="form-three widget-shadow">
					<form class="form-horizontal" id="myform" action="add_product_process.php" method="post" enctype="multipart/form-data">
						<input type="hidden" name="code" value="<?php echo $code_ajax; ?>" />
						<input type="hidden" name="select_cat_id" id="select_cat_id" />
						<a> ** required field</a>

						<div class="form-group">
							<label class="col-sm-2 control-label">Attribute Set** </label>
							<div class="col-sm-8">
								<select class="form-control1" id="selectattrset" name="selectattrset">
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Category Set** </label>
							<div id="example1" class="col-sm-8">
								<input type="text" id="myInput" class="form-control1" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">

								<div id="treeSelect">
									<ul id="myUL">
										<?php

										$query = $conn->query("SELECT * FROM category WHERE parent_id = '0'  AND status ='1' ORDER BY cat_name ASC");

										if ($query->num_rows > 0) {
											while ($row = $query->fetch_assoc()) {
												//echo "SELECT cat_id FROM category WHERE parent_id = '".$row['cat_id']."' ";
												$query1 = $conn->query("SELECT cat_id FROM category WHERE parent_id = '" . $row['cat_id'] . "'  AND status ='1'");
												//	print_r($query1);
												if ($query1->num_rows > 0) {
													echo '<li><span class="expand" onClick=\'expand("' . $row['cat_id'] . '",this)\'>[-]</span><label class="mainList">' . $row['cat_name'] . '</label></li>
																			 
																			<ul id="ul' . $row['cat_id'] . '" class="subList" style="display:block;">';
													echo categoryTree($row['cat_id'], $sub_mark . "&nbsp;&nbsp;&nbsp;");
													echo	'</ul>';
												} else {
													echo '<li><span class="expand"><input type="checkbox" name="category[]" value="' . $row['cat_id'] . '" class="check_category_limit" onclick="check_category_limit(this,' . $row['cat_id'] . ');"></span><label class="mainList"> ' . $row['cat_name'] . '</label></li>
																			';
												}
											}
										}

										function categoryTree($parent_id, $sub_mark = '')
										{
											global $conn;
											$query = $conn->query("SELECT * FROM category WHERE parent_id = $parent_id  AND status ='1' ORDER BY cat_name ASC");

											if ($query->num_rows > 0) {
												while ($row = $query->fetch_assoc()) {

													$query1 = $conn->query("SELECT cat_id FROM category WHERE parent_id = '" . $row['cat_id'] . "'  AND status ='1'");
													//	print_r($query1);
													if ($query1->num_rows > 0) {
														echo '<li><span class="expand" onClick=\'expand("' . $row['cat_id'] . '",this)\'>[-]</span><label class="mainList">' . $row['cat_name'] . '</label></li>
																			 
																			<ul id="ul' . $row['cat_id'] . '" class="subList" style="display:block;">';
														echo categoryTree($row['cat_id'], $sub_mark . "&nbsp;&nbsp;&nbsp;");
														echo '</ul>';
													} else {
														echo '<li><input type="checkbox" name="category[]" value="' . $row['cat_id'] . '" class="check_category_limit" onclick="check_category_limit(this,' . $row['cat_id'] . ');"> <label class="mainList"> ' . $row['cat_name'] . '</label></li>';
													}
												}
											}
										}





										?>
									</ul>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="focusedinput" class="col-sm-2 control-label">Product Name **</label>
							<div class="col-sm-8">
								<input type="text" class="form-control1" id="prod_name" name="prod_name" placeholder="Name" required>
							</div>
						</div>
						<!--<div class="form-group">
        									<label for="focusedinput" class="col-sm-2 control-label">Product Arabic Name **</label>
        									<div class="col-sm-8">
        										<input type="text" class="form-control1" id="prod_name_ar"  name="prod_name_ar" placeholder="Name" required>
        									</div>
        								</div>-->
						<div class="form-group">
							<label for="focusedinput" class="col-sm-2 control-label">SKU</label>
							<div class="col-sm-8">
								<input type="text" class="form-control1" id="prod_sku" name="prod_sku" placeholder="SKU auto generate">
							</div>
						</div>
						<div class="form-group">
							<label for="focusedinput" class="col-sm-2 control-label">URL key</label>
							<div class="col-sm-8">
								<input type="text" class="form-control1" id="prod_url" name="prod_url" placeholder="URL auto generate">
							</div>
						</div>
						<div class="form-group">
							<label for="focusedinput" class="col-sm-2 control-label">Product Short details **</label>
							<div class="col-sm-8">
								<textarea rows="6" cols="65" id="prod_short" name="prod_short" required placeholder="Miximum 300 letters"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="focusedinput" class="col-sm-2 control-label">Product Full Details **</label>
							<div class="col-sm-8">
								<textarea rows="6" cols="65" id="editor" name="prod_details" required placeholder="Miximum 1000 letters"></textarea>
							</div>
						</div>
						<!--<div class="form-group">
        									<label for="focusedinput" class="col-sm-2 control-label">Product Short details Arabic **</label>
        									<div class="col-sm-8">
        										<textarea rows="6" cols="65" id="prod_short_ar" name="prod_short_ar"  placeholder="Short description 300 letter" required maxlength="50"></textarea> 
        									</div>
        								</div>
        								<div class="form-group">
        									<label for="focusedinput" class="col-sm-2 control-label">Product Full Details Arabic **</label>
        									<div class="col-sm-8">
        									  <textarea rows="6" cols="65" id="editor_ar" name="prod_details_ar" required placeholder="Miximum 1000 letters"></textarea> 
        									</div>
        								</div>-->
						<div class="form-group">
							<label class="col-sm-2 control-label">TAX Class </label>
							<div class="col-sm-8">
								<select class="form-control1" id="selecttaxclass" name="selecttaxclass">

								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="focusedinput" class="col-sm-2 control-label">MRP</label>
							<div class="col-sm-8">
								<input type="number" class="form-control1" id="prod_mrp" name="prod_mrp" maxlength="7" placeholder="MRP ex. 214">
							</div>
						</div>
						<div class="form-group">
							<label for="focusedinput" class="col-sm-2 control-label">Marurang Price **</label>
							<div class="col-sm-8">
								<input type="number" class="form-control1" id="seller_price" name="seller_price" maxlength="7" placeholder="Sale Price ex. 208" value="" required>
							</div>
						</div>
						<div class="form-group">
							<label for="focusedinput" class="col-sm-2 control-label">Sale Price **</label>
							<div class="col-sm-8">
								<input type="number" class="form-control1" id="prod_price" readonly name="prod_price" maxlength="7" placeholder="" required>
							</div>
						</div>
						<div class="form-group">
							<label for="focusedinput" class="col-sm-2 control-label"></label>
							<div class="col-sm-8">
								<div class="panel panel-default bank-statement-panel">
									<div class="panel-body">
										<h6><strong>Bank Settlement Breakdown</strong></h6>
										<table style="border: none;">
											<tbody>
												<tr>
													<td>Marurang Price</td>
													<td id="marurang_price"></td>
												</tr>
												<tr>
													<td>Commision fee</td>
													<td id="commision_fee"></td>
												</tr>
												<tr>
													<td id="toggle-table" style="cursor: pointer;">
														Tax (GST, TCS, TDS)
														<i class="fa fa-arrow-right" aria-hidden="true"></i>
													</td>
													<td id="total-tax"></td>
												</tr>
												<tr class="price-table-breakdown" style="display: none;">
													<td>
														GST
														<a class="toggle-btn">
															<span class="info-icon">
																<i class="fa fa-info" aria-hidden="true"></i>
																<span class="hover-card">
																	<span class="arrow"></span>
																	This is the breakdown of the prices.
																</span>
															</span>
														</a>
													</td>
													<td id="gst"></td>
												</tr>
												<tr class="price-table-breakdown" style="display: none;">
													<td>
														TCS
														<a class="toggle-btn">
															<span class="info-icon">
																<i class="fa fa-info" aria-hidden="true"></i>
																<span class="hover-card">
																	<span class="arrow"></span>
																	This is the breakdown of the prices.
																</span>
															</span>
														</a>
													</td>
													<td id="tcs"></td>
												</tr>
												<tr class="price-table-breakdown" style="display: none;">
													<td>
														TDS
														<a class="toggle-btn">
															<span class="info-icon">
																<i class="fa fa-info" aria-hidden="true"></i>
																<span class="hover-card">
																	<span class="arrow"></span>
																	This is the breakdown of the prices.
																</span>
															</span>
														</a>
													</td>
													<td id="tds"></td>
												</tr>
											</tbody>
										</table>
										<div class="dotted-border"></div>
										<table style="border: none;">
											<tbody>
												<tr>
													<td>Bank Settlement Amount</td>
													<td id="total-bank-settlement"></td>
												</tr>
											</tbody>
										</table>
										<!-- <div class="panel panel-default" id="customer-price-breakdown">
											<div class="panel-body row" style="display: flex; align-items: center; height: 100%">
												<div class="col-md-4" style="background-image:url(https://www.marurang.in//media/2023-03-11/rajasthani-lehanga-12013345519-430-590.jpeg); height: 120px; width:90px; background-position: center; background-repeat: no-repeat; background-size: cover; border-radius: 0.5rem;">
												</div>
												<div class="col-md-8">
													<p class="text-muted" style="font-size: 12px;">Marurang Price ₹8999</p>
													<p class="text-muted" style="font-size: 12px;">Shipping (added separately) ₹136</p>
													<h5>₹9135</h5>
												</div>
											</div>
										</div> -->
										<div class="text-muted" style="font-size: 10px;">
											Bank settlement amount may vary slightly based on the quantity in the order, Meesho commission policy at the time of the order and the actual weight of the product as calculated by our third party delivery partner.
											<br>
											Customer price on app may vary based on the shipping address and the actual weight of the product as calculated by our third party delivery partner.
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-group"> <label class="col-sm-2 control-label">Coupon Code </label>
							<div class="col-sm-8"> <select class="form-control1" id="coupon_code" name="coupon_code">
									<option value="">Select Coupon</option> <?php $query = $conn->query("SELECT * FROM coupancode_vendor WHERE  activate ='active' ORDER BY sno ASC");
																			if ($query->num_rows > 0) {
																				while ($row = $query->fetch_assoc()) {																														?> <option value="<?php echo $row['sno']; ?>"><?php echo $row['name']; ?></option> <?php }
																																																																															}																											?>
								</select> </div>
						</div>
						<div class="form-group">
							<label for="focusedinput" class="col-sm-2 control-label">Quantity</label>
							<div class="col-sm-8">
								<input type="number" class="form-control1" id="prod_qty" name="prod_qty" placeholder="stock quantity">
								<br><br>
								<!--<button type="submit" return false;" class="btn btn-sm btn-warning"  style="float:left; display: inline-block; margin-right:20px;" >Advanced Inventory</button>-->

							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Stock Status</label>
							<div class="col-sm-8">

								<select class="form-control1" id="selectstock" name="selectstock">
									<option value="In Stock">In Stock</option>
									<option value="Out of Stock">Out of Stock</option>

								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Visibility</label>
							<div class="col-sm-8">

								<select class="form-control1" id="selectvisibility" name="selectvisibility">
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Country of Manufacture </label>
							<div class="col-sm-8">
								<select class="form-control1" id="selectcountry" name="selectcountry">

								</select>
							</div>
						</div>


						<div class="form-group">
							<label for="focusedinput" class="col-sm-2 control-label">HSN Code </label>
							<div class="col-sm-8">
								<select class="form-control1" id="prod_hsn" name="prod_hsn">
								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="focusedinput" class="col-sm-2 control-label">Weight(GM) </label>
							<div class="col-sm-8">
								<input type="text" class="form-control1" id="prod_weight" name="prod_weight" placeholder="Product Weight">
							</div>
						</div>

						<div class="form-group">
							<label for="focusedinput" class="col-sm-2 control-label">Product Purchase Limit for Customer</label>

							<div class="col-sm-8">
								<input type="number" class="form-control1" id="prod_purchase_lmt" name="prod_purchase_lmt" maxlength="3">

							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Select Brand **</label>
							<div class="col-sm-8">
								<select class="form-control1" id="selectbrand" name="selectbrand">
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Select Return Policy</label>
							<div class="col-sm-8">
								<select class="form-control1" id="return_policy" name="return_policy">
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Heavy Product</label>
							<div class="col-sm-8">
								<input type="checkbox" id="is_heavy" value='1' name="is_heavy">
							</div>
						</div>
						<div class="form-group">
							<label for="focusedinput" class="col-sm-2 control-label">Configurations </label>
							<div class="col-sm-8">
								<button type="button" onclick="check_product();" class="btn btn-hover btn-primary btn-primary">Create Configuration</button>
								<br><br>

								<a>Configurable products allow customers to choose options (Ex: shirt color). You need to create a simple product for each configuration (Ex: a product for each color).</a>

							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-10" style="background-color: #dad9d9;">
								<div id="skip_pric" style="display:none;"><input type="checkbox" name="skip_sale_price" id="skip_sale_price" value="1"><span>Apply single price to all SKUs</span></div>
								<div id="configurations_div_html">

								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="focusedinput" class="col-sm-2 control-label">Remarks</label>
							<div class="col-sm-8">
								<input type="text" class="form-control1" id="prod_remark" name="prod_remark" placeholder="200 sold in 3 hours">
							</div>
						</div>

						<div class="form-group">


							<label for="exampleInputFile" class="col-sm-2 control-label">Featured Images **</label>

							<div class="col-sm-8">
								<div class="">
									<div>
										<input type="file" name="featured_img" id="featured_img" onchange="uploadFile1('featured_img')" class="form-control1" required>
									</div>

								</div>
							</div>
							<br><br><br>
							<label for="exampleInputFile" class="col-sm-2 control-label">Product Images</label>
							<div class="col-sm-8 input-files">
								<a class="fa fa-plus fa-4 btn btn-primary" aria-hidden="true" id="moreImg">Add More Image</a>
							</div>
						</div>

						<div class="form-group">
							<label for="focusedinput" class="col-sm-2 control-label">Upload Video</label>
							<div class="col-sm-8">
								<input type="file" name="prod_youtubeid" id="prod_youtubeid" class="form-control1">
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Related Product multi select</label>
							<div id="example2" class="col-sm-8">
								<select class="form-control1 related_prod" id="selectrelatedprod" name="selectrelatedprod[]" multiple>
								</select>

								<a>Related products are shown to customers in addition to the item the customer is looking at.</a>
								<br>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Up-Sell Products</label>
							<div id="example1" class="col-sm-8">
								<select class="form-control1 related_prod" id="selectupsell" name="selectupsell[]" multiple>
								</select>

								<a>An up-sell item is offered to the customer as a pricier or higher-quality alternative to the product the customer is looking at.</a>
								<br>
							</div>
						</div>


						</br></br>
						<div class="col-sm-offset-2">
							<button type="submit" class="btn btn-success" href="javascript:void(0)" id="addProduct_btn">Save</button>
						</div>


					</form>
				</div>

			</div>
		</div>


		<div class="clearfix"> </div>

	</div>





	<div class="clearfix"> </div>

</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width:100%;">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Configurations</h4>
			</div>
			<div class="modal-body">
				<div class="col-sm-8" id="add_more_attr_btndiv">
					<a class="fa fa-plus fa-4 btn btn-primary" aria-hidden="true" onclick="add_more_attrs();">Add More Attributes</a>
				</div><br><br>
				<form class="form-horizontal" id="myform_attr">
					<div class="form-group" id="selectattrs_div">
						<label for="focusedinput" class="col-sm-2 control-label">Select Attributes</label>
						<div class="col-sm-9">
							<div class="input-files">
								<div style="vertical-align: middle; margin-top:5px;">
									<select class="form-control1" id="selectattrs" name="selectattrs[]" onchange="select_attr_val('selectattrs');" required style="float:left; display: inline-block; margin-right:20px;width:150px;">
									</select>
									<div id="cselectattrs"></div>
								</div><br>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" id="manage_configurations_btn" onclick=" return manage_configurations();">Add Configurations</button>
			</div>
		</div>

	</div>
</div>

<div class="col_1">


	<div class="clearfix"> </div>

</div>

</div>
</div>
</div>
<?php include("footernew.php"); ?>
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
</script>