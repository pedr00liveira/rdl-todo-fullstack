<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;

use Slim\Views\PhpRenderer as View;

class AuthController extends Controller {

    public function getSignUp($request, $response) {
        return $this->container->view->render($response, 'auth/signup.html');
    }

    public function postSignUp($request, $response) {
        
        $count = 0;

        $name = $request->getParam('name');
        $email = $request->getParam('email');
        $pass = $request->getParam('password');

        $sql = "SELECT * 
                FROM user
                WHERE email = '$email'";

        $result = $this->container->db->prepare($sql);

        if ($result->execute()) {

            while ($row = $result->fetch($this->container->db::FETCH_ASSOC)) {
                $count = $count + 1;
            }
        }

        if ($count == 0) {

            $sql = "INSERT INTO user (nome, email, pass)
                    VALUES ('$name', '$email', '$pass')";

            $result = $this->container->db->prepare($sql);

            if ($result->execute()) {
                return $response->withRedirect('signin');
            }
        }
        echo 'error';
        return false;
    }

    public function getSignIn($request, $response) {
        return $this->container->view->render($response, 'auth/signin.html');
    }

    public function postSignIn($request, $response) {
        
        $email = $request->getParam('email');
        $pass = $request->getParam('password');

        $sql = "SELECT id_user 
                FROM user
                WHERE email = '$email' 
                AND pass = '$pass'";

        $result = $this->container->db->prepare($sql);

        if ($result->execute()) {

            if ($result->rowCount() > 0) {
                $_SESSION['user'] = $result->fetchColumn();
                return $response->withRedirect('../home');
            }
        }

        return "error";
    }
}