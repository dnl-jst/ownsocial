<?php

class SearchController extends Core_Controller
{

	public function indexAction()
	{
		if (!$this->_currentUser) {
			return $this->redirect('/index/login/');
		}

		$search = $this->getRequest()->getPost('search');

		if (!$search) {
			return $this->redirect('/');
		}

		$users = Service_User::search($search);

		$this->_view->users = $users;
	}

}