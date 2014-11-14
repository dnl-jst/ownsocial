<?php

namespace Model;

use Core\Model;

class Relation extends Model
{

	protected $userId;
	protected $userId2;
	protected $created;
	protected $confirmed;

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
	public function getUserId2()
	{
		return $this->userId2;
	}

	/**
	 * @param mixed $userId2
	 */
	public function setUserId2($userId2)
	{
		$this->userId2 = $userId2;
	}

}