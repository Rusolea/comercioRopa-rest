<?php
    require_once 'config.php';
    require_once 'libs/router.php';

    require_once 'app/controllers/task.api.controller.php';

    //crea el router
    $router = new Router();

    #                 endpoint      verbo     controller           método
    //define la tabla de ruteo
    $router->addRoute('tareas',     'GET',    'TaskApiController', 'get'   );
    $router->addRoute('tareas',     'POST',   'TaskApiController', 'create');
    $router->addRoute('tareas/:ID', 'GET',    'TaskApiController', 'get'   );
    $router->addRoute('tareas/:ID', 'PUT',    'TaskApiController', 'update');
    $router->addRoute('tareas/:ID', 'DELETE', 'TaskApiController', 'delete');
    
    $router->addRoute('tareas/:ID/:subrecurso', 'GET',    'TaskApiController', 'get'   );
    
    //rutea
    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
