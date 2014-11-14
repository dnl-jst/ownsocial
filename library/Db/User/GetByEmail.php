<?php

class Db_User_GetByEmail extends Core_Query
{

	protected $email;

	protected function build()
	{
		$query = '
			SELECT
				u.id,
				u.email,
				u.password,
				u.first_name,
				u.last_name,
				IFNULL(u.portrait_file_id, cnfg.value) AS portrait_file_id,
				u.created
			FROM
				users u
			JOIN configs cnfg ON cnfg.key = \'default_portrait_id\'
			WHERE
				u.email = ?';

		$this->addBind($this->email);

		return $query;
	}

	/**
	 * @param mixed $email
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	}
	
}