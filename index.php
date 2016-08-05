<?php

require 'vendor/autoload.php';

$app = new App\App;

$container = $app->getContainer();

$container['errorHandler'] = function() {
	// TODO
	die('Route not found');
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

$app->post('/signup', function() {
	echo 'Sign up';
});

$app->map('/users', function() {
	echo 'Users';
}, ['GET', 'POST']);

$app->run();