<?php

namespace Model;

use Core\Model;

class Feed extends Model
{

	protected $id;
	protected $parentPostId;
	protected $userId;
	protected $groupId;
	protected $visiblity;
	protected $content;
	protected $imageFileId;
	protected $attachmentFileId;
	protected $created;
	protected $modified;
	protected $firstName;
	protected $lastName;
	protected $portraitFileId;
	protected $liked;
	protected $likes;
	protected $comments;

	/**
	 * @return mixed
	 */
	public function getComments()
	{
		return $this->comments;
	}

	/**
	 * @param mixed $comments
	 */
	public function setComments($comments)
	{
		$this->comments = $comments;
	}

	/**
	 * @return mixed
	 */
	public function getLiked()
	{
		return $this->liked;
	}

	/**
	 * @param mixed $liked
	 */
	public function setLiked($liked)
	{
		$this->liked = $liked;
	}

	/**
	 * @return mixed
	 */
	public function getLikes()
	{
		return $this->likes;
	}

	/**
	 * @param mixed $likes
	 */
	public function setLikes($likes)
	{
		$this->likes = $likes;
	}

	/**
	 * @return mixed
	 */
	public function getPortraitFileId()
	{
		return $this->portraitFileId;
	}

	/**
	 * @param mixed $portraitFileId
	 */
	public function setPortraitFileId($portraitFileId)
	{
		$this->portraitFileId = $portraitFileId;
	}

	/**
	 * @return mixed
	 */
	public function getContent()
	{
		return $this->content;
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

	/**
	 * @return mixed
	 */
	public function getFirstName()
	{
		return $this->firstName;
	}

	/**
	 * @param mixed $firstName
	 */
	public function setFirstName($firstName)
	{
		$this->firstName = $firstName;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
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
	public function getLastName()
	{
		return $this->lastName;
	}

	/**
	 * @param mixed $lastName
	 */
	public function setLastName($lastName)
	{
		$this->lastName = $lastName;
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
	public function getVisiblity()
	{
		return $this->visiblity;
	}

	/**
	 * @param mixed $visiblity
	 */
	public function setVisiblity($visiblity)
	{
		$this->visiblity = $visiblity;
	}

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
	 * @return mixed
	 */
	public function getParentPostId()
	{
		return $this->parentPostId;
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