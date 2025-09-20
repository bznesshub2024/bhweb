<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'third_party/razorpay/Razorpay.php';
require_once APPPATH . 'third_party/razorpay/src/Api.php';
require_once APPPATH . 'third_party/razorpay/src/Request.php';
require_once APPPATH . 'third_party/razorpay/src/Utility.php';
require_once APPPATH . 'third_party/razorpay/libs/Requests-2.0.4/src/Exception.php';
require_once APPPATH . 'third_party/razorpay/src/Errors/Error.php';
require_once APPPATH . 'third_party/razorpay/src/Errors/SignatureVerificationError.php';

use Razorpay\Api\Api;

class Razorpay extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Load Razorpay API key and secret key from config
        $this->load->config('razorpay');
        $this->api_key = $this->config->item('live_key');
        $this->api_secret = $this->config->item('live_secret');
    }

    public function capturePayment()
    {
        $payment_id = $this->input->get('payment_id');
        $amount = $this->input->get('amount');

        // Initialize Razorpay
        $api = new Api($this->api_key, $this->api_secret);

        try {
            // Capture payment
            $payment = $api->payment->fetch($payment_id)->capture(array('amount' => $amount));

            // Payment captured successfully
            // Handle success
            echo "Payment Captured";
        } catch (\Exception $e) {
            // Handle error
            echo $e->getMessage();
        }
    }
}
