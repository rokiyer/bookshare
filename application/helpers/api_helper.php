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

function activeButton($name){
	$CI =& get_instance();
	if($CI->uri->segment(2) == $name){
		echo $name;
	}else{
		$target_url = site_url("space/$name");
		echo "<a href='$target_url'>$name</a>";
	}
}

