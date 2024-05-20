<?php

$app->get('/home', 'HomeController:redirectCalendar');

$app->get('/home/calendar', 'HomeController:renderCalendar');

$app->get('/home/mark-as-done/{id}', 'HomeController:markDone');

$app->get('/home/delete/task/{id}', 'HomeController:deleteTask');
$app->get('/home/delete/category/{id}', 'HomeController:deleteCategory');

$app->get('/home/new', 'HomeController:redirectCreate');

$app->get('/home/new/task', 'HomeController:renderCreateTask');
$app->post('/home/new/task', 'HomeController:createTask');

$app->get('/home/new/category', 'HomeController:renderCreateCategory');
$app->post('/home/new/category', 'HomeController:createCategory');

$app->get('/home/info/{id}', 'HomeController:renderInfo');

$app->get('/home/edit/{id}', 'HomeController:renderEdit');
$app->post('/home/edit/{id}', 'HomeController:edit');

$app->get('/home/profile', 'HomeController:renderProfile');

$app->get('/auth/signup', 'AuthController:renderSignUp');
$app->post('/auth/signup', 'AuthController:signUp');

$app->get('/auth/signin', 'AuthController:renderSignIn');
$app->post('/auth/signin', 'AuthController:signIn');

$app->get('/home/logout', 'AuthController:logOut');