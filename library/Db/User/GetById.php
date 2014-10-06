<?php

class Db_User_GetById extends Core_Query
{

	protected $id;

	protected function build()
	{
		$sQuery = '
			SELECT
				id,
				email,
				password,
				first_name,
				last_name,
				portrait_file_id,
				created
			FROM
				users
			WHERE
				id = ?';

		$this->addBind($this->id);

		return $sQuery;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

}