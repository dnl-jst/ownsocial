<?php

namespace Db\User;

use Core\Query;

class SearchNotInGroup extends Query
{

	protected $search;
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
				u.language,
				u.first_name,
				u.last_name,
				u.department,
				IFNULL(u.portrait_file_id, cnfg.value) AS portrait_file_id,
				u.created
			FROM
				users u
			LEFT JOIN user_groups ug ON ug.user_id = u.id AND ug.group_id = ?
			JOIN configs cnfg ON cnfg.key = \'default_portrait_id\'
			WHERE
				u.account_confirmed = 1
			AND 	ug.user_id IS NULL
			AND	(u.first_name LIKE ? OR u.last_name LIKE ?)';

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
	 * @param mixed $groupId
	 */
	public function setGroupId($groupId)
	{
		$this->groupId = $groupId;
	}

}