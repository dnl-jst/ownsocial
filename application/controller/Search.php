<?php

namespace Application\Controller;

use Core\Controller;
use Service\Group;
use Service\User;

class Search extends Controller
{

	public function indexAction()
	{
		if (!$this->_currentUser) {
			$this->redirect('/index/login/');
		}

		$search = $this->getRequest()->getPost('search');

		if (!$search) {
			$this->redirect('/');
		}

		$users = User::search($search);
		$groups = Group::search($search);

		$this->_view->users = $users;
		$this->_view->groups = $groups;
	}

}