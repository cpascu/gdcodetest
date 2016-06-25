<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . '/../traits/ValidationRules.php');

class Authenticate extends BASE_Controller {
	use ValidationRules;

	public function __construct()
	{
		parent::__construct();
	}

	public function register()
	{
		$this->load->helper('form');
		$this->_pageLayout = 'register';
		$this->_build();
	}

	public function login()
	{
		$this->load->helper('form');
		$this->load->config('facebook');
		$this->load->config('github');
		$this->load->library('github');

		$this->pageData['githubLogin'] = $this->github->get_login_url();

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
				$this->load->library('user');
				$this->user->login($user->userId, $user->email);

				$response['success'] = true;
			}
			else
			{
				$response['errors']['general'] = 'Credentials were invalid.';	
			}
		}

		$this->_api_response($response);
	}

	public function register_post()
	{
		$this->load->library('form_validation');

		$response = array(
			'success' => false
		);

		$this->form_validation->set_rules('username',     'Username',         'required|max_length[15]|callback_duplicate_check[user_model,username]');
		$this->form_validation->set_rules('email',        'Email',            'required|valid_email|callback_duplicate_check[user_model,email]');
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

			$userId = $this->user_model->add_user($data);

			if (false === $userId)
			{
				$response['errors']['general'] = 'Failed to add account.';
			}
			else
			{
				$this->load->library('user');
				$this->user->login($userId, $data['email']);

				$response['success'] = true;
			}
		}

		$this->_api_response($response);
	}

	public function facebook_post()
	{
		$this->load->library('facebook');

		$response = array(
			'success' => false
		);

		if (!empty($this->facebook->is_authenticated()))
		{
			$fbUser = $this->facebook->request('get', '/me?fields=id,name,email');
			$userId = $this->_save_from_social(array('email' => $fbUser['email'], 'type' => 'facebook'));

			if (false !== $userId)
			{
				$this->load->library('user');
				$this->user->login($userId, $fbUser['email']);
				$response['success'] = true;
			}
			else
			{
				$response['errors']['general'] = 'Failed to add account.';
			}
		}
		else
		{
			$respose['errors']['general'] = 'Could not authenticate using Facebook.';
		}

		$this->_api_response($response);
	}

	public function github_callback()
	{
		$this->load->library('github');

		// authorize with github
		if (false === $this->github->authorize())
		{
			redirect('login');
		}
		else
		{
			// get emails associated with account from github
			$emails = $this->github->curl('user/emails', 'GET');

			if (empty($emails))
			{
				log_message('error', __METHOD__ . ': Github returned no emails.');

				redirect('login');
			}

			// there could be several, pick the one set to primary
			foreach ($emails as $email)
			{
				if ($email->primary)
				{
					$primaryEmail = $email->email;
					break;
				}
			}

			// should always have primary, but if no primary, just use the first one in the list
			$primaryEmail = empty($primaryEmail) ? $emails[0]->email : $primaryEmail;
			$userId       = $this->_save_from_social(array('email' => $primaryEmail, 'type' => 'github'));

			if (false !== $userId)
			{
				$this->load->library('user');
				$this->user->login($userId, $primaryEmail);

				redirect('contacts');
			}
			else
			{
				// TODO: add general error on login screen
				redirect('login');
			}
		}
	}

	private function _save_from_social(array $data)
	{
		if (empty($data['email']) || empty($data['type']))
		{
			log_message('error', __METHOD__ . ': Invalid or missing params.');

			return false;
		}

		$this->load->model('user_model');

		$user = $this->user_model->get_user(array('email' => $data['email']));

		if (false !== $user)
		{
			// check if login type already exists
			if (false == strpos($user->type, $data['type']))
			{
				// update with new type if needed
				$data = array(
					'userId' => $user->userId,
					'type'   => $user->type . ',' . $data['type']
				);

				$this->user_model->update_record($data);
			}

			return $user->userId;
		}
		else
		{
			// user not found, let's add it
			return $this->user_model->add_user($data);
		}
	}
}