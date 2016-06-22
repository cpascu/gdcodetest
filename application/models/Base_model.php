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

	public function add_record(array $data, $table = false)
	{
		$data = $this->_sanitize($data);

		$this->db->insert(false === $table ? $this->_get_table_name() : $table, $data);

		if ($this->db->affected_rows() > 0)
		{
			return $this->db->insert_id();
		}
		else
		{
			log_message('error', __METHOD__ . ': Failed to insert record.');
			
			return false;
		}
	}

	/**
	 * Get a record by params.
	 *
	 * @param  array   $data  The params to search by.
	 *
	 * @return mixed          The records found, empty array if nothing found, or false if failed.
	 */
	public function get_record(array $data) 
	{
		$this->db->select('*');
		
		foreach ($data as $col => $val)
		{
			$this->db->where($col, $val);
		}

		$query = $this->db->get($this->_get_table_name());

		if (false === $query) 
		{
			return false;
		}
		else
		{
			return $query->result();
		}
	}

	/**
	 * Generic update record.
	 *
	 * @param  array  $data The data to update
	 *
	 * @return boolean      True if successful, false otherwise.
	 */
	public function update_record(array $data)
	{
		$pKey = $this->_get_primary_key();

		if (!array_key_exists($pKey, $data) || 
			!is_numeric($data[$pKey]))
		{
			log_message('error', __METHOD__ . ': Invalid primary key.');
			return false;
		}

		$data       = $this->_sanitize($data);
		$primaryKey = $data[$pKey];

		// remove primary key from input data
		unset($data[$pKey]);

		$query = $this->db->set($data)
							->where($pKey, $primaryKey)
							->update($this->_get_table_name());

		return $query;
	}

	/**
	 * Sanitize the data before insert/update.
	 *
	 * @param  array  $data The data going into the insert/update.
	 *
	 * @return array        The sanitized data.
	 */
	protected function _sanitize(array $data)
	{
		return $data;
	}

	/**
	 * Get the table of the model.
	 *
	 * @return string The primary key.
	 */
	abstract protected function _get_table_name();

	/**
	 * Get the primary key of the table.
	 *
	 * @return string The primary key.
	 */
	abstract protected function _get_primary_key();
}