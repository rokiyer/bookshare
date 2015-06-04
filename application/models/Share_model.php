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

	function isDuplicateItem($book_id , $user_id){
		$query = $this->db->query("SELECT * FROM item WHERE book_id = $book_id AND user_id = $user_id ");
		if($query->num_rows() == 0)
			return FALSE;
		else
			return TRUE;
	}

	function queryItem(){
		$query_item = $this->db->query("SELECT item.id AS item_id, book.title ,
			user.username AS username , user.id AS user_id , book.image_url , item.description
		 FROM item 
			INNER JOIN book ON item.book_id = book.id 
			INNER JOIN user ON item.user_id = user.id 
			WHERE item.status = 1 ");
		$result_item = $query_item->result("array");
		return $result_item;
	}
	
}

