<?php

namespace Db\Conversation\Post;

use Core\Query;

class Store extends Query
{

	/** @var integer */
	protected $id;

	/** @var integer */
	protected $conversationId;

	/** @var integer */
	protected $userId;

	/** @var string */
	protected $message;

	/** @var integer */
	protected $created;

	protected function build()
	{
		$query = '
			INSERT INTO
				conversation_posts
				(
					id,
					conversation_id,
					user_id,
					message,
					created
				)
			VALUES
				(
					?,
					?,
					?,
					?,
					?
				)
			ON DUPLICATE KEY UPDATE
				message = VALUES(message)';

		$this->addBind($this->id);
		$this->addBind($this->conversationId);
		$this->addBind($this->userId);
		$this->addBind($this->message);
		$this->addBind($this->created);

		return $query;
	}

	/**
	 * @param int $id
	 */
	public function setId($id)
	{
		$this->id = $id;
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

	/**
	 * @param string $message
	 */
	public function setMessage($message)
	{
		$this->message = $message;
	}

	/**
	 * @param int $created
	 */
	public function setCreated($created)
	{
		$this->created = $created;
	}

}