<?php

namespace Application\Controller;

use Core\Controller;
use Service\User;
use Service\File;
use Model\File as FileModel;

class Profile extends Controller
{

	public function indexAction()
	{
		$userId = $this->getRequest()->getGet('user');

		if (!$userId) {
			$this->redirect('/');
		}

		$this->_view->user = User::getById($userId);
	}

	public function meAction()
	{
		$this->_view->user = User::getCurrent();
		$this->_view->render('profile/index.phtml');
	}

	public function updateAction()
	{
		$user = $this->_currentUser;

		$key = $this->getRequest()->getPost('key');
		$value = $this->getRequest()->getPost('value');

		$updateableKeys = array(
			'department'
		);

		if (in_array($key, $updateableKeys)) {

			$method = 'set' . ucfirst($key);
			$user->$method($value);

			User::store($user);

			$success = true;

		} else {
			$success = false;
		}

		$this->json(array('success' => $success));

	}

	public function changeLanguageAction()
	{
		$user = $this->_currentUser;

		$language = $this->getRequest()->getPost('language');

		if (!in_array($language, array('en', 'de'))) {

			$this->json(array('success' => false));
			return;
		}

		$user->setLanguage($language);
		User::store($user);

		$this->json(array('success' => true));
	}

	public function savePicAction()
	{
		$allowedExtensions = array('gif', 'jpeg', 'jpg', 'png');
		$allowedExtensions = array_map('preg_quote', $allowedExtensions);
		$regex = '/\.('.implode('|', $allowedExtensions).')$/i';

		if (!isset($_FILES['img']['tmp_name'])) {

			$this->json(array(
				'status' => 'error',
				'message' => 'something went wrong1'
			));
			return;

		}

		$file =& $_FILES['img'];

		if (!preg_match($regex, $file['name'])) {

			$this->json(array(
				'status' => 'error',
				'message' => 'something went wrong2'
			));
			return;

		}

		if ($file['error'] > 0)
		{
			$this->json(array(
				'status' => 'error',
				'message' => 'ERROR Return Code: '. $file['error']
			));
			return;
		}

		$fileName = $file['tmp_name'];

		$data = getimagesize($fileName);

		$width = $data[0];
		$height = $data[1];
		$mime = $data['mime'];

		$dbFile = new FileModel();
		$dbFile->setUserId($this->_currentUser->getId());
		$dbFile->setContent(file_get_contents($fileName));
		$dbFile->setType($mime);
		$dbFile->setCreated(time());

		$newFileId = File::store($dbFile);

		$this->json(array(
			'status' => 'success',
			'url' => '/file/?file=' . $newFileId,
			'width' => $width,
			'height' => $height
		));
	}

	public function cropPicAction()
	{
		$request = $this->getRequest();

		$imgUrl = $request->getPost('imgUrl');
		$queryString = parse_url($imgUrl, PHP_URL_QUERY);
		parse_str($queryString, $params);

		$fileId = $params['file'];

		$imgInitW = $request->getPost('imgInitW');
		$imgInitH = $request->getPost('imgInitH');
		$imgW = $request->getPost('imgW');
		$imgH = $request->getPost('imgH');
		$imgY1 = $request->getPost('imgY1');
		$imgX1 = $request->getPost('imgX1');
		$cropW = $request->getPost('cropW');
		$cropH = $request->getPost('cropH');
		$jpegQuality = 100;

		$file = File::getById($fileId);

		if ($file->getUserId() != $this->_currentUser->getId())
		{
			$this->json(array(
				'status' => 'error',
				'message' => 'permission denied'
			));
			return;
		}

		$rSourceImage = imagecreatefromstring($file->getContent());
		$rResizedImage = imagecreatetruecolor($imgW, $imgH);

		imagecopyresampled(
			$rResizedImage,
			$rSourceImage,
			0,
			0,
			0,
			0,
			$imgW,
			$imgH,
			$imgInitW,
			$imgInitH
		);


		$rDestImage = imagecreatetruecolor($cropW, $cropH);

		imagecopyresampled(
			$rDestImage,
			$rResizedImage,
			0,
			0,
			$imgX1,
			$imgY1,
			$cropW,
			$cropH,
			$cropW,
			$cropH
		);

		ob_start();

		imagejpeg($rDestImage, null, $jpegQuality);

		$file->setContent(ob_get_clean());

		File::store($file);

		$this->_currentUser->setPortraitFileId($fileId);

		User::store($this->_currentUser);

		$aResponse = array(
			'status' => 'success',
			'url' => '/file/?file=' . $file->getId()
		);

		$this->json($aResponse);
	}

}