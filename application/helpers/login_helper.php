<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function increment_login_attempts($email) {
    $CI =& get_instance();
    $CI->load->library('session');

    // Get the login attempts array
    $login_attempts = $CI->session->userdata('login_attempts') ?? array();

    // Remove login attempts older than 5 minutes
    $current_time = time();
    foreach ($login_attempts as $email_key => $email_attempts) {
        foreach ($email_attempts['attempts'] as $timestamp_key => $timestamp) {
            if ($timestamp < $current_time - 30) {
                unset($login_attempts[$email_key]['attempts'][$timestamp_key]);
            }
        }
        // If there are no attempts left for this email, remove it from the array
        if (empty($login_attempts[$email_key]['attempts'])) {
            unset($login_attempts[$email_key]);
        }
    }

    // Add a new login attempt
    if (!isset($login_attempts[$email])) {
        $login_attempts[$email] = array('attempts' => array());
    }
    $login_attempts[$email]['attempts'][$current_time] = $current_time;

    // Save the new attempt and counter values in the session
    $CI->session->set_userdata('login_attempts', $login_attempts);

    // Lock the user out after 3 failed attempts
    $failed_attempts = isset($login_attempts[$email]) ? $login_attempts[$email]['attempts'] : array();
    if (count($failed_attempts) >= 3) {
        $CI->session->set_userdata('login_locked', 'true');
    }
}


function is_login_locked($email) {
    $CI =& get_instance();
    $CI->load->library('session');

    // Get the login attempts array
    $login_attempts = $CI->session->userdata('login_attempts') ?? array();

    // Remove login attempts older than 5 minutes
    $current_time = time();
    foreach ($login_attempts as $email_key => $email_attempts) {
        foreach ($email_attempts['attempts'] as $timestamp_key => $timestamp) {
            if ($timestamp < $current_time - 30) {
                unset($login_attempts[$email_key]['attempts'][$timestamp_key]);
            }
        }
        // If there are no attempts left for this email, remove it from the array
        if (empty($login_attempts[$email_key]['attempts'])) {
            unset($login_attempts[$email_key]);
        }
    }

    // Add a new login attempt
    if (!isset($login_attempts[$email])) {
        $login_attempts[$email] = array('attempts' => array());
    }
    $login_attempts[$email]['attempts'][$current_time] = $current_time;

    // Save the new attempt and counter values in the session
    $CI->session->set_userdata('login_attempts', $login_attempts);

    // Check if the user is locked out
    $failed_attempts = $login_attempts[$email]['attempts'];
    if (count($failed_attempts) < 3) {
        $CI->session->unset_userdata('login_locked');
        return false;
    }

    $login_locked = $CI->session->userdata('login_locked');
    if (!$login_locked) {
        $CI->session->set_userdata('login_locked', $current_time);
        return false;
    }

    // Check how long the account has been locked out
    $time_since_lock = $current_time - $login_locked;

    // Unlock the account after 5 minutes
    if ($time_since_lock >= 300) {
        $CI->session->unset_userdata('login_locked');
        $CI->session->unset_userdata('login_attempts');
        return false;
    }

    return true;
}