<?php

namespace App\Controllers;

class Controller {

    const ERROR_INSTASK = 1;
    const ERROR_INSCAT = 2;
    const ERROR_EDITTASK = 3;
    const ERROR_DELTASK = 4;
    const ERROR_DELCAT = 5;
    const ERROR_MARKDONE = 6;

    const SUCCESS_INSTASK = 7;
    const SUCCESS_INSCAT = 8;
    const SUCCESS_EDITTASK = 9;
    const SUCCESS_DELTASK = 10;
    const SUCCESS_DELCAT = 11;
    const SUCCESS_MARKDONE = 12;

    const ERROR_SIGNIN = 13;
    const ERROR_SIGNUP = 14;
    const ERROR_LOGOUT = 15;
    const SUCCESS_SIGNIN = 16;
    const SUCCESS_SIGNUP = 17;
    const SUCCESS_LOGOUT = 18;
    
    const ERROR_NOTSIGNIN = 19;

    const ERROR_UNDEFINED = 0;

    const ERROR_PARAMS = [
        "bg" => "bg-danger",
        "icon" => "ti-alert-circle",
    ];

    const SUCCESS_PARAMS = [
        "bg" => "bg-success",
        "icon" => "ti-check",
    ];

    const ERROR_INSTASK_PARAMS = [
        "class" => Controller::ERROR_PARAMS,
        "msg" => "Task not created. Check if the form is filled correctly."
    ];
    
    const ERROR_INSCAT_PARAMS = [
        "class" => Controller::ERROR_PARAMS,
        "msg" => "Category not created. Check if the form is filled correctly."
    ];
    
    const ERROR_EDITTASK_PARAMS = [
        "class" => Controller::ERROR_PARAMS,
        "msg" => "Task not updated. Check if the form is filled correctly."
    ];
    
    const ERROR_DELTASK_PARAMS = [
        "class" => Controller::ERROR_PARAMS,
        "msg" => "Task not deleted. Try again later."
    ];
    
    const ERROR_DELCAT_PARAMS = [
        "class" => Controller::ERROR_PARAMS,
        "msg" => "Category not deleted. Check if there's any task linked to it."
    ];
    
    const ERROR_MARKDONE_PARAMS = [
        "class" => Controller::ERROR_PARAMS,
        "msg" => "Not marked as done. Try again later."
    ];
    
    const SUCCESS_INSTASK_PARAMS = [
        "class" => Controller::SUCCESS_PARAMS,
        "msg" => "Task created successfully."
    ];
    
    const SUCCESS_INSCAT_PARAMS = [
        "class" => Controller::SUCCESS_PARAMS,
        "msg" => "Category created successfully."
    ];
    
    const SUCCESS_EDITTASK_PARAMS = [
        "class" => Controller::SUCCESS_PARAMS,
        "msg" => "Task updated successfully."
    ];
    
    const SUCCESS_DELTASK_PARAMS = [
        "class" => Controller::SUCCESS_PARAMS,
        "msg" => "Task deleted successfully."
    ];
    
    const SUCCESS_DELCAT_PARAMS = [
        "class" => Controller::SUCCESS_PARAMS,
        "msg" => "Category deleted successfully."
    ];
    
    const SUCCESS_MARKDONE_PARAMS = [
        "class" => Controller::SUCCESS_PARAMS,
        "msg" => "Marked as done successfully."
    ];
    
    const ERROR_SIGNIN_PARAMS = [
        "class" => Controller::ERROR_PARAMS,
        "msg" => "Incorrect email or password."
    ];
    
    const ERROR_SIGNUP_PARAMS = [
        "class" => Controller::ERROR_PARAMS,
        "msg" => "Not signed up. Email may already exist or form is incorrect filled."
    ];
    
    const ERROR_LOGOUT_PARAMS = [
        "class" => Controller::ERROR_PARAMS,
        "msg" => "Logout error. Try again later."
    ];
    
    const SUCCESS_SIGNIN_PARAMS = [
        "class" => Controller::SUCCESS_PARAMS,
        "msg" => "Signed in. Welcome!"
    ];
    
    const SUCCESS_SIGNUP_PARAMS = [
        "class" => Controller::SUCCESS_PARAMS,
        "msg" => "Account created successfully"
    ];
    
    const SUCCESS_LOGOUT_PARAMS = [
        "class" => Controller::SUCCESS_PARAMS,
        "msg" => "Logout executed successfully."
    ];

    const ERROR_NOTSIGNIN_PARAMS = [
        "class" => Controller::ERROR_PARAMS,
        "msg" => "Not signed in."
    ];    

    const ERROR_UNDEFINED_PARAMS = [
        "class" => Controller::ERROR_PARAMS,
        "msg" => "Undefined error."
    ];

    protected $container;

    public function __construct ($container) {
        $this->container = $container;
    }

    public function renderToast($params) {
        
        $html = '
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 50">
            <div id="liveToast" class="toast '. $params['class']['bg'] .' hide ps-2 pt-2 pb-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body text-white d-flex align-items-center">
                <h2 class="pt-2"><i class="ti '. $params['class']['icon'] .' me-3 text-white"></i></h2>
                <span>'. $params['msg'] .'</span>
            </div>
            </div>
        </div>
        
        <script>
            this.addEventListener("load", function () {
                var toastEl = document.getElementById("liveToast");
                var toast = new bootstrap.Toast(toastEl);
                toast.show();
                url = (window.location.href).split("/");
                window.history.replaceState({}, "", url[url.length - 1].split("?")[0]);
            });
        </script>';
        
        return $html;
    }
    
}