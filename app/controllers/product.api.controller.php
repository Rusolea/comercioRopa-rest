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
        public function createProduct ($params = []) {
            $body = $this->getData();
            $nombre = $body->nombre;
            $descripcion = $body->descripcion;
            $precio = $body->precio;
            $id_categoria = $body->id_categoria;
  
            if (empty($nombre) || empty($descripcion) || empty($precio) || empty($id_categoria)) {
                $this->view->response("Complete los datos", 400);
                return; 
            }
            else {
                $this->model->insert($nombre, $descripcion, $precio, $id_categoria);
                $this->view->response("El producto fue insertado con éxito", 200);
            }
            
        }
        

        public function updateProduct($params = []) {
            $id = $params[':ID'];
            $product = $this->model->getProduct($id);

            if ($product) {
                $body = $this->getData();
                $nombre = $body->nombre;
                $descripcion = $body->descripcion;
                $precio = $body->precio;
                $id_categoria = $body->id_categoria;
                $this->model->update($id, $nombre, $descripcion, $precio, $id_categoria);
                
                $this->view->response("El producto fue actualizado con éxito", 200);

            } else {
                $this->view->response("El producto con el id=$id no existe", 404);
            }
        }

        public function getCategories($params = []) {
            $categories = $this->model->getCategorias();
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

        public function createCategory($params = []) {
            $body = $this->getData();
            $nombre_categoria = $body->nombre_categoria;
            if (empty($nombre_categoria)) { 
                $this->view->response("Complete los datos", 400);
            } else {
                $id = $this->model->insertCategory($nombre_categoria);
                $category = $this->model->getCategory($id);
                $this->view->response("La categoria fue insertada con éxito", 200);

            }
        }

        public function deleteCategory($params = []) {
            $id = $params[':ID'];
            $category = $this->model->getCategory($id);
            if ($category) {
                $this->model->deleteCategory($id);
                $this->view->response("La categoria con el id=$id fue eliminada con éxito", 200);
            } else {
                $this->view->response("La categoria con el id=$id no existe", 404);
            }
        }

        public function updateCategory($params = []) {
            $id = $params[':ID'];
            $category = $this->model->getCategory($id);
            if ($category) {
                $body = $this->getData();
                $nombre_categoria = $body->nombre_categoria;
                $this->model->updateCategory($id, $nombre_categoria);
                $this->view->response("La categoria fue actualizada con éxito", 200);
            } else {
                $this->view->response("La categoria con el id=$id no existe", 404);
            }
        }
        

    }
?>     
                    


