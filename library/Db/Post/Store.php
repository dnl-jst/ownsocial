<?php

class Db_Post_Store extends Core_Query
{

	protected $id;
	protected $parentPostId;
	protected $userId;
	protected $visibility;
	protected $content;
	protected $created;
	protected $modified;

	protected function build()
	{
		$query = '
			INSERT INTO
				posts
				(
					id,
					parent_post_id,
					user_id,
					visibility,
					content,
					created,
					modified
				)
			VALUES
				(
					?,
					?,
					?,
					?,
					?,
					?,
					?
				)
			ON DUPLICATE KEY UPDATE
				parent_post_id = VALUES(parent_post_id),
				user_id = VALUES(user_id),
				visibility = VALUES(visibility),
				content = VALUES(content),
				created = VALUES(created),
				modified = VALUES(modified)';

		$this->addBind($this->id);
		$this->addBind($this->parentPostId);
		$this->addBind($this->userId);
		$this->addBind($this->visibility);
		$this->addBind($this->content);
		$this->addBind($this->created);
		$this->addBind($this->modified);

		return $query;
	}

	/**
	 * @param mixed $parentPostId
	 */
	public function setParentPostId($parentPostId)
	{
		$this->parentPostId = $parentPostId;
	}

	/**
	 * @param mixed $content
	 */
	public function setContent($content)
	{
		$this->content = $content;
	}

	/**
	 * @param mixed $created
	 */
	public function setCreated($created)
	{
		$this->created = $created;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @param mixed $userId
	 */
	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

	/**
	 * @param mixed $visibility
	 */
	public function setVisibility($visibility)
	{
		$this->visibility = $visibility;
	}

	/**
	 * @param mixed $modified
	 */
	public function setModified($modified)
	{
		$this->modified = $modified;
	}

}