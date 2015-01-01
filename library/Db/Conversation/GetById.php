<?php

namespace Db\Conversation;

use Core\Query;

class GetById extends Query
{

	protected $id;

	protected function build()
	{
		$query = '
			SELECT
				c.id,
				c.title,
				c.created,
				c.created_by,
				c.last_update
			FROM
				conversations c
			WHERE
				c.id = ?';

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