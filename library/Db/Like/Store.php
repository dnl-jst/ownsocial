<?php

namespace Db\Like;

use Core\Query;

class Store extends Query
{

	protected $userId;
	protected $postId;
	protected $created;

	protected function build()
	{
		$query = '
			REPLACE INTO
				likes
				(
					user_id,
					post_id,
					created
				)
			VALUES
				(
					?,
					?,
					?
				)';

		$this->addBind($this->userId);
		$this->addBind($this->postId);
		$this->addBind($this->created);

		return $query;
	}

	/**
	 * @param mixed $postId
	 */
	public function setPostId($postId)
	{
		$this->postId = $postId;
	}

	/**
	 * @param mixed $userId
	 */
	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

	/**
	 * @param mixed $created
	 */
	public function setCreated($created)
	{
		$this->created = $created;
	}

}