<?php

namespace Application\Controller;

use Core\Controller;
use Service\File as FileService;

class File extends Controller
{

	public function indexAction()
	{
		$fileId = $this->getRequest()->getGet('file');
		$file = FileService::getById($fileId);

		$this->file($file->getType(), $file->getContent());
	}

}