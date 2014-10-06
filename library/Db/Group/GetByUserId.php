<?php

class Db_Group_GetByUserId extends Core_Query
{

	protected $userId;

	protected function build()
	{
		$query = '
			SELECT
				g.id,
				g.name,
				g.created,
				ug.role
			FROM
				user_groups ug
			JOIN groups g ON g.id = ug.group_id AND ug.confirmed = 1
			WHERE
				ug.user_id = ?';

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