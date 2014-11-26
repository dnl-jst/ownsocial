<?php

namespace Service;

use Core\Service;
use Db\UserGroup\Get;
use Db\UserGroup\Store;
use Model\UserGroup as UserGroupModel;

class UserGroup extends Service
{

	/**
	 * @param $userId
	 * @param $groupId
	 * @return UserGroupModel
	 * @throws \Core\Query\NoResultException
	 */
	public static function get($userId, $groupId)
	{
		$query = new Get();
		$query->setUserId($userId);
		$query->setGroupId($groupId);

		return self::fillModel(new UserGroupModel(), $query->fetchRow());
	}

	public static function store(UserGroupModel $userGroup)
	{
		$query = new Store();
		$query->setUserId($userGroup->getUserId());
		$query->setGroupId($userGroup->getGroupId());
		$query->setCreatedBy($userGroup->getCreatedBy());
		$query->setConfirmed($userGroup->getConfirmed());
		$query->setRole($userGroup->getRole());
		$query->query();
	}

}