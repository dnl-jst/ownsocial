<?php

namespace Db\Conversation\Post;

use Core\Query;

class GetUnreadCount extends Query
{

	protected $userId;

	protected function build()
	{
		$query = '
			SELECT
				COUNT(*)
			FROM
				conversation_users cu
			JOIN conversations c ON c.id = cu.conversation_id
			JOIN conversation_posts cp ON cp.conversation_id = c.id
			LEFT JOIN conversation_post_seen cps ON cps.post_id = cp.id AND cps.user_id = ?
			WHERE
				cu.user_id = ?
			AND	cps.created IS NULL';

		$this->addBind($this->userId);
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