<?php

class Db_Like_Store extends Core_Query
{

	protected $userId;
	protected $postId;

	protected function build()
	{
		$query = '
			REPLACE INTO
				likes
				(
					user_id,
					post_id
				)
			VALUES
				(
					?,
					?
				)';

		$this->addBind($this->userId);
		$this->addBind($this->postId);

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

}