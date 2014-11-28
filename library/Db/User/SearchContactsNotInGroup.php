<?php

namespace Db\User;

use Core\Query;

class SearchContactsNotInGroup extends Query
{

	protected $search;
	protected $userId;
	protected $groupId;

	protected function build()
	{
		$query = '
			SELECT
				u.id,
				u.type,
				u.email,
				u.email_confirmed,
				u.email_confirmation_hash,
				u.account_confirmed,
				u.password,
				u.first_name,
				u.last_name,
				u.department,
				IFNULL(u.portrait_file_id, cnfg.value) AS portrait_file_id,
				u.created
			FROM
				users u
			LEFT JOIN relations r1 ON r1.user_id = u.id AND r1.user_id2 = ? AND r1.confirmed IS NOT NULL
			LEFT JOIN relations r2 ON r2.user_id = ? AND r2.user_id2 = u.id AND r2.confirmed IS NOT NULL
			LEFT JOIN user_groups ug ON ug.user_id = u.id AND ug.group_id = ?
			JOIN configs cnfg ON cnfg.key = \'default_portrait_id\'
			WHERE
				u.account_confirmed = 1
			AND 	ug.user_id IS NULL
			AND	(u.first_name LIKE ? OR u.last_name LIKE ?)
			AND 	(r1.user_id IS NOT NULL OR r2.user_id IS NOT NULL)';

		$this->addBind($this->userId);
		$this->addBind($this->userId);
		$this->addBind($this->groupId);

		$this->addBind($this->search . '%');
		$this->addBind($this->search . '%');

		return $query;
	}

	/**
	 * @param mixed $search
	 */
	public function setSearch($search)
	{
		$this->search = $search;
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