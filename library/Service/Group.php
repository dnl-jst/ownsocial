<?php

class Service_Group extends Core_Service
{

	/**
	 * @param $userId
	 * @return Model_Group[]
	 * @throws Core_Query_NoResultException
	 */
	public static function getByUserId($userId)
	{
		$query = new Db_Group_GetByUserId();
		$query->setUserId($userId);

		return self::fillCollection(new Model_Group(), $query->fetchAll());
	}

	/**
	 * @param $id
	 * @return Model_Group
	 * @throws Core_Query_NoResultException
	 */
	public static function getById($id)
	{
		$query = new Db_Group_GetById();
		$query->setId($id);

		return self::fillModel(new Model_Group(), $query->fetchRow());
	}

	/**
	 * @param Model_Group $group
	 * @return int
	 */
	public static function store(Model_Group $group)
	{
		$query = new Db_Group_Store();
		$query->setId($group->getId());
		$query->setName($group->getName());
		$query->setCreated($group->getCreated());

		if ($group->getId()) {
			$query->query();
			return (int)$group->getId();
		} else {
			return (int)$query->insert();
		}
	}

}