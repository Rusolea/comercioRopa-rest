<?php
    require_once 'app/models/product.model.php';
    require_once 'app/controllers/api.controllers.php';

    class ProductApiController extends ApiController {
        private $model;

        public function __construct() {
            parent::__construct();
            $this->model = new ProductModel();
        }

        //controller que devuelve todos los productos y un producto por id
        function get($params = []) {
            if (empty($params)) {
                $campoOrden = isset($_GET['campoOrden']) ? $_GET['campoOrden'] : null;
                $tipoOrden = isset($_GET['tipoOrden']) ? $_GET['tipoOrden'] : null;
    
                //crear un array con los parametros
                $params = [
                    'campoOrden' => $campoOrden,
                    'tipoOrden' => $tipoOrden
                ];
    
                //obtener los productos con los parametros de orden
                $productos = $this->model->getAllProducts($params);
                $this->view->response($productos, 200);
            } else {
                $producto = $this->model->getProduct($params[':ID']); // Cambiar a la función correcta del modelo
                if ($producto) {
                    $this->view->response($producto, 200);
                } else {
                    $this->view->response('El producto con el id=' . $params[':ID'] . ' no existe.', 404);
                }
            }
        }
    

        public function deleteProduct($params = []) {
            var_dump($params);
            $id = $params[':ID'];
            $product = $this->model->getProduct($id);
            var_dump($product);

            if ($product) {
                $this->model->deleteProduct($id);
                $this->view->response("El producto con el id=$id fue eliminado con éxito", 200);
            } else {
                $this->view->response("El producto con el id=$id no existe", 404);
            }
        }

    

        function create($params = []) {
            $body = $this->getData();

            $titulo = $body->titulo;
            $descripcion = $body->descripcion;
            $prioridad = $body->prioridad;

            if (empty($titulo) || empty($prioridad)) {
                $this->view->response("Complete los datos", 400);
            } else {
                $id = $this->model->insertTask($titulo, $descripcion, $prioridad);

                // en una API REST es buena práctica es devolver el recurso creado
                $tarea = $this->model->getTask($id);
                $this->view->response($tarea, 201);
            }
    
        }

        public function createProduct($params = []) {
            $body = $this->getData();
            $nombre = $body->nombre;
            $descripcion = $body->descripcion;
            $precio = $body->precio;
            $id_categoria = $body->id_categoria;

            // Verificamos que los campos no estén vacíos antes de insertar
            if (empty($nombre) || empty($descripcion) || empty($precio) || empty($id_categoria)) {
                $this->view->response("Complete los datos", 400);
                return; // El return debe estar dentro del bloque if
            }
        
            $id = $this->model->insert($nombre, $descripcion, $precio, $id_categoria);
        
            if ($id) { // Corregir la sintaxis del if aquí
                // En una API REST, es buena práctica devolver el recurso creado
                $producto = $this->model->get($id);
                $this->view->response($producto, 201);
            }
            else {
                $this->view->response("El producto no pudo insertarse", 500);
            }
        }
        
        

        public function updateProduct($params = []) {
            $id = $params[':ID'];
            var_dump($id);
            $product = $this->model->getProduct($id);
            var_dump($product);

            if ($product) {
                $body = $this->getData();
                $nombre = $body->nombre;
                $descripcion = $body->descripcion;
                $precio = $body->precio;
                $id_categoria = $body->id_categoria;
                $this->model->update($id, $nombre, $descripcion, $precio, $id_categoria);
                
                $this->view->response("El producto fue actualizado con éxito", 200);
                var_dump($body);
                var_dump($nombre);
                var_dump($descripcion);
                var_dump($precio);
                var_dump($id_categoria);

            } else {
                $this->view->response("El producto con el id=$id no existe", 404);
                var_dump($product);
                var_dump($id);
                var_dump($nombre);
                var_dump($descripcion);
                var_dump($precio);
                var_dump($id_categoria);
            }
        }

        public function getCategories($params = []) {
            $categories = $this->model->getCategories();
            $this->view->response($categories, 200);
        }

        public function getCategory($params = []) {
            $id = $params[':ID'];
            $category = $this->model->getCategory($id);
            if ($category) {
                $this->view->response($category, 200);
            } else {
                $this->view->response("La categoria con el id=$id no existe", 404);
            }
        }

        public function getProductsByCategory($params = []) {
            $id = $params[':ID'];
            $products = $this->model->getProductsByCategory($id);
            if ($products) {
                $this->view->response($products, 200);
            } else {
                $this->view->response("La categoria con el id=$id no existe", 404);
            }
        }

    }
?>     
                    


