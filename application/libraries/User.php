<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User library.
 */
class User {
	private $_ci;

	public function __construct()
	{
		$this->ci =& get_instance();
	}

	public function is_logged_in()
	{
		// if userId is not set or session_id mismatch, not logged in
		if (session_id() !== $this->ci->session->session_id ||
			empty($this->ci->session->user_id))
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

		$this->ci->session->session_id = session_id();
		$this->ci->session->user_id    = $userId;
		$this->ci->session->user_email = $userEmail;

		return true;
	}

	public function logout()
	{
		session_destroy();

		return true;
	}
}