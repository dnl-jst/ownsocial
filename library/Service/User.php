<?php

class Service_User extends Core_Service
{

	/**
	 * @return bool|Model_User
	 */
	public static function getCurrent()
	{
		$userId = @$_SESSION['user.id'];

		if (!$userId) {
			return false;
		}

		try {
			$user = Service_User::getById($userId);
		} catch (Core_Query_NoResultException $e) {
			$user = false;
		}


		return $user;
	}

	/**
	 * @param $id
	 * @return Model_User
	 * @throws Core_Query_NoResultException
	 */
	public static function getById($id)
	{
		$query = new Db_User_GetById();
		$query->setId($id);

		$user = self::fillModel(new Model_User(), $query->fetchRow());

		return $user;
	}

	/**
	 * @param $email
	 * @return Model_User
	 * @throws Core_Query_NoResultException
	 */
	public static function getByEmail($email)
	{
		$query = new Db_User_GetByEmail();
		$query->setEmail($email);

		$user = self::fillModel(new Model_User(), $query->fetchRow());

		return $user;
	}

	/**
	 * @param $userId
	 * @return Model_User[]
	 * @throws Core_Query_NoResultException
	 */
	public static function getUnconfirmedContacts($userId)
	{
		$query = new Db_User_GetUnconfirmedContacts();
		$query->setId($userId);

		return self::fillCollection(new Model_User(), $query->fetchAll());
	}

}