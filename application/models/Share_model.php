<?php 
class Share_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}

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

	function createTrade($user_id , $item_id){
		$data = array(
           'user_id' => $user_id ,
           'item_id' => $item_id ,
           'status' => 1
        );
        $this->db->insert('trade', $data); 
        $trade_id = $this->db->insert_id();
        $this->updateItem($item_id , array('status' => 4));

  //       $record_insert_arr = array(
		// 	'trade_id' => $trade_id ,
		// 	'op' => 1	
		// 	);
		// $this->db->insert('trade_record' , $record_insert_arr );

        return $trade_id;
	}

	function getTradeStatus($trade_id){
		$query = $this->db->query("SELECT * FROM trade WHERE id = $trade_id ");
		if($query->num_rows() != 1)
			return 0;
		$row = $query->first_row();
		return $row->status;
	}

	function updateTrade($trade_id , $trade_op){
		//the validity of operation is checked in api , error message is returned in json format
		$target_transfer = array(
			'accept' => 2 ,
			'deny' => 3 ,
			'cancel' => 4 ,
			'return' => 5 ,
			'lost' => 6
			);
		$data = array(
			'status' => $target_transfer[$trade_op]
			);
		$this->db->where('id', $trade_id);
		$this->db->update('trade', $data);
		//some operation will change other table status , too.
		if( in_array($trade_op, array('return','cancel','deny')) ){	
			$item_query = $this->db->query("SELECT item_id FROM trade WHERE id = $trade_id");
			$row = $item_query->first_row();
			$item_id = $row->item_id;
			$this->db->query("UPDATE item SET status = 1 WHERE id = $item_id");// 1 - sharing
		}

		if( in_array($trade_op, array('lost')) ){	
			$item_query = $this->db->query("SELECT item_id FROM trade WHERE id = $trade_id");
			$row = $item_query->first_row();
			$item_id = $row->item_id;
			$this->db->query("UPDATE item SET status = 3 WHERE id = $item_id");// 3 - delete
		}

		//DO THE RECORD 
		// $record_insert_arr = array(
		// 	'trade_id' => $trade_id ,
		// 	'op' => $data['status']
		// 	);
		// $this->db->insert('trade_record' , $record_insert_arr );

		return TRUE;
	}

	
}

