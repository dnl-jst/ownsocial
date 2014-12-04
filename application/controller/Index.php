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
		$messages = array();

		if ($this->getRequest()->isPost()) {

			$email = $this->getRequest()->getPost('email');
			$password = $this->getRequest()->getPost('password');

			try {
				$user = User::getByEmail($email);

				if (!$user->getEmailConfirmed()) {

					$messages[] = array(
						'class' => 'warning',
						'message' => 'login_email_not_confirmed'
					);

				} else if (!$user->getAccountConfirmed()) {

					$messages[] = array(
						'class' => 'warning',
						'message' => 'login_account_not_confirmed'
					);

				} else if (password_verify($password, $user->getPassword())) {

					$_SESSION['user.id'] = $user->getId();

					$this->redirect('/');
				}

			} catch (NoResultException $e) {

				$messages[] = array(
					'class' => 'warning',
					'message' => 'login_failed'
				);

			}
		}

		$this->_view->messages = $messages;
	}

	public function logoutAction()
	{
		unset($_SESSION['user.id']);
		$this->redirect('/');
	}

}