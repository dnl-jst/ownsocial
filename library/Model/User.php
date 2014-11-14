<?php

namespace Model;

use Core\Model;
use Service\User as UserService;
use Service\Group;

class User extends Model
{

	/** @var int */
	protected $id;

	/** @var string */
	protected $email;

	/** @var string */
	protected $password;

	/** @var string */
	protected $firstName;

	/** @var string */
	protected $lastName;

	/** @var int */
	protected $portraitFileId;

	/** @var string */
	protected $created;

	/**
	 * @return int
	 */
	public function getPortraitFileId()
	{
		return $this->portraitFileId;
	}

	/**
	 * @param int $portraitFileId
	 */
	public function setPortraitFileId($portraitFileId)
	{
		$this->portraitFileId = $portraitFileId;
	}

	/**
	 * @return string
	 */
	public function getCreated()
	{
		return $this->created;
	}

	/**
	 * @param string $created
	 */
	public function setCreated($created)
	{
		$this->created = $created;
	}

	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	}

	/**
	 * @return string
	 */
	public function getFirstName()
	{
		return $this->firstName;
	}

	/**
	 * @param string $firstName
	 */
	public function setFirstName($firstName)
	{
		$this->firstName = $firstName;
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
	 * @return string
	 */
	public function getLastName()
	{
		return $this->lastName;
	}

	/**
	 * @param string $lastName
	 */
	public function setLastName($lastName)
	{
		$this->lastName = $lastName;
	}

	/**
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @param string $password
	 */
	public function setPassword($password)
	{
		$this->password = $password;
	}

	/**
	 * @return User[]
	 */
	public function getUnconfirmedContacts()
	{
		return UserService::getUnconfirmedContacts($this->getId());
	}

	/**
	 * @return \Model\Group[]
	 */
	public function getGroups()
	{
		return Group::getByUserId($this->getId());
	}

	public function getRelationTo(User $user)
	{
		return UserService::getRelation($this, $user);
	}

}