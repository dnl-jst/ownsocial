<?php

namespace Service;

use Core\Service;
use Db\Config\GetAll;

class Config extends Service
{

	public static function getAll()
	{
		$query = new GetAll();
		return $query->fetchAssoc();
	}

}