<?php

class GroupController extends Core_Controller
{

	public function indexAction()
	{
		$groupId = $this->getRequest()->getGet('id');
		$this->_view->group = Service_Group::getById($groupId);
	}

	public function addAction()
	{
		$groupName = $this->getRequest()->getPost('name');

		$group = new Model_Group();
		$group->setName($groupName);
		$group->setCreated(time());

		$groupId = Service_Group::store($group);

		$this->json(array('redirect' => '/group/?id=' . $groupId));
	}

}