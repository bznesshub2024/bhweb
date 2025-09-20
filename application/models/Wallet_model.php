<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wallet_model extends CI_Model {

    public function __construct() {
        parent::__construct();
		
		$this->date_time = date('Y-m-d H:i:s');
    }
	
	
	function get_wallet_data(){
		
		$this->db->select('amount,wallet_id');
		$this->db->where(array('user_id' => $this->session->userdata('user_id')));
		$query = $this->db->get('wallet_summery');
		
		$wallet_result = array();
		if($query->result_object()){
			$user_result = $query->result_object()[0];
			$wallet_result['amount'] = $user_result->amount;
			$wallet_result['wallet_id'] = $user_result->wallet_id; 
		}
		return $wallet_result;
	}
	
	function check_bank_details($user_id){
		
		$this->db->select('id');
		$this->db->where(array('user_id' => $user_id));
		$this->db->order_by("id", 'desc');
		
		
		$query = $this->db->get('bank_details');
		
		$cart_result = array();
		if($query->num_rows() >0){
			
			$data_result = $query->result_object()[0];		
			$cart_result['id'] = $data_result->id;	
		}
		else
		{
			$cart_result['id'] = '0';
		}
		return $cart_result;
	}
	
	function get_wallet_summery($wallet_id){
		
		$this->db->select("*");
		$this->db->where(array('wallet_id' => $wallet_id));
		$this->db->order_by("id", 'desc');
		$this->db->limit(8,0);
		
		
		$query = $this->db->get('wallet_transaction_history');
		
		$cart_result = array();
		if($query->num_rows() >0){
			$cart_result = $query->result_object();			
		}
		return $cart_result;
	}
	
	function get_wallet_bonus($wallet_id){
		
		$this->db->select("*");
		$this->db->where(array('wallet_id' => $wallet_id));
		$this->db->order_by("id", 'desc');
		
		
		$query = $this->db->get('wallet_transaction_history');
		
		$cart_result = array();
		if($query->num_rows() >0){
			$cart_result = $query->result_object();			
		}
		return $cart_result;
	}
	
	function get_wallet_summery_full($wallet_id){
		
		$this->db->select("*");
		$this->db->where(array('wallet_id' => $wallet_id));
		$this->db->order_by("id", 'desc');
		
		$query = $this->db->get('wallet_transaction_history');
		
		$cart_result = array();
		if($query->num_rows() >0){
			$cart_result = $query->result_object();			
		}
		return $cart_result;
	}
	
	function search_wallet_data($title,$start_date,$end_date,$wallet_id){
		
		$title_like = '';
		
		$this->db->where(array('wallet_id' => $wallet_id));
		$this->db->select("*");
		if($start_date != '' && $end_date != '') {
			
			$this->db->where('DATE(created_at) >=', date('Y-m-d',strtotime($start_date)));
			$this->db->where('DATE(created_at) <=', date('Y-m-d',strtotime($end_date)));
			/*$this->db->where('created_at >=', $start_date);
			$this->db->where('created_at <=', $end_date);*/
		}
		$this->db->like('remark', $title);
		

		
		$query = $this->db->get('wallet_transaction_history');
		$cart_result = array();
		if($query->num_rows() >0){
			$cart_result = $query->result_object();			
		}
		return $cart_result;
	}
	
	function withdrow_money_request($user_id,$amount)
	{
		$data['user_id'] = $user_id;
		$data['amount'] = $amount;
		$data['created_at'] = $this->date_time;
		
		
		$this->db->insert('wallet_withdrow',$data);
	}
}
