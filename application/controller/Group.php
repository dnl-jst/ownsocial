<?php

namespace Application\Controller;

use Core\Controller;
use Core\Query\NoResultException;
use Service\UserGroup as UserGroupService;
use Model\UserGroup as UserGroupModel;
use Service\Group as GroupService;
use Model\Group as GroupModel;
use Service\File as File;
use Model\File as FileModel;
use Service\Feed as FeedService;
use Core\Helper\FeedFormatter;
use Core\Helper\DateSince;

class Group extends Controller
{

	public function indexAction()
	{
		$groupId = $this->getRequest()->getGet('id');
		$group = GroupService::getById($groupId);

		try {
			$userGroup = UserGroupService::get($this->_currentUser->getId(), $groupId);
		} catch (NoResultException $e) {
			$userGroup = false;
		}

		if ($group->getType() === 'hidden' && !$userGroup) {
			$this->redirect('/');
			return;
		}

		$this->_view->group = $group;
		$this->_view->userGroup = $userGroup;
		$this->_view->isGroupAdmin = ($userGroup && $userGroup->getRole() === UserGroupModel::ROLE_ADMIN);
	}

	public function addAction()
	{
		$groupName = $this->getRequest()->getPost('name');
		$groupType = $this->getRequest()->getPost('type');

		if (!in_array($groupType, GroupModel::$types)) {
			$groupType = GroupModel::TYPE_HIDDEN;
		}

		$group = new GroupModel();
		$group->setName($groupName);
		$group->setType($groupType);
		$group->setCreated(time());

		$groupId = GroupService::store($group);

		$userGroup = new UserGroupModel();
		$userGroup->setUserId($this->_currentUser->getId());
		$userGroup->setGroupId($groupId);
		$userGroup->setConfirmed(time());
		$userGroup->setRole(UserGroupModel::ROLE_ADMIN);

		UserGroupService::store($userGroup);

		$this->json(array('status' => 'success', 'redirect' => '/group/?id=' . $groupId));
	}

	public function savePicAction()
	{
		$groupId = $this->getRequest()->getPost('group');

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
		$dbFile->setUserId(null);
		$dbFile->setGroupId($groupId);
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
		$group = GroupService::getById($file->getGroupId());

		/**if ($file->getUserId() != $this->_currentUser->getId())
		{
			$this->json(array(
				'status' => 'error',
				'message' => 'permission denied'
			));
			return;
		}**/

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

		$group->setPortraitFileId($fileId);

		GroupService::store($group);

		$aResponse = array(
			'status' => 'success',
			'url' => '/file/?file=' . $file->getId()
		);

		$this->json($aResponse);
	}

	public function feedAction()
	{
		$groupId = $this->getRequest()->getGet('id');
		$parentPostId = $this->getRequest()->getPost('parent_post', null);

		$feed = FeedService::getGroupFeed($groupId, $parentPostId, $this->_currentUser->getId());
		$data = array();

		foreach ($feed as &$post)
		{
			$post_array = $post->toArray();

			$post_array['content'] = FeedFormatter::format($post_array['content']);
			$post_array['created'] = DateSince::format($post_array['created']);

			if ($post_array['groupId']) {
				$post_array['group'] = GroupService::getById($post_array['groupId'])->toArray();
			}

			$data[] = $post_array;
		}

		if ($parentPostId) {
			$data = array_reverse($data);
		}

		$this->json(array('last_update' => time(), 'posts' => $data));
	}

}