<?php

namespace Service;

use Core\Controller\Request;
use Core\Translator;
use Db\User\Delete;
use Db\User\GetAdmins;
use Db\User\GetByConversationId;
use Db\User\GetByGroupId;
use Db\User\GetGroupRequests;
use Db\User\GetUnconfirmedUsers;
use Db\User\SearchContacts;
use Db\User\SearchContactsNotInConversation;
use Db\User\SearchContactsNotInGroup;
use Db\User\SearchNotInConversation;
use Db\User\SearchNotInGroup;
use Zend\Mail;
use Core\Service;
use Core\Query\NoResultException;
use Model\User as UserModel;
use Db\User\GetById;
use Db\User\GetByEmail;
use Db\User\GetUnconfirmedContacts;
use Db\User\Search;
use Db\User\Store;
use Service\Relation;

class User extends Service
{

	/**
	 * @return bool|UserModel
	 */
	public static function getCurrent()
	{
		$userId = @$_SESSION['user.id'];

		if (!$userId) {
			return false;
		}

		try {
			$user = self::getById($userId);
		} catch (NoResultException $e) {
			$user = false;
		}


		return $user;
	}

	/**
	 * @param $id
	 * @return UserModel
	 * @throws NoResultException
	 */
	public static function getById($id)
	{
		$query = new GetById();
		$query->setId($id);

		$user = self::fillModel(new UserModel(), $query->fetchRow());

		return $user;
	}

	/**
	 * @param $email
	 * @return UserModel
	 * @throws NoResultException
	 */
	public static function getByEmail($email)
	{
		$query = new GetByEmail();
		$query->setEmail($email);

		$user = self::fillModel(new UserModel(), $query->fetchRow());

		return $user;
	}

	/**
	 * @return UserModel[]
	 * @throws NoResultException
	 */
	public static function getAdmins()
	{
		$query = new GetAdmins();

		return self::fillCollection(new UserModel(), $query->fetchAll());
	}

	/**
	 * @param $userId
	 * @return UserModel[]
	 * @throws NoResultException
	 */
	public static function getUnconfirmedContacts($userId)
	{
		$query = new GetUnconfirmedContacts();
		$query->setId($userId);

		return self::fillCollection(new UserModel(), $query->fetchAll());
	}

	/**
	 * @param $search
	 * @return UserModel[]
	 * @throws NoResultException
	 */
	public static function search($search)
	{
		$query = new Search();
		$query->setSearch($search);

		return self::fillCollection(new UserModel(), $query->fetchAll());
	}

	/**
	 * @param $search
	 * @param $userId
	 * @return UserModel[]
	 * @throws NoResultException
	 */
	public static function searchContacts($search, $userId)
	{
		$query = new SearchContacts();
		$query->setSearch($search);
		$query->setUserId($userId);

		return self::fillCollection(new UserModel(), $query->fetchAll());
	}

	/**
	 * @param $search
	 * @param $groupId
	 * @return UserModel[]
	 * @throws NoResultException
	 */
	public static function searchNotInGroup($search, $groupId)
	{
		$query = new SearchNotInGroup();
		$query->setSearch($search);
		$query->setGroupId($groupId);

		return self::fillCollection(new UserModel(), $query->fetchAll());
	}

	/**
	 * @param $search
	 * @param $conversationId
	 * @return UserModel[]
	 * @throws NoResultException
	 */
	public static function searchNotInConversation($search, $conversationId)
	{
		$query = new SearchNotInConversation();
		$query->setSearch($search);
		$query->setConversationId($conversationId);

		return self::fillCollection(new UserModel(), $query->fetchAll());
	}

	/**
	 * @param $search
	 * @param $userId
	 * @param $conversationId
	 * @return UserModel[]
	 * @throws NoResultException
	 */
	public static function searchContactsNotInConversation($search, $userId, $conversationId)
	{
		$query = new SearchContactsNotInConversation();
		$query->setSearch($search);
		$query->setUserId($userId);
		$query->setConversationId($conversationId);

		return self::fillCollection(new UserModel(), $query->fetchAll());
	}

	public static function getRelation(UserModel $user1, UserModel $user2)
	{
		$relation = null;

		try {
			$relation = Relation::getByUsers($user1->getId(), $user2->getId());
		}
		catch (NoResultException $e)
		{}

		if (!$relation) {
			try {
				$relation = Relation::getByUsers($user2->getId(), $user1->getId());
			}
			catch (NoResultException $e)
			{}
		}

		return $relation;
	}

	/**
	 * @param UserModel $user
	 * @return integer
	 */
	public static function store(UserModel $user)
	{
		$query = new Store();
		$query->setId($user->getId());
		$query->setType($user->getType());
		$query->setEmail($user->getEmail());
		$query->setEmailConfirmed($user->getEmailConfirmed());
		$query->setEmailConfirmationHash($user->getEmailConfirmationHash());
		$query->setAccountConfirmed($user->getAccountConfirmed());
		$query->setPassword($user->getPassword());
		$query->setLanguage($user->getLanguage());
		$query->setFirstName($user->getFirstName());
		$query->setLastName($user->getLastName());
		$query->setDepartment($user->getDepartment());
		$query->setPortraitFileId($user->getPortraitFileId());
		$query->setCreated($user->getCreated());

		if ($user->getId()) {
			$query->query();
			return $user->getId();
		} else {
			$user->setId($query->insert());
			return $user->getId();
		}
	}

	public static function sendConfirmationMail(Translator $translator, Request $request, UserModel $user)
	{
		$confirmationLink = sprintf(
			'%s://%s/register/confirm/?user=%u&hash=%s',
			($request->isSecure()) ? 'https' : 'http',
			$request->getHost(),
			$user->getId(),
			$user->getEmailConfirmationHash()
		);

		$mail = new Mail\Message();
		$mail->setEncoding("UTF-8");
		$mail->setFrom('no-reply@' . $request->getHost());
		$mail->addTo($user->getEmail());

		$mail->setSubject(
			$translator->_(
				'mail_user_confirmation_subject',
				array('site_title' => Config::getByKey('site_title')),
				$user->getLanguage()
			)
		);

		$mail->setBody(
			$translator->_(
				'mail_user_confirmation_body',
				array('site_title' => Config::getByKey('site_title'), 'confirmation_link' => $confirmationLink),
				$user->getLanguage()
			)
		);

		$headers = $mail->getHeaders();
		$headers->removeHeader('Content-Type');
		$headers->addHeaderLine('Content-Type', 'text/plain; charset=UTF-8');

		$transport = new Mail\Transport\Sendmail();
		$transport->send($mail);

	}

	public static function sendAdminAcceptMail(Translator $translator, Request $request, UserModel $user)
	{
		$loginLink = sprintf(
			'%s://%s/',
			($request->isSecure()) ? 'https' : 'http',
			$request->getHost()
		);

		$mail = new Mail\Message();
		$mail->setEncoding("UTF-8");
		$mail->setFrom('no-reply@' . $request->getHost());
		$mail->addTo($user->getEmail());

		$mail->setSubject(
			$translator->_(
				'mail_user_admin_accept_subject',
				array('site_title' => Config::getByKey('site_title')),
				$user->getLanguage()
			)
		);

		$mail->setBody(
			$translator->_(
				'mail_user_admin_accept_body',
				array('site_title' => Config::getByKey('site_title'), 'login_link' => $loginLink),
				$user->getLanguage()
			)
		);

		$headers = $mail->getHeaders();
		$headers->removeHeader('Content-Type');
		$headers->addHeaderLine('Content-Type', 'text/plain; charset=UTF-8');

		$transport = new Mail\Transport\Sendmail();
		$transport->send($mail);
	}

	public static function sendNewUserNotification(Translator $translator, Request $request, UserModel $admin, UserModel $user)
	{
		$mail = new Mail\Message();
		$mail->setEncoding("UTF-8");
		$mail->setFrom('no-reply@' . $request->getHost());
		$mail->addTo($admin->getEmail());

		$mail->setSubject(
			$translator->_(
				'mail_new_user_subject',
				array('site_title' => Config::getByKey('site_title')),
				$admin->getLanguage()
			)
		);

		$mail->setBody(
			$translator->_(
				'mail_new_user_body',
				array(
					'site_title' => Config::getByKey('site_title'),
					'first_name' => $user->getFirstName(),
					'last_name' => $user->getLastName(),
					'email' => $user->getEmail()
				),
				$admin->getLanguage()
			)
		);

		$headers = $mail->getHeaders();
		$headers->removeHeader('Content-Type');
		$headers->addHeaderLine('Content-Type', 'text/plain; charset=UTF-8');

		$transport = new Mail\Transport\Sendmail();
		$transport->send($mail);
	}

	/**
	 * @return UserModel[]
	 */
	public static function getUnconfirmedUsers()
	{
		$query = new GetUnconfirmedUsers();

		try {
			$users = self::fillCollection(new UserModel(), $query->fetchAll());
		} catch (NoResultException $e) {
			$users = array();
		}

		return $users;
	}

	/**
	 * @param $id
	 */
	public static function delete($id)
	{
		$query = new Delete();
		$query->setId($id);
		$query->query();
	}

	/**
	 * @param $groupId
	 * @return UserModel[]
	 */
	public static function getByGroupId($groupId)
	{
		$query = new GetByGroupId();
		$query->setGroupId($groupId);

		try {
			$users = self::fillCollection(new UserModel(), $query->fetchAll());
		} catch (NoResultException $e) {
			$users = array();
		}

		return $users;
	}

	/**
	 * @param $groupId
	 * @return UserModel[]
	 */
	public static function getGroupRequests($groupId)
	{
		$query = new GetGroupRequests();
		$query->setGroupId($groupId);

		try {
			$users = self::fillCollection(new UserModel(), $query->fetchAll());
		} catch (NoResultException $e) {
			$users = array();
		}

		return $users;
	}

	/**
	 * @param $conversationId
	 * @return UserModel[]
	 */
	public static function getByConversationId($conversationId)
	{
		$query = new GetByConversationId();
		$query->setConversationId($conversationId);

		try {
			$users = self::fillCollection(new UserModel(), $query->fetchAll());
		} catch (NoResultException $e) {
			$users = array();
		}

		return $users;
	}

}