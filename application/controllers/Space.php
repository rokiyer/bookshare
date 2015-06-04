<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Space extends CI_Controller {

	private $user_id;

	function __construct(){
		parent::__construct();

		if(empty($this->session->userdata('user_id')) ){
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

		$user_info['create_time'] = date("Y-m-d" , $user_info['create_time']);

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

	public function upload()
	{
		$this->load->model("books_model");
		$book_info = $this->books_model->getDataFromDoubanByISBN('9787115145543');

		$author_str = "";
		foreach ($book_info['authors'] as $key => $value) {
			$author_str .= $value . "<br>";
		}
		$book_info['authors'] = $author_str ;

		$translators_str = "";
		foreach ($book_info['translators'] as $key => $value) {
			$translators_str .= $value . "<br>";
		}
		$book_info['translators'] = $translators_str ;

		$this->load->view('include/header' , $book_info);
		$this->load->view('space/nav');
		$this->load->view('space/upload');
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
