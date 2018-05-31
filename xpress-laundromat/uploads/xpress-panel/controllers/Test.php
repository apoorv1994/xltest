<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Test extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
    }

    function ashiv()
    {
    	echo json_encode($this->londury->_order($this->input->get(),1));
    }

}