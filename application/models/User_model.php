<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
  public function __construct() {
    parent::__construct();
    $this->load->database();
  }

  public function create_user($username, $email, $password) {
    $data = array(
      'name' => $username,
      'email' => $email,
      'password' => $password
    );

    return $this->db->insert('users', $data);
  }

  public function get_user_by_email($email) {
    $query = $this->db->get_where('users', array('email' => $email));
    return $query->row();
  }

  public function insert_user($data) {
    return $this->db->insert('usuarios', $data);
  }

  public function get_users() {
    // Select all columns except for the password field
    $this->db->select('user_id, name, email, permission_level');
    $this->db->from('users');
    $query = $this->db->get();
    
    // Return the result set as an array of objects
    return $query->result();
}
}