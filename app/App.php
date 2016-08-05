<?php

namespace App;

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
}