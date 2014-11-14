<?php

namespace Application\Controller;

use Core\Controller;
use Core\Query\NoResultException;
use Service\Config;
use Service\User as UserService;
use Service\Config as ConfigService;
use Model\User as UserModel;

class Register extends Controller
{

	public function indexAction()
	{

		$email = '';
		$firstName = '';
		$lastName = '';
		$errors = array();

		if ($this->getRequest()->isPost())
		{
			$email = trim($this->getRequest()->getPost('email'));
			$firstName = trim($this->getRequest()->getPost('first_name'));
			$lastName = trim($this->getRequest()->getPost('last_name'));
			$password = $this->getRequest()->getPost('password');
			$password2 = $this->getRequest()->getPost('password2');

			if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('~@[^.]+\.[^.]+~', $email)) {

				$errors['email'] = array(
					'class' => 'danger',
					'message' => 'Please enter a valid e-mail-address.'
				);

			} else {

				try {
					UserService::getByEmail($email);

					$errors['email'] = array(
						'class' => 'danger',
						'message' => 'This e-mail-address is already used.'
					);

				} catch (NoResultException $e) {}
			}

			if (!$firstName) {
				$errors['first_name'] = array(
					'class' => 'danger',
					'message' => 'Please enter your first name.'
				);
			}

			if (!$lastName) {
				$errors['last_name'] = array(
					'class' => 'danger',
					'message' => 'Please enter your last name.'
				);
			}

			if (!$password) {
				$errors['password'] = array(
					'class' => 'danger',
					'message' => 'Please enter a password.'
				);
			}

			if ($password !== $password2) {
				$errors['password2'] = array(
					'class' => 'danger',
					'message' => 'Passwords entered do not match.'
				);
			}

			if (!$errors) {

				$confirmationHash = md5(uniqid(time(), true));

				$user = new UserModel();
				$user->setEmail($email);
				$user->setEmailConfirmed(0);
				$user->setEmailConfirmationHash($confirmationHash);
				$user->setAccountConfirmed(0);
				$user->setFirstName($firstName);
				$user->setLastName($lastName);
				$user->setPassword(password_hash($password, PASSWORD_DEFAULT));
				$user->setCreated(time());
				$user->setPortraitFileId(ConfigService::getByKey('default_portrait_id'));

				UserService::store($user);
				UserService::sendConfirmationMail($this->getRequest(), $user);

				$this->redirect('/register/action-required/');
			}

		}

		$this->_view->email = $email;
		$this->_view->firstName = $firstName;
		$this->_view->lastName = $lastName;
		$this->_view->errors = $errors;

	}

	public function actionRequiredAction()
	{
		#
	}

	public function confirmAction()
	{
		$userId = $this->getRequest()->getGet('user');
		$confirmationHash = $this->getRequest()->getGet('hash');

		$messages = array();

		try {
			$user = UserService::getById($userId);
		} catch (NoResultException $e) {
			$user = false;
		}

		if ($user) {

			if ($user->getEmailConfirmed() == 1) {

				$messages[] = array(
					'class' => 'warning',
					'message' => 'You already confirmed your account.'
				);

			} else if ($user->getEmailConfirmationHash() === $confirmationHash) {

				$user->setEmailConfirmed(1);
				$user->setEmailConfirmationHash(null);

				if (Config::getByKey('network_type') === 'public') {
					$user->setAccountConfirmed(1);
				}

				UserService::store($user);

				$messages[] = array(
					'class' => 'success',
					'message' => 'You successfully confirmed your account!'
				);

				if (Config::getByKey('network_type') === 'private') {

					$messages[] = array(
						'class' => 'warning',
						'message' => 'This is a private network. You are notified when your account is confirmed by an administrator.'
					);

				}

			}

		} else {

			$messages[] = array(
				'class' => 'danger',
				'message' => 'an error occurred'
			);
		}

		$this->_view->messages = $messages;
	}

}