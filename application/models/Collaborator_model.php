<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Collaborator_model extends CI_Model {

    public function __construct()
    {
        $this->load->helper('db');
        parent::__construct();
    }

    public function get_all_collaborators()
    {
        $query = $this->db->get('collaborators');
        return $query->result_array();
    }

    public function create_collaborator($name, $email, $phone, $address_id, $user_id, $active)
    {
        $data = array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address_id' => $address_id,
            'user_id' => $user_id,
            'active' => $active
        );
        $this->db->insert('collaborators', $data);
        return $this->db->insert_id();
    }

    public function create_address($zip_code, $street, $number, $complement, $city, $state) {
        $data = array(
            'zip_code' => $zip_code,
            'street' => $street,
            'number' => $number,
            'complement' => $complement,
            'city' => $city,
            'state' => $state
        );

        // Insert the address
        $this->db->insert('addresses', $data);

        // Return the ID of the newly created address
        return $this->db->insert_id();
    }

    public function update_user_permission_level($user_id, $permission_level)
    {
        $this->db->where('user_id', $user_id);
        $this->db->update('users', array('permission_level' => $permission_level));
        return $this->db->affected_rows();
    }

    public function update_collaborator($id, $data)
    {
        $collaborator = get_collaborator_from_id($id);
        if (empty($collaborator)) {
            return false;
        }

        // Check if collaborator data has changed
        $has_changed = false;
        foreach ($data as $key => $value) {
            if ($collaborator[$key] !== $value) {
                $has_changed = true;
                break;
            }
        }

        // Update collaborator data if changed
        if ($has_changed) {
            $this->db->where('collaborator_id', $id);
            $this->db->update('collaborators', $data);
        }

        return true;
    }

    public function insert_or_update_collaborator_address($collaborator_address_data)
    {
        $collaborator_id = $collaborator_address_data['collaborator_id'];
        $address_id = $collaborator_address_data['address_id'];

        // Insert new collaborator addresses
        
        $data = array(
            'collaborator_id' => $collaborator_id,
            'address_id' => $address_id
        );
        $this->db->insert('collaborator_addresses', $data);
        
    }
    
}
