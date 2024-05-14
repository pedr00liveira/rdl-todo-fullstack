<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

$config['db']['host']   = 'localhost';
$config['db']['user']   = 'admin';
$config['db']['pass']   = '';
$config['db']['dbname'] = 'todo';

$app = new \Slim\App([
    'settings' => $config
]);

$container = $app->getContainer();

$container['view'] = function ($container) {
    $view =  new \Slim\Views\PhpRenderer(__DIR__ . '../resources/views');

    return $view;
};

require __DIR__ . '/../app/routes.php';