<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->model("query_model");
	}

	private $limit = 10;

	// item status 
	// 1 - sharing
	// 2 - unshare
	// 3 - deleted
	// 4 - borrowed

	// trade status
	// 1 - initial 
	// 2 - accepted 
	// 3 - denied 
	// 4 - canceled
	// 5 - returned 
	// 6 - lost

	public function index(){

		$data = array();

		$query = $this->db->query("SELECT count(*) AS user_num FROM user WHERE 1");
		$row = $query->first_row('array');
		$data['user_num'] = $row['user_num'];

		$query = $this->db->query("SELECT count(*) AS item_num FROM item WHERE 1");
		$row = $query->first_row('array');
		$data['item_num'] = $row['item_num'];

		$query = $this->db->query("SELECT count(*) AS item_num,status FROM item WHERE 1 GROUP BY status");
		$result = $query->result('array');
		$data['item_num_status'] = array();
		for($i = 1;$i <= 4;++$i){
			$data['item_num_status'][$i] = 0;
			foreach ($result as $key => $entry) {
				if($entry['status'] == $i){
					$data['item_num_status'][$i] = $entry['item_num'];
					break;
				}
			}
		}

		$query = $this->db->query("SELECT count(*) AS trade_num FROM trade WHERE 1");
		$row = $query->first_row('array');
		$data['trade_num'] = $row['trade_num'];

		$query = $this->db->query("SELECT count(*) AS trade_num,status FROM trade WHERE 1 GROUP BY status");
		$result = $query->result('array');
		$data['trade_num_status'] = array();
		for($i = 1;$i <= 6;++$i){
			$data['trade_num_status'][$i] = 0;
			foreach ($result as $key => $entry) {
				if($entry['status'] == $i){
					$data['trade_num_status'][$i] = $entry['trade_num'];
					break;
				}
			}
		}

		$this->load->view('include/header' , $data);
		$this->load->view('admin/index');
		$this->load->view('include/footer');
	}

	public function user(){

		$offset = $this->input->get_post('offset');
		$limit = $this->limit;
		
		$data = array();
		$data['search_data'] = array(
			'keyword' => $this->input->get_post('keyword'),
			'start_time' => $this->input->get_post('start_time'),
			'end_time' => $this->input->get_post('end_time')
			);

		list($total , $result_search) = $this->query_model->queryUser($data['search_data'] , $limit , $offset );
		$data['users'] = $result_search;
		$data['total'] = $total;
		$data['self'] = __FUNCTION__;

		$link_config = array(
			'total' => $data['total'],
			'offset' => $offset,
			'search_data' => $data['search_data'] ,
			'pre_url' => 'admin/' . __FUNCTION__  ,
			);
		$this->load->model('pagination_model');
		$data['link_array'] = $this->pagination_model->create_link($link_config);

		$data['self'] = __FUNCTION__ ;

		$this->load->view('include/header' , $data);
		$this->load->view('admin/user');
		$this->load->view('include/footer');

	}

	public function item(){

		$offset = $this->input->get_post('offset');
		$limit = $this->limit;
		
		$data = array();
		$data['search_data'] = array(
			'keyword' => $this->input->get_post('keyword'),
			'username' => $this->input->get_post('username'),
			'start_time' => $this->input->get_post('start_time'),
			'end_time' => $this->input->get_post('end_time') ,
			'item_status' => array(1,2,3,4)
			);

		list($total , $result_search) = $this->query_model->queryItem($data['search_data'] , $limit , $offset );
		$data['items'] = $result_search;
		$data['total'] = $total;
		$data['self'] = __FUNCTION__;

		unset($data['search_data']['item_status']);

		$link_config = array(
			'total' => $data['total'],
			'limit' => $this->limit,
			'offset' => $offset,
			'search_data' => $data['search_data'] ,
			'pre_url' => 'admin/' . __FUNCTION__  ,
			);

		$this->load->model('pagination_model');
		$data['link_array'] = $this->pagination_model->create_link($link_config);


		$data['self'] = __FUNCTION__ ;

		$this->load->view('include/header' , $data);
		$this->load->view('admin/item');
		$this->load->view('include/footer');

	}
	
	public function trade(){

		$offset = $this->input->get_post('offset');
		$limit = $this->limit;
		
		$data = array();
		$data['search_data'] = array(
			'owner_name' => $this->input->get_post('owner_name'),
			'borrower_name' => $this->input->get_post('borrower_name'),
			'item_title' => $this->input->get_post('item_title'),
			'start_time' => $this->input->get_post('start_time'),
			'end_time' => $this->input->get_post('end_time') ,
			'trade_status' => array(1,2,3,4,5,6)
			);

		list($total , $result_search) = $this->query_model->queryTrade($data['search_data'] , $limit , $offset );
		$data['trades'] = $result_search;
		$data['total'] = $total;
		$data['self'] = __FUNCTION__;

		unset($data['search_data']['trade_status']);

		$link_config = array(
			'total' => $data['total'],
			'limit' => $this->limit,
			'offset' => $offset,
			'search_data' => $data['search_data'] ,
			'pre_url' => 'admin/' . __FUNCTION__  ,
			);

		$this->load->model('pagination_model');
		$data['link_array'] = $this->pagination_model->create_link($link_config);


		$data['self'] = __FUNCTION__ ;

		$this->load->view('include/header' , $data);
		$this->load->view('admin/trade');
		$this->load->view('include/footer');

	}
}
