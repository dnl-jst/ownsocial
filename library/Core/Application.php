<?php

namespace Core;

use Core\Controller;
use Core\Controller\Request;
use Core\Controller\Response;
use Core\Exception;
use Core\View;
use Zend\Loader\AutoloaderFactory;

class Application
{
	protected $config;

	public function __construct($config)
	{
		$this->config = $config;
		$bootstrapFile = APPLICATION_ROOT . '/application/Bootstrap.php';

		if (is_file($bootstrapFile)) {
			require_once($bootstrapFile);

			if (class_exists('Bootstrap', false)) {
				foreach (get_class_methods('Bootstrap') as $method) {
					call_user_func(array('Bootstrap', $method), $this->config);
				}
			}
		}
	}

	public function run()
	{
		$request = new Request();
		$response = new Response();

		$autoloaderConfig = array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					'Application\\Controller' => APPLICATION_ROOT . '/application/controller/'
				)
			)
		);

		AutoloaderFactory::factory($autoloaderConfig);

		$this->callController($request, $response);

		echo $response->getOutput();
	}

	/**
	 * @param Request $request
	 * @param Response $response
	 * @throws Exception
	 * @return void
	 */
	protected function callController(Request $request, Response $response)
	{
		$path = $request->getPath();
		$path = trim($path, '/');
		$parts = explode('/', $path);

		$controller = (isset($parts[0]) && $parts[0]) ? $parts[0] : 'index';
		$controller = $this->sanitizeName($controller);

		$origAction = (isset($parts[1]) && $parts[1]) ? $parts[1] : 'index';
		$action = $this->sanitizeName($origAction);

		$translator = new Translator(APPLICATION_ROOT . '/languages/');
		$templatePath = APPLICATION_ROOT . '/application/templates/views/';
		$templateFile = $controller . '/' . $origAction . '.phtml';

		$view = new View($controller, $origAction, $templatePath, $templateFile, $translator);

		$controllerClass = 'Application\Controller\\' . ucfirst($controller);

		if (!class_exists($controllerClass)) {
			header('404 file not found', true, 404);
			die('404 file not found');
		}

		$controllerInstance = new $controllerClass($request, $response, $view, $translator);

		if (!$controllerInstance instanceof Controller) {
			throw new Exception('controller ' . $controllerClass . ' not instance of Core_Controller');
		}

		$actionMethod = $action . 'Action';

		if (!method_exists($controllerInstance, $actionMethod)) {
			header('404 file not found', true, 404);
			die('404 file not found');
		}

		$request->setController($controller);
		$request->setAction($action);

		$controllerInstance->dispatch($actionMethod);
	}

	private function sanitizeName($string)
	{
		$string = strtolower($string);
		$parts = explode('-', $string);
		$parts = array_map('ucfirst', $parts);
		$string = lcfirst(join('', $parts));

		return $string;
	}

}