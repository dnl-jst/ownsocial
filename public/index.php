<?php

ini_set('display_errors', true);
error_reporting(E_ALL);

date_default_timezone_set('Europe/Berlin');

define('APPLICATION_ROOT', realpath(dirname(__FILE__) . '/../') . '/');

require_once(APPLICATION_ROOT . 'vendor/autoload.php');

set_include_path(
	APPLICATION_ROOT . 'library' . PATH_SEPARATOR . get_include_path()
);

require_once('Core/AutoLoader.php');

$autoLoader = Core_AutoLoader::getInstance();

if (!is_file(APPLICATION_ROOT . 'config.php')) {
	header('Location: /install/');
	exit();
}

$config = include(APPLICATION_ROOT . '/config.php');

$application = new Core_Application($config);
$application->run();
