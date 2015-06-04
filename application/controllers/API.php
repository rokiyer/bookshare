<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class API extends CI_Controller {

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function userRegister()
	{
		$input = array(
			'cellphone' => $this->input->get_post('cellphone') ,
			'password' => $this->input->get_post('password') ,
			'confirm' => $this->input->get_post('confirm') ,
			);

		if(empty($input['cellphone'])){
			echoFail('Cellphone field is empty');
			return FALSE;
		}

		if(empty($input['password'])){
			echoFail('Password field is empty');
			return FALSE;
		}

		if(empty($input['confirm'])){
			echoFail('Confirm field is empty');
			return FALSE;
		}

		if($input['password'] != $input['confirm']){
			echoFail('Password and confirm does not match');
			return FALSE;
		}
		$this->load->model('user_model');
		if($this->user_model->isCellphoneDuplicated($input['cellphone']) == TRUE ){
			echoFail('Cellphone has been registered');
			return FALSE;
		}

		list($result , $msg) = $this->user_model->create($input);

		if($result == FALSE){
			echoFail($msg);
			return FALSE;
		}

		$this->user_model->processLogin($input['cellphone']);

		echoSucc('register succ');
		return TRUE;

	}

	public function userLogin()
	{
		$input = array(
			'cellphone' => $this->input->get_post('cellphone') ,
			'password' => $this->input->get_post('password') ,
			);

		if(empty($input['cellphone'])){
			echoFail('Cellphone field is empty');
			return FALSE;
		}

		if(empty($input['password'])){
			echoFail('Password field is empty');
			return FALSE;
		}

		$this->load->model('user_model');
		if($this->user_model->isCellphonePasswordMatched($input) == FALSE){
			echoFail('Cellphone or password is wrong');
			return FALSE;
		}

		$this->user_model->processLogin($input['cellphone']);

		echoSucc('login succ');
		return TRUE;
	}
}
