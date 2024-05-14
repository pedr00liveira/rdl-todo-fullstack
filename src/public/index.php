<?php

// use \Psr\Http\Message\ServerRequestInterface as Request;
// use \Psr\Http\Message\ResponseInterface as Response;


// require '../vendor/autoload.php';

// $app = new \Slim\App();

// $container = $app->getContainer();

// $container['view'] = new \Slim\Views\PhpRenderer('../templates/');

// $container['db'] = function ($c) {
//     $db = $c['settings']['db'];
//     $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
//         $db['user'], $db['pass']);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
//     return $pdo;
// };

// $app->get('/teste/{name}', function (Request $request, Response $response, array $args) {
//     $name = $args['name'];
//     $response->getBody()->write("Hello, $name");

//     return $response;
// });

require __DIR__ . '/../bootstrap/app.php';

$app->run();