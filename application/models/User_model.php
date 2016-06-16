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
	private $_columns    = array('userId', 'name', 'email', 'password', 'type', 'token');

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
		if (empty($data['name']) || 
			empty($data['email'] ||
			empty($data['password'] ||
			empty($data['type'] ))
		{
			log_message('error', __METHOD__ . ': Failed to add user, missing required data.');
		}

		$this->add_record($data);
	}
}
