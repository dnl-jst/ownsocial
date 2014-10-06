<?php

class Service_Relation extends Core_Service
{

	/**
	 * @param $userId
	 * @param $userId2
	 * @return Model_Relation
	 * @throws Core_Query_NoResultException
	 */
	public static function getByUsers($userId, $userId2)
	{
		$query = new Db_Relation_GetByUsers();
		$query->setUserId($userId);
		$query->setUserId2($userId2);

		return self::fillModel(new Model_Relation(), $query->fetchRow());
	}

	public static function store(Model_Relation $relation)
	{
		$query = new Db_Relation_Store();
		$query->setUserId($relation->getUserId());
		$query->setUserId2($relation->getUserId2());
		$query->setCreated($relation->getCreated());
		$query->setConfirmed($relation->getConfirmed());
		$query->query();
	}

}