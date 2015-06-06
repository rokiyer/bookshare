<?php 
class Share_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	function createItem($book_id , $user_id , $description){
		$insert_arr = array(
			'book_id' => $book_id ,
			'user_id' => $user_id ,
			'description' => $description ,
			'status' => 1
			);
		$this->db->insert('item' , $insert_arr);
		return $this->db->insert_id();
	}

	function getItem($item_id){
		$query_item = $this->db->query("SELECT * FROM item WHERE ");
	}

	function updateItem($item_id , $data){
		$this->db->where('id', $item_id);
		$this->db->update('item', $data);
		return TRUE;
	}

	function isDuplicateItem($book_id , $user_id){
		$query = $this->db->query("SELECT * FROM item WHERE book_id = $book_id AND user_id = $user_id ");
		if($query->num_rows() == 0)
			return FALSE;
		else
			return TRUE;
	}

	
}

