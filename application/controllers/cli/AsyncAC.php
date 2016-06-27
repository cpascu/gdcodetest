<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ActiveCampaign CLI controller, allows commands to be run from CLI.
 *
 * @author  Cosmin Pascu <csmnpsc@gmail.com>
 */
class Asyncac extends CI_Controller {
	private $_pid = false;

	public function __construct()
	{
		parent::__construct();

		$this->_pid = getmypid();

		// log start of async execution
		if ($this->input->is_cli_request() && isset($_SERVER['argv'][1]))
		{
			log_message('info', __METHOD__ . ": Started async command: (pid: {$this->_pid}) {$_SERVER['argv'][1]}");
		}
	}

	/**
	 * Sync a contact with Active Campaign.
	 *
	 * @param string $contactId The contact id in our database.
	 *
	 * @return void
	 */
	public function sync_contact($contactId)
	{
		if (!$this->input->is_cli_request())
		{
			$this->_finish(1);
		}

		if (empty($contactId))
		{
			log_message('error', __METHOD__ . ': Missing contactId.');
			$this->_finish(1);
		}

		$this->load->model('contacts_model');
		$contact = $this->contacts_model->get_record(array('contactId' => $contactId));
		
		$contact = !empty($contact[0]) ? (array)$contact[0] : false;

		if (!empty($contact))
		{
			$this->load->library('activecampaign_wrapper');
			$acId = $this->activecampaign_wrapper->sync_contact($contact);

			if (!empty($acId))
			{
				$this->contacts_model->update_record(array(
					'contactId' => (int)$contact['contactId'],
					'acId'      => (int)$acId,
					'synced'    => 1
				), false);
			}	
		}
		else
		{
			log_message('error', __METHOD__ . ": Could not find contact by contactId: {$contactId}");
			$this->_finish(1);
		}
		
		$this->_finish(0);
	}

	/**
	 * Delete a contact from Active Campaign.
	 *
	 * @param string $acId The activecampaign contact id.
	 *
	 * @return void
	 */
	public function delete_contact($acId)
	{
		if (!$this->input->is_cli_request())
		{
			$this->_finish(1);
		}

		if (empty($acId))
		{
			log_message('error', __METHOD__ . ': Missing acId.');
			$this->_finish(1);
		}

		$this->load->library('activecampaign_wrapper');
		$this->activecampaign_wrapper->delete_contact($acId);
	}

	private function _finish($exitCode = 0)
	{
		$exitCode = (int)$exitCode;

		if ($this->input->is_cli_request() && isset($_SERVER['argv'][1]))
		{
			log_message('info', __METHOD__ . ": Finished async command: (pid: {$this->_pid}) {$_SERVER['argv'][1]}");
		}

		exit($exitCode);
	}
}