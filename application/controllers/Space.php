<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Space extends CI_Controller {

	function __construct(){
		parent::__construct();
		if(isLogin() == FALSE){
			redirect('user/login');
		}
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function basic()
	{
		$this->load->view('include/header');
		$this->load->view('space/basic');
		$this->load->view('include/footer');
	}

	public function books()
	{
		$this->load->view('include/header');
		$this->load->view('space/books');
		$this->load->view('include/footer');
	}

	public function upload()
	{
		$this->load->view('include/header');
		$this->load->view('space/upload');
		$this->load->view('include/footer');
	}

	public function modify()
	{
		$this->load->view('include/header');
		$this->load->view('space/modify');
		$this->load->view('include/footer');
	}

	
}
