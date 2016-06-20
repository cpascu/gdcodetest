<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . '/../traits/ValidationRules.php');

class Authenticate extends BASE_Controller {
	use ValidationRules;

	public function __construct()
	{
		parent::__construct();
	}

	public function index() {}
	
	public function register()
	{
		$this->load->helper('form');
		$this->_pageLayout = 'register';
		$this->_build();
	}

	public function login()
	{
		$this->load->helper('form');
		$this->_pageLayout = 'login';
		$this->_build();
	}

	public function login_post()
	{
		$this->load->library('form_validation');

		$response = array(
			'success' => false
		);

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$response['errors']  = $this->form_validation->error_array();
		}
		else
		{
			$this->load->model('user_model');

			$data = array(
				'username' => $this->input->post('username', true),
			);

			$user = $this->user_model->get_user($data);

			if (false !== $user && password_verify($this->input->post('password'), $user->password))
			{
				$response['success'] = true;
			}
			else
			{
				$response['errors']['general'] = 'Credentials were invalid.';	
			}
		}

		$this->api_response($response);
	}

	public function register_post()
	{
		$this->load->library('form_validation');

		$response = array(
			'success' => false
		);

		$this->form_validation->set_rules('username',     'Username',         'required|max_length[15]|callback_duplicate_check[username]');
		$this->form_validation->set_rules('email',        'Email',            'required|valid_email|callback_duplicate_check[email]');
		$this->form_validation->set_rules('password',     'Password',         'required');
		$this->form_validation->set_rules('passwordConf', 'Confirm Password', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$response['errors']  = $this->form_validation->error_array();
		}
		else
		{
			$this->load->model('user_model');

			$data = array(
				'username' => $this->input->post('username', true),
				'email'    => $this->input->post('email', true),
				'password' => $this->input->post('password', true),
				'type'     => 'site'
			);

			if (false === $this->user_model->add_user($data))
			{
				$response['errors']['general'] = 'Failed to add account.';
			}
			else
			{
				$response['success'] = true;
			}
		}

		$this->api_response($response);
	}

	public function facebook_post()
	{
		$this->load->library('facebook');
	}

	public function github_post()
	{
		$this->load->library('github');	
	}
}