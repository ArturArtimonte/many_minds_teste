<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accounts extends CI_Controller {

	public function __construct() {
    
		parent::__construct();
		$this->load->helper('db');
		$this->load->model('User_model');
		$this->load->model('Collaborator_model');
		$this->load->library('form_validation');
		$this->load->library('session');
	}

	public function index()
	{
        check_login();
		$this->load->view('accounts');
	}

	public function create_collaborator_page(){
		check_login();
		$this->load->view('create_colab');
	}

	public function create_collaborator()
	{
		// Get the form values
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$zip_code = $this->input->post('zip_code');
		$street = $this->input->post('street');
		$number = $this->input->post('number');
		$complement = $this->input->post('complement');
		$city = $this->input->post('city');
		$state = $this->input->post('state');
		$permission_level = $this->input->post('permission_level');
		$user_id = $this->input->post('user_id');


		// Create a new address
		$address_id = $this->Collaborator_model->create_address($zip_code, $street, $number, $complement, $city, $state);

		// Create a new collaborator
		$collaborator_id = $this->Collaborator_model->create_collaborator($name, $email, $phone, $address_id, $user_id, true);

		// Insert or update the collaborator address
		$this->Collaborator_model->insert_or_update_collaborator_address(array(
			'collaborator_id' => $collaborator_id,
			'address_id' => $address_id
		));

		// Update the user's permission level
		$this->Collaborator_model->update_user_permission_level($user_id, $permission_level);

		// Redirect to the collaborators page
		redirect('collaborators');
	}

	public function create_collaborator_no_user()
	{
		// Get the form values
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$zip_code = $this->input->post('zip_code');
		$street = $this->input->post('street');
		$number = $this->input->post('number');
		$complement = $this->input->post('complement');
		$city = $this->input->post('city');
		$state = $this->input->post('state');
		$user_id = '1';

		// Create a new address
		$address_id = $this->Collaborator_model->create_address($zip_code, $street, $number, $complement, $city, $state);

		// Create a new collaborator
		$collaborator_id = $this->Collaborator_model->create_collaborator($name, $email, $phone, $address_id, $user_id, true);

		// Insert or update the collaborator address
		$this->Collaborator_model->insert_or_update_collaborator_address(array(
			'collaborator_id' => $collaborator_id,
			'address_id' => $address_id
		));

		// Redirect to the collaborators page
		redirect('collaborators');
	}

	public function get_users() {
		// Load the User_model
		$this->load->model('User_model');
		
		// Fetch a list of all users
		$users = $this->User_model->get_users();
		
		// Return the list of users as a JSON-encoded array
		echo json_encode($users);
	}

	public function alter_collaborator()
	{
		$this->load->view('alter_colab');
	}

	public function update_collaborator()
	{
		$this->load->model('Collaborator_model');
		$this->load->model('Address_model');
		$id = $_GET['id'];

		$collaborator = get_collaborator_from_id($id);

		if (empty($collaborator)) {
			show_404();
		}

		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$active = $this->input->post('active') ? 1 : 0;
		$zip_code = $this->input->post('zip_code');
		$street = $this->input->post('street');
		$number = $this->input->post('number');
		$complement = $this->input->post('complement');
		$city = $this->input->post('city');
		$state = $this->input->post('state');

		// Insert new address
		$address_data = array(
			'zip_code' => $zip_code,
			'street' => $street,
			'number' => $number,
			'complement' => $complement,
			'city' => $city,
			'state' => $state
		);
		$address_id = $this->Address_model->add_address($address_data);

		// Insert or update collaborator address relation
		$collaborator_address_data = array(
			'collaborator_id' => $id,
			'address_id' => $address_id
		);
		
		$this->Collaborator_model->insert_or_update_collaborator_address($collaborator_address_data);

		// Update collaborator
		$collaborator_data = array(
			'name' => $name,
			'email' => $email,
			'phone' => $phone,
			'active' => $active
		);
		$this->Collaborator_model->update_collaborator($id, $collaborator_data);

		return "sucess";
	}
}