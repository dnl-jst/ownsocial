<?php

namespace Db\Config;

use Core\Query;

class GetAll extends Query
{

	protected function build()
	{
		$query = '
			SELECT
				`key`,
				`value`
			FROM
				configs';

		return $query;
	}

}