<?php

namespace Application\Controller;

use Core\Controller;
use Service\User;

class Admin extends Controller
{

	public function init()
	{
		if ($this->_currentUser->getType() !== 'admin') {
			$this->redirect('/');
			return;
		}
	}

	public function acceptUserAction()
	{
		$userId = $this->getRequest()->getPost('id');

		$user = User::getById($userId);
		$user->setAccountConfirmed(1);

		User::store($user);
		User::sendAdminAcceptMail($this->getTranslator(), $this->getRequest(), $user);

		$this->json(array(
			'success' => true
		));
	}

	public function declineUserAction()
	{
		$userId = $this->getRequest()->getPost('id');

		User::delete($userId);

		$this->json(array(
			'success' => true
		));
	}

}