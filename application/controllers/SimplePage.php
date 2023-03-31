<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SimplePage extends CI_Controller {

    public function index()
    {
        // Load view for simple page
        $this->load->view('simplepage');
    }

}
