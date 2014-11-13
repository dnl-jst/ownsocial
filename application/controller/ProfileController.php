<?php

class ProfileController extends Core_Controller
{

	public function indexAction()
	{
		$userId = $this->getRequest()->getGet('user');

		if (!$userId) {
			$this->redirect('/');
		}

		$this->_view->user = Service_User::getById($userId);
	}

	public function meAction()
	{
		$this->_view->user = Service_User::getCurrent();
		$this->_view->render('profile/index.phtml');
	}

	public function savePicAction()
	{
		$aAllowedExtensions = array('gif', 'jpeg', 'jpg', 'png');
		$aAllowedExtensions = array_map('preg_quote', $aAllowedExtensions);
		$sRegex = '/\.('.implode('|', $aAllowedExtensions).')$/i';

		if (!isset($_FILES['img']['tmp_name'])) {

			return $this->json(array(
				'status' => 'error',
				'message' => 'something went wrong1'
			));

		}

		$aFile =& $_FILES['img'];

		if (!preg_match($sRegex, $aFile['name'])) {

			return $this->json(array(
				'status' => 'error',
				'message' => 'something went wrong2'
			));

		}

		if ($aFile['error'] > 0)
		{
			return $this->json(array(
				'status' => 'error',
				'message' => 'ERROR Return Code: '. $aFile['error']
			));
		}

		$sFileName = $aFile['tmp_name'];

		$aData = getimagesize($sFileName);

		$iWidth = $aData[0];
		$iHeight = $aData[1];
		$sMime = $aData['mime'];

		$oFile = new Model_File();
		$oFile->setUserId($this->_currentUser->getId());
		$oFile->setContent(file_get_contents($sFileName));
		$oFile->setType($sMime);
		$oFile->setCreated(time());

		$iNewFileId = Service_File::store($oFile);

		return $this->json(array(
			'status' => 'success',
			'url' => '/file/?file=' . $iNewFileId,
			'width' => $iWidth,
			'height' => $iHeight
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

		$file = Service_File::getById($fileId);

		if ($file->getUserId() != $this->_currentUser->getId())
		{
			return $this->json(array(
				'status' => 'error',
				'message' => 'permission denied'
			));
		}

		$image = getimagesizefromstring($file->getContent());
		$rImage = imagecreatefromstring($file->getContent());
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

		Service_File::store($file);

		$this->_currentUser->setPortraitFileId($fileId);

		Service_User::store($this->_currentUser);

		$aResponse = array(
			'status' => 'success',
			'url' => '/file/?file=' . $file->getId()
		);

		$this->json($aResponse);
	}

}