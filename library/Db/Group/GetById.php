<?php

namespace Db\Group;

use Core\Query;

class GetById extends Query
{

	protected $id;

	protected function build()
	{
		$query = '
			SELECT
				id,
				name,
				type,
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