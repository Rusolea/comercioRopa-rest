<?php
    require_once 'app/views/api.view.php';
    require_once 'app/models/models.php';

    abstract class ApiController {
        protected $view;
        private $model;

        public function __construct() {
            $this->view = new ApiView();
            $this->model = new Model();
            $this->data = file_get_contents("php://input"); //toma el input de la request
        }

        //convierte el input en un objeto JSON
        function getData() {
            return json_decode($this->data);
        }
    }
?>