<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orders extends CI_Controller
{

	public function __construct()
	{

		parent::__construct();
		$this->load->model('Orders_model');
		$this->load->model('Product_model');
		$this->load->model('Collaborator_model');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->helper('db');
	}

	public function index()
	{
		check_login();
		$data['orders'] = $this->Orders_model->get_all_orders();

		// Fetch the order items for each order
		foreach ($data['orders'] as &$order) {
			$order_items = $this->Orders_model->get_order_items($order['order_id']);

			// Add the product information to each order item
			foreach ($order_items as &$item) {
				$product = $this->Product_model->get_product_by_id($item['product_id']);
				$item['product_name'] = $product['name'];
				$item['product_price'] = $product['price'];
			}

			$order['order_items'] = $order_items;
		}
		$this->load->view('orders', $data);
	}

	public function create_order()
	{
		check_login();
		// Load suppliers from database
		$data['suppliers'] = $this->Collaborator_model->get_all_collaborators();

		// Load products from database
		$data['products'] = $this->Product_model->get_all_products();

		// Load items for the order from session
		$items = $this->session->userdata('items');

		$data['items'] = $items ? $items : array();

		// Calculate the total price of all items
		$data['total'] = 0;
		foreach ($data['items'] as $item) {
			$data['total'] += $item['subtotal'];
		}

		// Check if the add_item button was clicked
		if ($this->input->post('add_item')) {
			// Get the selected product and supplier IDs and the quantity
			$product_id = $this->input->post('product_id');
			$supplier_id = $this->input->post('supplier_id');
			$quantity = $this->input->post('quantity');

			// Load the product and supplier data
			$product = $this->Product_model->get_product_by_id($product_id);
			$supplier = get_collaborator_from_id($supplier_id);

			// Calculate the subtotal
			$subtotal = $product['price'] * $quantity;

			// Add the item to the session data
			$items = $this->session->userdata('items');
			$items[] = array(
				'supplier_id' => $supplier_id,
				'product_id' => $product_id,
				'name' => $product['name'],
				'quantity' => $quantity,
				'price' => $product['price'],
				'subtotal' => $subtotal,
				'user_id' => $this->session->userdata('user_id'),
				'status' => 'active'
			);
			$this->session->set_userdata('items', $items);

			// Recalculate the total price of all items
			$data['total'] = 0;
			foreach ($items as $item) {
				$data['total'] += $item['subtotal'];
			}
			$data['items'] = $items;

		}


		// Load the view
		$this->load->view('create_order', $data);
	}

	public function remove_item($key)
	{
		// Get the items from the session
		$items = $this->session->userdata('items');

		// Load suppliers from database
		$data['suppliers'] = $this->Collaborator_model->get_all_collaborators();

		// Load products from database
		$data['products'] = $this->Product_model->get_all_products();

		// Check if the item exists in the session
		if (isset($items[$key])) {
			// Remove the item from the session
			unset($items[$key]);

			// Save the updated items to the session
			$this->session->set_userdata('items', $items);
		}

		// Update the $data array with the new items and total price
		$data['items'] = $items ? $items : array();
		$data['total'] = 0;
		if (isset($item['subtotal'])) {
			foreach ($data['items'] as $item) {
				$data['total'] += $item['subtotal'];
			}
		}

		// Load the view with the updated $data array
		$this->load->view('create_order', $data);
	}

	public function remove_item_from_update($index)
	{
		$order_data = $this->session->userdata('order_data');
		if (isset($order_data['order_items'][$index])) {
			unset($order_data['order_items'][$index]);
		}
		$this->session->set_userdata('order_data', $order_data);

		// Redirect back to the update order page
		$this->load->view('update_order');
	}

	public function create_order_db()
	{
		check_login();

		// Load the order items from session data
		$items = $this->session->userdata('items');

		// Check if there are any items
		if (!empty($items)) {
			// Get the user ID
			$user_id = $this->session->userdata('user_id');

			// Create the order in the database
			$order_id = $this->Orders_model->create_order(
				array(
					'observations' => $this->input->post('observations'),
					'user_id' => $user_id,
					'status' => 'active'
				)
			);

			// Add the order items to the database
			foreach ($items as $item) {
				$this->Orders_model->create_order_item($order_id, $item['supplier_id'], $item['product_id'], $item['quantity'], $item['subtotal']);
			}

			// Clear the session data
			$this->session->unset_userdata('items');

			// Redirect to the order confirmation page
			redirect('order_confirmation/' . $order_id);
		} else {
			// If there are no items, redirect back to the create order page
			redirect('create_order');
		}
	}

	public function order_confirmation($order_id)
	{
		$data['order_id'] = $order_id;
		$this->load->view('order_confirmation', $data);
	}


	public function update_order()
	{
		check_login();

		// Get the order ID from the session
		$order_id = $this->session->userdata('order_id');

		// Fetch the order details
		$order = $this->Orders_model->get_order_by_id($order_id);

		// Fetch the order items from database
		$order_items = $this->Orders_model->get_order_items($order_id);

		// Loop through the order items and fetch the product details for each item
		foreach ($order_items as &$item) {
			$product_id = $item['product_id'];
			$product = $this->Product_model->get_product_by_id($product_id);
			$item['product'] = $product['name'];
			$item['price'] = $product['price'];
		}

		// Get all collaborators and products
		$suppliers = $this->Collaborator_model->get_all_collaborators();
		$products = $this->Product_model->get_all_products();

		// Check if the form was submitted to add a new item
		if ($this->input->post('add_item')) {
			// Get the product ID and quantity from the form
			$product_id = $this->input->post('product_id');
			$quantity = $this->input->post('quantity');

			// Get the product details
			$product = $this->Product_model->get_product_by_id($product_id);

			// Add the new item to the session
			$new_item = array(
				'product_id' => $product_id,
				'quantity' => $quantity,
				'price' => $product['price'],
				'product' => $product['name']
			);
			$order_items[] = $new_item;
			$this->session->set_userdata('order_items', $order_items);

			// Redirect to the update order page to refresh the view with the new item
			redirect('update_order');
		}

		// Pass the order, order items, collaborators, and products to the view
		$data = array(
			'order' => $order,
			'order_items' => $order_items,
			'suppliers' => $suppliers,
			'products' => $products
		);

		$this->session->set_userdata('order_data', $data);

		$this->load->view('update_order');
	}

	public function add_item_to_session()
	{
		$product_id = $this->input->post('product_id');
		$supplier_id = $this->input->post('supplier_id');
		$quantity = $this->input->post('quantity');

		// Fetch the product details
		$product = $this->Product_model->get_product_by_id($product_id);

		// Calculate the subtotal for this item
		$subtotal = $quantity * $product['price'];

		// Add the item to the session
		$new_item = array(
			'supplier_id' => $supplier_id,
			'product_id' => $product_id,
			'product' => $product['name'],
			'quantity' => $quantity,
			'subtotal' => $subtotal,
			'price' => $product['price'],
		);
		$order_data = $this->session->userdata('order_data');

		$order_data['order_items'][] = $new_item;

		$this->session->set_userdata('order_data', $order_data);

		// Redirect back to the update order page
		$this->load->view('update_order');
	}


	public function update_order_db()
	{
		$order_data = $this->session->userdata('order_data');

		// Get the order ID from the first item in the order data
		$order_id = $this->session->userdata('order_id');

		// Get the existing order items for this order
		$existing_items = $this->Orders_model->get_order_items($order_id);
		// Check for removed items
		foreach ($existing_items as $existing_item) {
			$item_exists = false;
			foreach ($order_data['order_items'] as $new_item) {
				if (isset($new_item['order_item_id']) && is_array($new_item) && $new_item['order_item_id'] == $existing_item['order_item_id']) {
					$item_exists = true;
					break;
				}
			}

			if (!$item_exists) {
				// Item has been removed, delete it
				$this->Orders_model->delete_order_item($existing_item['order_item_id']);
			}
		}

		// Update or insert order items
		foreach ($order_data['order_items'] as $new_item) {
			if (isset($new_item['order_item_id'])) {
				// Item already exists, update it
				$this->Orders_model->update_order_item($new_item['order_item_id'], $new_item);
			} else {
				// Item is new, insert it
				$this->Orders_model->insert_order_item($new_item, $order_id);
			}
		}


		$data = array(
			'observations' => $order_data['order']["observations"],
			'status' => $order_data['order']["status"]
		);

		$this->Orders_model->update_order($order_id, $data);

		// Clear the order data from the session
		$this->session->unset_userdata('order_data');
		$this->session->unset_userdata('order_id');

		// Redirect to the order confirmation page
		redirect('order_confirmation/' . $order_id);
	}

	public function set_order_id()
	{

		$_SESSION['order_id'] = $_POST['orderId'];
		// You can also return a response if needed
		echo "Order ID set successfully";
	}

	public function set_status_session()
	{

		// Get the current order data from the session
		$order_data = $this->session->userdata('order_data');

		// Update the order data with the new observations and status values
		$order_data['order']['observations'] = $this->input->post('observations');
		$order_data['order']['status'] = $this->input->post('status');

		// Store the updated order data in the session
		$this->session->set_userdata('order_data', $order_data);

		echo 'Status and observations saved to session';
	}

}