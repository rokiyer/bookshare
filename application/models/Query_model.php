<?php 
class Query_model extends CI_Model{

	private $ECHO_SQL = FALSE;

	function __construct(){
		parent::__construct();
	}

	function queryUser( $search_data  , $limit , $offset )
	{
		$user_name = isset($search_data['user_name'])?$search_data['user_name']:NULL;
		$key_word = isset($search_data['key_word'])?$search_data['key_word']:NULL;
		$privilege = isset($search_data['privilege'])?$search_data['privilege']:NULL;
		$verification = isset($search_data['verification'])?$search_data['verification']:NULL;
		$level = isset($search_data['level'])?$search_data['level']:NULL;
		$start_time = isset($search_data['start_time'])?($search_data['start_time']):NULL;
		$end_time = isset($search_data['end_time'])?($search_data['end_time']):NULL;
		$order = isset($search_data['order'])?$search_data['order']:NULL;
		$district_id = isset($search_data['district_id'])?$search_data['district_id']:NULL;

		$str  = "SELECT * FROM `user` WHERE 1 ";

		if(!empty($district_id))
			$str  .= " AND district_id = $district_id ";

		if(!empty($user_name))
		{
			$str  .= " AND user_name LIKE '%$user_name%' ";
		}
		else
		{
			if(!empty($key_word))
				$str .= " AND ( 
					user_name LIKE '%$key_word%' 
					OR cellphone LIKE '%$key_word%' 
					OR email LIKE '%$key_word%' 
					OR student_id LIKE '%$key_word%' ) ";
		}
		if(!empty($privilege))
			$str .= " AND privilege = $privilege ";
		if(!empty($verification))
			$str .= " AND verification = $verification ";
		if(!empty($level))
			$str .= " AND level = $level ";
		if(!empty($start_time) OR !empty($end_time))
			$str .= addTime( 'create_time' , $start_time , $end_time );
		if(!empty($order))
			$str .= addOrder($order);
		else
			$str .= ' ORDER BY user_id DESC ';

		$query_total = $this->db->query( $str );
		$total = $query_total->num_rows();

		$str .= addLimit( $limit , $offset );
		$this->echoSQL($str);

		$query_search = $this->db->query($str);
		$result_search = $query_search->result_array();
		return array($total , $result_search);
	}

	function queryItem($search_data , $limit = NULL, $offset = NULL ){

		$keyword = isset($search_data['keyword'])?$search_data['keyword']:NULL;
		$item_id = isset($search_data['item_id'])?$search_data['item_id']:NULL;
		$item_status = isset($search_data['item_status'])?$search_data['item_status']:NULL;

		$sql = "SELECT item.id AS item_id, item.description , item.status AS item_status ,
			book.title , book.publisher_id , book.id AS book_id , book.image_url , book.pubdate ,
			book.douban_url ,
			user.username , user.id AS user_id ,
			publisher.name AS publisher_name , publisher.id AS publisher_id 
		 FROM item 
			INNER JOIN book ON item.book_id = book.id 
			INNER JOIN user ON item.user_id = user.id 
			INNER JOIN publisher ON book.publisher_id = publisher.id
			WHERE 1 ";

		if($item_status != NULL){
			$sql .= "AND item.status IN (" . implode(',', $item_status) . ") ";
		}
		else
			$sql .= "AND item.status != 3 ";

		if($keyword != NULL)
			$sql .= "AND book.title LIKE '%$keyword%' ";
		
		if($item_id != NULL)
			$sql .= "AND item.id = $item_id ";

		$query_total = $this->db->query($sql);
		$total = $query_total->num_rows();

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

	
}

