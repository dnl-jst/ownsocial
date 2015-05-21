<?php

namespace Application\Controller;

use Core\Controller;
use Core\Query\NoResultException;
use Service\User;
use Service\UserGroup as UserGroupService;
use Model\UserGroup as UserGroupModel;
use Service\Group as GroupService;
use Model\Group as GroupModel;
use Service\File as File;
use Model\File as FileModel;
use Service\Feed as FeedService;
use Core\Helper\FeedFormatter;
use Core\Helper\DateSince;
use Service\UserGroup;

class Group extends Controller
{

	public function init()
	{
		#
	}

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

		$members = User::getByGroupId($groupId);
		$requests = User::getGroupRequests($groupId);

		$this->_view->group = $group;
		$this->_view->userGroup = $userGroup;
		$this->_view->isGroupAdmin = ($userGroup && $userGroup->getRole() === UserGroupModel::ROLE_ADMIN);
		$this->_view->members = $members;
		$this->_view->requests = $requests;
	}

	public function addAction()
	{
		$groupName = $this->getRequest()->getPost('name');
		$groupDescription = $this->getRequest()->getPost('description');
		$groupType = $this->getRequest()->getPost('type');

		if (!in_array($groupType, GroupModel::$types)) {
			$groupType = GroupModel::TYPE_HIDDEN;
		}

		$group = new GroupModel();
		$group->setName($groupName);
		$group->setDescription($groupDescription);
		$group->setType($groupType);
		$group->setCreated(time());

		$groupId = GroupService::store($group);

		$userGroup = new UserGroupModel();
		$userGroup->setUserId($this->_currentUser->getId());
		$userGroup->setGroupId($groupId);
		$userGroup->setCreatedBy($this->_currentUser->getId());
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

	public function suggestMembersAction()
	{
		$groupId = $this->getRequest()->getGet('id');
		$search = $this->getRequest()->getPost('search');
		$users = array();

		try {

			$userGroup = UserGroup::get($this->_currentUser->getId(), $groupId);

			if ($userGroup->getRole() !== UserGroupModel::ROLE_ADMIN) {

				$this->json($users);
				return;
			}

		} catch (NoResultException $e) {

			$this->json($users);
			return;

		}

		if (!$search) {

			$this->json($users);
			return;

		}

		if ($this->_config['network_type']['value'] === 'public') {

			try {
				$resultUsers = User::searchContactsNotInGroup($search, $this->_currentUser->getId(), $groupId);

				foreach($resultUsers as $user) {

					try {
						UserGroup::get($user->getId(), $groupId);
						continue;
					} catch (NoResultException $e) {}

					$users[] = array(
						'id' => $user->getId(),
						'first_name' => $user->getFirstName(),
						'last_name' => $user->getLastName(),
						'department' => $user->getDepartment(),
						'portrait_file_id' => $user->getPortraitFileId()
					);
				}

			} catch (NoResultException $e) {}

		} else {

			try {
				$resultUsers = User::searchNotInGroup($search, $groupId);

				foreach($resultUsers as $user) {

					try {
						UserGroup::get($user->getId(), $groupId);
						continue;
					} catch (NoResultException $e) {}

					$users[] = array(
						'id' => $user->getId(),
						'first_name' => $user->getFirstName(),
						'last_name' => $user->getLastName(),
						'department' => $user->getDepartment(),
						'portrait_file_id' => $user->getPortraitFileId()
					);
				}
			} catch (NoResultException $e) {}

		}

		$this->json($users);
	}

	public function addMembersAction()
	{
		$groupId = $this->getRequest()->getGet('id');
		$group = GroupService::getById($groupId);

		$newMembers = $this->getRequest()->getPost('new_members');

		try {

			$userGroup = UserGroup::get($this->_currentUser->getId(), $groupId);

			if ($userGroup->getRole() !== UserGroupModel::ROLE_ADMIN) {

				$this->json(array('success' => false));
				return;
			}

		} catch (NoResultException $e) {

			$this->json(array('success' => false));
			return;

		}

		if (is_array($newMembers)) {

			foreach ($newMembers as $newMemberId) {

				$newMember = User::getById($newMemberId);

				# continue if connection already exists
				try {
					UserGroup::get($newMemberId, $groupId);
					continue;
				} catch (NoResultException $e) {}

				$userGroup = new UserGroupModel();
				$userGroup->setUserId($newMemberId);
				$userGroup->setGroupId($groupId);
				$userGroup->setCreatedBy($this->_currentUser->getId());
				$userGroup->setConfirmed(null);
				$userGroup->setRole(UserGroupModel::ROLE_MEMBER);

				UserGroup::store($userGroup);
				User::sendNewGroupRequestMail($this->getTranslator(), $this->getRequest(), $this->_currentUser, $newMember, $group);
			}

		}

		$this->json(array(
			'success' => true
		));
	}

	public function acceptInvitationAction()
	{
		$groupId = $this->getRequest()->getPost('group');
		$success = false;

		$userGroup = UserGroup::get($this->_currentUser->getId(), $groupId);

		if ($userGroup->getUserId() != $userGroup->getCreatedBy()) {

			$userGroup->setConfirmed(time());
			UserGroup::store($userGroup);
			$success = true;

		}

		$this->json(array('success' => $success));
	}

	public function declineInvitationAction()
	{
		$groupId = $this->getRequest()->getPost('group');

		UserGroup::delete($this->_currentUser->getId(), $groupId);

		$this->json(array('success' => true));
	}

}