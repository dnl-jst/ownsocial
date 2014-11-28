<?php

namespace Model;

use Core\Model;

class Group extends Model
{

	const TYPE_HIDDEN = 'hidden';
	const TYPE_PROTECTED = 'protected';
	const TYPE_PUBLIC = 'public';

	public static $types = array(self::TYPE_HIDDEN, self::TYPE_PROTECTED, self::TYPE_PUBLIC);

	protected $id;
	protected $name;
	protected $description;
	protected $type;
	protected $portraitFileId;
	protected $created;
	protected $role;

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
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName($name)
	{
		$this->name = $name;
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
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param mixed $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

}