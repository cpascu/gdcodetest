<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts extends BASE_Controller {
	public function __construct()
	{
		parent::__construct();

		// first check if logged in
		$this->load->library('user');

		if (!$this->user->is_logged_in())
		{
			redirect('login');
		}
	}

	public function index()
	{
		$this->load->model('contacts_model');
		$this->load->helper('form');

		$userId   = $this->user->get_userid();
		$contacts = $this->contacts_model->get_record(array('userId', $userId));
		
		$this->pageData['js']['userId']   = $userId;
		$this->pageData['js']['contacts'] = $contacts;

		$this->_pageLayout = 'contacts';
		$this->_build();
	}

	public function add_contact_post()
	{
		$this->load->library('form_validation');

		$response = array(
			'success' => false
		);

		$this->form_validation->set_rules('name', 'Name', 'required|max_length[15]');

		if ($this->form_validation->run() == FALSE)
		{
			$response['errors']  = $this->form_validation->error_array();
		}
		else
		{
			$this->load->model('contacts_model');

			$data = $this->input->post(NULL, true);

			$contactId = $this->contacts_model->add_contact($data);

			if (false !== $contactId)
			{
				$response['success']   = true;
				$response['contactId'] = $contactId;
			}
			else
			{
				$response['errors']['general'] = 'Failed to add contact';
			}
		}

		$this->_api_response($response);
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
