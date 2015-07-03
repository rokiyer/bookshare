<?php 
class Query_model extends CI_Model{

	private $ECHO_SQL = FALSE;

	function __construct(){
		parent::__construct();
	}

	function queryItem($search_data , $limit = NULL, $offset = NULL ){

		$keyword = isset($search_data['keyword'])?$search_data['keyword']:NULL;
		$item_id = isset($search_data['item_id'])?$search_data['item_id']:NULL;
		$item_status = isset($search_data['item_status'])?$search_data['item_status']:NULL;
		$user_id = isset($search_data['user_id'])?$search_data['user_id']:NULL;
		$username = isset($search_data['username'])?$search_data['username']:NULL;
		$author_id = isset($search_data['author_id'])?$search_data['author_id']:NULL;
		$publisher_id = isset($search_data['publisher_id'])?$search_data['publisher_id']:NULL;
		$book_ids = isset($search_data['book_ids'])?$search_data['book_ids']:NULL;
		$order_time = isset($search_data['order_time'])?$search_data['order_time']:NULL;
		$order_name = isset($search_data['order_name'])?$search_data['order_name']:NULL;

		$no_user_id = isset($search_data['no_user_id'])?$search_data['no_user_id']:NULL;

		$start_time = isset($search_data['start_time'])?$search_data['start_time']:NULL;
		$end_time = isset($search_data['end_time'])?$search_data['end_time']:NULL;

		$sql = "SELECT * FROM item_view 
			WHERE 1 ";

		if($item_status != NULL){
			$sql .= "AND item_view.item_status IN (" . implode(',', $item_status) . ") ";
		}
		else
			$sql .= "AND item_view.item_status != 3 ";

		if($book_ids != NULL){
			$sql .= "AND item_view.book_id IN (" . implode(',', $book_ids) . ") ";
		}

		if($keyword != NULL)
			$sql .= "AND item_view.title LIKE '%$keyword%' ";

		if($username != NULL)
			$sql .= "AND item_view.username LIKE '%$username%' ";
		
		if($item_id != NULL)
			$sql .= "AND item_view.item_id = $item_id ";

		if($user_id != NULL)
			$sql .= "AND item_view.user_id = $user_id ";

		if($no_user_id != NULL)
			$sql .= "AND item_view.user_id != $no_user_id ";

		if($publisher_id != NULL)
			$sql .= "AND item_view.publisher_id = $publisher_id ";

		if($start_time != NULL AND $end_time != NULL){
			$sql .= " AND create_time  > '$start_time' AND create_time < '$end_time' ";
		}else if($start_time != NULL){
			$sql .= " AND create_time > '$start_time' ";
		}else if($start_time != NULL){
			$sql .= " AND create_time < '$end_time' ";
		}
		$query_total = $this->db->query($sql);
		$total = $query_total->num_rows();
		if($order_time == 1 AND $order_name == 1)
			$sql .= " ORDER BY create_time ASC , title DESC";
		else if($order_time == 1)
			$sql .= " ORDER BY create_time ASC , title ASC";
		else if($order_name == 1)
			$sql .= " ORDER BY title DESC , create_time DESC ";
		else
			$sql .= " ORDER BY create_time DESC , title ASC";

		$sql .= addLimit( $limit , $offset );

		$query_search = $this->db->query($sql);
		$result_search = $query_search->result_array();

		return array($total , $result_search);
	}

	function queryUser($search_data , $limit = NULL, $offset = NULL ){

		$keyword = isset($search_data['keyword'])?$search_data['keyword']:NULL;
		$cellphone = isset($search_data['cellphone'])?$search_data['cellphone']:NULL;
		$email = isset($search_data['email'])?$search_data['email']:NULL;
		$username = isset($search_data['username'])?$search_data['username']:NULL;
		$start_time = isset($search_data['start_time'])?$search_data['start_time']:NULL;
		$end_time = isset($search_data['end_time'])?$search_data['end_time']:NULL;

		// $start_time = date('Y-m-d H:i:s' , strtotime($start_time));
		// $end_time = date('Y-m-d H:i:s' , strtotime($end_time));
		
		$sql = "SELECT * FROM user 
			WHERE 1 ";

		if($keyword != NULL)
			$sql .= "AND (cellphone LIKE '%$keyword%' OR cellphone LIKE '%$keyword%' 
		OR email LIKE '%$keyword%' OR username LIKE '%$keyword%' )";

		if($cellphone != NULL)
			$sql .= "AND user LIKE '%$cellphone%' ";

		if($username != NULL)
			$sql .= "AND user LIKE '%$username%' ";

		if($start_time != NULL AND $end_time != NULL){
			$sql .= " AND create_time  > '$start_time' AND create_time < '$end_time' ";
		}else if($start_time != NULL){
			$sql .= " AND create_time > '$start_time' ";
		}else if($start_time != NULL){
			$sql .= " AND create_time < '$end_time' ";
		}

		$query_total = $this->db->query($sql);
		$total = $query_total->num_rows();

		$sql .= addLimit( $limit , $offset );
		

		$query_search = $this->db->query($sql);
		$result_search = $query_search->result_array();

		return array($total , $result_search);
	}

	function queryAuthor($search_data , $limit = NULL, $offset = NULL ){

		$author_id = isset($search_data['author_id'])?$search_data['author_id']:NULL;

		$sql = "SELECT SELECT book_id FROM book_author 
			WHERE author_id = $author_id ";

		if($item_status != NULL){
			$sql .= "AND item_view.item_status IN (" . implode(',', $item_status) . ") ";
		}
		else
			$sql .= "AND item_view.item_status != 3 ";

		if($keyword != NULL)
			$sql .= "AND book.title LIKE '%$keyword%' ";
		
		if($item_id != NULL)
			$sql .= "AND item_view.item_id = $item_id ";

		if($user_id != NULL)
			$sql .= "AND item_view.user_id = $user_id ";

		if($author_id != NULL)
			$sql .= "AND item_view.author_id = $author_id ";

		$query_total = $this->db->query($sql);
		$total = $query_total->num_rows();

		$sql .= " ORDER BY create_time DESC";
		$sql .= addLimit( $limit , $offset );
		

		$query_search = $this->db->query($sql);
		$result_search = $query_search->result_array();

		return array($total , $result_search);
	}

	function queryBookAuthors($book_id){
		$query_author = $this->db->query("SELECT book_author.book_id , book_author.author_id , 
			author.name AS name FROM book_author 
			INNER JOIN author ON author.id = book_author.author_id
			WHERE book_author.book_id = $book_id ");
		$result_author = $query_author->result("array");
		$authors = array();
		foreach ($result_author as $key => $value) {
			$author = array();
			$author["name"] = $value["name"];
			$author["book_id"] = $value["book_id"];
			$author["author_id"] = $value["author_id"];
			array_push($authors , $author);
		}
		return $authors;
	}

	function queryBookTranslators($book_id){
		$query_translator = $this->db->query("SELECT book_translator.book_id , book_translator.author_id AS translator_id, 
			author.name AS name FROM book_translator
			INNER JOIN author ON author.id = book_translator.author_id
			WHERE book_translator.book_id = $book_id ");
		$result_translator = $query_translator->result("array");
		$translators = array();
		foreach ($result_translator as $key => $value) {
			$translator = array();
			$translator["name"] = $value["name"];
			$translator["book_id"] = $value["book_id"];
			$translator["translator_id"] = $value["translator_id"];
			array_push($translators , $translator);
		}
		return $translators;
	}

	function queryTrade($search_data , $limit = NULL, $offset = NULL ){

		$item_title = isset($search_data['item_title'])?$search_data['item_title']:NULL;
		$item_status = isset($search_data['item_status'])?$search_data['item_status']:NULL;
		$trade_status = isset($search_data['trade_status'])?$search_data['trade_status']:NULL;
		$owner_id = isset($search_data['owner_id'])?$search_data['owner_id']:NULL;
		$borrower_id = isset($search_data['borrower_id'])?$search_data['borrower_id']:NULL;
		$owner_name = isset($search_data['owner_name'])?$search_data['owner_name']:NULL;
		$borrower_name = isset($search_data['borrower_name'])?$search_data['borrower_name']:NULL;

		$sql = "SELECT * FROM trade_view
			WHERE 1 ";

		if(!empty($item_id))
			$sql .= " AND item_id = $item_id";
		if(!empty($owner_id))
			$sql .= " AND owner_id = $owner_id";
		if(!empty($borrower_id))
			$sql .= " AND borrower_id = $borrower_id";
		if(!empty($trade_status))
			$sql .= " AND trade_status IN (" . implode(',', $trade_status) . ") ";
		if(!empty($borrower_name))
			$sql .= " AND borrower_name LIKE '%$borrower_name%' ";
		if(!empty($owner_name))
			$sql .= " AND owner_name LIKE '%$owner_name%' ";
		if(!empty($item_title))
			$sql .= " AND item_title LIKE '%$item_title%' ";

		$query_total = $this->db->query($sql);
		$total = $query_total->num_rows();

		$sql .= " ORDER BY create_time DESC";
		$sql .= addLimit( $limit , $offset );

		$query_search = $this->db->query($sql);
		$result_search = $query_search->result_array();

		return array($total , $result_search);
	}

	function queryTradeRecord($trade_id){
		$query = $this->db->query("SELECT * FROM trade_record WHERE trade_id = $trade_id");
		return $query->result('array');
	}

	
}

