<?php

class Bootstrap
{

	public static function initDb($config)
	{
		$db = new Zend\Db\Adapter\Adapter(array(
			'driver'   => 'Pdo_Mysql',
			'host'     => $config['db_host'],
			'username' => $config['db_user'],
			'password' => $config['db_pass'],
			'dbname'   => $config['db_name'],
			'charset'  => 'utf8mb4'
		));

		Core_Query::configureDb($db);
	}

	public static function initSession()
	{
		session_start();
	}

}