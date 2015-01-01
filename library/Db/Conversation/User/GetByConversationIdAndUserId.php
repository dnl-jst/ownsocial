<?php

namespace Db\Conversation\User;

use Core\Query;

class GetByConversationIdAndUserId extends Query
{

	/** @var int */
	protected $conversationId;

	/** @var int */
	protected $userId;

	protected function build()
	{
		$query = '
			SELECT
				id,
				conversation_id,
				user_id,
				created,
				created_by
			FROM
				conversation_users
			WHERE
				conversation_id = ?
			AND 	user_id = ?';

		$this->addBind($this->conversationId);
		$this->addBind($this->userId);

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
	 * @param int $userId
	 */
	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

}