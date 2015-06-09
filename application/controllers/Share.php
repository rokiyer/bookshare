<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Share extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("share_model");
	}

	public function index()
	{
		redirect('share/book');
		$this->load->view('welcome_message');
	}

	public function book(){
		$offset = $this->input->get_post('offset');
		$limit = 5;

		$data = array();
		$data['title'] = "Books on sharing" ;
		$data['search_data'] = array(
			'keyword' => $this->input->get_post('keyword'),
			'item_status' => array(1)
		);
		
		list( $data['total'] , $data['items']) = $this->query_model->queryItem( $data['search_data'] , $limit , $offset );

		foreach ($data["items"] as $key => $item) {
			$book_id = $item['book_id'];
			$data["items"][$key]['authors'] = $this->query_model->queryBookAuthors($book_id);
			$data["items"][$key]['translators'] = $this->query_model->queryBookTranslators($book_id);
		}

		unset($data['search_data']['item_status']);

		$link_config = array(
			'total' => $data['total'],
			'offset' => $offset,
			'limit' => $limit,
			'search_data' => $data['search_data'] ,
			'pre_url' => 'share/' . __FUNCTION__  ,
			);
		$this->load->model("pagination_model");
		$data['link_array'] = $this->pagination_model->create_link($link_config);


		$this->load->view('include/header' , $data);
		$this->load->view('share/book');
		$this->load->view('include/footer');
	}

	public function detail($item_id){
		$item_id = trim($item_id);
		if(empty($item_id)){
			redirect('share/error/1');
			return FALSE;
		}
			

		$query = $this->db->query("SELECT * FROM item_view WHERE item_id = $item_id AND item_status = 1 ");
		if($query->num_rows() == 0){
			redirect('share/error/2');
		}
		$row = $query->first_row('array');

		$data = array();
		$data['item'] = $row;
		
		$book_id = $data['item']['book_id'];
		$data['item']['authors'] = $this->query_model->queryBookAuthors($book_id);
		$data['item']['translators'] = $this->query_model->queryBookTranslators($book_id);

		$this->load->view('include/header' , $data);
		$this->load->view('share/detail');
		$this->load->view('include/footer');
	}

	public function user(){

		$user_id = $this->input->get_post('user_id');
		$user_id = trim($user_id);
		if(empty($user_id)){
			redirect('share/error/1');
			return FALSE;
		}

		$query_user = $this->db->query("SELECT * FROM user WHERE id=$user_id");
		$num_rows_user = $query_user->num_rows();
		if($num_rows_user == 0){
			redirect('share/error/1');
			return FALSE;
		}

		$data = array();
		$data['user'] = $query_user->first_row('array');

		$offset = $this->input->get_post('offset');
		$limit = 4;
		
		$data['title'] = "Books on sharing" ;
		$data['search_data'] = array(
			'item_status' => array(1) ,
			'user_id' => $user_id
		);
		
		list( $data['total'] , $data['items']) = $this->query_model->queryItem( $data['search_data'] , $limit , $offset );

		foreach ($data["items"] as $key => $item) {
			$book_id = $item['book_id'];
			$data["items"][$key]['authors'] = $this->query_model->queryBookAuthors($book_id);
			$data["items"][$key]['translators'] = $this->query_model->queryBookTranslators($book_id);
		}

		unset($data['search_data']['item_status']);

		$link_config = array(
			'total' => $data['total'],
			'offset' => $offset,
			'limit' => $limit,
			'search_data' => $data['search_data'] ,
			'pre_url' => 'share/' . __FUNCTION__  ,
			);
		$this->load->model("pagination_model");
		$data['link_array'] = $this->pagination_model->create_link($link_config);


		$this->load->view('include/header' , $data);
		$this->load->view('share/user');
		$this->load->view('include/footer');
	}

	public function author(){
		$author_id = $this->input->get_post("author_id");

		$author_id = trim($author_id);
		if(empty($author_id)){
			redirect('share/error/1');
			return FALSE;
		}

		$query_author = $this->db->query("SELECT * FROM author WHERE id=$author_id");
		$num_rows_author = $query_author->num_rows();
		if($num_rows_author == 0){
			redirect('share/error/1');
			return FALSE;
		}

		$data = array();
		$data['author'] = $query_author->first_row('array');

		$offset = $this->input->get_post('offset');
		$limit = 4;

		$query_book_ids = $this->db->query("SELECT book_id FROM book_author WHERE author_id = $author_id");
		$result_book_ids = $query_book_ids->result_array();
		$arr_book_ids = array();
		foreach ($result_book_ids as $key => $value) {
			array_push($arr_book_ids,$value['book_id']);
		}

		$data['title'] = "Books on sharing" ;
		$data['search_data'] = array(
			'item_status' => array(1) ,
			'author_id' => $author_id ,
			'book_ids' => $arr_book_ids
		);
		
		list( $data['total'] , $data['items']) = $this->query_model->queryItem( $data['search_data'] , $limit , $offset );

		foreach ($data["items"] as $key => $item) {
			$book_id = $item['book_id'];
			$data["items"][$key]['authors'] = $this->query_model->queryBookAuthors($book_id);
			$data["items"][$key]['translators'] = $this->query_model->queryBookTranslators($book_id);
		}

		unset($data['search_data']['item_status']);

		$link_config = array(
			'total' => $data['total'],
			'offset' => $offset,
			'limit' => $limit,
			'search_data' => $data['search_data'] ,
			'pre_url' => 'share/' . __FUNCTION__  ,
			);
		$this->load->model("pagination_model");
		$data['link_array'] = $this->pagination_model->create_link($link_config);


		$this->load->view('include/header' , $data);
		$this->load->view('share/user');
		$this->load->view('include/footer');
	}

	public function error($type){
		$data['error_msg'] = "Page not found";
		switch ($type) {
			case 1:
				$data['error_msg'] = "Page not found";
				break;
			
			default:
				$data['error_msg'] = "The book does not share any more";
				break;
		}

		$this->load->view('include/header' , $data);
		$this->load->view('share/error');
		$this->load->view('include/footer');

	}

	
}
