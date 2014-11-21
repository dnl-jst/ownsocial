<?php

namespace Db\UserGroup;

use Core\Query;

class Get extends Query
{

	protected $userId;
	protected $groupId;

	protected function build()
	{
		$query = '
			SELECT
				user_id,
				group_id,
				confirmed,
				role
			FROM
				user_groups
			WHERE
				user_id = ?
			AND 	group_id = ?';

		$this->addBind($this->userId);
		$this->addBind($this->groupId);

		return $query;
	}

	/**
	 * @param mixed $userId
	 */
	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

	/**
	 * @param mixed $groupId
	 */
	public function setGroupId($groupId)
	{
		$this->groupId = $groupId;
	}

}