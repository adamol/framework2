<?php

require 'vendor/autoload.php';

$app = new App\App;

$container = $app->getContainer();

$container['errorHandler'] = function() {
	return function($response) {
		return $response->setBody('Page not found')->withStatus(404);
	};
};

$container['config'] = function() {
	return [
	'db_driver' => 'mysql',
	'db_host' => 'localhost',
	'db_name' => 'framework',
	'db_user' => 'root',
	'db_pass' => 'root',
	];
};

$container['db'] = function($c) {
	return new PDO(
		$c->config['db_driver'].':host='.$c->config['db_host'].';dbname='.$c->config['db_name'],
		$c->config['db_user'],
		$c->config['db_pass']);
};

$app->get('/', [App\Controllers\HomeController::class, 'index']);
$app->get('/users', [App\Controllers\UserController::class, 'index']);

$app->post('/signup', function() {
	echo 'Sign up';
});

$app->run();