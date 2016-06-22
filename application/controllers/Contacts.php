<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts extends BASE_Controller {
	public function __construct()
	{
		// first check if logged in
		$this->load->library('user');

		if (!$this->user->is_logged_in())
		{
			redirect('login');
		}

		parent::__construct();
	}

	public function index()
	{
		$userId = $this->user->get_user_id();

		// get all contacts for user id
		// maybe add paging
		// load view
	}

	public function add_contact_post()
	{

	}

	public function delete_contact_post()
	{

	}

	public function update_contact_post()
	{

	}

	public function search_contact_post()
	{

	}
}
