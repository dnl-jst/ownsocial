<?php

namespace Core\Controller;

class Response
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