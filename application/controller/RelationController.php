<?php

class RelationController extends Core_Controller
{

	public function createRequestAction()
	{
		$user = $this->_currentUser;
		$relUserId = $this->getRequest()->getPost('user');

		$relation = new Model_Relation();
		$relation->setUserId($user->getId());
		$relation->setUserId2($relUserId);
		$relation->setCreated(time());
		$relation->setConfirmed(null);

		Service_Relation::store($relation);

		$this->json(true);
	}

	public function acceptRequestAction()
	{
		$user = Service_User::getCurrent();
		$relUserId = $this->getRequest()->getPost('user');

		$relation = Service_Relation::getByUsers($relUserId, $user->getId());
		$relation->setConfirmed(time());
		Service_Relation::store($relation);

		$this->json(true);
	}

	public function declineRequestAction()
	{
		$user = Service_User::getCurrent();
		$relUserId = $this->getRequest()->getPost('user');

		$relation = Service_Relation::getByUsers($relUserId, $user->getId());
		Service_Relation::delete($relation);

		$this->json(true);
	}

}