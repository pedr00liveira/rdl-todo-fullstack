<?php

namespace App\Controllers;

use App\Executers\HomeExecuter;

class HomeController extends Controller {

    public function renderSideBar($payload, $home) {

        $html = '';
        
        $count = 0;

        $html = $html . '
        <ul id="sidebarnav">

        <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span role="button" id="hide-show-category" class="user-select-none hide-menu">Categories <i class="ti ti-arrow-down ms-1"></i></span>
        </li>

        <li class="category-item sidebar-item">
            <a class="sidebar-link" href="'. $home .'new/category" aria-expanded="false">
                <span class="ps-1">
                    <i class="ti ti-plus"></i>
                </span>
                <span class="hide-menu user-select-none">New category</span>
            </a>
        </li>';

        $count = 0;

        if (!$payload['category']) {
            $html = $html . '
            <li class="category-item list-group-item border-0 p-0 mt-2">
                <span class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1">
                No categories yet
                </span>
            </li>';
        }

        foreach ($payload['category'] as $row) {

            if ($count == 0) {
                $text = 'primary';
                $count = $count + 1;
            } else if ($count == 1) {
                $text = 'warning';
                $count = $count + 1;
            } else {
                $text = 'secondary';
                $count = 0;
            }

            $html = $html . '
            <li class="category-item list-group-item border-0 p-0">
                <div class="d-flex justify-contents-between align-items-center">
                    <span class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1">
                    <i class="ti ti-bookmark fs-5 text-'. $text .'"></i>'. $row['name'] .'
                    </span>
                    <a href="'. $home .'delete/category/'. $row['id'] .'"><i class="ti ti-trash nav-small-cap-icon fs-4"></i></a>
                </div>
            </li>';

        }

        $html = $html . '
        <script>
            var hide = true;

            console.log("teste");

            document.getElementById("hide-show-category").addEventListener(\'click\', function() {

                var elements = document.getElementsByClassName("category-item");
                var names = "";
                for(var i = 0; i < elements.length; i++) {
                    elements[i].classList.toggle("d-none");
                }

                
                if (hide) {
                    this.innerHTML = "Categories <i class=\'ti ti-arrow-up ms-1\'></i>";
                    hide = false;
                } else {
                    this.innerHTML = "Categories <i class=\'ti ti-arrow-down ms-1\'></i>";
                    hide = true;
                }
            });
        </script>

        <li class="border-bottom my-3"></li>';
    
        $actual = 0;

        if (!$payload['task']) {
            $html = $html . '
            <li class="list-group-item border-0 p-0 mt-2">
                <span class="d-flex align-items-center gap-6 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1">
                No tasks yet
                </span>
            </li>';
        }

        foreach ($payload['task'] as $row) {

            if ($row['category'] != $actual) {
                $html = $html . '
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">'. $row['name_category'] .'</span>
                </li>';
                $actual = $row['category'];
            }

            $html = $html . '
            <li class="sidebar-item">
                <a class="sidebar-link ' . ( $row['done'] == 0 ? '' : 'opacity-25') . '" href="'. $home .'info/'. $row['id'] .'" aria-expanded="false">
                    <span>
                        <i class="' . ( $row['done'] == 0 ? $row['icon'] : 'ti ti-check') . '"></i>
                    </span>
                    <span class="hide-menu">'. $row['name'] .'</span>
                </a>
            </li>';
        }

        $html = $html . '
        </ul>
        <div class="position-sticky pb-1 pt-1 bg-white bottom-0 start-0">
            <div class="p-4 mb-5 mt-3 bg-secondary-subtle rounded ">
                <div class="hstack gap-3">
                    <a href="'. $home .'profile" class="john-img">
                        <img src="../../../../../resources/views/assets/images/profile/'. $payload['user']['icon'] .'" class="rounded-circle" width="40" height="40" alt="modernize-img">
                    </a>
                    <div class="john-title">
                        <h6 class="mb-0 fs-4 fw-semibold">'. $payload['user']['name'] .'</h6>
                    </div>
                    <a href="'. $home .'logout" class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="button" aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
                        <i class="ti ti-power fs-6"></i>
                    </a>
                </div>
            </div>
        </div>';

        return $html;

    }

    public function redirectCalendar($request, $response) {
        return $response->withRedirect('home/calendar');
    }

    public function redirectCreate($request, $response) {
        return $response->withRedirect('new/task');
    }

    public function renderCalendar($request, $response) {

        $payload = ( new HomeExecuter($this->container) )->renderCalendar();

        $html['sidebar'] = HomeController::renderSideBar($payload, "./");
        $html['main'] = '';

        $month = date("m");
        $day = date("d");

        switch ($month) {
            case 1:
            $html['main'] = $html['main'] . 'January';
            break;
            case 2:
            $html['main'] = $html['main'] . 'February';
            break;
            case 3:
            $html['main'] = $html['main'] . 'March';
            break;
            case 4:
            $html['main'] = $html['main'] . 'April';
            break;
            case 5:
            $html['main'] = $html['main'] . 'May';
            break;
            case 6:
            $html['main'] = $html['main'] . 'June';
            break;
            case 7:
            $html['main'] = $html['main'] . 'July';
            break;
            case 8:
            $html['main'] = $html['main'] . 'August';
            break;
            case 9:
            $html['main'] = $html['main'] . 'September';
            break;
            case 10:
            $html['main'] = $html['main'] . 'October';
            break;
            case 11:
            $html['main'] = $html['main'] . 'November';
            break;
            case 12:
            $html['main'] = $html['main'] . 'December';
            break;
        }
        
        $html['main'] = $html['main'] . ' ' . $day;
        
        if (substr($day, -1) == '1') {
            $html['main'] = $html['main'] . 'st';
        } else if (substr($day, -1) == '2') {
            $html['main'] = $html['main'] . 'nd';
        } else if (substr($day, -1) == '3') {
            $html['main'] = $html['main'] . 'rd';
        } else {
            $html['main'] = $html['main'] . 'th';  
        }

        $html['main'] = $html['main'] . '</b></h2>
        </div>';

        foreach ($payload['calendar'] as $row) {

            $days = round((strtotime($row['deadline']) - time()) / (60 * 60 * 24));

            if ($days < 7) {
              $text = 'danger';
            } else {
              $text = 'secondary';
            } 

            $html['main'] = $html['main'] . '
            <div class="alert alert-'. $text .'" role="alert">
                <div class="d-flex justify-content-between align-items-center">
                <div><b>'. $row['name_category'] .'</b> / '. $row['name'] .' </div>
                <div>
                    <b class="me-4"> '.  ( $days == 0  ? 'Due today' : ( $days >= 0  ? 'Due in ' . $days+1 . ' days' : "Deadline has passed" ) ) .' </b>
                    <a class="btn btn-'. ( $text == 'danger' ? $text : 'light') .'" href="./info/' . $row['id'] . '">
                        Details
                    </a>
                    <a class="btn btn-transparent" href="./delete/task/' . $row['id'] . '">
                        <i class="ti ti-trash"></i>
                    </a>
                </div>
                </div>
            </div>';
            
          }
        
        return $this->container->view->render($response, 'calendar.phtml', ['response' => $html]);
        
    }

    public function renderCreateTask($request, $response) {
        
        $payload = ( new HomeExecuter($this->container) )->renderCalendar();
        
        $html['sidebar'] = HomeController::renderSideBar($payload, "../");
        $html['categories'] = '';
        $html['icon'] = '';

        foreach ($payload['category'] as $row) {
            $html['categories'] = $html['categories'] . '
            <li>
            <a role="button" id="item'. $row['id'] .'" class="dropdown-item">
                '. $row['name'] .'
            </a>
            </li>
            
            <script>
            document.getElementById("item'. $row['id'] .'").addEventListener("click", 
                function() {
                document.getElementById("dropdownMenuButton1").innerHTML = "'. $row['name'] .'";
                document.getElementById("categoryValue").value = '. $row['id'] .';
                }
            );
            </script>';
        }

        foreach ($payload['icon'] as $row) {
            $html['icon'] = $html['icon'] . '
            <button id="icon'. $row['id'] .'" type="button" class="form-control col m-2 pt-2 pb-2 ps-3 pe-3">
                <i class="'. $row['class'] .'"></i>
            </button>
            
            <script>
              document.getElementById("icon'. $row['id'] .'").addEventListener("click", 
                function() {
                  document.getElementById("icon'. $row['id'] .'").classList.add("bg-dark");
                  document.getElementById("icon'. $row['id'] .'").classList.add("bg-opacity-10");
                  
                  actual = document.getElementById("iconValue").value
                  document.getElementById("iconValue").value = '. $row['id'] .';

                  document.getElementById("icon" + actual).classList.remove("bg-dark");
                  document.getElementById("icon" + actual).classList.remove("bg-opacity-10");
                }
              );
            </script>';
        }

        return $this->container->view->render($response, 'create.phtml', ['response' => $html]);
    }

    public function renderCreateCategory($request, $response) {

        $html['sidebar'] = HomeController::renderSideBar(
            ( new HomeExecuter($this->container) )->renderSideBar(),
            "../"
        );

        return $this->container->view->render($response, 'create-category.phtml', ['response' => $html]);
    }

    public function createTask($request, $response) {
        
        if (( new HomeExecuter($this->container) )->createTask($request)) {
            return $response->withRedirect('task');
        }

        echo 'error';
        return false;
    }

    public function createCategory($request, $response) {
        
        if (( new HomeExecuter($this->container) )->createCategory($request)) {
            return $response->withRedirect('../calendar');
        }

        echo 'error';
        return false;
    }

    public function renderInfo($request, $response, $args) {
        
        $html['sidebar'] = HomeController::renderSideBar(
            (new HomeExecuter($this->container))->renderSideBar(),
            "../"
        );

        $payload = (new HomeExecuter($this->container))->renderInfo($args);

        $html['main'] = '
        <div class="card m-5 p-5">
        <h1 class="display-1">' . $payload['task']['name'] . '</h1>
        <h3 class="p-2 ps-0 text-danger">' . $payload['task']['deadline'] . '</h3>
        <p class="w-100 lead mb-5">' . $payload['task']['desc'] . '</p>

        <div class="d-flex mt-4">
          <span class="badge rounded-pill text-bg-light p-3 position-relative">
            ' . $payload['task']['name_category'] . '
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">
              Category
            </span>
          </span>
          <span class="badge rounded-pill text-bg-light p-3 position-relative ms-5">
            ' . $payload['task']['deadline'] . '
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark">
              Deadline
            </span>
          </span>
        </div>
        
        <div class="mt-5">
          '. ( $payload['task']['done'] == 0 ? '<a type="button" class="btn btn-primary" href="../mark-as-done/' . $payload['task']['id'] . '">Mark as done</a>' : '' ) .'
          <a type="button" class="btn btn-success ms-2" href="../edit/' . $payload['task']['id'] . '">Edit</a>
          <a type="button" class="btn btn-danger ms-2" href="./../delete/task/' . $payload['task']['id'] . '">Delete</a>
          <a type="button" class="btn btn-dark ms-2" href="./../../home">Close</a>
        </div>';
 
        return $this->container->view->render($response, 'info.phtml', ['response' => $html]);
    }
    
    public function renderEdit($request, $response, $args) {
        
        $html['sidebar'] = HomeController::renderSideBar(
            (new HomeExecuter($this->container))->renderSideBar(),
            "../"
        );
        $html['main'] = '';

        $payload = (new HomeExecuter($this->container))->renderEdit($args);

        $html['main'] = $html['main'] . '
        <form class="w-100 p-4" method="post" action="../edit/' . $payload['task']['id'] . '">
            <div class="mb-4">
              <label for="exampleInputEmail1" class="form-label">Title</label>
              <input name="title" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="' . $payload['task']['name'] . '">
            </div>
            <div class="mb-4">
              <label for="exampleInputPassword1" class="form-label">Description</label>
              <textarea rows="6" name="desc" class="form-control" id="exampleInputPassword1">' . $payload['task']['desc'] . '</textarea>
            </div>
            <div class="d-flex">
              <div class="mb-4">
                <label for="dropdownMenuButton" class="form-label">Category</label>
                <div class="dropdown">
                  <button class="form-control dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    ' . $payload['task']['name_category'] . '
                  </button>
                  <input type="hidden" name="category" value="' . $payload['task']['category'] . '" id="categoryValue">
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">';
    
        foreach ($payload['category'] as $row) {
            $html['main'] = $html['main'] . '
            <li>
            <a role="button" id="item'. $row['id'] .'" class="dropdown-item">
                '. $row['name'] .'
            </a>
            </li>
            
            <script>
            document.getElementById("item'. $row['id'] .'").addEventListener("click", 
                function() {
                document.getElementById("dropdownMenuButton1").innerHTML = "'. $row['name'] .'";
                document.getElementById("categoryValue").value = '. $row['id'] .';
                }
            );
            </script>';
        }
                      
        $html['main'] = $html['main'] . '
                </ul>
            </div>
        </div>
            <div class="mb-4 ms-4">
                <label for="exampleInputEmail1" name="deadline" class="form-label">Deadline</label>
                <input type="date" name="until" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="' . $payload['task']['deadline'] . '" required>
                </div>
            </div>
            <div class="d-flex">
                <div class="mb-4">
                <label for="dropdownMenuButton" class="form-label">Icon</label>
                <input type="hidden" name="icon" value="' . $payload['task']['icon'] . '" id="iconValue">
                    <div class="row w-75">';

        foreach ($payload['icon'] as $row) {
            $html['main'] = $html['main'] .  '
            <button id="icon'. $row['id'] .'" type="button" class="form-control col m-2 pt-2 pb-2 ps-3 pe-3">
                <i class="'. $row['class'] .'"></i>
            </button>
            
            <script>
            document.getElementById("icon'. $row['id'] .'").addEventListener("click", 
                function() {
                document.getElementById("icon'. $row['id'] .'").classList.add("bg-dark");
                document.getElementById("icon'. $row['id'] .'").classList.add("bg-opacity-10");
                
                actual = document.getElementById("iconValue").value
                document.getElementById("iconValue").value = '. $row['id'] .';

                document.getElementById("icon" + actual).classList.remove("bg-dark");
                document.getElementById("icon" + actual).classList.remove("bg-opacity-10");
                }
            );\
            </script>';

            if ($payload['task']['icon'] == $row['id']) {
                $html['main'] = $html['main'] .  '
                <script>
                    document.getElementById("icon'. $row['id'] .'").classList.add("bg-dark");
                    document.getElementById("icon'. $row['id'] .'").classList.add("bg-opacity-10");
                </script> ';
            }
        }

        $html['main'] = $html['main'] . '
               </div>
              </div>
            </div>
            <button type="submit" class="btn btn-success">Edit</button>
            <a type="button" class="btn btn-danger ms-2" href="./../home">Close</a>
        </form>';

        return $this->container->view->render($response, 'edit.phtml', ['response' => $html]);
    }

    public function edit($request, $response, $args) {

        if (( new HomeExecuter($this->container) )->edit($request, $args)) {
            return $response->withRedirect('info/' . $args['id']);
        }

        echo 'error';
        return false;
        
    }

    public function renderProfile($request, $response) {

        $payload = ( new HomeExecuter($this->container) )->renderSideBar();
        $html['sidebar'] = HomeController::renderSideBar(
            $payload,
            "./"
        );

        $html['main'] = '';

        $html['main'] = $html['main'] . '
        <div class="row align-items-center mb-5">
            <div class="col-lg-4 order-lg-1 order-2">
            <div class="d-flex align-items-center justify-content-around m-4">
                <div class="text-center">
                <i class="ti ti-check fs-6 d-block mb-2"></i>
                <h4 class="mb-0 lh-1">' . $payload['user']['tasks'] . '</h4>
                <p class="mb-0 ">Tasks</p>
                </div>
                <div class="text-center">
                <i class="ti ti-bookmark fs-6 d-block mb-2"></i>
                <h4 class="mb-0 lh-1">' . $payload['user']['categories'] . '</h4>
                <p class="mb-0 ">Categories</p>
                </div>
            </div>
            </div>
            <div class="col-lg-4 mt-n3 order-lg-2 order-1">
            <div class="mt-n5">
                <div class="d-flex align-items-center justify-content-center mb-2">
                <div class="d-flex align-items-center justify-content-center round-110">
                    <img draggable="false" src="../../../../../resources/views/assets/images/profile/' . $payload['user']['icon'] . '" alt="modernize-img" class="w-50 h-50 rounded-circle overflow-hidden border border-4 border-white">
                </div>
                </div>
                <div class="text-center">
                <h5 class="mb-0">' . $payload['user']['name'] . '</h5>
                </div>
            </div>
            </div>
            <div class="col-lg-4 order-last text-center">
            <ul class="list-unstyled d-flex align-items-center justify-content-center my-3 mx-4 pe-xxl-4 gap-3">
                <li class="text-center">
                    <i class="ti ti-mail"></i>
                    <h4 class="mb-2 lh-1">' . $payload['user']['email'] . '</h4>
                    <p class="mb-0 ">Email</p>
                </li>
            </ul>
            </div>
        </div>';
        
        return $this->container->view->render($response, 'profile.phtml', ['response' => $html]);
    }

    public function deleteTask($request, $response, $args) {
        
        if (( new HomeExecuter($this->container) )->deleteTask($args)) {
            return $response->withRedirect('../../calendar');
        }
        
        echo 'error';
        return false;
    }

    public function deleteCategory($request, $response, $args) {
        
        if (( new HomeExecuter($this->container) )->deleteCategory($args) == 1) {
            return $response->withRedirect('../../calendar');
        }
        
        echo 'error';
        return false;
    }

    public function markDone($request, $response, $args) {
        
        if (( new HomeExecuter($this->container) )->markDone($args) == 1) {
            return $response->withRedirect('../calendar');
        }
        
        echo 'error';
        return false;
    }
}