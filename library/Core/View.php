<?php

class Core_View
{

	protected $_config = array();
	protected $_currentUser = null;
	protected $_templatePath;
	protected $_templateFile;
	protected $_templateVars = array();
	protected $_encoding = 'utf-8';
	protected $_layout = null;
	protected $_rendered = false;

	public function __construct($templatePath, $templateFile)
	{
		$this->_config = Service_Config::getAll();
		$this->_currentUser = Service_User::getCurrent();
		$this->_templatePath = $templatePath;
		$this->_templateFile = $templateFile;
		$this->_layout = APPLICATION_ROOT . '/application/templates/layouts/default.phtml';
	}

	public function __set($name, $value)
	{
		$this->_templateVars[$name] = $value;
	}

	public function __get($name)
	{
		return $this->_templateVars[$name];
	}

	public function render($templateFile)
	{
		$this->_templateFile = $templateFile;
	}

	public function _render($disableLayout)
	{
		if (!$this->_rendered)
		{
			$this->_rendered = true;

			ob_start();

			extract($this->_templateVars);

			include($this->_templatePath . $this->_templateFile);

			$html = ob_get_clean();

			if (!$disableLayout) {
				ob_start();
				include($this->_layout);
				$html = ob_get_clean();
			}

			return $html;
		}
	}

	protected function escape($var)
	{
		return htmlspecialchars($var, ENT_COMPAT, $this->_encoding);
	}

}