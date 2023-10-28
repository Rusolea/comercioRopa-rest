<?php
    require_once 'app/models/task.model.php';
    require_once 'app/controllers/api.controller.php';

    class TaskApiController extends ApiController {
        private $model;

        public function __construct() {
            parent::__construct();
            $this->model = new TaskModel();
        }

        public function get($params = []) {
            if (empty($params)) {
                $tasks = $this->model->getAll();
                $this->view->response($tasks, 200);
            } else {
                $id = $params[':ID'];
                $task = $this->model->get($id);
                if (!empty($task)) {
                    if($params['.sobrecurso']){
                        switch ($params['.sobrecurso']) {
                            case 'titulo':
                                $this->view->response($task->titulo, 200);
                                break;
                            case 'descripcion':
                                $this->view->response($task->descripcion, 200);
                                break;

                            default:                            
                            $this->view->response(                                
                                'La tarea no contiene '.$params[':subrecurso'].'.'                                
                                , 404);                                
                                break;                        
                            }                    
                        } else                        
                        $this->view->response($tarea, 200);                
                    } else {                    
                        $this->view->response(                        
                            'La tarea con el id='.$params[':ID'].' no existe.'                        
                            , 404);
                    }
                }
            }

                    

        public function create($params = []) {
            $body = $this->getData();
            
            $titulo = $body->titulo;
            $descripcion = $body->descripcion;
            $prioridad = $body->prioridad;

            if (empty($titulo) || empty($descripcion) || empty($prioridad)) {
                $this->view->response("Faltan datos obligatorios", 400);
                
            }else{
                else {
                    $id = $this->model->insertTask($titulo, $descripcion, $prioridad);
    
                    // en una API REST es buena práctica es devolver el recurso creado
                    $tarea = $this->model->getTask($id);
                    $this->view->response($tarea, 201);
                }
        
            }
    


        public function delete($params = []) {
            $id = $params[':ID'];
            $task = $this->model->get($id);
            if ($task) {
                $this->model->delete($id);
                $this->view->response("La tarea con el id=$id fue eliminada", 200);
            } else {
                $this->view->response("La tarea con el id=$id no existe", 404);
            }
        }

        public function update($params = []) {
            $id = $params[':ID'];
            $task = $this->model->get($id);
            if ($task) {
                $body = $this->getData();
                $this->model->update($id, $body->titulo, $body->descripcion, $body->completada);
                $this->view->response("La tarea con el id=$id
                    fue actualizada", 200); 


            } else {
                $this->view->response("La tarea con el id=$id no existe", 404);
            }
        }

        public function update($params = []) {
            $id = $params[':ID'];
            $tarea = $this->model->getTask($id);

            if($tarea) {
                $body = $this->getData();
                $titulo = $body->titulo;
                $descripcion = $body->descripcion;
                $prioridad = $body->prioridad;
                $this->model->updateTaskData($id, $titulo, $descripcion, $prioridad);

                $this->view->response('La tarea con id='.$id.' ha sido modificada.', 200);
            } else {
                $this->view->response('La tarea con id='.$id.' no existe.', 404);
            }
        }

    }
?>

