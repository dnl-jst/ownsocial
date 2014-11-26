<?php

namespace Service;

use Core\Controller\Request;
use Db\User\Delete;
use Db\User\GetByGroupId;
use Db\User\GetUnconfirmedUsers;
use Db\User\SearchContacts;
use Db\User\SearchContactsNotInGroup;
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

	public static function searchContacts($search, $userId)
	{
		$query = new SearchContacts();
		$query->setSearch($search);
		$query->setUserId($userId);

		return self::fillCollection(new UserModel(), $query->fetchAll());
	}

	public static function searchNotInGroup($search, $groupId)
	{
		$query = new SearchNotInGroup();
		$query->setSearch($search);
		$query->setGroupId($groupId);

		return self::fillCollection(new UserModel(), $query->fetchAll());
	}

	public static function searchContactsNotInGroup($search, $userId, $groupId)
	{
		$query = new SearchContactsNotInGroup();
		$query->setSearch($search);
		$query->setUserId($userId);
		$query->setGroupId($groupId);

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
		$query->setFirstName($user->getFirstName());
		$query->setLastName($user->getLastName());
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

	public static function sendConfirmationMail(Request $request, UserModel $user)
	{
		$confirmationLink = sprintf(
			'%s://%s/register/confirm/?user=%u&hash=%s',
			($request->isSecure()) ? 'https' : 'http',
			$request->getHost(),
			$user->getId(),
			$user->getEmailConfirmationHash()
		);

		$mail = new Mail\Message();
		$mail->setFrom('no-reply@' . $request->getHost());
		$mail->addTo($user->getEmail());
		$mail->setSubject('Your registration at "' . Config::getByKey('site_title') . '"');

		$body = array();
		$body[] = 'You registered at "' . Config::getByKey('site_title') . '".';
		$body[] = '';
		$body[] = 'To confirm and use your account, click the following link:';
		$body[] = '';
		$body[] = $confirmationLink;

		$mail->setBody(join(chr(10), $body));

		$transport = new Mail\Transport\Sendmail();
		$transport->send($mail);

	}

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

	public static function delete($id)
	{
		$query = new Delete();
		$query->setId($id);
		$query->query();
	}

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

}