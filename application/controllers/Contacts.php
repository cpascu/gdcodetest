<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(dirname(__FILE__) . '/../traits/ValidationRules.php');

class Contacts extends BASE_Controller {
	use ValidationRules;

	private $_allowedSubmitFields = array(
		'contactId',
		'name',
		'surname',
		'email',
		'phone',
		'custom1',
		'custom2',
		'custom3',
		'custom4',
		'custom5'
	);

	public function __construct()
	{
		parent::__construct();

		// always check if logged in
		$this->load->library('user');

		if (!$this->user->is_logged_in())
		{
			redirect('login');
		}

		$this->pageData['title']  = 'Address Book';
		$this->pageData['mainJs'] = 'contacts';
	}

	public function index()
	{
		$this->load->model('contacts_model');
		$this->load->helper('form');

		$contacts                         = $this->contacts_model->get_contacts($this->user->get_userid());
		$this->pageData['js']['contacts'] = $contacts;

		$this->_pageLayout = 'contacts';
		$this->_build();
	}

	public function add_contact_post()
	{
		if (!$this->input->is_ajax_request())
		{
		   exit('No direct script access allowed');
		}

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

			// get data from post
			$data = $this->input->post(NULL, true);
			// filter the data
			$data = array_intersect_key($data, array_flip($this->_allowedSubmitFields));

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
		if (!$this->input->is_ajax_request())
		{
		   exit('No direct script access allowed');
		}

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

			// get data from post
			$data = $this->input->post(NULL, true);
			// filter the data
			$data = array_intersect_key($data, array_flip($this->_allowedSubmitFields));

			if ($this->contacts_model->update_contact($data))
			{
				$response['success'] = true;
			}
			else
			{
				$response['errors']['general'] = 'Failed to update contact.';
			}
		}

		$this->_api_response($response);
	}

	public function delete_contact_post()
	{
		if (!$this->input->is_ajax_request())
		{
		   exit('No direct script access allowed');
		}

		$response = array(
			'success' => false
		);

		$this->load->library('form_validation');

		$this->form_validation->set_rules('contactId', 'Contact ID', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$response['errors']  = $this->form_validation->error_array();
		}
		else
		{
			$this->load->model('contacts_model');

			$contactId = $this->input->post('contactId', true);

			if ($this->contacts_model->delete_contact($contactId))
			{
				$response['success'] = true;
			}
			else
			{
				$response['errors']['general'] = 'Failed to delete contact.';
			}
		}

		$this->_api_response($response);
	}

	public function search_contact_post()
	{
		if (!$this->input->is_ajax_request())
		{
		   exit('No direct script access allowed');
		}

		$response = array(
			'success' => false
		);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('q', 'Search Token', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$response['errors']  = $this->form_validation->error_array();
		}
		else
		{
			$this->load->model('contacts_model');

			$token   = $this->input->post('q', true);
			$results = $this->contacts_model->search($token);

			if (false !== $results)
			{
				$response['success'] = true;
				$response['results'] = $results;
			}
			else
			{
				$response['errors']['general'] = 'Failed to delete contact.';
			}
		}

		$this->_api_response($response);
	}

	/**
	 * Sets standard validation rules for updating or inserting a new contact.
	 */
	private function _set_main_rules()
	{
		$this->form_validation->set_rules('name',      'Name',          'required|max_length[255]');
		$this->form_validation->set_rules('surname',   'Surname',       'max_length[255]');
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
