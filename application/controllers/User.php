<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function register()
	{	
		$result = $this->session->userdata('user_id');
		if(!empty($result) ){
			redirect('space/profile');
		}

		$this->load->view('include/header');
		$this->load->view('user/register');
		$this->load->view('include/footer');
	}

	public function login()
	{
		$result = $this->session->userdata('user_id');
		if(!empty($result)){
			redirect('space/profile');
		}

		$this->load->view('include/header');
		$this->load->view('user/login');
		$this->load->view('include/footer');
	}

	public function processLogout(){
		$this->session->sess_destroy();
		redirect('user/logout');
	}

	public function logout(){
		$this->load->view('include/header');
		$this->load->view('user/logout');
		$this->load->view('include/footer');
	}

}
