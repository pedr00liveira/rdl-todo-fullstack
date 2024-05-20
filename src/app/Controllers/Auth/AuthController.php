<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Executers\Auth\AuthExecuter;

class AuthController extends Controller {

    public function renderSignUp($request, $response) {
        if ($error = $request->getParam('erro')) {
            switch ($error) {
                case Controller::ERROR_SIGNUP:
                    $toastParams = Controller::ERROR_SIGNUP_PARAMS;
                    break;
                default:
                    $toastParams = Controller::ERROR_UNDEFINED_PARAMS;
            }

            $html['toast'] = Controller::renderToast($toastParams);
        } else {
            $html['toast'] = '';
        }

        return $this->container->view->render($response, 'auth/signup.phtml', ['response' => $html]);
    }

    public function signUp($request, $response) {
    
        if ( ( new AuthExecuter($this->container) )->signUp($request) ) {
            return $response->withRedirect('signin?erro=' . Controller::SUCCESS_SIGNUP);
        } else {
            return $response->withRedirect('signup?erro=' . Controller::ERROR_SIGNUP);
        }

        return $response->withRedirect('signup?erro=' . Controller::ERROR_SIGNUP);
    }

    public function renderSignIn($request, $response) {

        if ($error = $request->getParam('erro')) {
            switch ($error) {
                case Controller::ERROR_SIGNIN:
                    $toastParams = Controller::ERROR_SIGNIN_PARAMS;
                    break;
                case Controller::ERROR_NOTSIGNIN:
                    $toastParams = Controller::ERROR_NOTSIGNIN_PARAMS;
                    break;
                case Controller::SUCCESS_SIGNUP:
                    $toastParams = Controller::SUCCESS_SIGNUP_PARAMS;
                    break;
                case Controller::SUCCESS_LOGOUT:
                    $toastParams = Controller::SUCCESS_LOGOUT_PARAMS;
                    break;
                default:
                    $toastParams = Controller::ERROR_UNDEFINED_PARAMS;
            }

            $html['toast'] = Controller::renderToast($toastParams);
        } else {
            $html['toast'] = '';
        }

        return $this->container->view->render($response, 'auth/signin.phtml', ['response' => $html]);
    }

    public function signIn($request, $response) {
        
        if (( new AuthExecuter($this->container) )->signIn($request)) {
            return $response->withRedirect('../home/calendar?erro=' . Controller::SUCCESS_SIGNIN);
        } else {
            return $response->withRedirect('signin?erro=' . Controller::ERROR_SIGNIN);
        }

        return $response->withRedirect('signin?erro=' . Controller::ERROR_SIGNIN);
    }

    public function logOut($request, $response) {
        session_destroy();
        return $response->withRedirect('../auth/signin?erro=' . Controller::SUCCESS_LOGOUT);
    }
}