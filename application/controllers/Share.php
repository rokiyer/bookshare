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

		//页码导航
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
		if(empty($item_id))
			redirect('share/error/1');

		$query = $this->db->query("SELECT * FROM item WHERE id = $item_id AND status = 1 ");
		if($query->num_rows() == 0){
			redirect('share/error/2');
		}

		$data = array();
		$data['item_id'] = $item_id;

		list( $total , $items ) = $this->query_model->queryItem( $data );
		$item = $items[0];
		$book_id = $item['book_id'];
		$item['authors'] = $this->query_model->queryBookAuthors($book_id);
		$item['translators'] = $this->query_model->queryBookTranslators($book_id);

		$data['item'] = $item;

		$this->load->view('include/header' , $data);
		$this->load->view('share/detail');
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
