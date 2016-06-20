<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Custom extension of the CI controller.
 */
abstract class BASE_Controller extends CI_Controller
{
	/**
	 * Page data.
	 *
	 * @var array
	 */
	public $pageData = array(
		'pageTitle' => 'TEST',
		'js'        => array()
	);

	/**
	 * Default page layout for all pages.
	 *
	 * @var string
	 */
	protected $_bodyLayout = 'default';

	/**
	 * Default page layout.
	 *
	 * @var string
	 */
	protected $_pageLayout = 'default';

	/**
	 * Basic default constructor.
	 */
	public function __construct()
	{
		parent::__construct();

		$this->pageData['js']['siteUrl'] = base_url();
		$this->pageData['js']['test']    = 'bleh';
	}

	/**
	 * Default index method, should never hit.
	 *
	 * @return void
	 */
	public function index()
	{
		$this->_build();
	}

	/**
	 * Builds the page.
	 * 
	 * @return void
	 */
	protected function _build()
	{
		$this->load->view($this->_pageLayout, $this->pageData);
	}

	protected function api_response($data) 
	{
		$this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($data));
	}
}
