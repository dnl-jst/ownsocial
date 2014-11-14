<?php

namespace Db\User;

use Core\Query;

class Store extends Query
{

	/** @var null|integer */
	protected $id;

	/** @var string */
	protected $type;

	/** @var string */
	protected $email;

	/** @var integer */
	protected $emailConfirmed;

	/** @var string */
	protected $emailConfirmationHash;

	/** @var integer */
	protected $accountConfirmed;

	/** @var string */
	protected $password;

	/** @var string */
	protected $firstName;

	/** @var string */
	protected $lastName;

	/** @var integer */
	protected $portraitFileId;

	/** @var integer */
	protected $created;

	protected function build()
	{
		$query = '
			INSERT INTO
				users
				(
					id,
					type,
					email,
					email_confirmed,
					email_confirmation_hash,
					account_confirmed,
					password,
					first_name,
					last_name,
					portrait_file_id,
					created
				)
			VALUES
				(
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?
				)
			ON DUPLICATE KEY UPDATE
				type = VALUES(type),
				email = VALUES(email),
				email_confirmed = VALUES(email_confirmed),
				email_confirmation_hash = VALUES(email_confirmation_hash),
				account_confirmed = VALUES(account_confirmed),
				password = VALUES(password),
				first_name = VALUES(first_name),
				last_name = VALUES(last_name),
				portrait_file_id = VALUES(portrait_file_id)';

		$this->addBind($this->id);
		$this->addBind($this->type);
		$this->addBind($this->email);
		$this->addBind($this->emailConfirmed);
		$this->addBind($this->emailConfirmationHash);
		$this->addBind($this->accountConfirmed);
		$this->addBind($this->password);
		$this->addBind($this->firstName);
		$this->addBind($this->lastName);
		$this->addBind($this->portraitFileId);
		$this->addBind($this->created);

		return $query;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @param integer $created
	 */
	public function setCreated($created)
	{
		$this->created = $created;
	}

	/**
	 * @param string $email
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	}

	/**
	 * @param string $firstName
	 */
	public function setFirstName($firstName)
	{
		$this->firstName = $firstName;
	}

	/**
	 * @param string $lastName
	 */
	public function setLastName($lastName)
	{
		$this->lastName = $lastName;
	}

	/**
	 * @param string $password
	 */
	public function setPassword($password)
	{
		$this->password = $password;
	}

	/**
	 * @param int $portraitFileId
	 */
	public function setPortraitFileId($portraitFileId)
	{
		$this->portraitFileId = $portraitFileId;
	}

	/**
	 * @param int $accountConfirmed
	 */
	public function setAccountConfirmed($accountConfirmed)
	{
		$this->accountConfirmed = $accountConfirmed;
	}

	/**
	 * @param string $emailConfirmationHash
	 */
	public function setEmailConfirmationHash($emailConfirmationHash)
	{
		$this->emailConfirmationHash = $emailConfirmationHash;
	}

	/**
	 * @param int $emailConfirmed
	 */
	public function setEmailConfirmed($emailConfirmed)
	{
		$this->emailConfirmed = $emailConfirmed;
	}

	/**
	 * @param string $type
	 */
	public function setType($type)
	{
		$this->type = $type;
	}

}