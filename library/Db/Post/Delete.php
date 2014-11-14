<?php

namespace Db\Post;

use Core\Query;

class Delete extends Query
{

	protected $id;

	protected function build()
	{
		$query = '
			DELETE FROM
				posts
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