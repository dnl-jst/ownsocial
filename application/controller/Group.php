<?php

namespace Application\Controller;

use Core\Controller;
use Service\UserGroup as UserGroupService;
use Model\UserGroup as UserGroupModel;
use Service\Group as GroupService;
use Model\Group as GroupModel;

class Group extends Controller
{

	public function indexAction()
	{
		$groupId = $this->getRequest()->getGet('id');
		$this->_view->group = GroupService::getById($groupId);
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

}