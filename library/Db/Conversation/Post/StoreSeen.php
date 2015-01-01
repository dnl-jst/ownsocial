<?php

namespace Db\Conversation\Post;

use Core\Query;

class StoreSeen extends Query
{

	/** @var integer */
	protected $id;

	/** @var integer */
	protected $postId;

	/** @var integer */
	protected $userId;

	/** @var integer */
	protected $created;

	protected function build()
	{
		$query = '
			INSERT IGNORE INTO
				conversation_post_seen
				(
					id,
					post_id,
					user_id,
					created
				)
			VALUES
				(
					?,
					?,
					?,
					?
				)';

		$this->addBind($this->id);
		$this->addBind($this->postId);
		$this->addBind($this->userId);
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
	 * @param int $postId
	 */
	public function setPostId($postId)
	{
		$this->postId = $postId;
	}

}