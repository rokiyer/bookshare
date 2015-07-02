<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct(){
		parent::__construct();
	}

	public function index(){

		$data = array();

		$this->load->view('include/header' , $data);
		$this->load->view('admin/index');
		$this->load->view('include/footer');
	}

	public function user(){

		$data = array();

		$this->load->view('include/header' , $data);
		$this->load->view('admin/user');
		$this->load->view('include/footer');

	}

	
}
