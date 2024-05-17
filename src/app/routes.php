<?php

$app->post('/getCategory', 'HomeController:renderCategory')->setName('render.category');

$app->get('/home', 'HomeController:redirectCalendar');

$app->get('/home/calendar', 'HomeController:renderCalendar');

$app->get('/home/new', 'HomeController:redirectCreate');

$app->get('/home/new/task', 'HomeController:renderCreateTask');
$app->post('/home/new/task', 'HomeController:createTask');

$app->get('/home/new/category', 'HomeController:renderCreateCategory');
$app->post('/home/new/category', 'HomeController:createCategory');

$app->get('/home/info', 'HomeController:renderInfo');

$app->get('/home/edit', 'HomeController:renderEdit');
$app->post('/home/edit', 'HomeController:edit');

$app->get('/auth/signup', 'AuthController:renderSignUp');
$app->post('/auth/signup', 'AuthController:signUp');

$app->get('/auth/signin', 'AuthController:renderSignIn');
$app->post('/auth/signin', 'AuthController:signIn');