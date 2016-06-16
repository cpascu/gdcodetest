<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Custom extension of the CI model. Provides some common database functions.
 *
 * @author Cosmin Pascu <csmnpsc@gmail.com>
 */
abstract class Base_model extends CI_Model
{
	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}

	public function update($pKeyId, $data)
	{
		$data = $this->_sanitize($data);
	}

	public function add_record($data, $table = null)
	{
		$data = $this->_sanitize($data);

		$this->db->insert($this->_get_table_name, $data);

		if ($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
		else
		{
			log_message('error', __METHOD__ . ': Failed to insert record.')	
			
			return false;
		}
	}

	protected function _sanitize($data)
	{
		return $data;
	}

	/**
	 * Function to get the table of the model.
	 *
	 * @return string The primary key.
	 */
	abstract protected function _get_table_name();

	/**
	 * Funtion to get the primary key of the table.
	 *
	 * @return string The primary key.
	 */
	abstract protected function _get_primary_key();
}