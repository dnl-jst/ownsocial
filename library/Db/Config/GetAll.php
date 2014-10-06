<?php

class Db_Config_GetAll extends Core_Query
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