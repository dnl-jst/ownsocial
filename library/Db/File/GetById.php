<?php

namespace Db\File;

use Core\Query;

class GetById extends Query
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