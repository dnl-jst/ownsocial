<?php

namespace Service;

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
		$query->setEmail($user->getEmail());
		$query->setPassword($user->getPassword());
		$query->setFirstName($user->getFirstName());
		$query->setLastName($user->getLastName());
		$query->setPortraitFileId($user->getPortraitFileId());
		$query->setCreated($user->getCreated());

		if ($user->getId()) {
			$query->query();
			return $user->getId();
		} else {
			return $query->insert();
		}
	}

}