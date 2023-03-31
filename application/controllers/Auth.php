<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//namespace App\Controllers;

class Auth extends CI_Controller {

  public function __construct() {
    
      parent::__construct();
      $this->load->model('User_model');
      $this->load->library('form_validation');
      $this->load->library('session');
  }

  public function register() {

      $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.name]');
      $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
      $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|regex_match[/\d/]');
      $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');

      if ($this->form_validation->run() == FALSE) {
          // validation failed, show registration form with errors
          $validation_errors = validation_errors();
          if(strpos($validation_errors, 'is already taken') !== false) {
              $validation_errors = 'Username or email is already taken';
          }
          $this->load->view('register', ['validation_errors' => $validation_errors]);
      } else {
          // validation succeeded, create new user
          $name = $this->input->post('username');
          $email = $this->input->post('email');
          $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
          $this->User_model->create_user($name, $email, $password);
          $this->load->view('registration_success');
      }
  }

  public function login(){

    if ($this->session->userdata('logged_in')) {
        // User is logged in, redirect to homepage
        redirect('homepage');
    }
    
    $login_attempts = $this->session->userdata('login_attempts');
    $ip_address = $_SERVER['REMOTE_ADDR'];
    //$login_locked = $this->session->userdata('login_locked');
    
      // Validate the form data
      $this->form_validation->set_rules('email', 'Email', 'required');
      $this->form_validation->set_rules('password', 'Password', 'required');
   
      if ($this->form_validation->run() == FALSE) {
          // Return a validation error response
          $errors = validation_errors();
          $this->load->view('welcome_message', ['validation_errors' => $errors]);
      } else {
          // Check the user's credentials
          $email = $this->input->post('email');
          $password = $this->input->post('password');
        
          $login_locked = is_login_locked($email, $ip_address);
          $this->load->model('User_model');
          $user = $this->User_model->get_user_by_email($email);

          if (is_login_locked($email)) {
            echo json_encode(array('status' => 'error', 'message' => 'Too many login attempts. Please try again later.', 'login-try' => $login_attempts, 'login-lock' => $login_locked ));
            exit;
            }

          if ($user && password_verify($password, $user->password)) {
            // Login successful
            $this->session->set_userdata('logged_in', '1');
            $this->session->set_userdata('user_id', $user->user_id);
            $this->session->set_userdata('name', $user->name);
            $this->session->set_userdata('permission_level', $user->permission_level);
            echo json_encode(array('status' => 'success'));
            exit;
        } else {
            // Login failed
            increment_login_attempts($email);
            //$this->load->view('welcome_message');
            echo json_encode(array('status' => 'error', 'message' => 'Usuário ou senha inválidos.', 'login-try' => $login_attempts, 'login-lock' => $login_locked ));
            exit;
        }
        
      }
  }


  public function logout() {
      // destroy user session and redirect to login page
      $this->session->sess_destroy();
      redirect('login');
  }

  public function registration_sucess() {
    $this->load->view('registration_success');
  }

}

