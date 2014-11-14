<?php

namespace Service;

use Core\Service;
use Db\Config\GetAll;

class Config extends Service
{

	protected static $configs = null;

	public static function getAll()
	{
		if (self::$configs === null) {

			$query = new GetAll();

			self::$configs = $query->fetchAssoc();
		}

		return self::$configs;
	}

	public static function getByKey($key, $default = null)
	{
		$configs = self::getAll();

		if (isset($configs[$key])) {
			return $configs[$key]['value'];
		}

		return $default;
	}

}