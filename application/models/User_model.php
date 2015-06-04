<?php 
class User_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	public function isCellphoneDuplicated($cellphone){
		$query = $this->db->query("SELECT * FROM user WHERE cellphone = '$cellphone'");
		if($query->num_rows() == 0)
			return FALSE;
		else
			return TRUE;
	}

	public function isCellphonePasswordMatched($input){
		$cellphone = $input['cellphone'];
		$password = $input['password'];
		$query = $this->db->query("SELECT * FROM user WHERE cellphone = '$cellphone' AND password = SHA1('$password')");
		if($query->num_rows() == 0)
			return FALSE;
		else
			return TRUE;
	}

	public function processLogin($cellphone){
		$query = $this->db->query("SELECT * FROM user WHERE cellphone = '$cellphone'");
		$row = $query->first_row();
		$user_info = array(
			'user_id' => $row->id ,
			'name' => $row->name ,
			'cellphone' => $row->name 
			);
		$this->session->set_userdata($user_info);
	}

	public function create($input){
		$cellphone = $input['cellphone'];
		$password = $input['password'];
		$query = $this->db->query("INSERT INTO user(name,cellphone,password) VALUE ( '$cellphone' , '$cellphone' , SHA1('$password') )");
		return array(TRUE , 'register success');
	}

	public function getUserInfo($user_id){
		$query = $this->db->query("SELECT * FROM user WHERE user_id = 1");
		$row = $query->first_row('array');
		return $row;
	}

	public function getUserBooks($user_id){
		$query = $this->db->query("SELECT * FROM upload WHERE user_id = 1");
		$result = $query->result('array');
		return $result;
	}
}

