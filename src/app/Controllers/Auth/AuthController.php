<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Executers\Auth\AuthExecuter;

class AuthController extends Controller {

    public function renderSignUp($request, $response) {
        return $this->container->view->render($response, 'auth/signup.html');
    }

    public function signUp($request, $response) {
    
        if (( new AuthExecuter($this->container) )->signUp($request)) {
            return $response->withRedirect('signin');
        }
        
        echo 'error';
        return false;
    }

    public function renderSignIn($request, $response) {
        return $this->container->view->render($response, 'auth/signin.html');
    }

    public function signIn($request, $response) {
        
        if (( new AuthExecuter($this->container) )->signIn($request)) {
            return $response->withRedirect('../home');
        }

        echo 'error';
        return false;
    }

    public function logOut($request, $response) {
        session_destroy();
        return $response->withRedirect('../auth/signin');
    }
}