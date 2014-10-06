<?php

class IndexController extends Core_Controller
{

	public function indexAction()
	{
		if (!Service_User::getCurrent()) {
			return $this->redirect('/index/login/');
		}
	}

	public function loginAction()
	{
		if ($this->getRequest()->isPost()) {

			$email = $this->getRequest()->getPost('email');
			$password = $this->getRequest()->getPost('password');

			try {
				$user = Service_User::getByEmail($email);

				if (password_verify($password, $user->getPassword())) {
					$_SESSION['user.id'] = $user->getId();

					$this->redirect('/');
				}
			} catch (Core_Query_NoResultException $e) {
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