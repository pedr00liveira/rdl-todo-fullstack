<?php

namespace App\Executers\Auth;

use App\Executers\Executer;

class AuthExecuter extends Executer {

    public function signUp($request) {
        
        $count = 0;

        $name = $request->getParam('name');
        $email = $request->getParam('email');
        $pass = $request->getParam('password');
        $icon = $request->getParam('user_icon');

        $name = str_replace("'", "\\'", $name);
        $email = str_replace("'", "\\'", $email);
        $pass = str_replace("'", "\\'", $pass);

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

            $sql = "INSERT INTO user (name, email, pass, icon)
                    VALUES ('$name', '$email', '$pass', '$icon')";

            $result = $this->container->db->prepare($sql);

            if ($result->execute()) {
                return true;
            }

        } else {
            return false;
        }
        
        return false;
    }

    public function signIn($request) {
        
        $email = $request->getParam('email');
        $pass = $request->getParam('password');

        $email = str_replace("'", "\\'", $email);
        $pass = str_replace("'", "\\'", $pass);

        $sql = "SELECT id_user 
                FROM user
                WHERE email = '$email' 
                AND pass = '$pass'";

        $result = $this->container->db->prepare($sql);

        if ($result->execute()) {

            if ($result->rowCount() > 0) {
                $_SESSION['user'] = $result->fetchColumn();
                return true;
            }
        }

        return false;
    }
    
}