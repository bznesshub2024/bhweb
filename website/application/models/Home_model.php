<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model {

    public function __construct() {
        parent::__construct();
		
		$this->date_time = date('Y-m-d H:i:s');
    }
	
	function get_admin_email()
	{
		$this->db->select('description');
		$this->db->where(array('type'=>'system_email'));
		$query = $this->db->get('settings');
		
		$data_result = $query->result_object();
		foreach($data_result as $admin_data){
			   $email = $admin_data->description;
			}
		return $email;
	}
	
	function get_admin_phone()
	{
		$this->db->select('description');
		$this->db->where(array('type'=>'system_phone'));
		$query1 = $this->db->get('settings');
		
		$data1_result = $query1->result_object();
		foreach($data1_result as $admin1_data){
			   $phone = $admin1_data->description;
			}
		return $phone;
	}
	
	function get_aboutus_data_request()
	{
		$this->db->select('page_content');
		//$this->db->where(array('page_slug'=>'about-us'));
		$this->db->where('metaid','8');
		$query1 = $this->db->get('seometa');
		
		$data1_result = $query1->result_object();
		foreach($data1_result as $admin1_data){
			   $page_content = $admin1_data->page_content;
			}
		return $page_content;
	}
	
	function get_refund_data_request()
	{
		$this->db->select('page_content');
		$this->db->where('metaid','11');
		$query1 = $this->db->get('seometa');
		
		$data1_result = $query1->result_object();
		foreach($data1_result as $admin1_data){
			   $page_content = $admin1_data->page_content;
			}
		return $page_content;
	}
	
	function get_privacy_data_request()
	{
		$this->db->select('page_content');
		$this->db->where('metaid','9');
		$query1 = $this->db->get('seometa');
		
		$data1_result = $query1->result_object();
		foreach($data1_result as $admin1_data){
			   $page_content = $admin1_data->page_content;
			}
		return $page_content;
	}
	
	function get_term_data_request()
	{
		$this->db->select('page_content');
		$this->db->where('metaid','10');
		$query1 = $this->db->get('seometa');
		
		$data1_result = $query1->result_object();
		foreach($data1_result as $admin1_data){
			   $page_content = $admin1_data->page_content;
			}
		return $page_content;
	}
	
    //Functiofor for get category product
    function get_popular_product_request($pageno,$sortby,$devicetype){
       $prod_result = array();
       $product_array = array();
	   if($pageno >0){
		   $start = ($pageno*LIMIT);
	   }else{
		   $start = 0;
	   }
		$this->db->select('popular_product.product_id');
		$this->db->join('product_details', 'product_details.product_unique_id = popular_product.product_id','INNER');
		$this->db->join('vendor_product vp', 'product_details.product_unique_id = vp.product_id','INNER');
		$this->db->join('sellerlogin seller', 'vp.vendor_id = seller.seller_unique_id','INNER');
		$this->db->where(array('product_details.status'=>1,'vp.enable_status'=>1,'seller.status'=>1));
		//$this->db->group_by("popular_product.prod_id"); 
		
		$this->db->limit(LIMIT,$start);
		
		$query = $this->db->get('popular_product');
		
		
		if($query->num_rows() >0){
			$category_result = $query->result_object();
		   
			$product_id = array();
			foreach($category_result as $cat_product){
			   $product_id[] = $cat_product->product_id;
			}
		 
				  
			//get products details
			$this->db->select('pd.product_unique_id as id , pd.prod_name as name,pd.web_url as web_url, pd.product_sku as sku, pd.featured_img as img , "active" as active,
				vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_sale_price price, vp1.product_stock as stock, vp1.product_remark as remark');
			
			
			$this->db->join('(SELECT vp.id as min_id,vp.product_id,  min(vp.product_sale_price) as mrp_min
				FROM vendor_product vp WHERE  vp.product_id IN('.$this->getValues($product_id).') AND vp.enable_status=1 group by vp.product_id  ) as vp2','pd.product_unique_id = vp2.product_id');
			$this->db->join('vendor_product vp1', 'vp1.product_id = vp2.product_id AND vp1.product_sale_price = vp2.mrp_min','INNER');
			$this->db->join('sellerlogin seller', 'vp1.vendor_id = seller.seller_unique_id','INNER');
			$this->db->where_in('pd.product_unique_id', $product_id);
			$this->db->where(array('pd.status' => 1,'vp1.enable_status'=>1,'seller.status'=>1));
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
				
				$product_array = array();
				foreach($prod_result as $product_details){
					$product_response = array();
					$product_response['id'] = $product_details->id;
					$product_response['name'] = $product_details->name;
					$product_response['web_url'] = $product_details->web_url;
					$product_response['sku'] = $product_details->sku;
					$product_response['active'] = $product_details->active;
					$product_response['vendor_id'] = $product_details->vendor_id;
					$product_response['mrp'] = price_format($product_details->mrp);
					$product_response['price'] = price_format($product_details->price);
					$product_response['stock'] = $product_details->stock;
					$product_response['remark'] = $product_details->remark;
					$product_response['rating'] = 0;
					
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
					
					$product_response['imgurl'] = $img;
					$product_array[] = $product_response;
				}
			}
		}
		
		return $product_array;
    }
	

 //Functiofor for get category product
    function get_search_product_request($language, $search,$devicetype){
       $prod_result = array();$product_array = array();
	   $start = 0;
	  
	   $keywords = $this->filterSearchKeys($search);
	   $product_like = '';
	   $product_meta_like = '';
		$s =0;
		foreach($keywords as $keys){
			
			if($s==0){
				$product_like .= " (prod_name like '%".$keys."%' OR prod_name_ar like '%".$keys."%'   OR pm.meta_title like '%".$keys."%' OR pm.meta_key like '%".$keys."%'  OR pm.meta_value like '%".$keys."%' )";
				//$product_meta_like .= " (pm.meta_title like '%".$keys."%' OR pm.meta_key like '%".$keys."%'  OR pm.meta_value like '%".$keys."%' )";
			}else{
				$product_like .= " AND (prod_name like '%".$keys."%' OR prod_name_ar like '%".$keys."%'   OR pm.meta_title like '%".$keys."%' OR pm.meta_key like '%".$keys."%'  OR pm.meta_value like '%".$keys."%' )";
				//$product_meta_like .= " OR (pm.meta_title like '%".$keys."%' OR pm.meta_key like '%".$keys."%'  OR pm.meta_value like '%".$keys."%' )";
			}
			$s++;
		}
			//echo $product_like;			  
			//get products details
			/*$this->db->select('pd.product_unique_id as id , pd.prod_name as name,pd.web_url as web_url, pd.product_sku as sku, pd.featured_img as img , "active" as active,
				vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_sale_price price, vp1.product_stock as stock, vp1.product_remark as remark');
			
			
			$this->db->join('vendor_product vp1', 'vp1.product_id = pd.product_unique_id','INNER');
			$this->db->join('sellerlogin seller', 'vp1.vendor_id = seller.seller_unique_id','INNER');
			//$this->db->where_in('pd.product_unique_id', $product_id);
			$this->db->where(array('pd.status' => 1,'vp1.enable_status'=>1,'seller.status'=>1));
			
			//$this->db->like($product_like);
			
			$this->db->group_by("pd.product_unique_id"); 
			
		
			
			$this->db->limit(LIMIT,$start);*/
			
			$sql = "SELECT `pd`.`product_unique_id` as `id`, `pd`.`prod_name` as `name`, `pd`.`prod_name_ar` as `name_ar`, `pd`.`web_url` as `web_url`, `pd`.`product_sku` as `sku`, `pd`.`featured_img` as `img`,  `vp1`.`vendor_id`, `vp1`.`product_mrp` as `mrp`, `vp1`.`product_sale_price` `price`, `vp1`.`product_stock` as `stock`, `vp1`.`product_remark` as `remark`, 'active' as active
					FROM `product_details` as `pd`
					INNER JOIN `vendor_product` `vp1` ON `vp1`.`product_id` = `pd`.`product_unique_id`
					INNER JOIN `sellerlogin` `seller` ON `vp1`.`vendor_id` = `seller`.`seller_unique_id`
					LEFT JOIN  product_meta pm ON pm.prod_id = `pd`.`product_unique_id`
					LEFT JOIN  brand brand ON brand.brand_id = `pd`.`brand_id`
					WHERE `pd`.`status` = 1
					AND `vp1`.`enable_status` = 1
					AND `seller`.`status` = 1
					AND `brand`.`status` = 1
					AND  (".$product_like." OR brand.brand_name like '%".$search."%')
					GROUP BY `pd`.`product_unique_id`
					LIMIT 10";
			
			
		
			$query_prod = $this->db->query($sql);
			
				
			if($query_prod->num_rows() >0){
				$prod_result = $query_prod->result_object();
				
				
				foreach($prod_result as $product_details){
					$product_response = array();
					$product_response['id'] = $product_details->id;
					if($language==1){
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
					$product_response['rating'] = 0;
					
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
					
					$product_response['imgurl'] = $img;
					
					$product_array[] = $product_response;
				}
			}
		
		
		return $product_array;
    }
	
	
	function get_header_banner_request($section, $dimension){
		$this->db->select('*');
		
		$this->db->where(array('section'=>$section));
		$query = $this->db->get('homepage_banner');
		
		$banner_result = array();
		if($query->num_rows() >0){
			$home_result = $query->result_object();
			foreach($home_result as $banners){
				$img_decode1 = json_decode($banners->image);
				$banners->image = MEDIA_URL. $img_decode1->{$dimension};
				$banner_result[] = $banners;
			}
		}
		
		return $banner_result;
	}
	
	function get_home_section2_request($section){
		$this->db->select('*');
		
		$this->db->where(array('section'=>$section));
		$query = $this->db->get('homepage_banner');
		
		$banner_result = array();
		if($query->num_rows() >0){
			$banner_result = $query->result_object();
			
		}
		
		return $banner_result;
	}
	function get_header_section5_request($section){
		
		$query = $this->db->query('SELECT hb.*,cat.cat_name,cat.cat_name_ar,cat.cat_slug,cat.sub_title FROM `homepage_banner` hb, category cat WHERE hb.cat_id=cat.cat_id AND hb.section = "'.$section.'"');
		
		$banner_result = array();
		if($query->num_rows() >0){
			$banner_result = $query->result_object();
			
		}
		
		return $banner_result;
	}
	
	
	function get_category(){

       $prod_result = array();

       $product_array = array();

	   $start = 0;

	   $sortby = 1;

	   $devicetype = 1;


			$this->db->select('*');

			

			

			$this->db->where_in('parent_id','0');

			$this->db->limit(20,$start);

			

			$query_prod = $this->db->get('category');

			

			if($query_prod->num_rows() >0){

				$prod_result = $query_prod->result_object();

				

				$product_array = array();

				foreach($prod_result as $productdetails){

					$product_response = array();

					$product_response['id'] = $productdetails->cat_id;

					$product_response['name'] = $productdetails->cat_name;

					

					

					$product_response['imgurl'] = $productdetails->cat_img;

					$product_array[] = $product_response;

				}

			}

		

		

		return $product_array;

    }

	
	function get_home_products($language, $type){
       $prod_result = array();
       $product_array = array();
	   $start = 0;
	   $sortby = 1;
	   $devicetype = 1;
	   
	   if($type != 'New')
	   {
		
		$this->db->select('popular_product.product_id');
		$this->db->join('product_details', 'product_details.product_unique_id = popular_product.product_id','INNER');
		$this->db->join('vendor_product vp', 'product_details.product_unique_id = vp.product_id','INNER');
		$this->db->join('sellerlogin seller', 'vp.vendor_id = seller.seller_unique_id','INNER');
		$this->db->where(array('product_details.status'=>1,'vp.enable_status'=>1,'seller.status'=>1,'popular_product.type'=>$type));
		//$this->db->group_by("popular_product.prod_id"); 
		$this->db->order_by("popular_product.id",'ASC'); 
		
		$this->db->limit(15,$start);
		
		$query = $this->db->get('popular_product');
		
	   }
	   else
	   {
		   $this->db->select('product_unique_id as product_id');
		   $this->db->where(array('status'=>1));
		   $this->db->order_by("id",'DESC');
		   $this->db->limit(15,$start);
		   $query = $this->db->get('product_details');
	   }
		
		//print_r($this->db->last_query());    

		if($query->num_rows() >0){
			$category_result = $query->result_object();
		   
			$product_id = array();
			foreach($category_result as $cat_product){
			   $product_id[] = $cat_product->product_id;
			}
		 
				  
			//get products details
			$this->db->select('pd.product_unique_id as id , pd.prod_name as name, pd.prod_name_ar as name_ar,pd.web_url as web_url, pd.product_sku as sku, pd.featured_img as img , "active" as active,
				vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_sale_price price, vp1.product_stock as stock, vp1.product_remark as remark');
			
			
			$this->db->join('(SELECT vp.id as min_id,vp.product_id,  min(vp.product_sale_price) as mrp_min
				FROM vendor_product vp WHERE  vp.product_id IN('.$this->getValues($product_id).') AND vp.enable_status=1 group by vp.product_id  ) as vp2','pd.product_unique_id = vp2.product_id');
			$this->db->join('vendor_product vp1', 'vp1.product_id = vp2.product_id AND vp1.product_sale_price = vp2.mrp_min','INNER');
			$this->db->join('sellerlogin seller', 'vp1.vendor_id = seller.seller_unique_id','INNER');
			$this->db->where_in('pd.product_unique_id', $product_id);
			$this->db->where(array('pd.status' => 1,'vp1.enable_status'=>1,'seller.status'=>1));
			$this->db->group_by("pd.product_unique_id"); 
			
			if($type == 'New')
			{
				$this->db->order_by("pd.id",'DESC');
			}
			
			/*if($sortby==1){
				$this->db->order_by("vp2.mrp_min",'ASC'); 
			}else if($sortby==2){
				$this->db->order_by("vp2.mrp_min",'DESC'); 
			}else if($sortby==3){
				$this->db->order_by("pd.created_at",'DESC'); 
			}else if($sortby==4){
				$this->db->order_by("pd.prod_rating_count",'DESC'); 
			}*/
			
			$query_prod = $this->db->get('product_details as pd');
			
			if($query_prod->num_rows() >0){
				$prod_result = $query_prod->result_object();
				
				$product_array = array();
				foreach($prod_result as $product_details){
					$product_response = array();
					$product_response['id'] = $product_details->id;
					if($language ==1 ){
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
					$product_response['rating'] = 0;
					
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
					
					$product_response['imgurl'] = MEDIA_URL.$img;
					$product_array[] = $product_response;
				}
			}
		}
		
		return $product_array;
    }
	
	function get_home_cat_products($language, $catid){
       $prod_result = array();
       $product_array = array();
	   $start = 0;
	   $sortby = 1;
	   $devicetype = 1;
	  
		$this->db->select('product_category.prod_id');
		$this->db->join('product_details', 'product_details.product_unique_id = product_category.prod_id','INNER');
		$this->db->join('vendor_product vp', 'product_details.product_unique_id = vp.product_id','INNER');
		$this->db->join('sellerlogin seller', 'vp.vendor_id = seller.seller_unique_id','INNER');
		$this->db->where_in('product_category.cat_id', $catid);
		$this->db->where(array('product_details.status'=>1,'seller.status'=>1,'vp.enable_status'=>1));
		$this->db->group_by("product_category.prod_id"); 
		
		$this->db->limit(6,$start);
		
		$query = $this->db->get('product_category');
		
		if($query->num_rows() >0){
			$category_result = $query->result_object();
		   
			$product_id = array();
			foreach($category_result as $cat_product){
			   $product_id[] = $cat_product->prod_id;
			}
		 
				  
			//get products details
			$this->db->select('pd.product_unique_id as id , pd.prod_name as name, pd.prod_name_ar as name_ar,pd.prod_name_ar as name_ar,pd.web_url as web_url, pd.product_sku as sku, pd.featured_img as img , "active" as active,
				vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_sale_price price, vp1.product_stock as stock, vp1.product_remark as remark');
			
			
			$this->db->join('(SELECT vp.id as min_id,vp.product_id,  min(vp.product_sale_price) as mrp_min
				FROM vendor_product vp WHERE  vp.product_id IN('.$this->getValues($product_id).') AND vp.enable_status=1 group by vp.product_id  ) as vp2','pd.product_unique_id = vp2.product_id');
			$this->db->join('vendor_product vp1', 'vp1.product_id = vp2.product_id AND vp1.product_sale_price = vp2.mrp_min','INNER');
			$this->db->join('sellerlogin seller', 'vp1.vendor_id = seller.seller_unique_id','INNER');
			$this->db->where_in('pd.product_unique_id', $product_id);
			$this->db->where(array('pd.status' => 1,'vp1.enable_status'=>1,'seller.status'=>1));
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
				
				$product_array = array();
				foreach($prod_result as $product_details){
					$product_response = array();
					$product_response['id'] = $product_details->id;
					if($language ==1){
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
					$product_response['remark'] = html_entity_decode($product_details->remark);
					$product_response['rating'] = 0;
					
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
					
					$product_response['imgurl'] = MEDIA_URL.$img;
					$product_array[] = $product_response;
				}
			}
		}
		
		return $product_array;
    }
	
	
    //Functio for get recent product
    function get_recent_products_request($language, $devicetype,$product_ids){
       $prod_result = array();
       $product_array = array();
	   
		$start = 0;
		$sortby = 1;
		
		if($product_ids){
			  $product_id = explode(',',$product_ids);		 
				  
			//get products details
			$this->db->select('pd.product_unique_id as id , pd.prod_name as name,pd.prod_name_ar as name_ar,pd.web_url as web_url, pd.product_sku as sku, pd.featured_img as img , "active" as active,
				vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_sale_price price, vp1.product_stock as stock, vp1.product_remark as remark');
			
			
			$this->db->join('(SELECT vp.id as min_id,vp.product_id,  min(vp.product_sale_price) as mrp_min
				FROM vendor_product vp WHERE  vp.product_id IN('.$this->getValues($product_id).') AND vp.enable_status=1 group by vp.product_id  ) as vp2','pd.product_unique_id = vp2.product_id');
			$this->db->join('vendor_product vp1', 'vp1.product_id = vp2.product_id AND vp1.product_sale_price = vp2.mrp_min','INNER');
			$this->db->join('sellerlogin seller', 'vp1.vendor_id = seller.seller_unique_id','INNER');
			$this->db->where_in('pd.product_unique_id', $product_id);
			$this->db->where(array('pd.status' => 1,'vp1.enable_status'=>1,'seller.status'=>1));
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
			
			$this->db->limit(10,$start);
			$query_prod = $this->db->get('product_details as pd');
			
			if($query_prod->num_rows() >0){
				$prod_result = $query_prod->result_object();
				
				$product_array = array();
				foreach($prod_result as $product_details){
					$product_response = array();
					$product_response['id'] = $product_details->id;
					if($language==1){
						$product_response['name'] = html_entity_decode($product_details->name_ar);
					}else{
						$product_response['name'] = html_entity_decode($product_details->name);
					}
					$product_response['web_url'] = $product_details->web_url;
					$product_response['sku'] = $product_details->sku;
					$product_response['active'] = $product_details->active;
					$product_response['vendor_id'] = $product_details->vendor_id;
					$product_response['mrp'] = price_format($product_details->mrp);
					$product_response['price'] = price_format($product_details->price);
					$product_response['stock'] = $product_details->stock;
					$product_response['remark'] = html_entity_decode($product_details->remark);
					$product_response['rating'] = 0;
					
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
					
					$product_response['imgurl'] = $img;
					$product_array[] = $product_response;
				}
			}
		}
		
		return $product_array;
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
	
	
// Remove unnecessary words from the search term and return them as an array
function filterSearchKeys($query){
    $query = trim(preg_replace("/(\s+)+/", " ", $query));
    $words = array();
    // expand this list with your words.
   // $list = array("or","I","you","they","to","but","that","this","those","then");
    $c = 0;
    foreach(explode(" ", $query) as $key){
     //   if (in_array($key, $list)){
       //     continue;
        //}
        $words[] = trim($key);
        if ($c >= 15){
            break;
        }
        $c++;
    }
    return $words;
}

   
}

