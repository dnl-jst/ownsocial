<?php

namespace Application\Controller;

use Core\Controller;
use Service\File as FileService;
use Model\File as FileModel;

class File extends Controller
{

	public function indexAction()
	{
		$fileId = $this->getRequest()->getGet('file');
		$file = FileService::getById($fileId);

		$this->file($file->getType(), $file->getContent(), $file->getName());
	}

	public function imageAction()
	{
		$fileId = $this->getRequest()->getGet('file');
		$file = FileService::getById($fileId);

		$this->image($file->getType(), $file->getContent());
	}

	public function metaAction()
	{
		$fileId = $this->getRequest()->getGet('file');
		$file = FileService::getById($fileId);

		$this->json(array(
			'type' => $file->getType(),
			'name' => $file->getName(),
			'size' => strlen($file->getContent())
		));
	}

	public function addAction()
	{
		$image = file_get_contents('php://input');

		$mime = @$_SERVER['CONTENT_TYPE'];
		$fileName = @$_SERVER['HTTP_X_FILE_NAME'];

		$file = new FileModel();
		$file->setUserId($this->_currentUser->getId());
		$file->setType($mime);
		$file->setContent($image);
		$file->setName($fileName);
		$file->setCreated(time());

		$fileId = FileService::store($file);

		$this->json(array(
			'file_id' => $fileId
		));
	}

	public function addImageAction()
	{
		$image = file_get_contents('php://input');

		$mime = getimagesizefromstring($image);

		$file = new FileModel();
		$file->setUserId($this->_currentUser->getId());
		$file->setType($mime['mime']);
		$file->setContent($image);
		$file->setCreated(time());

		$fileId = FileService::store($file);

		$this->json(array(
			'file_id' => $fileId
		));
	}

}