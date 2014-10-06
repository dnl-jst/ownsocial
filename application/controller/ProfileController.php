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

}