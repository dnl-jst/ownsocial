<?php

namespace Model\Conversation;

use Core\Model;

class Post extends Model
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

	/** @var integer */
	protected $seen;

	/**
	 * @return int
	 */
	public function getConversationId()
	{
		return $this->conversationId;
	}

	/**
	 * @param int $conversationId
	 */
	public function setConversationId($conversationId)
	{
		$this->conversationId = $conversationId;
	}

	/**
	 * @return int
	 */
	public function getCreated()
	{
		return $this->created;
	}

	/**
	 * @param int $created
	 */
	public function setCreated($created)
	{
		$this->created = $created;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getMessage()
	{
		return $this->message;
	}

	/**
	 * @param string $message
	 */
	public function setMessage($message)
	{
		$this->message = $message;
	}

	/**
	 * @return int
	 */
	public function getUserId()
	{
		return $this->userId;
	}

	/**
	 * @param int $userId
	 */
	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

	/**
	 * @return int
	 */
	public function getSeen()
	{
		return $this->seen;
	}

	/**
	 * @param int $seen
	 */
	public function setSeen($seen)
	{
		$this->seen = $seen;
	}

}