<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

	public function __construct() {
    
		parent::__construct();
		//$this->load->helper('products');
		$this->load->model('Product_model');
		$this->load->library('form_validation');
		$this->load->library('session');
	}

	public function index()
	{
        check_login();
		// Load the products from the database
		$products = $this->Product_model->get_all_products();

		// Load the view to display the products
		$data = array('products' => $products);
		$this->load->view('products', $data);
	}

	public function create_products()
	{
        check_login();

		$this->load->view('create_products');
	}

	public function create_product_in_db()
	{
		// Check user permission level
		$permission_level = $this->session->userdata('permission_level');
		if ($permission_level !== 'admin' && $permission_level !== 'collaborator' && $permission_level !== 'supplier') {
			// Redirect to home page if user doesn't have appropriate permission level
			redirect(base_url());
		}
		
		// Load form validation library
		$this->load->library('form_validation');
		
		// Set validation rules
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$this->form_validation->set_rules('price', 'Price', 'required|numeric');
		$this->form_validation->set_rules('stock_quantity', 'Stock Quantity', 'required|numeric');
		$this->form_validation->set_rules('active', 'Active', 'required');
		
		// Check if form validation passed
		if ($this->form_validation->run() == FALSE) {
			// Load the create product form
			$this->load->view('create_product_form');
		} else {
			// Get form data
			$product_data = array(
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
				'price' => $this->input->post('price'),
				'stock_quantity' => $this->input->post('stock_quantity'),
				'active' => $this->input->post('active')
			);
			
			// Register the product in the database
			$this->Product_model->register_product($product_data);
			
			// Redirect to the products page

			$products = $this->Product_model->get_all_products();
			$data = array('products' => $products);
			$this->load->view('products', $data);
		}
	}


	public function edit_product()
	{
		// Get the product ID from the URL parameter
		$product_id = $this->input->get('id');
	
		// Load the product data from the database using the Product_model
		$product = $this->Product_model->get_product_by_id($product_id);
	
		// Load the edit_product view with the product data
		$data = array('product' => $product);
		$this->load->view('edit_product', $data);
	}

	public function update_product()
	{
		$product_id = $this->input->post('product_id');
		$name = $this->input->post('name');
		$description = $this->input->post('description');
		$price = $this->input->post('price');
		$stock_quantity = $this->input->post('stock_quantity');
		$active = $this->input->post('active') ? 1 : 0;

		$data = array(
			'name' => $name,
			'description' => $description,
			'price' => $price,
			'stock_quantity' => $stock_quantity,
			'active' => $active
		);

		$this->load->model('Product_model');
		$this->Product_model->alter_product($product_id, $data);

		redirect('products');
	}

}