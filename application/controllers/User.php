<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function register()
	{
		if(!empty($this->session->userdata('user_id')) ){
			redirect('space/basic');
		}

		$this->load->view('include/header');
		$this->load->view('user/register');
		$this->load->view('include/footer');
	}

	public function login()
	{
		if(!empty($this->session->userdata('user_id')) ){
			redirect('space/basic');
		}

		$this->load->view('include/header');
		$this->load->view('user/login');
		$this->load->view('include/footer');
	}

	public function logout(){
		$this->session->sess_destroy();

		$this->load->view('include/header');
		$this->load->view('user/logout');
		$this->load->view('include/footer');
	}

}
