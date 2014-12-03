<?php

namespace Model;

use Core\Model;

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

}