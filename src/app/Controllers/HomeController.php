<?php

namespace App\Controllers;

use Slim\Views\PhpRenderer as View;

class HomeController extends Controller {

    public function index($request, $response) {
        return $this->container->view->render($response, 'index.html');
    }
}