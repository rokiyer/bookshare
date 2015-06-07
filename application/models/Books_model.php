<?php 
class Books_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	public function getBookInfoByISBN($isbn){
		$query_book = $this->db->query("SELECT * FROM book WHERE isbn10 = '$isbn' OR isbn13 = '$isbn' ");

		//if not exists , get data from douban
		if($query_book->num_rows() == 0){
			$book_info = $this->getDataFromDoubanByISBN($isbn);
			if($book_info == FALSE)
				return FALSE;

			if(trim($book_info['isbn13']) != $isbn AND trim($book_info['isbn10']) != $isbn)
				return FALSE;
			$this->saveBookInfoToDB($book_info);

		}

		$query_book = $this->db->query("SELECT book.* , 
			publisher.name AS publisher_name , publisher.id AS publisher_id
			FROM book 
			INNER JOIN publisher ON book.publisher_id = publisher.id 
			WHERE isbn10 = '$isbn' OR isbn13 = '$isbn'  ");

		$row = $query_book->first_row("array");
		$book_id = $row["id"];
		//author
		$query_author = $this->db->query("SELECT author.name AS author_name , author.id AS author_id 
			FROM book_author 
			INNER JOIN author ON book_author.author_id = author.id
			WHERE book_author.book_id = $book_id ");
		$result_author = $query_author->result("array");
		$row["authors"] = $result_author;
		//translator
		$query_translator = $this->db->query("SELECT author.name AS translator_name , author.id AS translator_id 
			FROM book_translator 
			INNER JOIN author ON book_translator.author_id = author.id 
			WHERE book_translator.book_id = $book_id ");
		$result_translator = $query_translator->result("array");
		$row["translators"] = $result_translator;
		//tag
		$query_tag = $this->db->query("SELECT tag.name AS tag_name , book_tag.tag_id AS tag_id 
			FROM book_tag 
			INNER JOIN tag ON book_tag.tag_id = tag.id
			WHERE book_tag.book_id = $book_id ");
		$result_tag = $query_tag->result("array");
		$row["tags"] = $result_tag;

		return $row;
	}

	private function saveBookInfoToDB($book_info){
		$publisher_id = $this->createPublisher($book_info["publisher"]);
		$book = array(
			'isbn10' => $book_info['isbn10'] ,
			'isbn13' => $book_info['isbn13'] ,
			'title' => $book_info['title'] ,
			'description' => $book_info['summary'] ,
			'isbn13' => $book_info['isbn13'] ,
			'publisher_id' => $publisher_id ,
			'douban_url' => $book_info['alternate'] ,

			'image_url' => $book_info['image'] ,
			'pages' => isset($book_info['pages'])?$book_info['pages']:"",
			'price' => isset($book_info['price'])?$book_info['price']:"" ,
			'binding' => isset($book_info['binding'])?$book_info['binding']:"" ,
			'pubdate' =>isset($book_info['pubdate'])?$book_info['pubdate']:"" ,

			'rate_score' => $book_info['rate']['average'] ,
			'rate_num' => $book_info["rate"]['numRaters'] ,
			);
		$insert_book = $this->db->insert( "book" , $book );
		$book_id = $this->db->insert_id();

		foreach ($book_info['authors'] as $key => $author) {
			$author_id = $this->createAuthor($author);
			$book_author_arr = array( 'book_id' => $book_id , 'author_id' => $author_id );
			$this->db->insert('book_author' , $book_author_arr);
		}
		foreach ($book_info['translators'] as $key => $author) {
			$author_id = $this->createAuthor($author);
			$book_author_arr = array( 'book_id' => $book_id , 'author_id' => $author_id );
			$this->db->insert('book_translator' , $book_author_arr);
		}
		foreach ($book_info['tags'] as $key => $tag){
			$book_info['tags'][$key] = (int)$tag;
		}
		$book_info['tags'] = array_unique($book_info['tags']);
		foreach ($book_info['tags'] as $key => $tag) {
			$tag_id = $this->createTag($tag["name"]);
			$book_tag_arr = array( 'book_id' => $book_id , 'tag_id' => (int)$tag_id , 'count' => (int)$tag["count"] );
			$this->db->insert('book_tag' , $book_tag_arr);
		}
		
	}

	private function createAuthor($author_name){
		$query_author = $this->db->query("SELECT * FROM author WHERE name = '$author_name'");
		if($query_author->num_rows() == 0){
			$insert_author = $this->db->query("INSERT INTO author(name) VALUE('$author_name')");
			$author_id = $this->db->insert_id();
		}else{
			$row = $query_author->first_row();
			$author_id = $row->id;
		}
		return $author_id;
	}

	private function createTag($tag_name){
		$query_tag = $this->db->query("SELECT * FROM tag WHERE name = '$tag_name'");
		if($query_tag->num_rows() == 0){
			$insert_tag = $this->db->query("INSERT INTO tag(name) VALUE('$tag_name')");
			$tag_id = $this->db->insert_id();
		}else{
			$row = $query_tag->first_row();
			$tag_id = $row->id;
		}
		return $tag_id;
	}

	private function createPublisher($publisher_name){
		$query_publisher = $this->db->query("SELECT * FROM publisher WHERE name = '$publisher_name'");
		if($query_publisher->num_rows() == 0){
			$insert_publisher = $this->db->query("INSERT INTO publisher(name) VALUE('$publisher_name')");
			$publisher_id = $this->db->insert_id();
		}else{
			$row = $query_publisher->first_row();
			$publisher_id = $row->id;
		}
		return $publisher_id;
	}

	
	//From douban
	public function getDataFromDoubanByISBN($isbn)		
	{
		$xml_url = "http://api.douban.com/book/subject/isbn/$isbn";
		//we need extract book_xml info 
		$book_info = array();
		$content = @file_get_contents($xml_url);
		if($book_info = $this->extractBookXml($content) )
		{
			$book_info['image'] = strtr($book_info['image'] , array('spic' => 'lpic') );
			$book_info["rate"]["average"] = (float)$book_info["rate"]["average"];
			$book_info["rate"]["numRaters"] = (int)$book_info["rate"]["numRaters"];
			$book_info["pages"] = (int)$book_info["pages"];
			return $book_info;
		}
		else
			return false;
	}

	private function extractBookXml($content)
	{
		$book_info = array();
		if( $book_xml = @simplexml_load_string($content) )
		{
			$book_info['title'] = (string)$book_xml->title;
			$book_info['summary'] = (string)$book_xml->summary;

			foreach ($book_xml->link as $value) {
				$ref = $value->attributes()->rel;
				$href = $value->attributes()->href;
				$book_info["$ref"] = (string)$href;
			}

			$db_namespace = 'http://www.douban.com/xmlns/';
			$db = $book_xml->children($db_namespace);

			$book_info['translators'] = array();
			$book_info['authors'] = array();
			$book_info['tags'] = array();
			foreach ($db as $value) {
				$name = $value->attributes()->name;
				if($name == "translator"){
					array_push($book_info['translators'] , (string)$value);
				}else if($name == "author"){
					array_push($book_info['authors'] , (string)$value);
				}else{
					if((string)$value == ""){
						$tag = array('name' => (string)$name ,'count' => (int)$value->attributes()->count);
						array_push($book_info['tags'] , $tag);
					}else{
						$book_info["$name"] = (string)$value;
					}
				}
			}

			$gd_namespace = "http://schemas.google.com/g/2005";
			$gd = $book_xml->children($gd_namespace);
			foreach ($gd as $value) {
				$book_info["rate"] = array(
					"average" => $value->attributes()->average,
					"numRaters" => $value->attributes()->numRaters,
					"max" => $value->attributes()->max,
					"min" => $value->attributes()->min,
				);
			}

			return $book_info;
		}
		else
		{
			return false;
		}
	}

	public function extractBookImageUrl($image_url)
	{
		// http://img5.douban.com/spic/s9770877.jpg
		$pattern = '/^http:.*.douban.com\/s(.*)/';
		$matches = array();
		if( preg_match($pattern, $image_url , $matches ) )
			return "l".$matches[1];
		else
			return 0;
	}

	public function getAuthorInfo($author_id){
		$query = $this->db->query("SELECT * FROM author WHERE author_id = $author_id");
		if($query->num_rows() == 0)
			return FALSE;
		$row = $query->first_row("array");
		return $row;
	}

	
}


// This XML file does not appear to have any style information associated with it. The document tree is shown below.
// <entry xmlns="http://www.w3.org/2005/Atom" xmlns:db="http://www.douban.com/xmlns/" xmlns:gd="http://schemas.google.com/g/2005" xmlns:openSearch="http://a9.com/-/spec/opensearchrss/1.0/" xmlns:opensearch="http://a9.com/-/spec/opensearchrss/1.0/">
// <id>http://api.douban.com/book/subject/1767741</id>
// <title>C++ Primer 中文版（第 4 版）</title>
// <category scheme="http://www.douban.com/2007#kind" term="http://www.douban.com/2007#book"/>
// <author>...</author>
// <author>...</author>
// <author>...</author>
// <link href="http://api.douban.com/book/subject/1767741" rel="self"/>
// <link href="http://book.douban.com/subject/1767741/" rel="alternate"/>
// <link href="http://img3.douban.com/spic/s1638975.jpg" rel="image"/>
// <link href="http://m.douban.com/book/subject/1767741/" rel="mobile"/>
// <summary>...</summary>
// <db:attribute name="isbn10">7115145547</db:attribute>
// <db:attribute name="isbn13">9787115145543</db:attribute>
// <db:attribute name="author-intro">...</db:attribute>
// <db:attribute name="pages">745</db:attribute>
// <db:attribute name="translator">李师贤</db:attribute>
// <db:attribute name="translator">蒋爱军</db:attribute>
// <db:attribute name="translator">梅晓勇</db:attribute>
// <db:attribute name="translator">林瑛</db:attribute>
// <db:attribute name="author">Stanley B.Lippman</db:attribute>
// <db:attribute name="author">Josée LaJoie</db:attribute>
// <db:attribute name="author">Barbara E.Moo</db:attribute>
// <db:attribute name="price">99.00元</db:attribute>
// <db:attribute name="publisher">人民邮电出版社</db:attribute>
// <db:attribute name="binding">16开</db:attribute>
// <db:attribute name="pubdate">2006</db:attribute>
// <db:attribute name="title">C++ Primer 中文版（第 4 版）</db:attribute>
// <db:tag count="3081" name="C++"/>
// <db:tag count="1305" name="编程"/>
// <db:tag count="857" name="计算机"/>
// <db:tag count="691" name="程序设计"/>
// <db:tag count="487" name="经典"/>
// <db:tag count="457" name="C/C++"/>
// <db:tag count="390" name="经典教材"/>
// <db:tag count="377" name="经典之作"/>
// <gd:rating average="9.2" max="10" min="0" numRaters="3856"/>
// </entry>

