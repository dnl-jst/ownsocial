<?php

class Db_User_GetByEmail extends Core_Query
{

	protected $email;

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
				email = ?';

		$this->addBind($this->email);

		return $sQuery;
	}

	/**
	 * @param mixed $email
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	}
	
}