<?php
require_once 'config.php';
//de esta clase heredan todos los modelos como product.model.php
    class Model {
        protected $db;
        //constructor
        function __construct() {
            $this->db = new PDO('mysql:host='. MYSQL_HOST .';dbname='. MYSQL_DB .';charset=utf8', MYSQL_USER, MYSQL_PASS);
        }
    }
?>
