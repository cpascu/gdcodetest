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

	public function __construct()
	{
	
	}


}