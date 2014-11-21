<?php

namespace Service;

use Core\Service;
use Db\UserGroup\Get;
use Db\UserGroup\Store;
use Model\UserGroup as UserGroupModel;

class UserGroup extends Service
{

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
		$query->setConfirmed($userGroup->getConfirmed());
		$query->setRole($userGroup->getRole());
		$query->query();
	}

}