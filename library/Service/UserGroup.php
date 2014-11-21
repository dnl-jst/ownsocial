<?php

namespace Service;

use Core\Service;
use Db\UserGroup\Store;
use Model\UserGroup as UserGroupModel;

class UserGroup extends Service
{

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