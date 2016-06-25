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
	public function duplicate_check($value, $model, $field)
	{
		$this->load->model($model);

		if (!empty($this->$model->get_record(array($field => $value))))
		{
			$this->form_validation->set_message('duplicate_check', 'The {field} is already taken.');
			return false;
		}

		return true;
	}

	public function duplicate_contact_email($value, $contactId)
	{
		$this->load->model('contacts_model');
		$this->contacts_model->is_email_taken($value, $contactId)
		{
			$this->form_validation->set_message('duplicate_check', 'This email is already used for another contact.');
			return false;
		}

		return true;
	}
}