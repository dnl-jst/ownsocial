<?php

namespace Db\Post;

use Core\Query;

class Store extends Query
{

	protected $id;
	protected $rootPostId;
	protected $parentPostId;
	protected $userId;
	protected $visibility;
	protected $content;
	protected $imageFileId;
	protected $created;
	protected $modified;

	protected function build()
	{
		$query = '
			INSERT INTO
				posts
				(
					id,
					root_post_id,
					parent_post_id,
					user_id,
					visibility,
					content,
					image_file_id,
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
					?,
					?,
					?
				)
			ON DUPLICATE KEY UPDATE
				root_post_id = VALUES(root_post_id),
				parent_post_id = VALUES(parent_post_id),
				user_id = VALUES(user_id),
				visibility = VALUES(visibility),
				content = VALUES(content),
				image_file_id = VALUES(image_file_id),
				created = VALUES(created),
				modified = VALUES(modified)';

		$this->addBind($this->id);
		$this->addBind($this->rootPostId);
		$this->addBind($this->parentPostId);
		$this->addBind($this->userId);
		$this->addBind($this->visibility);
		$this->addBind($this->content);
		$this->addBind($this->imageFileId);
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

	/**
	 * @param mixed $imageFileId
	 */
	public function setImageFileId($imageFileId)
	{
		$this->imageFileId = $imageFileId;
	}

	/**
	 * @param mixed $rootPostId
	 */
	public function setRootPostId($rootPostId)
	{
		$this->rootPostId = $rootPostId;
	}

}