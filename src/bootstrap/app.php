<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

$config['db']['host']   = 'localhost';
$config['db']['user']   = 'root';
$config['db']['pass']   = '';
$config['db']['dbname'] = 'todo';

$config['displayErrorDetails'] = true;

$app = new \Slim\App([
    'settings' => $config
]);

$container = $app->getContainer();

$container['view'] = function ($container) {
    $view =  new \Slim\Views\PhpRenderer('../resources/views');
    return $view;
};

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$container['HomeController'] = function ($container) {
    return new \App\Controllers\HomeController($container);
};

require __DIR__ . '/../app/routes.php';