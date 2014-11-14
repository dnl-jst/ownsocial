<?php

namespace Model;

use Core\Model;

class Like extends Model
{

	protected $userId;
	protected $postId;
	protected $created;

	/**
	 * @return mixed
	 */
	public function getPostId()
	{
		return $this->postId;
	}

	/**
	 * @param mixed $postId
	 */
	public function setPostId($postId)
	{
		$this->postId = $postId;
	}

	/**
	 * @return mixed
	 */
	public function getUserId()
	{
		return $this->userId;
	}

	/**
	 * @param mixed $userId
	 */
	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

	/**
	 * @return mixed
	 */
	public function getCreated()
	{
		return $this->created;
	}

	/**
	 * @param mixed $created
	 */
	public function setCreated($created)
	{
		$this->created = $created;
	}

}