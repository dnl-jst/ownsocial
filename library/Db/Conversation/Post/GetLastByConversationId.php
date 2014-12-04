<?php

namespace Db\Conversation\Post;

use Core\Query;

class GetLastByConversationId extends Query
{

	/** @var integer */
	protected $conversationId;

	/** @var integer */
	protected $offset;

	protected function build()
	{
		$query = '
			SELECT
				id,
				conversation_id,
				user_id,
				message,
				created
			FROM
				conversation_posts
			WHERE
				conversation_id = ?
			ORDER BY
				created DESC
			LIMIT ' . (integer)$this->offset . ', 10';

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

}