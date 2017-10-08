<?php
    session_start();
    use Core\Route;

	require_once 'config.php';
	const CONFIG = [
        'db_dsn' => DB_SERVER,
        'db_user' => DB_USER,
        'db_pass' => DB_PASSWORD
   	];

    require dirname(__DIR__) . '/vendor/autoload.php';

    //$uri = $_SERVER['QUERY_STRING'];
    $uri = str_replace('/', '', $_SERVER['REQUEST_URI']);
    $route = new Route();

    $route->add('', ['controller' => 'Home', 'action' => 'homeAction']);
    $route->add('register', ['controller' => 'User', 'action' => 'registerAction']);
    $route->add('login', ['controller' => 'Security', 'action' => 'loginAction']);
    $route->add('logout', ['controller' => 'Security', 'action' => 'logoutAction']);
    $route->add('error404', ['controller' => 'Error404', 'action' => 'error404Action']);

    try {
        $route->dispatch($uri);
    } catch (Exception $e) {
        throw $e;
    }




