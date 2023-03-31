<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function check_login_to_welcome()
{
    // Load session library
    $CI =& get_instance();
    $CI->load->library('session');
    
    // Check if user is logged in
    if ($CI->session->userdata('logged_in')) {
        // User is logged in, redirect to homepage
        redirect('homepage');
    } else {
        // User is not logged in, redirect to login page
        redirect('welcome');
    }
}

function check_login()
{
    // Load session library
    $CI =& get_instance();
    $CI->load->library('session');
    
    // Check if user is logged in
    if (!$CI->session->userdata('logged_in')) {
        // User is not logged in, redirect to login page
        redirect('login');
    }
}

function check_login_welcome()
{
    // Load session library
    $CI =& get_instance();
    $CI->load->library('session');
    
    // Check if user is logged in
    if ($CI->session->userdata('logged_in')) {
        // User is logged in, redirect to homepage
        redirect('homepage');
    }
}