<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User library.
 */
class User {
	private $_CI;

	public function __construct()
	{
		$this->_CI =& get_instance();
	}

	public function is_logged_in()
	{
		if (empty($this->_CI->session->user_id))
		{
			return false;
		}

		return true;
	}

	public function login($userId, $userEmail)
	{
		if (empty($userId) || empty($userEmail))
		{
			log_message('error', __METHOD__ . ': Missing or invalid params.');

			return false;
		}

		$this->_CI->session->user_id    = $userId;
		$this->_CI->session->user_email = $userEmail;

		return true;
	}

	public function logout()
	{
		session_destroy();
		return true;
	}

	public function get_userid()
	{
		return $this->_CI->session->user_id;
	}
}