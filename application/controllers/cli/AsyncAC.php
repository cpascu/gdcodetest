<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ActiveCampaign CLI controller, allows commands to be run from CLI.
 *
 * @author  Cosmin Pascu <csmnpsc@gmail.com>
 */
class AsyncAC extends CI_Controller {
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
	 * @param string $data Firstly json_encoded and secondly urlencoded string containing contact data.
	 *
	 * @return void
	 */
	public function sync_contact($data)
	{
		if (!$this->input->is_cli_request())
		{
			$this->_finish(1);
		}

		if (empty($data))
		{
			log_message('error', __METHOD__ . ': Missing data.');
			$this->_finish(1);
		}

		$data = json_decode(urldecode($data));

		// check if was valid json
		if (empty($data))
		{
			log_message('error', __METHOD__ . ': Invalid data.');
			$this->_finish(1);
		}
		else
		{
			$this->load->library('activecampaign_wrapper');
			$this->activecampaign_wrapper->sync_contact((array)$data);
		}

		$this->_finish(0);
	}

	/**
	 * Delete a contact from Active Campaign.
	 *
	 * @param string $data Firstly json_encoded and secondly urlencoded string containing contact data, must have email.
	 *
	 * @return void
	 */
	public function delete_contact($data)
	{
		if (!$this->input->is_cli_request())
		{
			$this->_finish(1);
		}

		if (empty($data))
		{
			log_message('error', __METHOD__ . ': Missing data.');
			$this->_finish(1);
		}

		$data = json_decode(urldecode($data));

		// check if was valid json
		if (empty($data))
		{
			log_message('error', __METHOD__ . ': Invalid data.');
			$this->_finish(1);
		}
		else
		{
			$this->load->library('activecampaign_wrapper');
			$this->activecampaign_wrapper->delete_contact((array)$data);
		}
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