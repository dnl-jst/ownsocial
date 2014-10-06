<?php

class Core_Application
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
		$request = new Core_Controller_Request();
		$response = new Core_Controller_Response();

		$autoLoader = Core_AutoLoader::getInstance();
		$autoLoader->addPath(APPLICATION_ROOT . '/application/controller/');

		$this->callController($request, $response);

		echo $response->getOutput();
	}

	/**
	 * @param Core_Controller_Request $request
	 * @param Core_Controller_Response $response
	 * @throws Core_Exception
	 * @return void
	 */
	protected function callController(Core_Controller_Request $request, Core_Controller_Response $response)
	{
		$path = $request->getPath();
		$path = trim($path, '/');
		$parts = explode('/', $path);

		$controller = (isset($parts[0]) && $parts[0]) ? $parts[0] : 'index';
		$controller = $this->sanitizeName($controller);

		$action = (isset($parts[1]) && $parts[1]) ? $parts[1] : 'index';
		$action = $this->sanitizeName($action);

		$view = new Core_View(APPLICATION_ROOT . '/application/templates/views/', $controller . '/' . $action . '.phtml');

		$controllerClass = ucfirst($controller) . 'Controller';
		$controllerInstance = new $controllerClass($request, $response, $view);

		if (!$controllerInstance instanceof Core_Controller) {
			throw new Core_Exception('controller ' . $controllerClass . ' not instance of Core_Controller');
		}

		$actionMethod = $action . 'Action';

		if (!method_exists($controllerInstance, $actionMethod)) {
			throw new Core_Exception('action ' . $actionMethod . ' not found in controller ' . $controllerClass);
		}

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