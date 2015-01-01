<?php

namespace Model;

use Core\Model;
use Core\Query\NoResultException;
use Model\User as UserModel;
use Model\Conversation\User as ConversationUserModel;
use Service\Conversation\Post;
use Service\Conversation\User as ConversationUserService;
use Service\User as UserService;

class Conversation extends Model
{

	/** @var integer */
	protected $id;

	/** @var string */
	protected $title;

	/** @var integer */
	protected $created;

	/** @var integer */
	protected $createdBy;

	/** @var integer */
	protected $lastUpdate;

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
	public function getCreatedBy()
	{
		return $this->createdBy;
	}

	/**
	 * @param int $createdBy
	 */
	public function setCreatedBy($createdBy)
	{
		$this->createdBy = $createdBy;
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
	public function getLastUpdate()
	{
		return $this->lastUpdate;
	}

	/**
	 * @param int $lastUpdate
	 */
	public function setLastUpdate($lastUpdate)
	{
		$this->lastUpdate = $lastUpdate;
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @param User $user
	 * @return ConversationUserModel
	 */
	public function getRelation(UserModel $user)
	{
		return ConversationUserService::getByConversationIdAndUserId($this->getId(), $user->getId());
	}

	/**
	 * @param UserModel $user
	 * @return bool
	 */
	public function hasRelation(UserModel $user)
	{
		try {
			$this->getRelation($user);
			return true;
		} catch (NoResultException $e) {
			return false;
		}
	}

	public function getLastPost($userId)
	{
		try {
			$post = reset(Post::getLastByConversationId($this->getId(), $userId, 0, 1));
		} catch (NoResultException $e) {
			$post = false;
		}

		return $post;
	}

	public function getMembers()
	{
		return UserService::getByConversationId($this->getId());
	}

}