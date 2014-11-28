<?php

use Core\Query;

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

		Query::configureDb($db);

		$currentDbLayoutVersion = require(APPLICATION_ROOT . 'db_layout_version.php');
		$installedDbLayoutVersion = \Service\Config::getByKey('db_layout_version');

		if ($currentDbLayoutVersion != $installedDbLayoutVersion) {

			$siteTitle = \Service\Config::getByKey('site_title');

			$updateUrl = ((@$config['https']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/install/db_update.php';

			echo '<h1>' . htmlspecialchars($siteTitle) . '</h1>';
			echo '<p>This network is currently in maintenance mode. Pleasy try again later.</p>';
			echo '<p>If you are an administrator of this network, visit <a href="' . htmlspecialchars($updateUrl) . '">' . htmlspecialchars($updateUrl) . '</a>';

			die();
		}
	}

	public static function initSession()
	{
		session_start();
	}

}