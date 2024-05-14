<?php

$app->get('/home', function ($request, $response) {
    $response = $this->view->render($response, 'index.html');
    return $response;
});