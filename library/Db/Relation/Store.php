<?php

class Db_Relation_Store extends Core_Query
{

	protected $userId;
	protected $userId2;
	protected $created;
	protected $confirmed;

	protected function build()
	{
		$query = '
			INSERT INTO
				relations
				(
					user_id,
					user_id2,
					created,
					confirmed
				)
			VALUES
				(
					?,
					?,
					?,
					?
				)
			ON DUPLICATE KEY UPDATE
				created = VALUES(created),
				confirmed = VALUES(confirmed)';

		$this->addBind($this->userId);
		$this->addBind($this->userId2);
		$this->addBind($this->created);
		$this->addBind($this->confirmed);

		return $query;
	}

	/**
	 * @param mixed $confirmed
	 */
	public function setConfirmed($confirmed)
	{
		$this->confirmed = $confirmed;
	}

	/**
	 * @param mixed $created
	 */
	public function setCreated($created)
	{
		$this->created = $created;
	}

	/**
	 * @param mixed $userId
	 */
	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

	/**
	 * @param mixed $userId2
	 */
	public function setUserId2($userId2)
	{
		$this->userId2 = $userId2;
	}

}