<?php

namespace Application\Controller;

use Core\Controller;
use Core\Query\NoResultException;
use Service\User;

class Index extends Controller
{

	public function indexAction()
	{
		if (!User::getCurrent()) {
			$this->redirect('/index/login/');
			return;
		}
	}

	public function loginAction()
	{
		if ($this->getRequest()->isPost()) {

			$email = $this->getRequest()->getPost('email');
			$password = $this->getRequest()->getPost('password');

			try {
				$user = User::getByEmail($email);

				if (password_verify($password, $user->getPassword())) {
					$_SESSION['user.id'] = $user->getId();

					$this->redirect('/');
				}
			} catch (NoResultException $e) {
				# todo
			}
		}
	}

	public function logoutAction()
	{
		unset($_SESSION['user.id']);
		$this->redirect('/');
	}

}