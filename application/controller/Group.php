<?php

namespace Application\Controller;

use Core\Controller;
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

		$group = new GroupModel();
		$group->setName($groupName);
		$group->setCreated(time());

		$groupId = GroupService::store($group);

		$this->json(array('redirect' => '/group/?id=' . $groupId));
	}

}