<?php

class Db_Group_GetById extends Core_Query
{

	protected $id;

	protected function build()
	{
		$query = '
			SELECT
				id,
				name,
				created
			FROM
				groups
			WHERE
				id = ?';

		$this->addBind($this->id);

		return $query;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

}