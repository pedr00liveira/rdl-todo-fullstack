<?php

$app->get('/home', function ($request, $response) {
    
    $response = $this->view->render($response, 'teste.html');
    return $response;
});