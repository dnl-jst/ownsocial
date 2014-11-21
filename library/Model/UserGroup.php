<?php

namespace Model;

use Core\Model;

class UserGroup extends Model
{

	const ROLE_MEMBER = 'member';
	const ROLE_ADMIN = 'admin';

	public static $roles = array(self::ROLE_MEMBER, self::ROLE_ADMIN);

	protected $userId;
	protected $groupId;
	protected $confirmed;
	protected $role;

	/**
	 * @return mixed
	 */
	public function getConfirmed()
	{
		return $this->confirmed;
	}

	/**
	 * @param mixed $confirmed
	 */
	public function setConfirmed($confirmed)
	{
		$this->confirmed = $confirmed;
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
	public function getRole()
	{
		return $this->role;
	}

	/**
	 * @param mixed $role
	 */
	public function setRole($role)
	{
		$this->role = $role;
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

}