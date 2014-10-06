<?php

class Db_Group_Store extends Core_Query
{

	protected $id;
	protected $name;
	protected $created;

	protected function build()
	{
		$query = '
			INSERT INTO
				groups
				(
					id,
					name,
					created
				)
			VALUES
				(
					?,
					?,
					?
				)
			ON DUPLICATE KEY UPDATE
				name = VALUES(name)';

		$this->addBind($this->id);
		$this->addBind($this->name);
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

}