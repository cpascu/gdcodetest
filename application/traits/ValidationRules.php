<?php defined('BASEPATH') || exit('No direct script access allowed');

trait ValidationRules
{
	/**
	 * Checks if username is taken.
	 *
	 * @param  string $username The username to check.
	 *
	 * @return bool False if username exists, true if available
	 */
	public function duplicate_check($value, $params)
	{
		$params = explode(',', $params);

		$this->load->model($params[0]);

		if (!empty($this->$params[0]->get_record(array($params[1] => $value))))
		{
			$this->form_validation->set_message('duplicate_check', "The {$params[1]} is already used.");
			return false;
		}

		return true;
	}

	public function duplicate_contact_email($value, $contactId)
	{
		$this->load->model('contacts_model');
		if ($this->contacts_model->is_email_taken($value, $contactId))
		{
			$this->form_validation->set_message('duplicate_contact_email', 'This email is already used for another contact.');
			return false;
		}

		return true;
	}
}