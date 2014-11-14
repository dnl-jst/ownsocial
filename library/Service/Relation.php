<?php

namespace Service;

use Core\Service;
use Model\Relation as RelationModel;
use Db\Relation\GetByUsers;
use Db\Relation\Store;
use Db\Relation\Delete;

class Relation extends Service
{

	/**
	 * @param $userId
	 * @param $userId2
	 * @return RelationModel
	 * @throws \Core\Query\NoResultException
	 */
	public static function getByUsers($userId, $userId2)
	{
		$query = new GetByUsers();
		$query->setUserId($userId);
		$query->setUserId2($userId2);

		return self::fillModel(new RelationModel(), $query->fetchRow());
	}

	/**
	 * @param RelationModel $relation
	 * @return void
	 */
	public static function store(RelationModel $relation)
	{
		$query = new Store();
		$query->setUserId($relation->getUserId());
		$query->setUserId2($relation->getUserId2());
		$query->setCreated($relation->getCreated());
		$query->setConfirmed($relation->getConfirmed());
		$query->query();
	}

	/**
	 * @param RelationModel $relation
	 * @return void
	 */
	public static function delete(RelationModel $relation)
	{
		$query = new Delete();
		$query->setUserId($relation->getUserId());
		$query->setUserId2($relation->getUserId2());
		$query->query();
	}

}