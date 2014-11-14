<?php

ini_set('display_errors', true);
error_reporting(E_ALL);

date_default_timezone_set('Europe/Berlin');

define('APPLICATION_ROOT', realpath(dirname(__FILE__) . '/../') . '/');
define('LIBRARY_PATH', APPLICATION_ROOT . 'library');

require_once(APPLICATION_ROOT . 'vendor/autoload.php');

set_include_path(
	LIBRARY_PATH . PATH_SEPARATOR . get_include_path()
);

$autoloaderConfig = array(
	'Zend\Loader\StandardAutoloader' => array(
		'namespaces' => array(
			'Core' => LIBRARY_PATH . '/Core',
			'Db' => LIBRARY_PATH . '/Db',
			'Model' => LIBRARY_PATH . '/Model',
			'Service' => LIBRARY_PATH . '/Service'
		)
	)
);

Zend\Loader\AutoloaderFactory::factory($autoloaderConfig);

if (!is_file(APPLICATION_ROOT . 'config.php')) {
	header('Location: /install/');
	exit();
}

$config = include(APPLICATION_ROOT . '/config.php');

$application = new \Core\Application($config);
$application->run();
