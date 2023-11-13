<?php
    require_once 'config.php';
    require_once 'libs/router.php';

    require_once 'app/controllers/product.api.controller.php';

    //crea el router instancia de la clase routerß
    $router = new Router();

    #                 endpoint      verbo     controller           método
    //define la tabla de ruteo
    $router->addRoute('products',     'GET',    'productApiController', 'get'   );
    $router->addRoute('products/:ID', 'GET',    'productApiController', 'get'   );
    $router->addRoute('products',     'POST',   'productApiController', 'createProduct');
    $router->addRoute('products/:ID', 'DELETE', 'productApiController', 'deleteProduct');
    $router->addRoute('products/:ID', 'PUT',    'productApiController', 'updateProduct');

    $router->addRoute('categorias',     'GET',    'productApiController', 'getCategorias'   );
    $router->addRoute('categorias/:ID', 'GET',    'productApiController', 'getCategoria'   );

    //rutea
    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']); //le pasamos el htaacces con el resource y el metodo
    //$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
