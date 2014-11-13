<?php

class Model_File extends Core_Model
{

	/** @var integer */
	protected $id;

	/** @var integer */
	protected $userId;

	/** @var string */
	protected $content;

	/** @var string */
	protected $type;

	/** @var integer */
	protected $created;

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
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param mixed $type
	 */
	public function setType($type)
	{
		$this->type = $type;
	}

	/**
	 * @return integer
	 */
	public function getUserId()
	{
		return $this->userId;
	}

	/**
	 * @param integer $userId
	 */
	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

}