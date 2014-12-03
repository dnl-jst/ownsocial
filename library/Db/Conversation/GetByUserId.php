<?php

namespace Db\Conversation;

use Core\Query;

class GetByUserId extends Query
{

	protected $userId;

	protected function build()
	{
		$query = '
			SELECT
				c.id,
				c.title,
				c.created,
				c.created_by,
				c.last_update
			FROM
				conversation_users cu
			LEFT JOIN conversations c ON c.id = cu.conversation_id
			WHERE
				cu.user_id = ?
			ORDER BY
				c.last_update DESC';

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