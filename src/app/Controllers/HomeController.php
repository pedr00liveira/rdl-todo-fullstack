<?php

namespace App\Controllers;

use Slim\Views\PhpRenderer as View;

class HomeController extends Controller {

    public function renderSideBar() {
        $sql = "SELECT id_type_task, name
                FROM type_task
                WHERE ref_id_user = ". $_SESSION['user'];

        $result = $this->container->db->prepare($sql);
        
        if ($result->execute()) {

            $res = $result->fetchAll();

            $json['category'] = array();

            foreach ($res as $row) {
                
                $json['category'][] = [
                    'id' => $row['id_type_task'],
                    'name' => $row['name']
                ];
            }

            $sql = "SELECT t.id_task as id, t.name as task, tt.id_type_task as id_type, tt.name as type, i.class as icon
                    FROM task t
                    INNER JOIN type_task tt
                    ON t.ref_id_type = tt.id_type_task
                    INNER JOIN icon i
                    ON t.ref_id_icon = i.id_icon
                    WHERE t.ref_id_user = ". $_SESSION['user'] . 
                    " ORDER BY ref_id_type";

            $result = $this->container->db->prepare($sql);

            if ($result->execute()) {

                $res = $result->fetchAll();

                $json['task'] = array();
                
                foreach ($res as $row) {
                    $json['task'][] = [
                        'category' => $row['id_type'],
                        'name_category' => $row['type'],
                        'id' => $row['id'],
                        'name' => $row['task'],
                        'icon' => $row['icon']
                    ];
                }

                $sql = "SELECT name, email, icon
                        FROM user
                        WHERE id_user = ". $_SESSION['user'];

                $result = $this->container->db->prepare($sql);

                if ($result->execute()) {

                    $res = $result->fetchAll();

                    foreach ($res as $row) {
                        $json['user'] = [
                            'name' => $row['name'],
                            'email' => $row['email'],
                            'icon' => $row['icon']
                        ];
                    }

                    return $json;
                
                }
            }
        }
        
        return false;
                    
    }

    public function redirectCalendar($request, $response) {
        return $response->withRedirect('home/calendar');
    }

    public function redirectCreate($request, $response) {
        return $response->withRedirect('new/task');
    }

    public function renderCalendar($request, $response) {
        return $this->container->view->render($response, 'calendar.phtml', ['response' => HomeController::renderSideBar()]);
    }

    public function renderCreateTask($request, $response) {
        return $this->container->view->render($response, 'create.phtml', ['response' => HomeController::renderSideBar()]);
    }

    public function renderCreateCategory($request, $response) {
        return $this->container->view->render($response, 'create-category.phtml', ['response' => HomeController::renderSideBar()]);
    }

    public function createTask($request, $response) {
        
        $title = $request->getParam('title');
        $desc = $request->getParam('desc');
        $category = $request->getParam('category');

        $sql = "INSERT INTO task (nome, email, pass)
                VALUES ('$title', '$desc', '$category')";

        $result = $this->container->db->prepare($sql);

        if ($result->execute()) {
            return $response->withRedirect('signin');
        }

        echo 'error';
        return false;
    }

    public function createCategory($request, $response) {
        
        $title = $request->getParam('title');
        $desc = $request->getParam('desc');
        $category = $request->getParam('category');

        $sql = "INSERT INTO task (nome, email, pass)
                VALUES ('$title', '$desc', '$category')";

        $result = $this->container->db->prepare($sql);

        if ($result->execute()) {
            return $response->withRedirect('signin');
        }

        echo 'error';
        return false;
    }

    public function renderInfo($request, $response) {
        return $this->container->view->render($response, 'info.html');
    }
    
    public function renderEdit($request, $response) {
        return $this->container->view->render($response, 'edit.html');
    }

    public function edit($request, $response) {
        return $this->container->view->render($response, 'edit.html');
    }
}