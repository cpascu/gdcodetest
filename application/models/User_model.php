<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * User model.
 *
 * @author Cosmin Pascu <csmnpsc@gmail.com>
 */
class User_model extends BASE_Model {
	private $_tableName  = 'users';
	private $_primaryKey = 'userId';

	public function __construct()
	{
		parent::__construct();
	}

	protected function _get_table_name()
	{
		return $this->_tableName;
	}

	protected function _get_primary_key()
	{
		return $this->_primaryKey;
	}

	protected function _sanitize (array $data)
	{
		foreach ($data as $index => &$d)
		{
			switch ($index)
			{
				case 'userId':
					$d = (int)$d;
					break;
				case 'password':
					$d = password_hash($d, PASSWORD_BCRYPT);
					break;
				case 'username':
				case 'email':
				case 'type':
					$d = trim($d);
					break;
			}
		}

		return $data;
	}

	/**
	 * Add a user.
	 *
	 * @param array $data The userdata.
	 *
	 * @return  mixed     The userId if successful, false otherwise.
	 */
	public function add_user(array $data)
	{
		if ( empty($data['email']) ||
			 empty($data['type'] ))
		{
			log_message('error', __METHOD__ . ': Failed to add user, missing required data.');
			return false;
		}

		$userId = $this->add_record($data);

		return (false !== $userId) ? $userId : false;
	}

	public function get_user(array $data)
	{
		if (!empty($data['username']) || !empty($data['email']))
		{
			$user = $this->get_record($data);
			// there will be only 1 result, unique column
			return !empty($user) ? $user[0] : false;
		}
		else
		{
			log_message('error', __METHOD__ . ': Missing required params.');

			return false;
		}
	}
}
