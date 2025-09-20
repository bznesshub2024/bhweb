<!DOCTYPE html>
<html lang="en">
<head>
  <title>ecoShop India</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

<?php //include header file
	include('header.php');
	$exp = explode('-',$_REQUEST['product_id']);
	if(count($exp)>0){
	    $product_id = end($exp); 
	}else{
	    $product_id = $_REQUEST['product_id'];
	}

?>
<section class="cstm-sec">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
       <div class="single-page">
         <div class="row">
           <div class="col-md-6">
            <div class="inner-pro">
             <div class="product-image" id="product_main_image">
               
             </div>
             <div class="products-img">
               <div class="owl-carousel sub-product owl-theme" id="product_other_images">
                 
                  
                </div>
             </div>
             </div>
           </div>
           <div class="col-md-6">
             <h2 class="product-name" id="product_names"></h2>
             <div class="product-name" id="product_rating"></div>
             <div class="product-name" id="product_brand"></div>
             <p class="sell-price">Price(Rs.) ₹ <span id="product_price_span">0</span>  <strike id="product_mrp_span">0</strike> <span id="product_offpercent_span"> 0% OFF</span></p>
             <div class="product-name" id="product_weight_div"></div>
              <div class="product-attribute">
				<div id="product_price_div">
					
				</div>
             </div>
             <p></p>
             <div class="product-page-btn">
                 <button class="btn btn-pink" id="wishlist<?php echo $product_id; ?>">Wish List</button>
               <button class="btn btn-pink" id="cart<?php echo $product_id; ?>">Add to Cart</button>
               
              <!-- <i class="fa fa-heart" aria-hidden="true"></i>-->
               
             </div>
          <!--   <button class="btn btn-pink" id="buy<?php echo $product_id; ?>">Buy now</button>-->
             <div class="product-details">
               <h4>Overview</h4>
               <ul id="product_desc_ul">
                                
               </ul>
             </div>
			 <div class="product-attribute">
				<div id="product_attribute_div">
					
				</div>
             </div>
             <div class="product-description">
               <h4>DETAILS</h4>
               <p id="product_full_desc"></p>
             </div>
           </div>
         </div>
       </div>
      </div>
    </div>
  </div>
</section>

<section class="cstm-sec">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="related-products">
        <div class="detail-sec">
          <h2>Related Products</h2>
        </div>
        <div id="related_product_div"></div>
         </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
//function for getting homepage banners

get_single_product_details();
function get_single_product_details(){
	$("#product_main_image").html('<div class="loader"><img class="loader_img" src="<?php echo $MEDIA_URL;  ?>home/loader.gif" ></div>');		
	$.ajax({
		url: "<?php echo $API_URL; ?>getproductdetails_sec.php",
		type: "POST",
		 
		data: {language:'<?php echo $language; ?>',securecode:'<?php echo $securecode; ?>',prodid:'<?php echo $product_id; ?>'},
		success: function(html){
			var catHtml_home = carousel_indicators = '';
			var catObj = JSON.parse(html);
			var categoryArray = catObj.Information;
			if(categoryArray){
				var product_id = categoryArray.id;
				var product_name = categoryArray.name;
				var prod_rating = categoryArray.prod_rating;
				var prod_rating_count = categoryArray.prod_rating_count;
				var brand = categoryArray.brand;
				var unit = categoryArray.unit;
				
				var product_fulldetail = categoryArray.fulldetail;
			
				var imageObj = JSON.parse(categoryArray.img_url);
				
				
				var pricearray = categoryArray.pricearray;
				
				var  price_html = '';
				if(pricearray.length >2){
					var price_obj = JSON.parse(pricearray);
				    
					var product_price = price_obj[0].attrvalue;
					var product_mrp = 0;
					var product_offpercent = 0;
					price_html +='Select Size: <select id="product_price" onchange="change_price('+product_id+')">';
					for(var p=0;p<price_obj.length;p++){
					    price_html +='<option value="'+price_obj[p].attrvalue+'"  >'+price_obj[p].attrnam+'</option>';
					   
					}
					
			    }else{
			    	var product_price = categoryArray.price;
			    	var product_mrp = categoryArray.mrp;
			    	var product_offpercent = categoryArray.offpercent;
			    }
				
				$("#product_price_div").html(price_html);
				
				product_price = product_price.replace(/,/g, '');
				$("#cart"+product_id).attr('onclick', 'single_product_add_cart('+product_id+','+product_price+')');
				$("#buy"+product_id).attr('onclick', 'single_product_buy_cart('+product_id+','+product_price+')');
				$("#wishlist"+product_id).attr('onclick', 'product_add_wishlist('+product_id+','+product_price+')');
				
				var image_url = imageObj[0].url;
				$("#product_names").html(product_name);
				$("#product_price_span").html(product_price);
				
				if(parseInt(product_mrp) >0){
				    $("#product_mrp_span").html(' ₹ '+product_mrp);
				    $("#product_offpercent_span").html(' &nbsp;('+product_offpercent+'% OFF)');
				}else{
				    $("#mrp_off_p").hide();
				}
				var rating_html = create_rating_html(prod_rating);
				$("#product_rating").html(rating_html+' ('+prod_rating_count+')');
				$("#product_brand").html(brand);
				
				$("#product_main_image").html('<img class="_1Nyybr _30XEf0 block__pic" alt="'+product_name+'" src="<?php echo $MEDIA_URL; ?>'+image_url+'" >');
			    
				$(".block__pic").imagezoomsl({
					zoomrange: [3, 3]
				});
			
				$("#product_full_desc").html(product_fulldetail);
				var img_arr = imageObj.length;
				var other_img_list = '';
				if(img_arr >0){
					for(j=0;j<img_arr;j++){
						var other_image_url = imageObj[j].url;
						other_img_list += ' <div class="item"><a href="javascript:void(0);" onclick="change_main_image('+j+');" ><img id="thumb'+j+'" class="_1Nyybr _30XEf0" alt="'+product_name+'" src="<?php echo $MEDIA_URL; ?>'+other_image_url+'"></a></div>';
					}
				
					$("#product_other_images").html(other_img_list);
					product_other_img_crousel();
				}
				if(isJson(categoryArray.short_desc)){
					var short_desc = JSON.parse(categoryArray.short_desc);
					var short_desc_leng = short_desc.length; 
					if(short_desc_leng > 0){
						var product_desc = '';
						for(d=0;d<short_desc_leng;d++){
							var desc_array = short_desc[d];
							product_desc += '<li><span>'+desc_array.attrnam+' :</span>'+desc_array.attrvalue+'</li>';
						}
						$("#product_desc_ul").html(product_desc);
					}
				}else{
					$("#product_desc_ul").html('<li><span>'+categoryArray.short_desc+'</span></li>');
				}
				
				var product_arrt = JSON.parse(categoryArray.attr);
				
				var attr_html = size_html = color_html =weight_html ='';
				if(product_arrt.size){
					var size_str = product_arrt.size;
					var size_attr = size_str.split(",");
					var size_html = 'Select Size <select id="product_size">';
					for(s=0;s<size_attr.length;s++){
						size_html += '<option value="'+size_attr[s]+'">'+size_attr[s]+'</option>';
					}
					size_html += '</select>';
				}
				if(product_arrt.color){
					var color_str = product_arrt.color;
					var color_attr = color_str.split(",");
					var color_html = 'Select Color <select id="product_color">';
					for(c=0;c<color_attr.length;c++){
						color_html += '<option value="'+color_attr[c]+'">'+color_attr[c]+'</option>';
					}
					size_html += '</select>';
				}
				
				if(product_arrt.weight){
					var weight_str = product_arrt.weight;
					var weight_attr = weight_str.split(",");
					if(weight_attr[0]){
						$("#product_weight_div").html("Weight "+weight_attr[0]+" "+unit);
					}
					/*var weight_html = 'Select Weight <select id="product_weight">';
					for(w=0;w<weight_attr.length;w++){
						weight_html += '<option value="'+weight_attr[w]+'">'+weight_attr[w]+'</option>';
					}
					size_html += '</select>';*/
				}
				
				if(size_html || color_html){
					attr_html +='<h4>Product Information</h4><ul id="product_attribute_ul">';
					
					attr_html +=size_html;
					attr_html +=color_html;
					attr_html +=weight_html;
					attr_html +='</ul>';
					$("#product_attribute_div").html(attr_html);
				}
				
				var related_array = catObj.related;
				
				var related_length = related_array.length;
				var category_product_list='';
				if(related_length >0){
					for(var i =0 ; i<related_length;i++){
						
						var catArrayproduct = related_array[i];
						var product_name =  create_product_url(catArrayproduct.name);
						var imageObj = JSON.parse(catArrayproduct.img_url);
						
						var pricearray = catArrayproduct.pricearray;
					
				    	if(pricearray.length >2){
					        var price_obj = JSON.parse(pricearray);
				    
					        var prices = price_obj[0].attrvalue;
					        var mrps = 0;
					        var offs = 0;
				        }else{
					        var prices = catArrayproduct.price;
					        var mrps = catArrayproduct.mrp;
					        var offs = catArrayproduct.offpercent;
					    }
					    prices = prices.replace(/,/g, '');
						category_product_list += '<div class="item-detail"><div class="" title="'+catArrayproduct.name+'">';
						category_product_list += '<a href="<?php echo $SITE_URL; ?>product/'+product_name+'-'+catArrayproduct.id+'"><div class="_2PX1l4" style="height:150px"><div class="_3BTv9X" style="height:150px;width:150px">';
						category_product_list += '<img class="_1Nyybr _30XEf0" alt="'+catArrayproduct.name+'" src="<?php echo $MEDIA_URL;  ?>'+imageObj[0].url+'" ></div></div>';
						category_product_list += '<div class="iUmrbN">'+catArrayproduct.name+'</div><div class="BXlZdc">₹ '+prices+'<strike> ₹ '+mrps+'</strike> <span>'+offs+'% off</span></div></a></div><div class="xtra"><a href="<?php echo $SITE_URL; ?>product/'+product_name+'-'+catArrayproduct.id+'" class="see-icon"><i class="fa fa-eye" aria-hidden="true"></i></a>';
						category_product_list +='<a id="cart'+catArrayproduct.id+'" href="javascript:void(0);" onclick="product_add_cart('+catArrayproduct.id+','+prices+')" title="Add to Cart" class="cart-icon"><i class="fa fa-cart-plus" aria-hidden="true"></i></a></div></div>';
					}
					$("#related_product_div").html(category_product_list);
			
				}
			
			}
		}
	});
	
}

//function for add product into cart
function single_product_add_cart(product_id,product_price){
	var quantity = 1;
	<?php if(!$user_id){ ?>
		$('#loginModal').modal('show');
	<?php }else{ ?>
	if(product_id && product_price){
		var product_size  = $("#product_size").val();
		var product_color  = $("#product_color").val();
		$("#cart"+product_id).html('<i class="fa fa-spinner fa-spin"></i>');		
		$.ajax({
			url: "<?php echo $API_URL; ?>add_prod_into_cart_refer.php",
			type: "POST",
			
			data: {language:'<?php echo $language; ?>',securecode:'<?php echo $securecode; ?>',size:product_size,color:product_color,user_id:'<?php echo $user_id; ?>',prod_id:product_id,prod_price:product_price,qty:quantity},
			success: function(html){
				$("#cart"+product_id).html('<i class="fa fa-cart-plus" aria-hidden="true"></i>');
				var catObj = JSON.parse(html);
				var cartArray = catObj.Information;
			
					var status = catObj.status;
					if(status ==2){
					   alert(catObj.msg);
					}else{   
					    	get_cart_products('<?php echo $user_id; ?>');
					}
				
			}
		});
	}	
		
		
	<?php } ?>
}

function change_main_image(id){
     var srcs = $("#thumb"+id).attr('src');
     
    $(".block__pic").attr('src',srcs);
    
}
function change_price(product_id){
    var product_price = $("#product_price").val();
    product_price = product_price.replace(/,/g, '');
    $("#cart"+product_id).attr('onclick', 'single_product_add_cart('+product_id+','+product_price+')');
	$("#buy"+product_id).attr('onclick', 'single_product_buy_cart('+product_id+','+product_price+')');
	$("#wishlist"+product_id).attr('onclick', 'product_add_wishlist('+product_id+','+product_price+')');
				
	$("#product_price_span").html(product_price);
	$("#product_mrp_span").html(0);
	$("#product_offpercent_span").html('0% OFF');
}

//function for add product into cart
function single_product_buy_cart(product_id,product_price){
	var quantity = 1;
	<?php if(!$user_id){ ?>
		$('#loginModal').modal('show');
	<?php }else{ ?>
	if(product_id && product_price){
		var product_size  = $("#product_size").val();
		var product_color  = $("#product_color").val();
		$("#buy"+product_id).html('<i class="fa fa-spinner fa-spin"></i>');		
		$.ajax({
			url: "<?php echo $API_URL; ?>add_prod_into_cart_refer.php",
			type: "POST",
			
			data: {language:'<?php echo $language; ?>',securecode:'<?php echo $securecode; ?>',size:product_size,color:product_color,user_id:'<?php echo $user_id; ?>',prod_id:product_id,prod_price:product_price,qty:quantity},
			success: function(html){
				$("#buy"+product_id).html('<i class="fa fa-cart-plus" aria-hidden="true"></i>');
				var catObj = JSON.parse(html);
				var cartArray = catObj.Information;
			//	get_cart_products('<?php echo $user_id; ?>');
					var status = catObj.status;
					if(status ==2){
					   alert(catObj.msg);
					}else{   
					    	get_cart_products('<?php echo $user_id; ?>');
					    	location.href = "<?php echo $SITE_URL; ?>cart";
					}
				
			
			}
		});
	}	
		
		
	<?php } ?>
}
function product_other_img_crousel(){
$('.sub-product').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:5
        },
        600:{
            items:5
        },
        800:{
            items:5
        },
        1000:{
            items:5
        },
        1200:{
            items:5
        }
    }
})
}
</script>
<script>

$( document ).ready(function() {
    console.log( "ready!" );

    		


});
</script>
<?php 
//initialize footer file
include('footer.php'); 
?>
<script>
  $('.category-list').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:2
        },
        600:{
            items:3
        },
        800:{
            items:4
        },
        1000:{
            items:6
        },
        1200:{
            items:9
        }
    }
})
 function create_rating_html(rate){
	var html_rate = '';
	for(var rat =0;rat<5;rat++){
		if(rat<rate){
			html_rate += '<span class="fa fa-star checked"></span>';						
		}else{
			html_rate += '<span class="fa fa-star"></span>';						
		}
	}
	return html_rate;
}

</script>
<?php
	if($product_id){ 
		if(isset($_COOKIE['products_id'])){
			$explode_cook = explode(',',$_COOKIE['products_id']);
		}else{
			$explode_cook = array();
		}
		if (in_array($product_id, $explode_cook)){
			
		}else{
			$new_list = $_COOKIE['products_id'].','.$product_id;
			setcookie('products_id', $new_list, time() + (86400 * 30), "/"); // 86400 = 1 day

		}
		
	}
?>