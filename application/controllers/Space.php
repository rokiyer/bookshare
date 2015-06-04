<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Space extends CI_Controller {

	private $user_id;

	function __construct(){
		parent::__construct();
		if(isLogin() == FALSE){
			redirect('user/login');
		}

		$this->user_id = $this->session->userdata('user_id');
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function profile()
	{
		$this->load->model('user_model');
		$user_info = $this->user_model->getUserInfo($this->user_id);

		$user_info['create_time'] = date("Y-m-d" , strtotime($user_info['create_time']) );
		$user_info['user_id'] = $user_info['id'];

		$this->load->view('include/header' , $user_info);
		$this->load->view('space/nav');
		$this->load->view('space/profile');
		$this->load->view('include/footer');
	}

	public function display()
	{
		$this->load->model('user_model');
		$user_books = $this->user_model->getuserBooks($this->user_id);

		$this->load->view('include/header' , $user_books);
		$this->load->view('space/nav');
		$this->load->view('space/books');
		$this->load->view('include/footer');
	}

	public function share()
	{
		$isbn = $this->input->get("isbn");
		$this->load->model("books_model");
		$data['msg'] = 0;
		if(!empty($isbn)){
			$isbn = trim($isbn);
			$data = $this->books_model->getBookInfoByISBN($isbn);
			if($data == FALSE)
				$data['msg'] = 2;
			else
				$data['msg'] = 1;
				
			$data['isbn'] = $isbn;
		}

		$this->load->view('include/header' , $data);
		$this->load->view('space/nav');
		if(!empty($isbn) AND $data['msg'] == 1)
			$this->load->view('space/share');
		else
			$this->load->view('space/share_init');
		$this->load->view('include/footer');
	}

	public function modify()
	{
		$this->load->view('include/header');
		$this->load->view('space/nav');
		$this->load->view('space/modify');
		$this->load->view('include/footer');
	}
	
}
