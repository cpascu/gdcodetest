<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Custom extension of the CI model. Provides some common database functions.
 *
 * @author Cosmin Pascu <csmnpsc@gmail.com>
 */
abstract class BASE_Model extends CI_Model
{
	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();

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

	/**
	 * Generic add record to database.
	 *
	 * @param array   $data     The record data.
	 * @param boolean $sanitize Wether to sanitize the input before insert.
	 *
	 * @return mixed      The primary id of the newly added record, or false if failed.
	 */
	public function add_record(array $data, $sanitize = true)
	{
		if ($sanitize)
		{
			$data = $this->_sanitize($data);
		}

		$this->db->insert($this->_get_table_name(), $data);

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
	 * @param  array  $data    The params to search by.
	 * @param  string $columns Custom columns to select.
	 *
	 * @return mixed           The records found, empty array if nothing found, or false if failed.
	 */
	public function get_record(array $data, $columns = false) 
	{
		if (false !== $columns)
		{
			$this->db->select($columns);
		}
		else
		{
			$this->db->select('*');
		}
		
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
	 * @param array  $data The data to update
	 * @param boolean $sanitize Wether to sanitize the input before insert.
	 *
	 * @return boolean      True if successful, false otherwise.
	 */
	public function update_record(array $data, $sanitize = true)
	{
		$pKey = $this->_get_primary_key();

		if (!array_key_exists($pKey, $data) || 
			!is_numeric($data[$pKey]))
		{
			log_message('error', __METHOD__ . ': Invalid primary key.');
			return false;
		}

		if ($sanitize)
		{
			$data = $this->_sanitize($data);
		}

		$primaryKey = $data[$pKey];

		// remove primary key from input data
		unset($data[$pKey]);

		$query = $this->db->where($pKey, $primaryKey)
							->update($this->_get_table_name(), $data);

		return $query;
	}

	/**
	 * Generic remove record from database.
	 *
	 * @param  int $primaryId The id of the record.
	 *
	 * @return boolean        True if delete successful, false otherwise.
	 */
	public function delete_record($primaryId)
	{
		if (!is_numeric($primaryId))
		{
			log_message('error', __METHOD__ . ': Primary key must be numeric.');

			return false;
		}

		$primaryId = (int)$primaryId;

		$query = $this->db->where($this->_get_primary_key(), $primaryId)->delete($this->_get_table_name());
		
		return false === $query ? false : true;
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

}