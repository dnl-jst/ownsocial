<?php

class Db_User_GetUnconfirmedContacts extends Core_Query
{

	protected $id;

	protected function build()
	{
		$sQuery = '
			SELECT
				u.id,
				u.email,
				u.password,
				u.first_name,
				u.last_name,
				u.portrait_file_id,
				u.created
			FROM
				users u
			JOIN relations r ON r.user_id = u.id AND r.user_id2 = ? AND r.confirmed IS NULL';

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