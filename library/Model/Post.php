<?php

namespace Model;

use Core\Model;

class Post extends Model
{
	protected $id;
	protected $rootPostId;
	protected $parentPostId;
	protected $userId;
	protected $groupId;
	protected $visibility;
	protected $content;
	protected $imageFileId;
	protected $attachmentFileId;
	protected $created;
	protected $modified;

	/**
	 * @return mixed
	 */
	public function getModified()
	{
		return $this->modified;
	}

	/**
	 * @param mixed $modified
	 */
	public function setModified($modified)
	{
		$this->modified = $modified;
	}

	/**
	 * @param mixed $parentPostId
	 */
	public function setParentPostId($parentPostId)
	{
		$this->parentPostId = $parentPostId;
	}

	/**
	 * @return mixed
	 */
	public function getParentPostId()
	{
		return $this->parentPostId;
	}

	/**
	 * @param mixed $content
	 */
	public function setContent($content)
	{
		$this->content = $content;
	}

	/**
	 * @return mixed
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * @param mixed $created
	 */
	public function setCreated($created)
	{
		$this->created = $created;
	}

	/**
	 * @return mixed
	 */
	public function getCreated()
	{
		return $this->created;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
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
	public function getUserId()
	{
		return $this->userId;
	}

	/**
	 * @param mixed $visiblity
	 */
	public function setVisibility($visibility)
	{
		$this->visibility = $visibility;
	}

	/**
	 * @return mixed
	 */
	public function getVisibility()
	{
		return $this->visibility;
	}

	/**
	 * @return mixed
	 */
	public function getImageFileId()
	{
		return $this->imageFileId;
	}

	/**
	 * @param mixed $imageFileId
	 */
	public function setImageFileId($imageFileId)
	{
		$this->imageFileId = $imageFileId;
	}

	/**
	 * @return mixed
	 */
	public function getRootPostId()
	{
		return $this->rootPostId;
	}

	/**
	 * @param mixed $rootPostId
	 */
	public function setRootPostId($rootPostId)
	{
		$this->rootPostId = $rootPostId;
	}

	/**
	 * @return mixed
	 */
	public function getGroupId()
	{
		return $this->groupId;
	}

	/**
	 * @param mixed $groupId
	 */
	public function setGroupId($groupId)
	{
		$this->groupId = $groupId;
	}

	/**
	 * @return mixed
	 */
	public function getAttachmentFileId()
	{
		return $this->attachmentFileId;
	}

	/**
	 * @param mixed $attachmentFileId
	 */
	public function setAttachmentFileId($attachmentFileId)
	{
		$this->attachmentFileId = $attachmentFileId;
	}

}