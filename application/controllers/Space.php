<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Space extends CI_Controller {

	private $user_id;
	private $limit = 4;

	function __construct(){
		parent::__construct();
		if(isLogin() == FALSE){
			redirect('user/login');
		}

		$this->user_id = $this->session->userdata('user_id');
		$this->load->model('user_model');
	}

	public function index()
	{
		redirect('space/profile');
		$this->load->view('welcome_message');
	}

	public function profile()
	{
		$user_info = $this->user_model->getUserInfo($this->user_id);

		$user_info['create_time'] = date("Y-m-d" , strtotime($user_info['create_time']) );
		$user_info['user_id'] = $user_info['id'];

		$this->load->view('include/header' , $user_info);
		$this->load->view('space/nav');
		$this->load->view('space/profile');
		$this->load->view('include/footer');
	}

	public function profile_edit()
	{
		$user_info = $this->user_model->getUserInfo($this->user_id);

		$user_info['create_time'] = date("Y-m-d" , strtotime($user_info['create_time']) );
		$user_info['user_id'] = $user_info['id'];

		$this->load->view('include/header' , $user_info);
		$this->load->view('space/profile_edit');
		$this->load->view('include/footer');
	}

	public function profile_pwd(){

		$result = 0;

		if($this->input->get_post("submit")){
			$input = array(
				'cpwd' => $this->input->get_post('cpwd'),
				'npwd1' => $this->input->get_post('npwd1'),
				'npwd2' => $this->input->get_post('npwd2'),
			);

			$result = $this->user_model->changePwd($input , $this->user_id);
		}

		$data = array(
			'result' => $result 
			);
		
		$this->load->view('include/header' , $data);
		$this->load->view('space/profile_pwd');
		$this->load->view('include/footer');

	}

	public function display()
	{
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

	public function items()
	{
		$offset = $this->input->get_post('offset');
		$limit = $this->limit;

		$data = array();
		$data['title'] = "Books on sharing" ;
		$data['search_data'] = array(
			'keyword' => $this->input->get_post('keyword'),
			'item_status' => array(1,2) ,
			'user_id' => $this->session->userdata['user_id'] ,
			'order_time' => $this->input->get_post('order_time'),
			'order_name' => $this->input->get_post('order_name'),
		);

		list( $data['total'] , $data['items']) = $this->query_model->queryItem( $data['search_data'] , $limit , $offset );

		foreach ($data["items"] as $key => $item) {
			$book_id = $item['book_id'];
			$data["items"][$key]['authors'] = $this->query_model->queryBookAuthors($book_id);
			$data["items"][$key]['translators'] = $this->query_model->queryBookTranslators($book_id);
		}

		unset($data['search_data']['item_status']);

		$data['link_time'] = url_maker( $data['search_data'] , 'space/' . __FUNCTION__  , 
			array('name'=>'order_time','value'=>(1-$data['search_data']['order_time']) ));
		$data['link_name'] = url_maker( $data['search_data'] , 'space/' . __FUNCTION__  , 
			array('name'=>'order_name','value'=>(1-$data['search_data']['order_name']) ));

		$link_config = array(
			'total' => $data['total'],
			'offset' => $offset,
			'limit' => $limit,
			'search_data' => $data['search_data'] ,
			'pre_url' => 'space/' . __FUNCTION__  ,
			);
		$this->load->model("pagination_model");
		$data['link_array'] = $this->pagination_model->create_link($link_config);

		$this->load->view('include/header' , $data);
		$this->load->view('space/nav');
		$this->load->view('space/items');
		$this->load->view('include/footer');
	}

	public function item_edit($item_id){
		$data = array();
		$data['item_id'] = $item_id;

		list( $total , $items ) = $this->query_model->queryItem( $data );
		$item = $items[0];
		$book_id = $item['book_id'];
		$item['authors'] = $this->query_model->queryBookAuthors($book_id);
		$item['translators'] = $this->query_model->queryBookTranslators($book_id);

		$data['item'] = $item;

		$this->load->view('include/header' , $data);
		$this->load->view('space/nav');
		$this->load->view('space/item_edit');
		$this->load->view('include/footer');
	}

	public function shared(){
		$offset = $this->input->get_post('offset');
		$limit = $this->limit;

		$data = array();
		$data['title'] = "Books on sharing" ;
		$data['search_data'] = array(
			 // trade_status = 1 someone request , 2 accept , 3 deny , 4 cancel , 5 return ,
			'owner_id' => $this->session->userdata['user_id']
		);

		list( $data['total'] , $data['trades']) = $this->query_model->queryTrade( $data['search_data'] , $limit , $offset );

		foreach ($data['trades'] as $key => $trade) {
			$data['trades'][$key]['trade_record'] = $this->query_model->queryTradeRecord($trade['trade_id']);
		}

		$link_config = array(
			'total' => $data['total'],
			'offset' => $offset,
			'limit' => $limit,
			'search_data' => $data['search_data'] ,
			'pre_url' => 'space/' . __FUNCTION__  ,
			);
		$this->load->model("pagination_model");
		$data['link_array'] = $this->pagination_model->create_link($link_config);

		$this->load->view('include/header' , $data);
		$this->load->view('space/nav');
		$this->load->view('space/shared');
		$this->load->view('include/footer');
	}

	public function borrow(){
		$offset = $this->input->get_post('offset');
		$limit = $this->limit;

		$data = array();
		$data['title'] = "Books on sharing" ;
		$data['search_data'] = array(
			 // trade_status = 1 someone request , 2 accept , 3 deny , 4 cancel , 5 return ,
			'borrower_id' => $this->session->userdata['user_id']
		);

		list( $data['total'] , $data['trades']) = $this->query_model->queryTrade( $data['search_data'] , $limit , $offset );

		foreach ($data['trades'] as $key => $trade) {
			$data['trades'][$key]['trade_record'] = $this->query_model->queryTradeRecord($trade['trade_id']);
		}

		$link_config = array(
			'total' => $data['total'],
			'offset' => $offset,
			'limit' => $limit,
			'search_data' => $data['search_data'] ,
			'pre_url' => 'space/' . __FUNCTION__  ,
			);
		$this->load->model("pagination_model");
		$data['link_array'] = $this->pagination_model->create_link($link_config);

		$this->load->view('include/header' , $data);
		$this->load->view('space/nav');
		$this->load->view('space/borrow');
		$this->load->view('include/footer');
	}

}
