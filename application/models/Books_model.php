<?php 
class Books_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	//From douban
	public function getDataFromDoubanByISBN($isbn)		
	{
		$xml_url = "http://api.douban.com/book/subject/isbn/$isbn";
		//we need extract book_xml info 
		$book_info = array();
		$content = @file_get_contents($xml_url);
		if($book_info = $this->extractBookXml($content ) )
		{
			$book_info['isbn'] = $isbn;
			$book_info['image_url'] = strtr($book_info['image_url'] , array('spic' => 'lpic') );
			return $book_info;
		}
		else
		{
			return false;
		}
	}

	public function extractBookXml($content)
	{
		$book_info = array();
		if( $book_xml = @simplexml_load_string($content) )
		{
			$book_info['title'] = (string)$book_xml->title;
			//consider the situation that a book has more than one author
			$book_info['authors'] = array();
			foreach ($book_xml->author as $key => $value) {
				array_push($book_info['authors'] , (string)$value->name);
			}

			foreach ($book_xml->link as $value) {
				$ref = $value->attributes()->rel;
				$href = $value->attributes()->href;
				if($ref == "image")
					$book_info["image_url"] = (string)$href;
				else
					$book_info["$ref"] = (string)$href;

			}

			$book_info['translators'] = array();

			$db_namespace = 'http://www.douban.com/xmlns/';
			$db = $book_xml->children($db_namespace);
			foreach ($db as $value) {
				$name = $value->attributes()->name;
				if($name == "pages")
					$book_info['pages'] = (int)$value;
				if($name == "price")
					$book_info['price'] = "$value";
				if($name == "publisher")
					$book_info['publisher'] = "$value";
				if($name == "binding")
					$book_info['binding'] = "$value";
				if($name == "pubdate")
					$book_info['pubdate'] = "$value";
				if($name == "translator")
					array_push($book_info['translators'] , (string)$value);
			}
			// $book_info['xml'] = $content;
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

	
}

