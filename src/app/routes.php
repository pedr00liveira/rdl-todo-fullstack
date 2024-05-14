<?php

$app->get('/home', function ($request, $response) {
    echo "test";
    $response = $this->view->render($response, 'teste.html');
    return $response;
});