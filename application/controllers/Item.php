<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("share_model");
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function display(){
		$data['items'] = $this->share_model->queryItem();
		$this->load->view('include/header' , $data);
		$this->load->view('item/display');
		$this->load->view('include/footer');
	}

	public function detail(){
		$this->load->view('include/header');
		$this->load->view('item/detail');
		$this->load->view('include/footer');
	}

	
}
