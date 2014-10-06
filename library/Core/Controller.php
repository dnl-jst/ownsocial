<?php

class Core_Controller
{

	/** @var Core_Controller_Request */
	protected $_request;

	/** @var Core_Controller_Response */
	protected $_response;

	/** @var Core_View */
	protected $_view;

	/** @var bool */
	protected $_disableLayout = false;

	/** @var bool */
	protected $_disableRender = false;

	/** @var Model_User */
	protected $_currentUser;

	/** @var array */
	protected $_config;

	public function __construct(Core_Controller_Request $request, Core_Controller_Response $response, Core_View $view)
	{
		$this->_request = $request;
		$this->_response = $response;
		$this->_view = $view;
		$this->_currentUser = Service_User::getCurrent();
		$this->_config = Service_Config::getAll();
	}

	protected function getRequest()
	{
		return $this->_request;
	}

	protected function getResponse()
	{
		return $this->_response;
	}

	public function dispatch($method)
	{
		$this->$method();

		if (!$this->_disableRender) {
			$this->_response->setOuput($this->_view->_render($this->_disableLayout));
		}
	}

	public function json($data)
	{
		$this->_disableRender = true;
		$this->_response->setOuput(json_encode($data));
	}

	public function file($type, $content)
	{
		$this->_disableRender = true;
		header('Content-Type: ' . $type);
		$this->_response->setOuput($content);
	}

	public function redirect($url)
	{
		header('Location: ' . $url);
		exit();
	}

}