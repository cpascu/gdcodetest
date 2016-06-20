<?php defined('BASEPATH') || exit('No direct script access allowed');

require_once('Base_model.php');
/**
 * User model
 *
 * @author Cosmin Pascu <csmnpsc@gmail.com>
 */
class User_model extends Base_model {
	private $_tableName  = 'users';
	private $_primaryKey = 'userId';
	private $_columns    = array(
		'userId', 
		'username', 
		'email', 
		'password', 
		'type', 
		'token'
	);

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
		if (empty($data['username']))
		{
			log_message('error', __METHOD__ . ': Missing required params.');
			return false;
		}

		$user = $this->get_record($data);

		// there will be only 1 result, unique column
		return !empty($user) ? $user[0] : false;
	}

	protected function _sanitize (array $data)
	{
		foreach ($data as $index => &$d)
		{
			switch ($index)
			{
				case 'password':
					$d = password_hash($d, PASSWORD_BCRYPT);
					break;
				case 'userId':
					$d = (int)$d;
					break;
				case 'username':
				case 'email':
				case 'type':
				case 'token':
					break;
			}
		}

		return $data;
	}
}
