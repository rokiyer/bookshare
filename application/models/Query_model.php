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

	
}

