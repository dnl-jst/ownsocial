<?php

namespace Db\Like;

use Core\Query;

class Delete extends Query
{

	protected $userId;
	protected $postId;

	protected function build()
	{
		$query = '
			DELETE FROM
				likes
			WHERE
				user_id = ?
			AND 	post_id = ?';

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