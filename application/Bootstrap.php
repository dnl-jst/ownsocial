<?php

class Bootstrap
{

	public static function initDb($config)
	{
		$oDb = new Zend_Db_Adapter_Pdo_Mysql(array(
			'host'     => $config['db_host'],
			'username' => $config['db_user'],
			'password' => $config['db_pass'],
			'dbname'   => $config['db_name'],
			'charset'  => 'utf8mb4'
		));

		Core_Query::configureDb($oDb);
	}

	public static function initSession()
	{
		session_start();
	}

}