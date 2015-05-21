<?php

namespace Application\Controller;

use Core\Controller;
use Core\Query\NoResultException;
use Service\Config;
use Service\User as UserService;
use Service\Config as ConfigService;
use Model\User as UserModel;
use Service\User;

class Register extends Controller
{

	public function indexAction()
	{

		$email = '';
		$firstName = '';
		$lastName = '';
		$language = '';
		$defaultLanguage = Config::getByKey('default_language', 'en');
		$errors = array();

		if ($this->getRequest()->isPost())
		{
			$email = trim($this->getRequest()->getPost('email'));
			$language = trim($this->getRequest()->getPost('language'));
			$firstName = trim($this->getRequest()->getPost('first_name'));
			$lastName = trim($this->getRequest()->getPost('last_name'));
			$password = $this->getRequest()->getPost('password');
			$password2 = $this->getRequest()->getPost('password2');

			if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('~@[^.]+\.[^.]+~', $email)) {

				$errors['email'] = array(
					'class' => 'danger',
					'message' => 'register_msg_err_email_invalid'
				);

			} else {

				try {
					UserService::getByEmail($email);

					$errors['email'] = array(
						'class' => 'danger',
						'message' => 'register_msg_err_email_already_used'
					);

				} catch (NoResultException $e) {}
			}

			if (!$firstName) {
				$errors['first_name'] = array(
					'class' => 'danger',
					'message' => 'register_msg_err_first_name'
				);
			}

			if (!$lastName) {
				$errors['last_name'] = array(
					'class' => 'danger',
					'message' => 'register_msg_err_last_name'
				);
			}

			if (!$password) {
				$errors['password'] = array(
					'class' => 'danger',
					'message' => 'register_msg_err_password'
				);
			}

			if ($password !== $password2) {
				$errors['password2'] = array(
					'class' => 'danger',
					'message' => 'register_msg_err_password_mismatch'
				);
			}

			if (!$language || !in_array($language, array('en', 'de'))) {
				$errors['language'] = array(
					'class' => 'danger',
					'message' => 'register_msg_err_language'
				);
			}

			if (!$errors) {

				$confirmationHash = md5(uniqid(time(), true));

				$user = new UserModel();
				$user->setType('user');
				$user->setEmail($email);
				$user->setEmailConfirmed(0);
				$user->setEmailConfirmationHash($confirmationHash);
				$user->setAccountConfirmed(0);
				$user->setFirstName($firstName);
				$user->setLastName($lastName);
				$user->setLanguage($language);
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
		$this->_view->language = $language;
		$this->_view->defaultLanguage = $defaultLanguage;

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
					'message' => 'registration_confirm_already_confirmed'
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
					'message' => 'registration_confirm_success'
				);

				if (Config::getByKey('network_type') === 'private') {

					$admins = User::getAdmins();

					foreach ($admins as $admin) {
						UserService::sendNewUserNotification($this->getRequest(), $admin, $user);
					}

					$messages[] = array(
						'class' => 'warning',
						'message' => 'registration_confirm_private_network'
					);

				}

			}

		} else {

			$messages[] = array(
				'class' => 'danger',
				'message' => 'error'
			);
		}

		$this->_view->messages = $messages;
	}

}