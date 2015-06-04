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
			'name' => $row->username ,
			'cellphone' => $row->cellphone 
			);
		$this->session->set_userdata($user_info);
	}

	public function create($input){
		$cellphone = $input['cellphone'];
		$password = $input['password'];
		$query = $this->db->query("INSERT INTO user(username,cellphone,password) VALUE ( '$cellphone' , '$cellphone' , SHA1('$password') )");
		return array(TRUE , 'register success');
	}

	public function init($fx_host)
	{
		if(isset($this->host_list[$fx_host]))
		{
			$this->fx_host = $fx_host;
			$this->url = $this->host_list[$fx_host]['url'];
			$this->token = $this->host_list[$fx_host]['token'];
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function exec($method,$arr = NULL)
	{
		$param =($arr==NULL)?NULL:http_build_query($arr);
		$url = $this->url.$method."?token=".$this->token."&".$param;
		$content = file_get_contents($url);
		return json_decode($content);
	}
}

