<?php

namespace Db\User;

use Core\Query;

class GetById extends Query
{

	protected $id;

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
				u.id = ?';

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