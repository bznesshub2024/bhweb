<?php
include('session.php');

if (!isset($_SESSION['admin'])) {
	header("Location: index.php");
}

include("header.php");
$code = $_POST['code'];
$code = stripslashes($code);
$datetime = date('Y-m-d');

if (!isset($_SESSION['admin'])) {
	header("Location: index.php");
	//echo " dashboard redirect to index";
} else {
	if ($code == $_SESSION['_token'] && isset($_POST['product_id'])) {
		$enableproduct = trim(strip_tags($_POST['enableproduct']));
		$prod_mrp = trim(strip_tags($_POST['prod_mrp']));
		$prod_price = trim(strip_tags($_POST['prod_price']));
		$seller_price = trim(strip_tags($_POST['seller_price']));
		$selecttaxclass = trim(strip_tags($_POST['selecttaxclass']));
		$prod_qty = trim(strip_tags($_POST['prod_qty']));
		$selectstock = trim(strip_tags($_POST['selectstock']));
		$prod_purchase_lmt = trim(strip_tags($_POST['prod_purchase_lmt']));
		$prod_remark = trim(strip_tags($_POST['prod_remark']));
		$brand_id = trim(strip_tags($_POST['brand_id']));

		$product_id = trim($_POST['product_id']);
		$coupon_code = trim($_POST['coupon_code']);
		$regarding_price = trim(strip_tags($_POST['regarding_price']));

		$selectrelatedprod = '';

		if (array_key_exists('selectrelatedprod', $_POST)) {
			$selectrelatedprod = implode(',', $_POST['selectrelatedprod']);
		}

		$selectupsell = '';
		if (array_key_exists('selectupsell', $_POST)) {
			$selectupsell = implode(',', $_POST['selectupsell']);
		}


		$enableproduct	=   addslashes($enableproduct);
		$prod_mrp	=   addslashes($prod_mrp);
		$prod_price	=   addslashes($prod_price);
		$seller_price	=   addslashes($seller_price);
		$selecttaxclass	=   addslashes($selecttaxclass);
		$prod_qty	=   addslashes($prod_qty);
		$selectstock	=   addslashes($selectstock);
		$prod_purchase_lmt	=   addslashes($prod_purchase_lmt);
		if($prod_purchase_lmt == '')
		{
			$prod_purchase_lmt = '1000';
		}
		$prod_remark	=   addslashes($prod_remark);


		$price_type = '';

		if ($enableproduct != 1) {
			$enableproduct = 0;
		}

		if (isset($prod_mrp)  && isset($prod_price)) {


			// code for check product exist - END
			$stmti = $conn->prepare("SELECT pd.id, vp.id as vendor_prod_id FROM product_details pd, vendor_product vp WHERE pd.product_unique_id=vp.product_id
					AND vp.vendor_id = ? AND pd.product_unique_id=?");
			$stmti->bind_param("ss", $_SESSION['admin'], $product_id);
			$stmti->execute();

			$stmti->bind_result($prodid, $vendor_prod_id);

			$prod_exist = 0;
			while ($stmti->fetch()) {
				$prod_exist = 1;
			}
			if ($prod_exist == 1) {
				// code for add product main - START
				
				if(strlen($_FILES['featured_img']['name']) >1){
					$Common_Function->img_dimension_arr = $img_dimension_arr;
					$featured_img1 = $Common_Function->file_upload('featured_img',$media_path);
					$featured_img = json_encode($featured_img1);
				}else{
					$featured_img = urldecode( $_POST['featured_imgtxt']);
				}
				
				if(is_array($_FILES['product_image']['name'])){
					$Common_Function->img_dimension_arr = $img_dimension_arr;
					$prod_img_url_arr = $Common_Function->file_upload('product_image',$media_path);
				 	$prod_img_en = json_encode($prod_img_url_arr);
					
					if($prod_imgs_url){
						$prod_img_url = json_encode(array_merge(json_decode($prod_imgs_url, true),json_decode($prod_img_en, true)));
					}else{
						$prod_img_url = $prod_img_en;
					}

				}else{
					$prod_img_url = urldecode( $_POST['prod_img_urltxt']);
				}
				
				

				$prod_id = $product_id;

				$stmt11 = $conn->prepare("UPDATE `vendor_product` SET `product_mrp` = ?,`product_sale_price` =?, `product_tax_class` =?, `product_stock` =?,
						`stock_status` =?, `product_purchase_limit` =?,`product_remark` =?,`product_related_prod` =?, `product_upsell_prod` =?, `enable_status` =?,`coupon_code` =?,`seller_price` = ?
						 WHERE product_id ='" . $prod_id . "' AND vendor_id = '" . $_SESSION['admin'] . "'");

				$stmt11->bind_param("ssiisisssiss", $prod_mrp, $prod_price, $selecttaxclass, $prod_qty, $selectstock, $prod_purchase_lmt, $prod_remark, $selectrelatedprod, $selectupsell, $enableproduct, $coupon_code, $seller_price);

				$stmt11->execute();
				$stmt11->store_result();
				
				
				$stmt110 = $conn->prepare("UPDATE `product_details` SET `brand_id` = '" . $brand_id . "',`featured_img` = '" . $featured_img . "',`prod_img_url` = '" . $prod_img_url . "',`regarding_price` = '".$regarding_price."' WHERE product_unique_id ='" . $prod_id . "'");

				$stmt110->execute();
				$stmt110->store_result();

				// code for add product for Attribute - START

				if (array_key_exists('selected_attr', $_POST) && array_key_exists('attr_combination', $_POST)) {
					if (count($_POST['selected_attr']) > 0  && count($_POST['attr_combination']) > 0) {

						$delete = $conn->prepare("DELETE FROM `product_attribute_value`  WHERE `vendor_prod_id` = '" . $vendor_prod_id . "' AND `product_id` = '" . $prod_id . "' ");

						$delete->execute();
						
						$delete2 = $conn->prepare("DELETE FROM `product_attribute`  WHERE `prod_id` = '" . $prod_id . "'");

						$delete2->execute();

						foreach ($_POST['selected_attr'] as $attr_json) {
							$attr_json_decod = json_decode($attr_json);
							$attr_id = $attr_json_decod->attribute_id;
							$attribute_val = json_encode($attr_json_decod->attribute_val, JSON_FORCE_OBJECT);

							$sql_attr_prep = $conn->prepare("INSERT INTO `product_attribute`(`prod_attr_id`,`prod_id`,`attr_value`,`vendor_id`) VALUES (?,?,?,?)");

							$sql_attr_prep->bind_param("isss", $attr_id, $prod_id, $attribute_val, $_SESSION['admin']);

							$sql_attr_prep->execute();
							$sql_attr_prep->store_result();
						}

						$sql_attr = '';
						$count_varient = count($_POST['attr_combination']);
						for ($v = 0; $v < $count_varient; $v++) {
							$varient_val = json_encode($_POST['attr_combination'][$v], JSON_FORCE_OBJECT);
							$prod_skus = $Common_Function->validate_product_sku($_POST['prod_skus'][$v], $conn);
							$sale_price = $_POST['sale_price'][$v];
							$mrp_price = $_POST['mrp_price'][$v];
							$stocks = $_POST['stocks'][$v];
							$conf_image = '';
							if ($_FILES['conf_image' . $v]['name']) {
								$Common_Function->img_dimension_arr = $img_dimension_arr;
								$conf_image1 = $Common_Function->file_upload('conf_image' . $v, $media_path);
								$conf_image = json_encode($conf_image1);
							}

							$sql_attr .= " ('" . $prod_id . "','" . $vendor_prod_id . "', '" . $prod_skus . "', " . $varient_val . ", '" . $sale_price . "', '" . $mrp_price . "', '" . $stocks . "','" . $conf_image . "','','" . $datetime . "'),";
						}
						$sql_attr .= ";";
						$sql_attr = str_replace(',;', ';', $sql_attr);

						$sql_meta_prep = $conn->prepare("INSERT INTO `product_attribute_value`(`product_id`, `vendor_prod_id`, `product_sku`, `prod_attr_value`, `price`, `mrp`, `stock`,`conf_image`, `notify_on_stock_below`, `created_at`) 
									VALUES " . $sql_attr);

						$sql_meta_prep->execute();
						$sql_meta_prep->store_result();
					}
				} else {

					if (array_key_exists('prod_skus', $_POST) && array_key_exists('sale_price', $_POST)) {
						$prod_skus = $_POST['prod_skus'];
						$sale_price = $_POST['sale_price'];
						$mrp_price = $_POST['mrp_price'];
						$stocks = $_POST['stocks'];
						$conf_ids = $_POST['conf_ids'];

						$count_varient = count($_POST['conf_ids']);
						for ($v = 0; $v < $count_varient; $v++) {
							$sql_meta_prep = $conn->prepare("UPDATE `product_attribute_value` SET `price` ='" . $sale_price[$v] . "' , `mrp` = '" . $mrp_price[$v] . "', `stock` = '" . $stocks[$v] . "',
								`notify_on_stock_below` ='' WHERE `vendor_prod_id` = '" . $vendor_prod_id . "' AND `product_id` = '" . $prod_id . "' AND id ='" . $conf_ids[$v] . "'");

							$sql_meta_prep->execute();
							$sql_meta_prep->store_result();
						}
					}
				}


				$msg = "Product updated successfully.";
			} else {
				$msg = "Product Web URL and SKU already exist.";
			}
		} else {
			$msg = "Invalid Parameters. Please fill all required fields.";
		}
	} else if ($code == $_SESSION['_token'] && isset($_POST['prod_id']) && isset($_POST['status'])) {
		$prod_id = trim($_POST['prod_id']);
		$status = trim($_POST['status']);

		$stmt11 = $conn->prepare("UPDATE `vendor_product` SET `enable_status` = '" . $status . "' WHERE product_id ='" . $prod_id . "' AND vendor_id ='" . $_SESSION['admin'] . "'");

		//$stmt11->bind_param( "i",$status);

		$stmt11->execute();
		$stmt11->store_result();
		echo 'done';
	} else {
		$msg = "Invalid Parameters. Please fill all required fields.";
	}
}

include("footernew.php");
echo '<script>successmsg1("' . $msg . '","manage_product.php"); </script> ';
die;
