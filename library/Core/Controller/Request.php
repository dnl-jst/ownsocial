<?php

namespace Core\Controller;

class Request
{

	/** @var string */
	protected $controller;

	/** @var string */
	protected $action;

	/**
	 * @return string
	 */
	public function getAction()
	{
		return $this->action;
	}

	/**
	 * @param string $action
	 */
	public function setAction($action)
	{
		$this->action = $action;
	}

	/**
	 * @return string
	 */
	public function getController()
	{
		return $this->controller;
	}

	/**
	 * @param string $controller
	 */
	public function setController($controller)
	{
		$this->controller = $controller;
	}

	/**
	 * @return bool
	 */
	public function isSecure()
	{
		if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) === 'on') {
			return true;
		}

		return false;
	}

	public function getPath()
	{
		$queryString = $_SERVER['REQUEST_URI'];
		$parts = explode('?', $queryString);
		return $parts[0];
	}

	public function getGet($key, $default = null)
	{
		if (isset($_GET[$key])) {
			return $_GET[$key];
		}

		return $default;
	}

	public function getPost($key, $default = null)
	{
		if (isset($_POST[$key])) {
			return $_POST[$key];
		}

		return $default;
	}

	public function isPost()
	{
		return (strtolower($_SERVER['REQUEST_METHOD']) === 'post');
	}

}