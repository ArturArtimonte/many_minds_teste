<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Orders_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function create_order($data)
    {
        $this->db->insert('orders', $data);
        return $this->db->insert_id();
    }

    public function delete_order_item($order_item_id)
    {
        $this->db->where('order_item_id', $order_item_id);
        $this->db->delete('order_items');
    }

    public function create_order_item($order_id, $supplier_id, $product_id, $quantity, $unit_price)
    {
        $data = array(
            'order_id' => $order_id,
            'supplier_id' => $supplier_id,
            'product_id' => $product_id,
            'quantity' => $quantity,
            'unit_price' => $unit_price
        );
        $this->db->insert('order_items', $data);
        return $this->db->insert_id();
    }

    public function insert_order_item($new_item, $order_id)
    {
        $data = array(
            'order_id' => $order_id,
            'supplier_id' => $new_item['supplier_id'],
            'product_id' => $new_item['product_id'],
            'quantity' => $new_item['quantity'],
            'unit_price' => $new_item['price']
        );
        $this->db->insert('order_items', $data);
        return $this->db->insert_id();
    }

    public function get_all_orders()
    {
        $query = $this->db->get('orders');
        return $query->result_array();
    }

    public function get_order_by_id($order_id)
    {
        $this->db->where('order_id', $order_id);
        $query = $this->db->get('orders');
        return $query->row_array();
    }

    public function get_order_items($order_id)
    {
        $this->db->where('order_id', $order_id);
        $query = $this->db->get('order_items');
        return $query->result_array();
    }

    public function update_order($order_id, $data)
    {
        $this->db->set($data);
        $this->db->where('order_id', $order_id);
        $this->db->update('orders');
    }

    public function update_order_item($order_item_id, $new_item)
    {
        $this->db->where('order_item_id', $order_item_id);
        $this->db->update('order_items', array(
            'order_id' => $new_item['order_id'],
            'supplier_id' => $new_item['supplier_id'],
            'product_id' => $new_item['product_id'],
            'quantity' => $new_item['quantity'],
            'unit_price' => $new_item['price']
        )
        );
    }

}