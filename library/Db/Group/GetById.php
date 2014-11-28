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
				g.id,
				g.name,
				g.description,
				g.type,
				COALESCE(g.portrait_file_id, cnfg.value) AS portrait_file_id,
				g.created
			FROM
				groups g
			JOIN configs cnfg ON cnfg.key = \'default_portrait_id\'
			WHERE
				g.id = ?';

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