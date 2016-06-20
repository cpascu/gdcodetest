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
	public function duplicate_check($value, $field)
	{
		$this->load->model('user_model');

		if (!empty($this->user_model->get_record(array($field => $value))))
		{
			$this->form_validation->set_message('duplicate_check', 'The {field} is already taken.');
			return false;
		}
	}
}