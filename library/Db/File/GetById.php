<?php

class Db_File_GetById extends Core_Query
{

	protected $id;

	protected function build()
	{
		$query = '
			SELECT
				id,
				user_id,
				content,
				type,
				created
			FROM
				files
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