<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function example(){
	$CI =& get_instance();
	if($CI->session->userdata('msg') === FALSE)
	{
		return NULL;
	}
}

function echoFail($error_msg)
{
	$output = array(
		'result' => 0 ,
		'msg' => $error_msg
		);
	echo json_encode($output);
}

function echoSucc($succ_msg)
{
	$output = array(
		'result' => 1 ,
		'msg' => $succ_msg
		);
	echo json_encode($output);
}

function isLogin(){
	$CI =& get_instance();
	$result = $CI->session->userdata('user_id');
	return !empty($result);
}


function activeButton($name){
	$CI =& get_instance();
	if($CI->uri->segment(2) == $name){
		echo $name;
	}else{
		$target_url = site_url("space/$name");
		echo "<a href='$target_url'>$name</a>";
	}
}

function isActive($name){
	$CI =& get_instance();
	return ($CI->uri->segment(2) == $name);
}

function echo_exist($var){
	if(!empty($var) AND isset($var))
		echo $var;
}


// if search does not specify limit , it will automatic add one - 50 
function addLimit( $limit , $offset )
{
	if(!empty($limit))
	{
		$limit = ($limit < 0)?0:$limit;
		if(!empty($offset) )
		{
			$offset = ($offset < 0)?0:$offset;
			return " LIMIT $offset , $limit " ;
		}
		else
			return " LIMIT 0 , $limit " ;
	}
	else
		return " LIMIT 0 , 10 " ;
}

function url_maker($search_data , $pre_url , $order )
{
	foreach ($search_data as $key => $value) {
		if(empty($value))
			unset($search_data[$key]);
	}
	$search_data[$order['name']] = $order['value'];
	return $pre_url.'?'.http_build_query($search_data);
}

function getTradeStatusName($statusNum){
	$convert_arr = array(
		1 => 'initial' ,
		2 => 'accepted' ,
		3 => 'denied' ,
		4 => 'canceled' ,
		5 => 'returned' ,
		6 => 'lost'
		);
	return $convert_arr[$statusNum];
}

function getItemStatusName($statusNum){
	$convert_arr = array(
		1 => 'sharing' ,
		2 => 'unshare' ,
		3 => 'deleted' ,
		4 => 'borrowed' ,
		);
	return $convert_arr[$statusNum];
}