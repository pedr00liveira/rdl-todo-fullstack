<?php

namespace App\Controllers;

use Slim\Views\PhpRenderer as View;

class HomeController extends Controller {

    public function index($request, $response) {
        return $response->withRedirect('home/calendar');
    }

    public function calendar($request, $response) {
        return $this->container->view->render($response, 'calendar.html');
    }

    public function create($request, $response) {
        return $this->container->view->render($response, 'create.html');
    }

    public function info($request, $response) {
        return $this->container->view->render($response, 'info.html');
    }
    
    public function edit($request, $response) {
        return $this->container->view->render($response, 'create.html');
    }
}