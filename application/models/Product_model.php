<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
      }

    public function register_product($data)
    {
        $this->db->insert('products', $data);
        return $this->db->insert_id();
    }

    public function disable_product($product_id)
    {
        $data = array(
            'active' => FALSE
        );
        $this->db->where('product_id', $product_id);
        $this->db->update('products', $data);
    }

    public function alter_product($product_id, $data)
    {
        $this->db->where('product_id', $product_id);
        $this->db->update('products', $data);
    }

    public function get_all_products() {
        $query = $this->db->get('products');
        return $query->result_array();
    }

    public function get_product_by_id($id)
    {
        $query = $this->db->get_where('products', array('product_id' => $id));
        return $query->row_array();
    }

}