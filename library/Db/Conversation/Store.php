<?php

namespace Db\Conversation;

use Core\Query;

class Store extends Query
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

	protected function build()
	{
		$query = '
			INSERT INTO
				conversations
				(
					id,
					title,
					created,
					created_by,
					last_update
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
				title = VALUES(title),
				last_update = VALUES(last_update)';

		$this->addBind($this->id);
		$this->addBind($this->title);
		$this->addBind($this->created);
		$this->addBind($this->createdBy);
		$this->addBind($this->lastUpdate);

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
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @param int $created
	 */
	public function setCreated($created)
	{
		$this->created = $created;
	}

	/**
	 * @param int $createdBy
	 */
	public function setCreatedBy($createdBy)
	{
		$this->createdBy = $createdBy;
	}

	/**
	 * @param int $lastUpdate
	 */
	public function setLastUpdate($lastUpdate)
	{
		$this->lastUpdate = $lastUpdate;
	}

}