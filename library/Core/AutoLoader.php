<?php

class Core_AutoLoader
{
	protected static $_instance;

	/**
	 * @return Core_AutoLoader
	 */
	public static function getInstance()
	{
		if (self::$_instance === null) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * @param $class
	 * @throws Core_Exception
	 */
	public static function autoload($class)
	{
		if (class_exists($class, false) || interface_exists($class, false)) {
			return;
		}

		$file = str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';

		include_once $file;

		if (!class_exists($class, false) && !interface_exists($class, false)) {
			require_once('Core/Exception.php');
			throw new Core_Exception('unable to autoload class: ' . $class);
		}
	}

	public function __construct()
	{
		spl_autoload_register(array(__CLASS__, 'autoload'));
	}

	public function addPath($path)
	{
		set_include_path(
			realpath($path) . PATH_SEPARATOR . get_include_path()
		);
	}
}