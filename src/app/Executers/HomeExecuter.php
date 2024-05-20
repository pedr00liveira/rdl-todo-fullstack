<?php

namespace App\Executers;

class HomeExecuter extends Executer {

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

            $sql = "SELECT t.id_task as id, t.name as task, tt.id_type_task as id_type, tt.name as type, i.class as icon, t.done
                    FROM task t
                    INNER JOIN type_task tt
                    ON t.ref_id_type = tt.id_type_task
                    INNER JOIN icon i
                    ON t.ref_id_icon = i.id_icon
                    WHERE t.ref_id_user = ". $_SESSION['user'] . 
                    " ORDER BY ref_id_type, done, until DESC";

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
                        'done' => $row['done'],
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
    
    public function renderCalendar($request) {

        $json = HomeExecuter::renderSideBar();

        $category = 0;
        $done = 0;

        try {
            $category = $request->getParam('category');
            $done = $request->getParam('done');
        } catch (\Exception $e) {
            $done = 0;
        }

        $sql = "SELECT t.id_task as id, t.name as task, tt.id_type_task as id_type, tt.name as type, i.class as icon, t.until, t.done
                    FROM task t
                    INNER JOIN type_task tt
                    ON t.ref_id_type = tt.id_type_task
                    INNER JOIN icon i
                    ON t.ref_id_icon = i.id_icon
                    WHERE t.ref_id_user = ". $_SESSION['user'];

        if ($category != 0) {
            $sql = $sql . " AND t.ref_id_type = " . $category;
        }

        if ($done == 0) {
            $sql = $sql . " AND t.done = 0 ";
        }
        
        $sql = $sql . " ORDER BY done, until";

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
                    'icon' => $row['icon'],
                    'done' => $row['done']
                ];
            }

            if ($category != 0) {

                $sql = "SELECT t.name as name
                        FROM type_task t
                        WHERE t.id_type_task = ". $category;

                $result = $this->container->db->prepare($sql);

                if ($result->execute()) {

                    $res = $result->fetchAll();

                    foreach ($res as $row) {
                        $name_category = $row['name'];
                    }
                }

            } else {

                $name_category = "";
            }

            $json['filter'] = [
                "id_category" => intval($category),
                "category" => $name_category,
                "done" => intval($done)
            ];

            return $json;
        }

        return false;

    }

    public function createTask($request) {
        $title = $request->getParam('title');
        $desc = $request->getParam('desc');
        $category = $request->getParam('category');
        $deadline = $request->getParam('until');
        $icon = $request->getParam('icon');

        $title = str_replace("'", "''", $title);
        $desc = str_replace("'", "''", $desc);

        $sql = "INSERT INTO task (name, description, ref_id_type, until, ref_id_user, ref_id_icon)
                VALUES ('$title', '$desc', $category, '$deadline', ". $_SESSION['user'] .", $icon)";

        $result = $this->container->db->prepare($sql);

        if ($result->execute()) {
            return true;
        } 

        return false;
    }

    public function createCategory($request) {

        $title = $request->getParam('title');

        $title = str_replace("'", "\\'", $title);

        $sql = "INSERT INTO type_task (name, ref_id_user)
                VALUES ('$title', '". $_SESSION['user'] ."')";

        $result = $this->container->db->prepare($sql);

        if ($result->execute()) {
            return true;
        }

        return false;

    }

    public function renderInfo($args) {

        $sql = "SELECT t.id_task as id, t.name as task, t.description as description, tt.id_type_task as id_type, tt.name as type, t.until as deadline, t.done
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
                    'deadline' => date_format(date_create($row['deadline']), "d/m/Y"),
                    'done' => $row['done']
                ];
            }

            return $json;
        }

        return false;
    }

    public function renderEdit($args) {
        
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

                    return $json;
                }
            }
        }

        var_dump("erro");
        return false;
        
    }

    public function edit($request, $args) {

        $title = $request->getParam('title');
        $desc = $request->getParam('desc');
        $category = $request->getParam('category');
        $deadline = $request->getParam('until');
        $icon = $request->getParam('icon');

        $title = str_replace("'", "\\'", $title);
        $desc = str_replace("'", "\\'", $desc);

        $sql = "UPDATE task
                SET name = '$title', ref_id_type = $category, description = '$desc', until = '$deadline', ref_id_icon = '$icon'
                WHERE id_task = " . $args['id'];
        $result = $this->container->db->prepare($sql);

        if ($result->execute()) {
            return true;
        }

    }

    public function deleteTask($args) {

        $sql = "DELETE FROM task
                WHERE id_task = " . $args['id'];
        
        $result = $this->container->db->prepare($sql);

        if ($result->execute()) {
            return true;
        }

        return false;
    }
    
    public function deleteCategory($args) {

        $sql = "SELECT *
                FROM task
                WHERE ref_id_type = " . $args['id'];

        $result = $this->container->db->prepare($sql);

        if ($result->execute()) {
            if ($result->rowCount() > 0) {
                return 0;
            }

            $sql = "DELETE FROM type_task
                WHERE id_type_task = " . $args['id'];
        
            $result = $this->container->db->prepare($sql);

            if ($result->execute()) {
                return 1;
            }

            var_dump("erro");
            return 2;

        }

        var_dump("erro");
        return 2;
        
    }

    public function markDone($args) {

        $sql = "UPDATE task
                SET done = true
                WHERE id_task = " . $args['id'];

        $result = $this->container->db->prepare($sql);

        if ($result->execute()) {
            return true;
        }

        var_dump("erro");
        return false;
        
    }

}