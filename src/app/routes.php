<?php

$app->get('/home', 'HomeController:index')->setName('home');

$app->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
$app->post('/auth/signup', 'AuthController:postSignUp');

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