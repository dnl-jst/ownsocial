<?php

namespace Db\Group;

use Core\Query;

class Store extends Query
{

	protected $id;
	protected $name;
	protected $type;
	protected $created;

	protected function build()
	{
		$query = '
			INSERT INTO
				groups
				(
					id,
					name,
					type,
					created
				)
			VALUES
				(
					?,
					?,
					?,
					?
				)
			ON DUPLICATE KEY UPDATE
				name = VALUES(name),
				type = VALUES(type)';

		$this->addBind($this->id);
		$this->addBind($this->name);
		$this->addBind($this->type);
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
	 * @param mixed $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @param mixed $created
	 */
	public function setCreated($created)
	{
		$this->created = $created;
	}

	/**
	 * @param mixed $type
	 */
	public function setType($type)
	{
		$this->type = $type;
	}

}