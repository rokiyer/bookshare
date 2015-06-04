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

