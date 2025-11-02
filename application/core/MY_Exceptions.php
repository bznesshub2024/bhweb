<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Exceptions extends CI_Exceptions {

    function __construct() {
        parent::__construct();

        if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') {
            redirect("https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 'location', 301);
        }
    }

    // Overide the 404 error
    public function show_404($page = '', $log_error = TRUE)
    {
        // Since $this is not available, use $this->CI instead
        $this->CI =& get_instance();

        // Your awesome code here!
        // ...
    }
}