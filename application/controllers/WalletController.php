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
