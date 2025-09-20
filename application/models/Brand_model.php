<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brand_model extends CI_Model {

    public function __construct() {
        parent::__construct();
		
		$this->date_time = date('Y-m-d H:i:s');
    }

    //Functiofor for get category
    function get_brand_request($language, $devicetype){
       $category_result = array();
	   
		$this->db->select('brand_id,brand_name, brand_name_ar,brand_img');
		$this->db->where(array('status' => 1));
		$this->db->order_by('brand_name','ASC');
		$query = $this->db->get('brand');
		
		if($query->num_rows() >0){
		   $category_array = $query->result_object();
		   foreach($category_array as $cat_details){
			   $cat_response = array();
			   $cat_response['brand_id'] = $cat_details->brand_id;
			     // 1 arabic 2 english
			   if($language == 1){
				    $cat_response['brand_name'] = $cat_details->brand_name_ar;
			   }else{
					$cat_response['brand_name'] = $cat_details->brand_name;   
			   }
			   $cat_response['brand_name_link'] = $cat_details->brand_name; 
				$img_decode = json_decode($cat_details->brand_img);
				$img ='';
					
			   if($devicetype == 1){					
					if(isset($img_decode->{MOBILE})){
						$img = $img_decode->{MOBILE};
					}else{
						$img = $cat_details->brand_img;
					}
					
				}else{
					if(isset($img_decode->{DESKTOP})){
						$img = $img_decode->{DESKTOP};
					}else{
						$img = $cat_details->brand_img;
					}
				}
				$cat_response['imgurl'] = $img;
				$category_result[] = $cat_response;
		   }
		}
		
		return $category_result;
    }
	
	
	
    //Functiofor for get brand product
    function get_brand_product_request($language, $brand_name,$pageno,$sortby,$devicetype){
       $prod_result = array();
	   $product_array = array();
	//echo "name ".$brand_name;
		$brand_name = str_replace('%20',' ',$brand_name);
		$this->db->select('brand_id, brand_name, brand_name_ar');
		$this->db->where(array('brand_name' => $brand_name));
		$query0 = $this->db->get('brand');
		 $result0 = $query0->result_object();
		$brand_data = '';
		$data_array = array();
		$brandname_main =$brand_name;
		foreach($result0 as $id)
		{
			 $brand_data = $id->brand_id;
			 if($language == 1){
				  $brandname_main =$id->brand_name_ar;
			}else{
				 $brandname_main =$id->brand_name;
			}
			//print_r(json_decode(json_encode($id), true));
			//$data_array = json_decode(json_encode($id), true);
		}
		 $brand_id = $brand_data;
		//echo 'ddd'.$brand_id;
		//$brand_id = $data_array['brand_id'];
		//print_r($data_array['brand_id']);
	 
		
		
	 if($pageno >0){
		   $start = ($pageno*LIMIT_CAT);
	   }else{
		   $start = 0;
	   }
		
		  
			//get products details
			$this->db->select('vp1.product_sale_price as mrp_min, pd.product_unique_id as id , pd.prod_name as name,  pd.prod_name_ar as name_ar,pd.web_url as web_url, 
							pd.product_sku as sku, pd.featured_img as img , "active" as active,
							vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_stock as stock, vp1.product_remark as remark');
			
			$this->db->join('vendor_product vp1', 'vp1.product_id = pd.product_unique_id','INNER');
			$this->db->join('sellerlogin seller', 'vp1.vendor_id = seller.seller_unique_id','INNER');
			$this->db->join('brand brand', 'brand.brand_id = pd.brand_id','INNER');
			
			$this->db->where(array('pd.status' => 1,'vp1.enable_status'=>1,'seller.status'=>1,'brand.status' =>1,'pd.brand_id'=>$brand_id));
			$this->db->group_by("pd.product_unique_id"); 
			//echo "bane ".$brand_id;
			if($sortby==1){
				$this->db->order_by("mrp_min",'ASC'); 
			}else if($sortby==2){
				$this->db->order_by("mrp_min",'DESC'); 
			}else if($sortby==3){
				$this->db->order_by("pd.created_at",'DESC'); 
			}else if($sortby==4){
				$this->db->order_by("pd.prod_rating_count",'DESC'); 
			}
			
			$this->db->limit(LIMIT_CAT,$start);
			$query_prod = $this->db->get('product_details as pd');
			//print_r($this->db->last_query());die();
			if($query_prod->num_rows() >0){
				$prod_result = $query_prod->result_object();
				
				foreach($prod_result as $product_details){
					$product_response = array();
					$product_response['id'] = $product_details->id;
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
					$product_response['price'] = price_format($product_details->mrp_min);
					$product_response['stock'] = $product_details->stock;
					$product_response['remark'] = $product_details->remark;
					$product_response['rating'] = 0;
					
					$product_review_array1 = $this->get_product_review_count($product_details->id);

					if(!empty($product_review_array1))
					{
						$product_response['product_total_rating'] = $product_review_array1['total_rating'];
						$product_response['product_rating_count'] = $product_review_array1['rating_count'];
					}
					else
					{
						$product_response['product_total_rating'] = '0';
						$product_response['product_rating_count'] = '0';
					}
					
					$discount_per = 0;
					$discount_price = 0;
					if($product_details->mrp_min >0){
						$discount_price = ($product_details->mrp-$product_details->mrp_min);
						
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
					$product_response['imgurl'] = $img;
					$product_array[] = $product_response;
				}
			}
		
			//get products total
			$this->db->select('vp1.product_sale_price as mrp_min, pd.product_unique_id as id , pd.prod_name as name,pd.web_url as web_url, 
							pd.product_sku as sku, pd.featured_img as img , "active" as active,
							vp1.vendor_id, vp1.product_mrp as mrp, vp1.product_stock as stock, vp1.product_remark as remark');
			
			$this->db->join('vendor_product vp1', 'vp1.product_id = pd.product_unique_id','INNER');
			$this->db->join('sellerlogin seller', 'vp1.vendor_id = seller.seller_unique_id','INNER');
			$this->db->join('brand brand', 'brand.brand_id = pd.brand_id','INNER');
			
			$this->db->where(array('pd.status' => 1,'vp1.enable_status'=>1,'seller.status'=>1,'brand.status' =>1,'pd.brand_id'=>$brand_id));
			$this->db->group_by("pd.product_unique_id"); 
			
			$query_prod1 = $this->db->get('product_details as pd');
			$total_record = $query_prod1->num_rows();
		return array("product_array" =>$product_array,"total_count"=>$total_record,"brand_id"=>$brand_id,"brand_name"=>$brandname_main);
    }
	
	function get_product_review_count($prod_id, $pageno = '')
	{

		if ($pageno > 0) {
			$start = ($pageno * LIMIT);
		} else {
			$start = 0;
		}

		$this->db->select("pr.review_id,rating,pr.title as review_title,pr.comment as review_comment,pr.created_at as review_date, apl.fullname as user_name");
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
	
   
}
