<?php

namespace Db\User;

use Core\Query;

class GetByGroupId extends Query
{

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
				user_groups ug
			JOIN users u ON u.id = ug.user_id
			JOIN configs cnfg ON cnfg.key = \'default_portrait_id\'
			WHERE
				ug.group_id = ?';

		$this->addBind($this->groupId);

		return $query;
	}

	/**
	 * @param mixed $groupId
	 */
	public function setGroupId($groupId)
	{
		$this->groupId = $groupId;
	}

}