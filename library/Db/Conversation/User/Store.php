<?php

namespace Db\Conversation\User;

use Core\Query;

class Store extends Query
{

	/** @var int */
	protected $id;

	/** @var int */
	protected $conversationId;

	/** @var int */
	protected $userId;

	/** @var int */
	protected $created;

	/** @var int */
	protected $createdBy;

	protected function build()
	{
		$query = '
			INSERT INTO
				conversation_users
				(
					id,
					conversation_id,
					user_id,
					created,
					created_by
				)
			VALUES
				(
					?,
					?,
					?,
					?,
					?
				)';

		$this->addBind($this->id);
		$this->addBind($this->conversationId);
		$this->addBind($this->userId);
		$this->addBind($this->created);
		$this->addBind($this->createdBy);

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
	 * @param int $created
	 */
	public function setCreated($created)
	{
		$this->created = $created;
	}

	/**
	 * @param int $createdBy
	 */
	public function setCreatedBy($createdBy)
	{
		$this->createdBy = $createdBy;
	}

}