<?php

namespace App;

class Router
{
	protected $path;
	protected $routes = [];
	protected $methods = [];

	public function setPath($path = '/')
	{
		$this->path = $path;
	}

	public function addRoute($uri, $handler, array $methods = ['GET'])
	{
		$this->routes[$uri] = $handler;
		$this->methods[$uri] = $methods;
	}

	public function getResponse()
	{
		if (!in_array($_SERVER['REQUEST_METHOD'], $this->methods[$this->path])) {
			die('method not allowed');
		}
		return $this->routes[$this->path];
	}
}