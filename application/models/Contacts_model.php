<?php defined('BASEPATH') || exit('No direct script access allowed');

require_once('Base_model.php');
/**
 * User model.
 *
 * @author Cosmin Pascu <csmnpsc@gmail.com>
 */
class Contacts_model extends Base_model {
	private $_tableName  = 'contacts';
	private $_primaryKey = 'contactId';

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
				case 'contactId':
				case 'userId':
				case 'acId':
				case 'synced':
					$d = (int)$d;
					break;
				case 'name':
				case 'surname':
				case 'email':
				case 'phone':
				case 'custom1':
				case 'custom2':
				case 'custom3':
				case 'custom4':
				case 'custom5':
					$d = trim($d);
					break;
			}
		}

		// if any data is missing during insert or update, reset back to null
		$data['surname'] = !empty($data['surname']) ? $data['surname'] : null;
		$data['email']   = !empty($data['email'])   ? $data['email']   : null;
		$data['phone']   = !empty($data['phone'])   ? $data['phone']   : null;
		$data['custom1'] = !empty($data['custom1']) ? $data['custom1'] : null;
		$data['custom2'] = !empty($data['custom2']) ? $data['custom2'] : null;
		$data['custom3'] = !empty($data['custom3']) ? $data['custom3'] : null;
		$data['custom4'] = !empty($data['custom4']) ? $data['custom4'] : null;
		$data['custom5'] = !empty($data['custom5']) ? $data['custom5'] : null;

		return $data;
	}

	public function add_contact(array $data)
	{
		// need at least a name
		if (empty($data['name']))
		{
			log_message('error', __METHOD__ . ': Failed to add contact, missing or invalid params.');
			return false;
		}

		$contactId = $this->add_record($data);

		if (false !== $contactId)
		{
			if (!empty($data['email']))
			{
				// run backgroud job to sync with ActiveCampaign
				$this->load->helper('async');
				Async::run('cli/contact/sync', $contactId);
			}

			return $contactId;
		}

		return false;
	}

	public function update_contact(array $data)
	{
		// need at least a name
		if (empty($data['contactId']) || empty($data['name']))
		{
			log_message('error', __METHOD__ . ': Failed to add contact, missing or invalid params.');
			return false;
		}

		if ($this->update_record($data))
		{
			if (!empty($data['email']))
			{
				$this->load->helper('async');
				Async::run('cli/contact/sync', $data['contactId']);
			}

			return true;
		}

		return false;
	}

	public function delete_contact($contactId)
	{
		if (empty($contactId) || !is_numeric($contactId))
		{
			log_message('error', __METHOD__ . ': Missing or invalid contactId.');
			return false;
		}

		$contact = $this->get_record(array('contactId' => $contactId));

		if (!empty($contact->acId))
		{
			$this->load->helper('async');
			Async::run('cli/contact/delete', $contact->acId);
		}

		return $this->delete_record($contactId);
	}

	public function get_contacts($userId)
	{
		if (empty($userId))
		{
			log_message('error', __METHOD__ . ': Invalid userId.');

			return false;
		}

		return $this->get_record(array('userId' => $userId), 'contactId, name, surname, email, phone, custom1, custom2, custom3, custom4, custom5');
	}

	public function is_email_taken($email, $contactId)
	{	
		return $this->db->select('*')
					->from($this->_get_table_name())
					->where('email', $email)
					->where('contactId !=', (int)$contactId)
					->count_all_results();
	}
}