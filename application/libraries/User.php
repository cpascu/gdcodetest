<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User library.
 */
abstract class User {
	abstract public $user;

	abstract public function get_user()
	{
		//get the user instance, test session if logged in only once
	}

	abstract public function save_session(array $data)
	{
		if (!empty($data))
		{
			$this->session->set_userdata($data);
			return true;
		}
		
		return false;
	}

	public function __construct()
	{
	
	}


}