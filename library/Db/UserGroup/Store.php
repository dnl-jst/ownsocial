<?php

namespace Db\UserGroup;

use Core\Query;

class Store extends Query
{

	/** @var integer */
	protected $userId;

	/** @var integer */
	protected $groupId;

	/** @var integer */
	protected $createdBy;

	/** @var integer */
	protected $confirmed;

	/** @var string */
	protected $role;

	protected function build()
	{
		$query = '
			INSERT INTO
				user_groups
				(
					user_id,
					group_id,
					created_by,
					confirmed,
					role
				)
			VALUES
				(
					?,
					?,
					?,
					?,
					?
				)
			ON DUPLICATE KEY UPDATE
				confirmed = VALUES(confirmed),
				role = VALUES(role)';

		$this->addBind($this->userId);
		$this->addBind($this->groupId);
		$this->addBind($this->createdBy);
		$this->addBind($this->confirmed);
		$this->addBind($this->role);

		return $query;
	}

	/**
	 * @param int $userId
	 */
	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

	/**
	 * @param int $groupId
	 */
	public function setGroupId($groupId)
	{
		$this->groupId = $groupId;
	}

	/**
	 * @param string $role
	 */
	public function setRole($role)
	{
		$this->role = $role;
	}

	/**
	 * @param int $confirmed
	 */
	public function setConfirmed($confirmed)
	{
		$this->confirmed = $confirmed;
	}

	/**
	 * @param int $createdBy
	 */
	public function setCreatedBy($createdBy)
	{
		$this->createdBy = $createdBy;
	}

}