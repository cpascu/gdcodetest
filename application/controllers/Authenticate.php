<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Authenticate extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function index() {}
	
	public function register()
	{
		$this->load->view('register');
	}

	public function login()
	{
		$this->load->view('register');
	}

	public function login_post()
	{
		// do login
	}

	public function register_post()
	{
		// do register
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