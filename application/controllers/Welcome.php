<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		check_login_welcome();
		$this->load->view('welcome_message');
	}
}
