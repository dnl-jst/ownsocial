<?php

class Core_Controller_Response
{
	protected $_output;

	public function __construct()
	{
		#
	}

	public function setOuput($output)
	{
		$this->_output = $output;
	}

	public function getOutput()
	{
		return $this->_output;
	}

}