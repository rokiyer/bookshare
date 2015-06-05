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

	function queryItem($search_data , $limit , $offset ){

		$keyword = isset($search_data['keyword'])?$search_data['keyword']:NULL;

		$sql = "SELECT item.id AS item_id, book.title , book.publisher_id , book.id AS book_id ,
			user.username , user.id AS user_id , book.image_url , item.description , 
			publisher.name AS publisher_name , publisher.id AS publisher_id , book.pubdate 
		 FROM item 
			INNER JOIN book ON item.book_id = book.id 
			INNER JOIN user ON item.user_id = user.id 
			INNER JOIN publisher ON book.publisher_id = publisher.id
			WHERE item.status = 1 ";

		if($keyword != NULL)
			$sql .= "AND book.title LIKE '%$keyword%' ";

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

