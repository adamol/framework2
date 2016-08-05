<?php

namespace App;

use App\Exceptions\MethodNotAllowedException;
use App\Exceptions\RouteNotFoundException;

class App
{
	protected $container;

	function __construct()
	{
		$this->container = new Container([
			'router' => function() {
				return new Router;
			}
		]);
	}

	public function getContainer()
	{
		return $this->container;
	}

	public function get($uri, $handler)
	{
		$this->container->router->addRoute($uri, $handler, ['GET']);
	}

	public function post($uri, $handler)
	{
		$this->container->router->addRoute($uri, $handler, ['POST']);
	}

	public function map($uri, $handler, array $methods = ['GET'])
	{
		$this->container->router->addRoute($uri, $handler, $methods);
	}

	public function run()
	{
		$router = $this->container->router;

		$path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
		$router->setPath($path);

		try {
			$response = $router->getResponse();
		} catch (RouteNotFoundException $e) {
			if ($this->container->has('errorHandler')) {
				$response = $this->container->errorHandler;
			} else {
				return;
			}
		} catch (MethodNotAllowedException $e) {
			die('Method not allowed');
		}
		
		return $this->process($response);
	}

	protected function process($callable)
	{
		return $callable();
	}
}