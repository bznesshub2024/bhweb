<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CategoryProduct_model extends CI_Model {

    public function __construct() {
        parent::__construct();
		
		$this->date_time = date('Y-m-d H:i:s');
    }

	
	function get_sub_category_request($catid)
	{
		$this->db->select('category.cat_id');
		$this->db->where_in('category.parent_id', $catid);
		/*$this->db->where(array('category.parent_id'=>0));*/
		
		$query = $this->db->get('category');
		
		
		if($query->num_rows() >0){
			$category_result = $query->result_object();
		   
		   
		   $sub_cat_id = array();
			foreach($category_result as $cat_product){
			  $sub_cat_id[] = $cat_product->cat_id;
				
			}
			return $sub_cat_id;
		}
		else
		{
			$sub_cat_id = array();
		}
		return $sub_cat_id;
	}


	function get_product_custom_cloth_with_cat($cat_id){
		
		
			
			$this->db->select("parent_id");
			$this->db->where(array('cat_id'=>$cat_id,'status'=>1));
			$query_cat = $this->db->get('category');
			
			$prod_cat = $query_cat->result_object();
			$cat_result = $prod_cat[0];
			$cat_id1 = $cat_result->parent_id;
				
			if($cat_id1 == 10)
			{
				return $cat_id1;
			}
			else
			{
				$this->db->select("parent_id");
				$this->db->where(array('cat_id'=>$cat_id1,'status'=>1));
				$query_cat1 = $this->db->get('category');
				
				$prod_cat1 = $query_cat1->result_object();
				$cat_result1 = $prod_cat1[0];
				$cat_id2 = $cat_result1->parent_id;
				
				if($cat_id2 == 10)
				{
					return $cat_id2;
				}
				else
				{
					$this->db->select("parent_id");
					$this->db->where(array('cat_id'=>$cat_id2,'status'=>1));
					$query_cat2 = $this->db->get('category');
					
					$prod_cat2 = $query_cat2->result_object();
					$cat_result2 = $prod_cat2[0];
					$cat_id3 = $cat_result2->parent_id;
					
					if($cat_id3 == 10)
					{
						return $cat_id3;
					}

				}
				
				
			}
			
		
	}

	function get_product_review($prod_id, $pageno = '')
	{

		if ($pageno > 0) {
			$start = ($pageno * LIMIT);
		} else {
			$start = 0;
		}

		$this->db->select("pr.review_id,AVG(rating) as rating,pr.title as review_title,pr.comment as review_comment,pr.created_at as review_date, apl.fullname as user_name");
		$this->db->join('appuser_login apl', 'apl.user_unique_id = pr.user_id', 'INNER');
		$this->db->where(array('pr.product_id' => $prod_id, 'pr.status' => 1));
		$this->db->order_by('pr.created_at', 'DESC');
		$this->db->limit(LIMIT, $start);
		$query_review = $this->db->get('product_review pr');

		if ($query_review->num_rows() > 0) {
			$prod_result = $query_review->result_object();

			$product_array = array();
			$rating_count = 0;
			$rating_star = 0;
			foreach ($prod_result as $product_details) {
				$rating_star += $product_details->rating;
				$rating_count++;
			}
			$product_array['total_rating'] = $rating_star / $rating_count;
			$product_array['rating_count'] = $rating_count;
		}
		return $product_array;
	}

    //Functiofor for get category product
	function get_category_product_request($language, $catid,$pageno,$sortby,$devicetype,$config_attr,$config_brand,$min_price,$max_price,$rating){
       $prod_result = array();
	   $product_array = array();
	   
	   if($pageno >0){
		   $start = ($pageno*LIMIT_CAT);
	   }else{
		   $start = 0; 
	   }
	   $config_attr_decode =  json_decode($config_attr);
		
		$this->db->select('product_category.prod_id');
		$this->db->join('product_details', 'product_details.product_unique_id = product_category.prod_id','INNER');
		$this->db->join('vendor_product vp', 'product_details.product_unique_id = vp.product_id','INNER');
		$this->db->join('sellerlogin seller', 'vp.vendor_id = seller.seller_unique_id','INNER');
		$this->db->join('brand', 'brand.brand_id = product_details.brand_id', 'INNER');
		
		if (count(json_decode($config_brand, true)) > 0) {
			$this->db->where_in('product_details.brand_id', array_column(json_decode($config_brand, true), 'brand_id'));
		}
		
		
		if ($rating !== '') {
			$this->db->join('product_review', 'product_details.product_unique_id = product_review.product_id', 'LEFT');
			$this->db->where('product_review.status', '1');
			$this->db->having('AVG(product_review.rating) >=', $rating);
			$this->db->having('AVG(product_review.rating) <', $rating + 1);	
		}
		
		if ($min_price != '' && $max_price !== '')
		{
			$this->db->where(array('vp.product_sale_price >=' => $min_price, 'vp.product_sale_price <=' => $max_price,));
		}
		
		if($config_attr_decode){
			$this->db->join('product_attribute_value pav', 'vp.id = pav.vendor_prod_id','INNER');
		}	
		
		$this->db->where_in('product_category.cat_id', $catid);
		$this->db->where(array('(product_details.status'=>1,'seller.status'=>1,'vp.enable_status'=>1));
		
		$first_line = 0;
		if($config_attr_decode){
			foreach($config_attr_decode as $config_attribute){ 
				$attr_id = $config_attribute->attr_id;
				$attr_name = $config_attribute->attr_name;
				$attr_value = trim($config_attribute->attr_value);
				
				
				$query_prod = $this->db->query(' SELECT id FROM product_attributes_conf WHERE 
								attribute_id = "'.$attr_id.'" AND attribute_value = "'.$attr_value.'" ');
			
				if($query_prod->num_rows() >0){	
					if($first_line == 0)
					{
						$this->db->like('pav.prod_attr_value', ':"'.$attr_value.'"');
					}
					else
					{
						$this->db->or_like('pav.prod_attr_value', ':"'.$attr_value.'"');
					}
				}else{
					$this->db->reset_query();
					return 'invalid_filter';die;
				}
				$first_line++;
			}
			
	    }

		$this->db->group_end()->group_by("product_category.prod_id"); 
		$cloned_query = clone $this->db;
		$total = $cloned_query->get('product_category')->num_rows();
		//$this->db->limit(LIMIT,$start);
		
		$query = $this->db->get('product_category');
		/*print_r($this->db); */

		//print_r($this->db->last_query());
		
		if($query->num_rows() >0){
			$category_result = $query->result_object();
		   
			$product_id = array();
			foreach($category_result as $cat_product){
			   $product_id[] = $cat_product->prod_id;
			}
			
				  
			$this->db->select('pd.product_unique_id as id , pd.prod_name as name, pd.prod_name_ar as name_ar,pd.web_url as web_url, pd.product_sku as sku, pd.featured_img as img , "active" as active,
				vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_sale_price price, vp1.product_stock as stock,vp1.stock_status, vp1.product_remark as remark,seller.phone');
			
			
			$this->db->join('(SELECT vp.id as min_id,vp.product_id,  min(vp.product_sale_price) as mrp_min
				FROM vendor_product vp WHERE  vp.product_id IN('.$this->getValues($product_id).') AND vp.enable_status=1 group by vp.product_id  ) as vp2','pd.product_unique_id = vp2.product_id');
			$this->db->join('vendor_product vp1', 'vp1.product_id = vp2.product_id AND vp1.product_sale_price = vp2.mrp_min','INNER');
			$this->db->join('sellerlogin seller', 'vp1.vendor_id = seller.seller_unique_id','INNER');
			
			$this->db->where_in('pd.product_unique_id', $product_id);
			$this->db->where(array('pd.status' => 1,'seller.status'=>1, 'vp1.enable_status'=>1));
			$this->db->group_by("pd.product_unique_id"); 
			
			if($sortby==1){
				$this->db->order_by("vp2.mrp_min",'ASC'); 
			}else if($sortby==2){
				$this->db->order_by("vp2.mrp_min",'DESC'); 
			}else if($sortby==3){
				$this->db->order_by("pd.created_at",'DESC'); 
			}else if($sortby==4){
				$this->db->order_by("pd.prod_rating_count",'DESC'); 
			}
			$this->db->limit(LIMIT,$start);
			$query_prod = $this->db->get('product_details as pd');
			
			
			/*print_r($this->db->last_query());*/
			
			if($query_prod->num_rows() >0){
				$prod_result = $query_prod->result_object();
				
				foreach($prod_result as $product_details){
					$product_response = array();
					$product_response['id'] = $product_details->id;
					/* 1 arabci  2 english */
					if($language == 1){
						$product_response['name'] = $product_details->name_ar;
					}else{
						$product_response['name'] = $product_details->name;	
					}
					
					$product_response['web_url'] = $product_details->web_url;
					$product_response['sku'] = $product_details->sku;
					$product_response['active'] = $product_details->active;
					$product_response['vendor_id'] = $product_details->vendor_id;
					$product_response['mrp'] = price_format($product_details->mrp);
					$product_response['price'] = price_format($product_details->price);
					$product_response['stock'] = $product_details->stock;
					$product_response['stock_status'] = $product_details->stock_status;
					$product_response['remark'] = $product_details->remark;
					$product_response['seller_mobile'] = $product_details->phone;
					$product_response['rating'] = 0;

					$product_wishlist_array = $this->get_product_wishlist($product_details->id,$this->session->userdata("user_id"));
					$product_response['product_wishlist'] = $product_wishlist_array;
					
					$product_review_array = $this->get_product_review($product_details->id);

					if(!empty($product_review_array))
					{
						$product_response['product_total_rating'] = $product_review_array['total_rating'];
						$product_response['product_rating_count'] = $product_review_array['rating_count'];
					}
					else
					{
						$product_response['product_total_rating'] = '0';
						$product_response['product_rating_count'] = '0';
					}
					
					$discount_per = 0;
					$discount_price = 0;
					if($product_details->price >0){
						$discount_price = ($product_details->mrp-$product_details->price);
						
						$discount_per = ($discount_price/$product_details->mrp)*100;
						
					}
					$product_response['totaloff'] = price_format($discount_price);
					$product_response['offpercent'] = round($discount_per).'%';
					
					$img_decode = json_decode($product_details->img);
					
					if($devicetype == 1){
						if(isset($img_decode->{MOBILE})){						
							$img = $img_decode->{MOBILE};
						}else{
							$img = $product_details->img;
						}
						
					}else{
						if(isset($img_decode->{DESKTOP})){						
							$img = $img_decode->{DESKTOP};
						}else{
							$img = $product_details->img;
						}
					}
					
					$product_response['imgurl'] = str_replace("-430-590",'',$img);
					$product_array[] = $product_response;
				}
			}
		}
		
		return array(
			"product_array" => $product_array,
			"total_products" => $total
		);
    }
	
	function get_product_wishlist($prod_id, $user_id = '')
	{
		$this->db->select("id");
		$this->db->where(array('prod_id' => $prod_id, 'user_id' => $user_id));
		$query_wishlist = $this->db->get('wishlistdetails');
		
		$count = 0;
		if ($query_wishlist->num_rows() > 0) {
			$count = 1;
		}
		return $count;
	}
	
    function get_category_product_request_old($language, $catid,$pageno,$sortby,$devicetype,$config_attr){
       $prod_result = array();
	   $product_array = array();
	   
	   if($pageno >0){
		   $start = ($pageno*LIMIT_CAT);
	   }else{
		   $start = 0; 
	   }
	   $config_attr_decode =  json_decode($config_attr);
		
		$this->db->select('product_category.prod_id');
		$this->db->join('product_details', 'product_details.product_unique_id = product_category.prod_id','INNER');
		$this->db->join('vendor_product vp', 'product_details.product_unique_id = vp.product_id','INNER');
		$this->db->join('sellerlogin seller', 'vp.vendor_id = seller.seller_unique_id','INNER');
		
		if($config_attr_decode){
			$this->db->join('product_attribute_value pav', 'vp.id = pav.vendor_prod_id','INNER');
		}	
		
		$this->db->where_in('product_category.cat_id', $catid);
		$this->db->where(array('(product_details.status'=>1,'seller.status'=>1,'vp.enable_status'=>1));
		
		$first_line = 0;
		if($config_attr_decode){
			foreach($config_attr_decode as $config_attribute){ 
				$attr_id = $config_attribute->attr_id;
				$attr_name = $config_attribute->attr_name;
				$attr_value = trim($config_attribute->attr_value);
				
				
				$query_prod = $this->db->query(' SELECT id FROM product_attributes_conf WHERE 
								attribute_id = "'.$attr_id.'" AND attribute_value = "'.$attr_value.'" ');
			
				if($query_prod->num_rows() >0){	
					if($first_line == 0)
					{
						$this->db->like('pav.prod_attr_value', ':"'.$attr_value.'"');
					}
					else
					{
						$this->db->or_like('pav.prod_attr_value', ':"'.$attr_value.'"');
					}
				}else{
					$this->db->reset_query();
					return 'invalid_filter';die;
				}
				$first_line++;
			}
			
	    }

		$this->db->group_end()->group_by("product_category.prod_id"); 
		
		$this->db->limit(LIMIT,$start);
		
		$query = $this->db->get('product_category');
		//print_r($this->db);

		//print_r($this->db->last_query());
		
		if($query->num_rows() >0){
			$category_result = $query->result_object();
		   
			$product_id = array();
			foreach($category_result as $cat_product){
			   $product_id[] = $cat_product->prod_id;
			}
							  
			//get products details
			$this->db->select('pd.product_unique_id as id , pd.prod_name as name, pd.prod_name_ar as name_ar,pd.web_url as web_url, pd.product_sku as sku, pd.featured_img as img , "active" as active,
				vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_sale_price price, vp1.product_stock as stock,vp1.stock_status, vp1.product_remark as remark,seller.phone');
			
			
			$this->db->join('(SELECT vp.id as min_id,vp.product_id,  min(vp.product_sale_price) as mrp_min
				FROM vendor_product vp WHERE  vp.product_id IN('.$this->getValues($product_id).') AND vp.enable_status=1 group by vp.product_id  ) as vp2','pd.product_unique_id = vp2.product_id');
			$this->db->join('vendor_product vp1', 'vp1.product_id = vp2.product_id AND vp1.product_sale_price = vp2.mrp_min','INNER');
			$this->db->join('sellerlogin seller', 'vp1.vendor_id = seller.seller_unique_id','INNER');
			$this->db->join('product_attribute_value pav', 'pav.product_id = pd.product_unique_id','INNER');
			
			$this->db->where_in('pd.product_unique_id', $product_id);
			$this->db->where(array('pd.status' => 1,'seller.status'=>1, 'vp1.enable_status'=>1, 'pav.conf_image !=' => ''));
			
			/*$this->db->group_by("pd.product_unique_id");*/
			
			if($sortby==1){
				$this->db->order_by("vp2.mrp_min",'ASC'); 
			}else if($sortby==2){
				$this->db->order_by("vp2.mrp_min",'DESC'); 
			}else if($sortby==3){
				$this->db->order_by("pd.created_at",'DESC'); 
			}else if($sortby==4){
				$this->db->order_by("pd.prod_rating_count",'DESC'); 
			}
			
			$query_prod = $this->db->get('product_details as pd');
			
			
			
			if($query_prod->num_rows() >0){
				$prod_result = $query_prod->result_object();
				
				foreach($prod_result as $product_details){
					$product_response = array();
					$product_response['id'] = $product_details->id;
					// 1 arabci  2 english
					if($language == 1){
						$product_response['name'] = $product_details->name_ar;
					}else{
						$product_response['name'] = $product_details->name;	
					}
					
					$product_response['web_url'] = $product_details->web_url;
					$product_response['sku'] = $product_details->sku;
					$product_response['active'] = $product_details->active;
					$product_response['vendor_id'] = $product_details->vendor_id;
					$product_response['mrp'] = price_format($product_details->mrp);
					$product_response['price'] = price_format($product_details->price);
					$product_response['stock'] = $product_details->stock;
					$product_response['stock_status'] = $product_details->stock_status;
					$product_response['remark'] = $product_details->remark;
					$product_response['seller_mobile'] = $product_details->phone;
					$product_response['rating'] = 0;

					$product_review_array = $this->get_product_review($product_details->id);
 
					if(!empty($product_review_array))
					{
						$product_response['product_total_rating'] = $product_review_array['total_rating'];
						$product_response['product_rating_count'] = $product_review_array['rating_count'];
					}
					else
					{
						$product_response['product_total_rating'] = '0';
						$product_response['product_rating_count'] = '0';
					}
					
					$discount_per = 0;
					$discount_price = 0;
					if($product_details->price >0){
						$discount_price = ($product_details->mrp-$product_details->price);
						
						$discount_per = ($discount_price/$product_details->mrp)*100;
						
					}
					$product_response['totaloff'] = price_format($discount_price);
					$product_response['offpercent'] = round($discount_per).'%';
					
					$img_decode = json_decode($product_details->img);
					
					if($devicetype == 1){
						if(isset($img_decode->{MOBILE})){						
							$img = $img_decode->{MOBILE};
						}else{
							$img = $product_details->img;
						}
						
					}else{
						if(isset($img_decode->{DESKTOP})){						
							$img = $img_decode->{DESKTOP};
						}else{
							$img = $product_details->img;
						}
					}
					
					$product_response['imgurl'] = str_replace("-430-590",'',$img);
					$product_array[] = $product_response;
				}
			}
		}
		
		return $product_array;
    }


	function get_category_sponsor_product_request($language, $catid,$pageno,$sortby,$devicetype,$config_attr){
       $prod_result = array();
	   $product_array = array();
	   
	   if($pageno >0){
		   $start = ($pageno*LIMIT_CAT);
	   }else{
		   $start = 0; 
	   }
	   $config_attr_decode =  json_decode($config_attr);
		
		$this->db->select('sponsor_product.product_id');
		$this->db->join('product_details', 'product_details.product_unique_id = sponsor_product.product_id','INNER');
		$this->db->join('vendor_product vp', 'product_details.product_unique_id = vp.product_id','INNER');
		$this->db->join('sellerlogin seller', 'vp.vendor_id = seller.seller_unique_id','INNER');
		
		if($config_attr_decode){
			$this->db->join('product_attribute_value pav', 'vp.id = pav.vendor_prod_id','INNER');
		}	
		
		$this->db->where_in('sponsor_product.cat_id', $catid);
		$this->db->where(array('product_details.status'=>1,'seller.status'=>1,'vp.enable_status'=>1));
		
		$first_line = 0;
		if($config_attr_decode){
			foreach($config_attr_decode as $config_attribute){ 
				$attr_id = $config_attribute->attr_id;
				$attr_name = $config_attribute->attr_name;
				$attr_value = trim($config_attribute->attr_value);
				
				
				$query_prod = $this->db->query(' SELECT id FROM product_attributes_conf WHERE 
								attribute_id = "'.$attr_id.'" AND attribute_value = "'.$attr_value.'" ');
			
				if($query_prod->num_rows() >0){	
					if($first_line == 0)
					{
						$this->db->like('pav.prod_attr_value', ':"'.$attr_value.'"');
					}
					else
					{
						$this->db->or_like('pav.prod_attr_value', ':"'.$attr_value.'"');
					}
				}else{
					$this->db->reset_query();
					return 'invalid_filter';die;
				}
				$first_line++;
			}
			
	    }
		$this->db->group_by("sponsor_product.product_id");
		
		$this->db->limit(LIMIT,$start);
		
		$query = $this->db->get('sponsor_product');
	
		
		if($query->num_rows() >0){
			$category_result = $query->result_object();
		   
			$product_id = array();
			foreach($category_result as $cat_product){
			   $product_id[] = $cat_product->product_id;
			}
		 
				  
			$this->db->select('pd.product_unique_id as id , pd.prod_name as name, pd.prod_name_ar as name_ar,pd.web_url as web_url, pd.product_sku as sku, pd.featured_img as img , "active" as active,
				vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_sale_price price, vp1.product_stock as stock, vp1.product_remark as remark,seller.phone');
			
			
			$this->db->join('(SELECT vp.id as min_id,vp.product_id,  min(vp.product_sale_price) as mrp_min
				FROM vendor_product vp WHERE  vp.product_id IN('.$this->getValues($product_id).') AND vp.enable_status=1 group by vp.product_id  ) as vp2','pd.product_unique_id = vp2.product_id');
			$this->db->join('vendor_product vp1', 'vp1.product_id = vp2.product_id AND vp1.product_sale_price = vp2.mrp_min','INNER');
			$this->db->join('sellerlogin seller', 'vp1.vendor_id = seller.seller_unique_id','INNER');
			
			$this->db->where_in('pd.product_unique_id', $product_id);
			$this->db->where(array('pd.status' => 1,'seller.status'=>1, 'vp1.enable_status'=>1));
			$this->db->group_by("pd.product_unique_id"); 
			
			if($sortby==1){
				$this->db->order_by("vp2.mrp_min",'ASC'); 
			}else if($sortby==2){
				$this->db->order_by("vp2.mrp_min",'DESC'); 
			}else if($sortby==3){
				$this->db->order_by("pd.created_at",'DESC'); 
			}else if($sortby==4){
				$this->db->order_by("pd.prod_rating_count",'DESC'); 
			}
			
			$query_prod = $this->db->get('product_details as pd');
			
			if($query_prod->num_rows() >0){
				$prod_result = $query_prod->result_object();
				
				foreach($prod_result as $product_details){
					$product_response = array();
					$product_response['id'] = $product_details->id;
					// 1 arabci  2 english
					if($language == 1){
						$product_response['name'] = $product_details->name_ar;
					}else{
						$product_response['name'] = $product_details->name;	
					}
					
					$product_response['web_url'] = $product_details->web_url;
					$product_response['sku'] = $product_details->sku;
					$product_response['active'] = $product_details->active;
					$product_response['vendor_id'] = $product_details->vendor_id;
					$product_response['mrp'] = price_format($product_details->mrp);
					$product_response['price'] = price_format($product_details->price);
					$product_response['stock'] = $product_details->stock;
					$product_response['remark'] = $product_details->remark;
					$product_response['seller_mobile'] = $product_details->phone;
					$product_response['rating'] = 0;

					$product_review_array = $this->get_product_review($product_details->id);

					if(!empty($product_review_array))
					{
						$product_response['product_total_rating'] = $product_review_array['total_rating'];
						$product_response['product_rating_count'] = $product_review_array['rating_count'];
					}
					else
					{
						$product_response['product_total_rating'] = '';
						$product_response['product_rating_count'] = '';
					}
					
					$discount_per = 0;
					$discount_price = 0;
					if($product_details->price >0){
						$discount_price = ($product_details->mrp-$product_details->price);
						
						$discount_per = ($discount_price/$product_details->mrp)*100;
						
					}
					$product_response['totaloff'] = price_format($discount_price);
					$product_response['offpercent'] = round($discount_per).'% off';
					
					$img_decode = json_decode($product_details->img);
					
					if($devicetype == 1){
						if(isset($img_decode->{MOBILE})){						
							$img = $img_decode->{MOBILE};
						}else{
							$img = $product_details->img;
						}
						
					}else{
						if(isset($img_decode->{DESKTOP})){						
							$img = $img_decode->{DESKTOP};
						}else{
							$img = $product_details->img;
						}
					}
					
					$product_response['imgurl'] = str_replace("-430-590",'',$img);
					$product_array[] = $product_response;
				}
			}
		}
		
		return $product_array;
    }

	function get_category_sponsor_product_count($catid,$pageno,$sortby,$devicetype,$config_attr){
       $prod_result = array();
	   $product_array = array();
	   
	   $config_attr_decode =  json_decode($config_attr);
	   
		$this->db->select('sponsor_product.product_id');
		$this->db->join('product_details', 'product_details.product_unique_id = sponsor_product.product_id','INNER');
		$this->db->join('vendor_product vp', 'product_details.product_unique_id = vp.product_id','INNER');
		$this->db->join('sellerlogin seller', 'vp.vendor_id = seller.seller_unique_id','INNER');
		
		if($config_attr_decode){
			$this->db->join('product_attribute_value pav', 'vp.id = pav.vendor_prod_id','INNER');
		}	
		
		$this->db->where_in('sponsor_product.cat_id', $catid);
		$this->db->where(array('product_details.status'=>1,'seller.status'=>1,'vp.enable_status'=>1));
		
		$first_line = 0;
		if($config_attr_decode){
			foreach($config_attr_decode as $config_attribute){ 
				$attr_id = $config_attribute->attr_id;
				$attr_name = $config_attribute->attr_name;
				$attr_value = trim($config_attribute->attr_value);
				
				
				$query_prod = $this->db->query(' SELECT id FROM product_attributes_conf WHERE 
								attribute_id = "'.$attr_id.'" AND attribute_value = "'.$attr_value.'" ');
			
				if($query_prod->num_rows() >0){	
					if($first_line == 0)
					{
						$this->db->like('pav.prod_attr_value', ':"'.$attr_value.'"');
					}
					else
					{
						$this->db->or_like('pav.prod_attr_value', ':"'.$attr_value.'"');
					}
				}else{
					$this->db->reset_query();
					return 'invalid_filter';die;
				}
				$first_line++;
			}
			
	    }
		$this->db->group_by("sponsor_product.product_id");
		
		$this->db->limit(LIMIT,$start);
		
		$query = $this->db->get('sponsor_product');
		
		
		return $query->num_rows();
	}
	
	function get_category_details($language, $cat_slug){
		$this->db->select('cat_id,cat_name, cat_name_ar,cat_img,parent_id,cat_slug');
		$this->db->where(array('status' => 1, 'cat_slug' => $cat_slug));
		$this->db->order_by('cat_order','ASC');
		$query = $this->db->get('category');
		
		if($query->num_rows() >0){
		  return $category_array = $query->result_object()[0];
		}
	}
	
	function get_category_product_count($catid,$pageno,$sortby,$devicetype,$config_attr){
       $prod_result = array();
	   $product_array = array();
	   
	   $config_attr_decode =  json_decode($config_attr);
	   
		$this->db->select('product_category.prod_id');
		$this->db->join('product_details', 'product_details.product_unique_id = product_category.prod_id','INNER');
		$this->db->join('vendor_product vp', 'product_details.product_unique_id = vp.product_id','INNER');
		$this->db->join('sellerlogin seller', 'vp.vendor_id = seller.seller_unique_id','INNER');
		
		if($config_attr_decode){
			$this->db->join('product_attribute_value pav', 'vp.id = pav.vendor_prod_id','INNER');
		}	
		
		$this->db->where_in('product_category.cat_id', $catid);
		$this->db->where(array('product_details.status'=>1,'seller.status'=>1,'vp.enable_status'=>1));
		if($config_attr_decode){
			foreach($config_attr_decode as $config_attribute){ 
				$attr_id = $config_attribute->attr_id;
				$attr_name = $config_attribute->attr_name;
				$attr_value = trim($config_attribute->attr_value);
				
				
				$query_prod = $this->db->query(' SELECT id FROM product_attributes_conf WHERE 
								attribute_id = "'.$attr_id.'" AND attribute_value = "'.$attr_value.'" ');
			
				if($query_prod->num_rows() >0){				
					$this->db->like('pav.prod_attr_value', ':"'.$attr_value.'"');
				}else{
					$this->db->reset_query();
					
				}
			}
	    }
		
		$this->db->group_by("product_category.prod_id"); 
		
		$query = $this->db->get('product_category');
		
		
		return $query->num_rows();
	}
	
	/*
		Break All The Values In Valid Form
	*/
	
	function getValues($var){
		if(is_array($var)){
			$values = "'".implode("','" , $var )."'";
		}else{ 
			$delm = Array(",","\n");
			$values = "'".str_replace($delm , "','" , $var)."'";  
		}
		return $values;
	}
   
}
