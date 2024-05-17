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

                $sql = "SELECT 
                            u.name, 
                            u.email, 
                            u.icon, 
                            (SELECT COUNT(t.id_task) 
                            FROM task t 
                            WHERE t.ref_id_user = u.id_user) AS tasks, 
                            (SELECT COUNT(tt.id_type_task) 
                            FROM type_task tt 
                            WHERE tt.ref_id_user = u.id_user) AS cats
                        FROM 
                            user u
                        WHERE 
                            u.id_user = " . $_SESSION['user']; 

                $result = $this->container->db->prepare($sql);

                if ($result->execute()) {

                    $res = $result->fetchAll();

                    foreach ($res as $row) {
                        $json['user'] = [
                            'name' => $row['name'],
                            'email' => $row['email'],
                            'icon' => $row['icon'],
                            'tasks' => $row['tasks'],
                            'categories' => $row['cats']
                        ];
                    }

                    $sql = "SELECT id_icon, class
                            FROM icon";

                    $result = $this->container->db->prepare($sql);
                    
                    if ($result->execute()) {

                        $res = $result->fetchAll();

                        $json['icon'] = array();

                        foreach ($res as $row) {
                            
                            $json['icon'][] = [
                                'id' => $row['id_icon'],
                                'class' => $row['class']
                            ];
                        }
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
        $json = HomeController::renderSideBar();

        $sql = "SELECT t.id_task as id, t.name as task, tt.id_type_task as id_type, tt.name as type, i.class as icon, t.until
                    FROM task t
                    INNER JOIN type_task tt
                    ON t.ref_id_type = tt.id_type_task
                    INNER JOIN icon i
                    ON t.ref_id_icon = i.id_icon
                    WHERE t.ref_id_user = ". $_SESSION['user'] . 
                    " ORDER BY until";

        $result = $this->container->db->prepare($sql);

        if ($result->execute()) {

            $res = $result->fetchAll();

            $json['calendar'] = array();
            
            foreach ($res as $row) {
                $json['calendar'][] = [
                    'category' => $row['id_type'],
                    'name_category' => $row['type'],
                    'id' => $row['id'],
                    'name' => $row['task'],
                    'deadline' => $row['until'],
                    'icon' => $row['icon']
                ];
            }

            return $this->container->view->render($response, 'calendar.phtml', ['response' => $json]);
        }

        return false;
        
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
        $deadline = $request->getParam('until');
        $icon = $request->getParam('icon');

        $sql = "INSERT INTO task (name, description, ref_id_type, until, ref_id_user, ref_id_icon)
                VALUES ('$title', '$desc', '$category', '$deadline', ". $_SESSION['user'] .", $icon)";

        $result = $this->container->db->prepare($sql);

        if ($result->execute()) {
            return $response->withRedirect('task');
        }

        echo 'error';
        return false;
    }

    public function createCategory($request, $response) {
        
        $title = $request->getParam('title');

        $sql = "INSERT INTO type_task (name, ref_id_user)
                VALUES ('$title', '". $_SESSION['user'] ."')";

        $result = $this->container->db->prepare($sql);

        if ($result->execute()) {
            return $response->withRedirect('../calendar');
        }

        echo 'error';
        return false;
    }

    public function renderInfo($request, $response, $args) {
        
        $sql = "SELECT t.id_task as id, t.name as task, t.description as description, tt.id_type_task as id_type, tt.name as type, t.until as deadline
                FROM task t
                INNER JOIN type_task tt
                ON t.ref_id_type = tt.id_type_task
                INNER JOIN icon i
                ON t.ref_id_icon = i.id_icon
                WHERE t.id_task = " . $args['id'];

        $result = $this->container->db->prepare($sql);

        if ($result->execute()) {

            $res = $result->fetchAll();
            
            foreach ($res as $row) {
                $json['task'] = [
                    'category' => $row['id_type'],
                    'name_category' => $row['type'],
                    'id' => $row['id'],
                    'name' => $row['task'],
                    'desc' => $row['description'],
                    'deadline' => $row['deadline']
                ];
            }
        }

        return $this->container->view->render($response, 'info.phtml', ['response' => $json]);
    }
    
    public function renderEdit($request, $response, $args) {
        
        $sql = "SELECT t.id_task as id, t.name as task, t.description as description, tt.id_type_task as id_type, tt.name as type, t.until as deadline, t.ref_id_icon as icon
        FROM task t
        INNER JOIN type_task tt
        ON t.ref_id_type = tt.id_type_task
        INNER JOIN icon i
        ON t.ref_id_icon = i.id_icon
        WHERE t.id_task = " . $args['id'];

        $result = $this->container->db->prepare($sql);

        if ($result->execute()) {

            $res = $result->fetchAll();
            
            foreach ($res as $row) {
                $json['task'] = [
                    'category' => $row['id_type'],
                    'name_category' => $row['type'],
                    'id' => $row['id'],
                    'name' => $row['task'],
                    'desc' => $row['description'],
                    'deadline' => $row['deadline'],
                    'icon' => $row['icon']
                ];
            }

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

                $sql = "SELECT id_icon, class
                            FROM icon";

                $result = $this->container->db->prepare($sql);
                
                if ($result->execute()) {

                    $res = $result->fetchAll();

                    $json['icon'] = array();

                    foreach ($res as $row) {
                        
                        $json['icon'][] = [
                            'id' => $row['id_icon'],
                            'class' => $row['class']
                        ];
                    }

                    return $this->container->view->render($response, 'edit.phtml', ['response' => $json]);
                }
            }
        }

        return false;
        
    }

    public function edit($request, $response, $args) {

        $title = $request->getParam('title');
        $desc = $request->getParam('desc');
        $category = $request->getParam('category');
        $deadline = $request->getParam('until');
        $icon = $request->getParam('icon');

        $sql = "UPDATE task
                SET name = '$title', ref_id_type = $category, description = '$desc', until = '$deadline', ref_id_icon = '$icon'
                WHERE id_task = " . $args['id'];
        $result = $this->container->db->prepare($sql);

        if ($result->execute()) {
            return $response->withRedirect('info/' . $args['id']);
        }

        echo 'error';
        return false;
        
    }

    public function renderProfile($request, $response) {
        return $this->container->view->render($response, 'profile.phtml', ['response' => HomeController::renderSideBar()]);
    }
}