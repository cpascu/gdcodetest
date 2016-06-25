<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(dirname(__FILE__) . '/../traits/ValidationRules.php');

class Contacts extends BASE_Controller {
	use ValidationRules;

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
		$contacts = $this->contacts_model->get_record(array('userId' => $userId));

		$this->pageData['js']['userId']   = $userId;
		$this->pageData['js']['contacts'] = $contacts;

		$this->_pageLayout = 'contacts';
		$this->_build();
	}

	public function add_contact_post()
	{
		$response = array(
			'success' => false
		);

		$this->load->library('form_validation');
		$this->_set_main_rules();

		if ($this->form_validation->run() == FALSE)
		{
			$response['errors']  = $this->form_validation->error_array();
		}
		else
		{
			$this->load->model('contacts_model');

			$data           = $this->input->post(NULL, true);
			$data['userId'] = $this->user->get_userid();
			$contactId      = $this->contacts_model->add_contact($data);

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

	public function update_contact_post()
	{
		$response = array(
			'success' => false
		);

		$this->load->library('form_validation');

		$this->form_validation->set_rules('contactId', 'Contact ID', 'required');
		$this->_set_main_rules();
		

		if ($this->form_validation->run() == FALSE)
		{
			$response['errors']  = $this->form_validation->error_array();
		}
		else
		{
			$this->load->model('contacts_model');
			$data = $this->input->post(NULL, true);

			// check if email is taken
			$this->form_validation->reset_validation();
			$this->form_validation->set_rules('email', 'Email', "");

			if ($this->form_validation->run() == FALSE)
			{
				$response['errors']  = $this->form_validation->error_array();
			}
			else
			{
				if ($this->contacts_model->update_contact($data))
				{
					$response['success'] = true;
				}
				else
				{
					$response['errors']['general'] = 'Failed to update contact.';
				}
			}
		}

		$this->_api_response($response);
	}

	public function delete_contact_post()
	{

	}

	public function search_contact_post()
	{

	}

	/**
	 * Sets standard validation rules for updating or inserting a new contact.
	 */
	private function _set_main_rules()
	{
		$this->form_validation->set_rules('name',      'Name',          'required|max_length[15]');
		$this->form_validation->set_rules('surname',   'Surname',       'max_length[15]');
		$this->form_validation->set_rules('phone',     'Phone',         'max_length[20]');
		$this->form_validation->set_rules('custom1',   'Custom Fields', 'max_length[255]');
		$this->form_validation->set_rules('custom2',   'Custom Fields', 'max_length[255]');
		$this->form_validation->set_rules('custom3',   'Custom Fields', 'max_length[255]');
		$this->form_validation->set_rules('custom4',   'Custom Fields', 'max_length[255]');
		$this->form_validation->set_rules('custom5',   'Custom Fields', 'max_length[255]');

		// if it's an update, contact email might simply be the same, ignore checks within same contactId
		if (isset($_POST['contactId']))
		{
			$contactId = $this->input->post('contactId', true);
			$this->form_validation->set_rules('email', 'Email', "valid_email|max_length[255]|callback_duplicate_contact_email[{$contactId}]");
		}
		else
		{
			$this->form_validation->set_rules('email', 'Email', 'valid_email|max_length[255]|callback_duplicate_check[contacts_model,email]');
		}
	}
}
