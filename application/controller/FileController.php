<?php

class FileController extends Core_Controller
{

	public function indexAction()
	{
		$fileId = $this->getRequest()->getGet('file');
		$file = Service_File::getById($fileId);

		$this->file($file->getType(), $file->getContent());
	}

}