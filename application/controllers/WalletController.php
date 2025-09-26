<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class WalletController extends REST_Controller
{
    protected $request_method = 'post';

    public function __construct()
    {
        parent::__construct();

        // Load Model
		$this->load->model('wallet_model');
    }

    public function index_get()
    {
        $this->responses(1, 'Server OK');
    }

    public function getIndexPage_get()
    {
		$user_id = $this->session->userdata('user_id');
		$this->data['bank_details'] = $this->wallet_model->check_bank_details($user_id);
		$this->data['wallet'] = $this->wallet_model->get_wallet_data();
        $this->data['wallet_summery'] = $this->wallet_model->get_wallet_summery($this->data['wallet']['wallet_id']);
        $this->data['wallet_bonus'] = $this->wallet_model->get_wallet_bonus($this->data['wallet']['wallet_id']);
		$this->load->view('website/user-wallet.php',$this->data);
    }

    public function add_wallet_get()
	{
		$user_id = $this->session->userdata('user_id');
		$this->data['bank_details'] = $this->wallet_model->check_bank_details($user_id);
		$this->data['wallet'] = $this->wallet_model->get_wallet_data();
        $this->data['wallet_summery'] = $this->wallet_model->get_wallet_summery($this->data['wallet']['wallet_id']);
        $this->data['wallet_bonus'] = $this->wallet_model->get_wallet_bonus($this->data['wallet']['wallet_id']);
        //print_r($this->data['wallet']['wallet_id']);die;
		$this->load->view('website/add_wallet.php',$this->data);
	}


	public function add_wallet_create_post()
	{
		$order_id = 'ord'.$this->random_strings_digit(10).date('dmYHi');
		$this->response([
		'order_id' => $order_id
		], self::HTTP_OK);
	}

	public function add_wallet_verify_post()
	{
	$razorpay_payment_id   = $this->input->post('razorpay_payment_id');
    //$razorpay_order_id     = $this->input->post('razorpay_order_id');
    //$razorpay_signature    = $this->input->post('razorpay_signature');
    //$full_razorpay_response= $this->input->post('full_razorpay_response'); 
    $amount                = $this->input->post('amount');

    $user_id = $this->session->userdata('user_id');


    $this->db->select('*');
	$this->db->where(array('user_unique_id' => $user_id));
	$query1 = $this->db->get('appuser_login');
	
	$user_result1 = $query1->result_object()[0];

    //$wallet_id = 'w_'.$this->random_strings(8);


	$this->db->select('*');
	$this->db->where(array('user_id' => $user_id));
	$query_wallet = $this->db->get('wallet_summery');
	$get_wallet = $query_wallet->result_object()[0];
	$old_amount = $get_wallet->amount;
	$walet_history_upd['amount'] = $old_amount + $amount;
	$wallet_id =$get_wallet->wallet_id;
	$this->db->where(array('user_id'=>$user_id));
	$this->db->update('wallet_summery', $walet_history_upd);
			
	// $data_wallet['user_id'] = $user_result1->user_unique_id;
	// $data_wallet['wallet_id'] = $wallet_id;
	// $data_wallet['amount'] = $amount;
	// $data_wallet['created_at'] = date('Y-m-d H:i:s');
	// $this->db->insert('wallet_summery',$data_wallet);


	$transaction_id = 'txt'.$this->random_strings_digit(3).date('dmYHi');

	$this->db->select('*');
	$this->db->where(array('wallet_id' => $wallet_id));
	$this->db->order_by('id','DESC');
	$this->db->limit(1,0);
	$query_wallet_his = $this->db->get('wallet_transaction_history');

	$old_balance = 0;
	if($query_wallet_his->num_rows() >0){
		$get_wallet = $query_wallet_his->result_object()[0];
	
		$old_balance = $get_wallet->balance;
	}		

	$data_wallet_history1['wallet_id'] = $wallet_id;
	$data_wallet_history1['payment_type'] = 5;
	$data_wallet_history1['transaction_id'] = $transaction_id;
	$data_wallet_history1['transaction_type'] = 'credit';
	$data_wallet_history1['amount'] = $amount;
	$data_wallet_history1['balance'] = $old_balance + $amount;
	$data_wallet_history1['product_id'] = '';
	$data_wallet_history1['order_id'] = '';
	$data_wallet_history1['user_id'] = $user_result1->user_unique_id;
	$data_wallet_history1['remark'] = 'Add Money to your Wallet';
	$data_wallet_history1['created_at'] = date('Y-m-d H:i:s');
	$this->db->insert('wallet_transaction_history',$data_wallet_history1);

	echo json_encode([
        "status"   => 'success',
        //"csrfHash" => $csrfHash
    ]);
    // ✅ If you want ALL parameters at once:
    //$allParams = $this->input->post();
    //print_r([$razorpay_payment_id,$amount]);die;

	}

	function random_strings($length_of_string){ 
  
		// String of all alphanumeric character 
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
  
		// Shufle the $str_result and returns substring 
		// of specified length 
		return substr(str_shuffle($str_result),0, $length_of_string); 
	}
	function random_strings_digit($length_of_string){ 
  
		// String of all alphanumeric character 
		$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
  
		// Shufle the $str_result and returns substring 
		// of specified length 
		return substr(str_shuffle($str_result),0, $length_of_string); 
	}

    public function getuserWalletTransaction_get()
    {
        $this->data['wallet'] = $this->wallet_model->get_wallet_data();
		$this->data['wallet_summery'] = $this->wallet_model->get_wallet_summery_full($this->data['wallet']['wallet_id']);
		$this->load->view('website/user-wallet-transaction.php',$this->data);
    }
	
	public function user_wallet_transaction_get($wallet_id)
    {
		$this->data['wallet_id'] = $wallet_id;
		$this->data['wallet_summery'] = $this->wallet_model->get_wallet_summery_full($wallet_id);
		$this->load->view('website/wallet_transaction_id_wise.php',$this->data);
    }
	
	function withdrow_money_get(){
		
		$user_id = $this->session->userdata('user_id');
		$amount = $this->input->get('amount');
		
		$response = $this->wallet_model->withdrow_money_request($user_id,$amount);
		
		$this->session->set_flashdata('withdrow_success_msg','Withdrawal Request Add Successfully.');
		return redirect('user-wallet'); 
	}
	
	function search_wallet_data_post(){
		
		$title = $this->input->post('title');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		
		$this->data['wallet'] = $this->wallet_model->get_wallet_data();
		
		$response = $this->wallet_model->search_wallet_data($title,$start_date,$end_date,$this->data['wallet']['wallet_id']);
		
		echo json_encode($response);
	}
	
	function search_wallet_data_id_wise_post(){
		
		$title = $this->input->post('title');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$wallet_id = $this->input->post('wallet_id');
		
		$response = $this->wallet_model->search_wallet_data($title,$start_date,$end_date,$wallet_id);
		
		echo json_encode($response);
	}

}
