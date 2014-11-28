<?php

namespace Db\Group;

use Core\Query;

class Search extends Query
{

	protected $search;

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
				g.name LIKE ?
			AND 	(
					g.type = \'protected\'
				OR	g.type = \'public\'
			)';

		$this->addBind('%' . $this->search . '%');

		return $query;
	}

	/**
	 * @param mixed $search
	 */
	public function setSearch($search)
	{
		$this->search = $search;
	}

}