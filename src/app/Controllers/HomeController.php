<?php

namespace App\Controllers;

use Slim\Views\PhpRenderer as View;

class HomeController extends Controller {

    protected $view;

    public function index($request, $response) {
        return $this->container->view->render($response, 'auth/signup.html');
    }
}