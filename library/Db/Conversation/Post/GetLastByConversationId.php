<?php

namespace Db\Conversation\Post;

use Core\Query;

class GetLastByConversationId extends Query
{

	/** @var integer */
	protected $conversationId;

	/** @var integer */
	protected $userId;

	/** @var integer */
	protected $offset;

	/** @var integer */
	protected $limit = 10;

	protected function build()
	{
		$query = '
			SELECT
				cp.id,
				cp.conversation_id,
				cp.user_id,
				cp.message,
				cp.created,
				IF(IFNULL(cps.created, 0) = 0, 0, 1) AS seen
			FROM
				conversation_posts cp
			LEFT JOIN conversation_post_seen cps ON cps.post_id = cp.id AND cps.user_id = ?
			WHERE
				cp.conversation_id = ?
			ORDER BY
				cp.created DESC
			LIMIT ' . (integer)$this->offset . ', ' . (integer)$this->limit;

		$this->addBind($this->userId);
		$this->addBind($this->conversationId);

		return $query;
	}

	/**
	 * @param int $conversationId
	 */
	public function setConversationId($conversationId)
	{
		$this->conversationId = $conversationId;
	}

	/**
	 * @param int $offset
	 */
	public function setOffset($offset)
	{
		$this->offset = $offset;
	}

	/**
	 * @param int $userId
	 */
	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

	/**
	 * @param int $limit
	 */
	public function setLimit($limit)
	{
		$this->limit = $limit;
	}

}