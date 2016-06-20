<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once("../third_party/activecampaign/autoload.php");

/**
 * Active campaign wrapper.
 */
class Activecampaign {
	private $_ac = false;

	public function __construct()
	{
		$this->_ac = new ActiveCampaign(ACTIVECAMPAIGN_URL, ACTIVECAMPAIGN_API_KEY);
	}

	public function add($data)
	{

	}

	public function update($data) 
	{

	}
}