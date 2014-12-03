<?php

namespace Model\Conversation\Post;

use Core\Model;

class Seen extends Model
{

	/** @var integer */
	protected $id;

	/** @var integer */
	protected $postId;

	/** @var integer */
	protected $userId;

	/** @var integer */
	protected $created;

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
	 * @return int
	 */
	public function getPostId()
	{
		return $this->postId;
	}

	/**
	 * @param int $postId
	 */
	public function setPostId($postId)
	{
		$this->postId = $postId;
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

}