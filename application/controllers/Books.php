<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Books extends CI_Controller {

	function __construct(){
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function display(){
		$this->load->view('include/header');
		$this->load->view('books/display');
		$this->load->view('include/footer');
	}

	public function detail(){
		$this->load->view('include/header');
		$this->load->view('books/detail');
		$this->load->view('include/footer');
	}

	
}
