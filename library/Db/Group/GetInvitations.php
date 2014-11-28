<?php

namespace Db\Group;

use Core\Query;

class GetInvitations extends Query
{

	protected $userId;

	protected function build()
	{
		$query = '
			SELECT
				g.id,
				g.name,
				g.description,
				g.type,
				COALESCE(g.portrait_file_id, cnfg.value) AS portrait_file_id,
				g.created
			FROM
				user_groups ug
			JOIN groups g ON g.id = ug.group_id
			JOIN configs cnfg ON cnfg.key = \'default_portrait_id\'
			WHERE
				ug.user_id = ?
			AND 	ug.user_id != IFNULL(ug.created_by, 0)
			AND	ug.confirmed IS NULL';

		$this->addBind($this->userId);

		return $query;
	}

	/**
	 * @param mixed $userId
	 */
	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

}