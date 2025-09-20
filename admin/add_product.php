<?php
include('session.php');


if (!$Common_Function->user_module_premission($_SESSION, $Product)) {
	echo "<script>location.href='no-premission.php'</script>";
	die();
}

if (!isset($_SESSION['admin'])) {
	header("Location: index.php");
}

?>
<?php include("header.php"); ?>

<style>
	.switch {
		position: relative;
		display: block;
		vertical-align: top;
		width: 66.5px;
		height: 30px;
		padding: 3px;
		margin: 0 10px 10px 0;
		background: linear-gradient(to bottom, #eeeeee, #FFFFFF 25px);
		background-image: -webkit-linear-gradient(top, #eeeeee, #FFFFFF 25px);
		border-radius: 18px;
		box-shadow: inset 0 -1px white, inset 0 1px 1px rgba(0, 0, 0, 0.05);
		cursor: pointer;
		box-sizing: content-box;
	}

	.switch-input {
		position: absolute;
		top: 0;
		left: 0;
		opacity: 0;
		box-sizing: content-box;
	}

	.switch-label {
		position: relative;
		display: block;
		height: inherit;
		font-size: 10px;
		text-transform: uppercase;
		background: #eceeef;
		border-radius: inherit;
		box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.12), inset 0 0 2px rgba(0, 0, 0, 0.15);
		box-sizing: content-box;
	}

	.switch-label:before,
	.switch-label:after {
		position: absolute;
		top: 50%;
		margin-top: -.5em;
		line-height: 1;
		-webkit-transition: inherit;
		-moz-transition: inherit;
		-o-transition: inherit;
		transition: inherit;
		box-sizing: content-box;
	}

	.switch-label:before {
		content: attr(data-off);
		right: 11px;
		color: #aaaaaa;
		text-shadow: 0 1px rgba(255, 255, 255, 0.5);
	}

	.switch-label:after {
		content: attr(data-on);
		left: 11px;
		color: #FFFFFF;
		text-shadow: 0 1px rgba(0, 0, 0, 0.2);
		opacity: 0;
	}

	.switch-input:checked~.switch-label {
		background: #ff7529;
		box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.15), inset 0 0 3px rgba(0, 0, 0, 0.2);
	}

	.switch-input:checked~.switch-label:before {
		opacity: 0;
	}

	.switch-input:checked~.switch-label:after {
		opacity: 1;
	}

	.switch-handle {
		position: absolute;
		top: 4px;
		left: 4px;
		width: 28px;
		height: 28px;
		background: linear-gradient(to bottom, #FFFFFF 40%, #f0f0f0);
		background-image: -webkit-linear-gradient(top, #FFFFFF 40%, #f0f0f0);
		border-radius: 100%;
		box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.2);
	}

	.switch-handle:before {
		content: "";
		position: absolute;
		top: 50%;
		left: 50%;
		margin: -6px 0 0 -6px;
		width: 12px;
		height: 12px;
		background: linear-gradient(to bottom, #eeeeee, #FFFFFF);
		background-image: -webkit-linear-gradient(top, #eeeeee, #FFFFFF);
		border-radius: 6px;
		box-shadow: inset 0 1px rgba(0, 0, 0, 0.02);
	}

	.switch-input:checked~.switch-handle {
		left: 40px;
		box-shadow: -1px 1px 5px rgba(0, 0, 0, 0.2);
	}

	.switch-label,
	.switch-handle {
		transition: All 0.3s ease;
		-webkit-transition: All 0.3s ease;
		-moz-transition: All 0.3s ease;
		-o-transition: All 0.3s ease;
	}

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

	#myUL,
	.subList {
		list-style-type: none;
	}

	.mainList {
		font-weight: 400;
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
							<div class="bs-example widget-shadow" data-example-id="hoverable-table">
								<div class="d-flex align-items-center mb-lg-3">
									<button type="button" onclick="back_page('manage_product.php')" id="back_btn" class="btn btn-danger waves-effect waves-light"><i class="fa fa-arrow-left"></i> Back</button>

									<h4 class="ml-3"><b>Add New Product :</b></h4>
								</div>

								<div class="form-three widget-shadow">
									<form class="form-horizontal" id="myform" action="add_product_process.php" method="post" enctype="multipart/form-data">
										<div class="form-group row align-items-center">
											<input type="hidden" name="code" value="<?php echo $code_ajax; ?>" />
											<a> <span class="text-danger ml-2">&#42;&#42;</span> required field</a>
										</div>
										<div class="form-group row align-items-center">
											<label for="focusedinput" class="col-sm-2 control-label m-0">Enable product</label>
											<div class="col-sm-8">
												<label class="switch">
													<input class="switch-input" type="checkbox" id="togglebtn" name="enableproduct" checked value="1" />
													<span class="switch-label" data-on="On" data-off="Off"></span>
													<span class="switch-handle"></span>
												</label>
											</div>
										</div>

										<div class="form-group row align-items-center">
											<label class="col-sm-2 control-label m-0">Attribute Set <span class="text-danger">&#42;&#42;</span> </label>
											<div class="col-sm-8">
												<select class="form-control" id="selectattrset" name="selectattrset">
												</select>
											</div>
										</div>

										<div class="form-group row align-items-center">
											<label class="col-sm-2 control-label m-0">Category Set <span class="text-danger">&#42;&#42;</span> </label>
											<div id="example1" class="col-sm-8"> 
												<input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">

												<div id="treeSelect">
													<ul id="myUL" class="pt-2">
														<?php

														$query = $conn->query("SELECT * FROM category WHERE parent_id = '0'  AND status ='1' ORDER BY cat_name ASC");

														if ($query->num_rows > 0) {
															while ($row = $query->fetch_assoc()) {
																//echo "SELECT cat_id FROM category WHERE parent_id = '".$row['cat_id']."' ";
																$query1 = $conn->query("SELECT cat_id FROM category WHERE parent_id = '" . $row['cat_id'] . "'  AND status ='1'");
																//	print_r($query1);
																if ($query1->num_rows > 0) {
																	echo '<li><span class="expand" onClick=\'expand("' . $row['cat_id'] . '",this)\'>[-]</span><label style="font-weight:bold" class="mainList ml-1">' . $row['cat_name'] . '</label></li>
																			 
																			<ul id="ul' . $row['cat_id'] . '" class="subList" style="display:block;">';
																	echo categoryTree($row['cat_id'], $sub_mark . "&nbsp;&nbsp;&nbsp;");
																	echo	'</ul>';
																} else {
																	echo '<li><span class="expand"><input type="checkbox" name="category[]" value="' . $row['cat_id'] . '" class="check_category_limit" onclick="check_category_limit(this);"></span><label class="mainList ml-1"> ' . $row['cat_name'] . '</label></li>
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
																		echo '<li><span class="expand" onClick=\'expand("' . $row['cat_id'] . '",this)\'>[-]</span><label style="font-weight:bold" class="mainList">' . $row['cat_name'] . '</label></li>
																			 
																			<ul id="ul' . $row['cat_id'] . '" class="subList" style="display:block;">';
																		echo categoryTree($row['cat_id'], $sub_mark . "&nbsp;&nbsp;&nbsp;");
																		echo '</ul>';
																	} else {
																		echo '<li><input type="checkbox" name="category[]" value="' . $row['cat_id'] . '" class="check_category_limit" onclick="check_category_limit(this);"> <label class="mainList"> ' . $row['cat_name'] . '</label></li>';
																	}
																}
															}
														}

														?>
													</ul>
												</div>
											</div>
										</div>



										<div class="form-group row align-items-center">
											<label for="focusedinput" class="col-sm-2 control-label m-0">Product Name <span class="text-danger">&#42;&#42;</span></label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="prod_name" name="prod_name" placeholder="Name" required>
											</div>
										</div>
										<!--<div class="form-group row align-items-center">
        									<label for="focusedinput" class="col-sm-2 control-label m-0">Product Arabic Name  <span class="text-danger">&#42;&#42;</span></label>
        									<div class="col-sm-8">
        										<input type="text" class="form-control" id="prod_name_ar"  name="prod_name_ar" placeholder="Name" required>
        									</div>
        								</div>-->
										<div class="form-group row align-items-center">
											<label for="focusedinput" class="col-sm-2 control-label m-0">SKU</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="prod_sku" name="prod_sku" placeholder="SKU auto generate">
											</div>
										</div>
										<div class="form-group row align-items-center">
											<label for="focusedinput" class="col-sm-2 control-label m-0">URL key</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="prod_url" name="prod_url" placeholder="URL auto generate">
											</div>
										</div>
										<div class="form-group row align-items-center">
											<label for="focusedinput" class="col-sm-2 control-label m-0">Product Short details <span class="text-danger">&#42;&#42;</span></label>
											<div class="col-sm-8">
												<textarea class="form-control" rows="6" cols="65" id="prod_short" name="prod_short" placeholder="Short description 300 letter" required maxlength="50"></textarea>
											</div>
										</div>
										<div class="form-group row align-items-center">
											<label for="focusedinput" class="col-sm-2 control-label m-0">Product Full Details <span class="text-danger">&#42;&#42;</span></label>
											<div class="col-sm-8">
												<textarea class="form-control" rows="6" cols="65" id="editor" name="prod_details" required placeholder="Miximum 1000 letters"></textarea>
											</div>
										</div>

										<!--<div class="form-group row align-items-center">
        									<label for="focusedinput" class="col-sm-2 control-label m-0">Product Short details Arabic  <span class="text-danger">&#42;&#42;</span></label>
        									<div class="col-sm-8">
        										<textarea rows="6" cols="65" id="prod_short_ar" name="prod_short_ar"  placeholder="Short description 300 letter" required maxlength="50"></textarea> 
        									</div>
        								</div>
        								<div class="form-group row align-items-center">
        									<label for="focusedinput" class="col-sm-2 control-label m-0">Product Full Details Arabic  <span class="text-danger">&#42;&#42;</span></label>
        									<div class="col-sm-8">
        									  <textarea rows="6" cols="65" id="editor_ar" name="prod_details_ar" required placeholder="Miximum 1000 letters"></textarea> 
        									</div>
        								</div>-->
										<div class="form-group row align-items-center">
											<label class="col-sm-2 control-label m-0">TAX Class (<a target="_blank" href="<?php echo MEDIAURL.'services-booklet.pdf';?>">View</a>) </label>
											<div class="col-sm-8">
												<select class="form-control" id="selecttaxclass" name="selecttaxclass">

												</select>
											</div>
										</div>

										<div class="form-group row align-items-center">
											<label for="focusedinput" class="col-sm-2 control-label m-0">MRP</label>
											<div class="col-sm-8">
												<input type="number" class="form-control" id="prod_mrp" name="prod_mrp" maxlength="7" placeholder="MRP ex. 214">
											</div>
										</div>
										<div class="form-group row align-items-center">
											<label for="focusedinput" class="col-sm-2 control-label m-0">Sell Price <span class="text-danger">&#42;&#42;</span></label>
											<div class="col-sm-8">
												<input type="number" class="form-control" id="seller_price" name="seller_price" maxlength="7" placeholder="Sale Price ex. 208" required>
											</div>
										</div>
										<div class="form-group row align-items-center">
											<label for="focusedinput" class="col-sm-2 control-label m-0">Final Price <span class="text-danger">&#42;&#42;</span></label>
											<div class="col-sm-8">
												<input type="number" class="form-control" id="prod_price" readonly name="prod_price" maxlength="7" placeholder="" required>
											</div>
										</div>
										<div class="form-group row align-items-center">
											<label for="focusedinput" class="col-sm-2 control-label m-0"></label>
											<div class="col-sm-8">
												<div class="panel panel-default bank-statement-panel">
													<div class="panel-body">
														<h6><strong>Bank Settlement Breakdown</strong></h6>
														<table style="border: none;">
															<tbody>
																<tr>
																	<td>Product Price</td>
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
														<div class="text-muted px-1 pb-2" style="font-size: 10px;">
															Bank settlement amount may vary slightly based on the quantity in the order, Meesho commission policy at the time of the order and the actual weight of the product as calculated by our third party delivery partner.
															<br>
															Customer price on app may vary based on the shipping address and the actual weight of the product as calculated by our third party delivery partner.
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group row align-items-center">
											<label for="focusedinput" class="col-sm-2 control-label m-0">Quantity</label>
											<div class="col-sm-8">
												<input type="number" class="form-control" id="prod_qty" name="prod_qty" placeholder="stock quantity">
												<!--<button type="submit" return false;" class="btn btn-sm btn-warning"  style="float:left; display: inline-block; margin-right:20px;" >Advanced Inventory</button>-->

											</div>
										</div>
										<div class="form-group row align-items-center">
											<label class="col-sm-2 control-label m-0">Stock Status</label>
											<div class="col-sm-8">

												<select class="form-control" id="selectstock" name="selectstock">
													<option value="In Stock">In Stock</option>
													<option value="Out of Stock">Out of Stock</option>

												</select>
											</div>
										</div>




										<div class="form-group row align-items-center">
											<label for="focusedinput" class="col-sm-2 control-label m-0">HSN Code </label>
											<div class="col-sm-8">
												<select class="form-control" id="prod_hsn" name="prod_hsn">
												</select>
											</div>
										</div>

										<div class="form-group row align-items-center">
											<label for="focusedinput" class="col-sm-2 control-label m-0">Weight(GM) </label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="prod_weight" name="prod_weight" placeholder="Product Weight">
											</div>
										</div>


										<div class="form-group row align-items-center">
											<label for="focusedinput" class="col-sm-2 control-label m-0">Product Purchase Limit for Customer</label>

											<div class="col-sm-8">
												<input type="number" class="form-control" id="prod_purchase_lmt" name="prod_purchase_lmt" maxlength="3">
											</div>
										</div>
										<div class="form-group row align-items-center">
											<label class="col-sm-2 control-label m-0">Select Brand</label>
											<div class="col-sm-8">
												<select class="form-control" id="selectbrand" name="selectbrand">
												</select>
											</div>
										</div>
										<div class="form-group row align-items-center">
											<label class="col-sm-2 control-label m-0">Select Seller <span class="text-danger">&#42;&#42;</span></label>
											<div class="col-sm-8">
												<select class="form-control" id="selectseller" name="selectseller" onchange="get_seller_related_product()">
												</select>
											</div>
										</div>
										<div class="form-group row align-items-center">
											<label class="col-sm-2 control-label m-0">Visibility</label>
											<div class="col-sm-8">

												<select class="form-control" id="selectvisibility" name="selectvisibility">
												</select>
											</div>
										</div>

										<div class="form-group row align-items-center">
											<label class="col-sm-2 control-label m-0">Country of Manufacture </label>
											<div class="col-sm-8">
												<select class="form-control" id="selectcountry" name="selectcountry">

												</select>
											</div>
										</div>
										<div class="form-group row align-items-center">
											<label class="col-sm-2 control-label m-0">Select Return Policy</label>
											<div class="col-sm-8">
												<select class="form-control" id="return_policy" name="return_policy">
												</select>
											</div>
										</div>
										<div class="form-group row align-items-center">
											<label class="col-sm-2 control-label m-0">regarding prize money</label>
											<div class="col-sm-8">
												<input type="checkbox" id="regarding_price" value='1' name="regarding_price">
											</div>
										</div>
										<div class="form-group row">
											<label for="focusedinput" class="col-sm-2 control-label mt-1">Configurations </label>
											<div class="col-sm-8">
												<button type="button" onclick="check_product();" class="btn btn-hover btn-dark waves-effect waves-light">Add Products Details</button>
												<br><br>
												<a>Configurable products allow customers to choose options (Ex: shirt color). You need to create a simple product for each configuration (Ex: a product for each color).</a>

											</div>
										</div>
										<div class="form-group row align-items-center">
											<label for="focusedinput" class="col-sm-2 control-label mt-1"> </label>
											<div class="col-sm-8">
												<div id="skip_pric" style="display:none;">
													<div class="form-check">
														<input class="form-check-input" type="checkbox" name="skip_sale_price" id="skip_sale_price" value="1">
														<label class="form-check-label" for="skip_sale_price">Apply single price to all SKUs</label>
													</div>
												</div>
												<div id="configurations_div_html" class="table-responsive">

												</div>
											</div>
										</div>
										<div class="form-group row align-items-center">
											<label for="focusedinput" class="col-sm-2 control-label m-0">Remarks</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="prod_remark" name="prod_remark" placeholder="200 sold in 3 hours">
											</div>
										</div>

										<div class="form-group row">


											<label for="exampleInputFile" class="col-sm-2 control-label mt-1">Featured Images <span class="text-danger">&#42;&#42;</span></label>

											<div class="col-sm-8">
												<input type="file" name="featured_img" id="featured_img" onchange="uploadFile1('featured_img')" class="form-control-file" required>
												<div id="image-viewer"></div>
											</div>
										</div>
										<div class="form-group row">
											<label for="exampleInputFile" class="col-sm-2 control-label mt-1">Product Images</label>
											<div class="col-sm-8 input-files">
												<button type="button" class="btn btn-hover btn-dark waves-effect waves-light" id="moreImg"><i class="fa-solid fa-circle-plus"></i> Add More Image</button>
											</div>
										</div>

										<div class="form-group" style="display:none">
											<label for="focusedinput" class="col-sm-2 control-label m-0">Shipping Fees</label>
											<div class="col-sm-8">
												<input type="number" class="form-control" value="0" id="shipping" name="shipping">
											</div>
										</div>

										<div class="form-group row align-items-center">
											<label for="focusedinput" class="col-sm-2 control-label m-0">Upload Video</label>
											<div class="col-sm-8">
												<input type="file" name="prod_youtubeid" id="prod_youtubeid" class="form-control-file">
											</div>
										</div>

										<div class="form-group row align-items-center">
											<label class="col-sm-2 control-label m-0">Related Product multi select</label>
											<div id="example2" class="col-sm-8">
												<select class="form-control related_prod" id="selectrelatedprod" name="selectrelatedprod[]" multiple>
												</select>

												<a>Related products are shown to customers in addition to the item the customer is looking at.</a>
											</div>
										</div>

										<div class="form-group row align-items-center">
											<label class="col-sm-2 control-label m-0">Up-Sell Products</label>
											<div id="example1" class="col-sm-8">
												<select class="form-control related_prod" id="selectupsell" name="selectupsell[]" multiple>
												</select>

												<a>An up-sell item is offered to the customer as a pricier or higher-quality alternative to the product the customer is looking at.</a>
											</div>
										</div>

										<div class="form-group row align-items-center">
											<label for="focusedinput" class="col-sm-2 control-label m-0"> Meta Title</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="prod_meta" name="prod_meta" placeholder="60 Letters">
											</div>
										</div>
										<div class="form-group row align-items-center">
											<label for="focusedinput" class="col-sm-2 control-label m-0">Meta Keywords</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" id="prod_keyword" name="prod_keyword" placeholder="250 letters">
											</div>
										</div>
										<div class="form-group row align-items-center">
											<label for="focusedinput" class="col-sm-2 control-label m-0">Meta Description</label>
											<div class="col-sm-8">
												<textarea class="form-control" rows="7" id="prod_meta_desc" name="prod_meta_desc" placeholder="150 letters"></textarea>
											</div>
										</div>
										</br></br>
										<div class="col-sm-offset-2">
											<button type="submit" class="btn btn-dark waves-effect waves-light" href="javascript:void(0)" id="addProduct_btn">Save</button>
										</div>


									</form>
								</div>

							</div>
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
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Configurations</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body p-2">
				<!--<div class="col-sm-8" id="add_more_attr_btndiv">
					<a class="fa fa-plus fa-4 btn btn-dark waves-effect waves-light" aria-hidden="true" onclick="add_more_attrs();">Add More Attributes</a>
				</div>-->
				<form class="form-horizontal" id="myform_attr">
					<div class="form-group row align-items-center">
						<div class="form-group mb-0">
							<div class="col-sm-12">
								<div class="attributes">
									<table class="table table-sm table-borderless mb-0">
										<tbody id="selectattrs_div"></tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-dark waves-effect waves-light" id="manage_configurations_btn" onclick=" return manage_configurations();">Add Configurations</button>
			</div>
		</div>

	</div>
</div>

<div class="col_1">

	<div class="clearfix"> </div>

</div>

<?php include("footernew.php"); ?>
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

	});
</script>