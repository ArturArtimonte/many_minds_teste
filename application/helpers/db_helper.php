<?php
defined('BASEPATH') or exit('No direct script access allowed');

function get_collaborators()
{
    $CI =& get_instance();
    $CI->db->select('*');
    $CI->db->from('collaborators');
    $query = $CI->db->get();
    return $query->result_array();
}

function get_collaborator_from_id($collaborator_id)
{
    $CI =& get_instance();
    $CI->db->select('*');
    $CI->db->from('collaborators');
    $CI->db->where('collaborator_id', $collaborator_id);
    $query = $CI->db->get();
    return $query->row_array();
}