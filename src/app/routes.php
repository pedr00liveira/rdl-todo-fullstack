<?php


$app->get('/home', 'HomeController:index');
$app->get('/home/calendar', 'HomeController:calendar');
$app->get('/home/new', 'HomeController:create');
$app->get('/home/info', 'HomeController:info');
$app->get('/home/edit', 'HomeController:edit');


$app->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
$app->post('/auth/signup', 'AuthController:postSignUp');

$app->get('/auth/signin', 'AuthController:getSignIn')->setName('auth.signin');
$app->post('/auth/signin', 'AuthController:postSignIn');

// $app->get('/home', function ($request, $response) {
//     //$response = ;
//     $sql = "SELECT * 
//             FROM user
//             WHERE id_user = 1";

//     $result = $this->db->prepare($sql);

//     if ($result->execute()) {

//         while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
//             echo $row['name'];
//         }
//     }

//     return $this->view->render($response, 'auth/auth_signup.html');

// });

// $app->get('/auth/signup', function ($request, $response) {
//     //$response = ;
//     $sql = "SELECT * 
//             FROM user
//             WHERE id_user = 1";

//     $result = $this->db->prepare($sql);

//     if ($result->execute()) {

//         while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
//             echo $row['name'];
//         }
//     }

//     return $this->view->render($response, 'auth/auth_signup.html');

// });