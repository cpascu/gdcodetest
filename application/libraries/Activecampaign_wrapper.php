<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . '/../third_party/activecampaign/ActiveCampaign.class.php');

/**
 * Active campaign wrapper.
 */
class Activecampaign_wrapper {
	private $_CI;
	private $_AC;

	public function __construct()
	{
		$this->_CI =& get_instance();
		$this->_CI->load->config('activecampaign');
		$this->_AC = new ActiveCampaign($this->_CI->config->item('activecampaign_url'), $this->_CI->config->item('activecampaign_key'));
	}

	/**
	 * Map regular data into activecampaign api data.
	 *
	 * @param  array  $data The regular data.
	 *
	 * @return array        The activecampaign api compatible data.
	 */
	private function _get_ac_data(array $data)
	{
		// default values
		$acData = array(
			'email'               => '',
			'name'                => '',
			'surname'             => '',
			'phone'               => '',
			'field[%CUSTOM_1%,0]' => '',
			'field[%CUSTOM_2%,0]' => '',
			'field[%CUSTOM_3%,0]' => '',
			'field[%CUSTOM_4%,0]' => '',
			'field[%CUSTOM_5%,0]' => '',
			'p[1]'                => 1, // magic number - the one and only list id in our trial activecampaign application
			'status[1]'           => 1  // magic number - active
		);

		foreach ($data as $key => $d)
		{
			switch ($key)
			{
				case 'acId':
					$acData['id'] = $d;
				case 'email':
					$acData['email'] = $d;
					break;
				case 'name':
					$acData['first_name'] = $d;
					break;
				case 'surname':
					$acData['last_name'] = $d;
					break;
				case 'phone':
					$acData['phone'] = $d;
					break;
				case 'custom1':
					$acData['field[%CUSTOM_1%,0]'] = $d;
					break;
				case 'custom2':
					$acData['field[%CUSTOM_2%,0]'] = $d;
					break;
				case 'custom3':
					$acData['field[%CUSTOM_3%,0]'] = $d;
					break;
				case 'custom4':
					$acData['field[%CUSTOM_4%,0]'] = $d;
					break;
				case 'custom5':
					$acData['field[%CUSTOM_5%,0]'] = $d;
					break;
			}
		}

		return $acData;
	}

	public function sync_contact(array $data)
	{
		if (empty($data['email']))
		{
			log_message('error', __METHOD__ . ': Missing email field.');
			return false;
		}

		$acData  = $this->_get_ac_data($data);

		// the contact might already exist - AC api only lets us sync by email, but what if we want to change the email
		if (!empty($acData['id']))
		{
			// try updating by id first
			$request = $this->_AC->api('contact/edit', $acData);

			if (!(int)$request->success)
			{
				// add by sync otherwise
				unset($acData['id']);
				$request = $this->_AC->api('contact/sync', $acData);
			}
		}
		else
		{
			// add by sync, clearly does not exist
			$request = $this->_AC->api('contact/sync', $acData);
		}

		if (!(int)$request->success)
		{
			log_message('error', __METHOD__ . ": {$request->error}");
			return false;
		}

		return $request->subscriber_id;
	}

	public function delete_contact($acId)
	{
		if (empty($acId))
		{
			log_message('error', __METHOD__ . ': Missing acId.');
			return false;
		}

		$deleteData = array(
			'id' => $acId
		);

		// delete the contact from activecampaign
		$request = $this->_AC->api('contact/delete', $deleteData);

		if (!(int)$request->success)
		{
			log_message('error', __METHOD__ . ": {$request->error}");
			return false;
		}

		return true;
	}

	//TODO: maybe run api call in a thread to make the curl non blocking
}