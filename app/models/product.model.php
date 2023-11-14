<?php
//esta clase hereda de model.php que contiene la conexion a la base de datos y el constructor
    require_once 'app/models/models.php';
    


class ProductModel extends Model {  
    
    function getAllProducts($params = []) {
        var_dump($params);
        // Definir los campos permitidos para ordenar
        $camposOrdenPermitidos = ["id", "nombre", "descripcion", "precio", "id_categoria"]; 
    
        // Definir los tipos de orden permitidos
        $tiposOrdenPermitidos = ["ASC", "DESC"];
    
        // Si no se especifica el orden, se ordena por id ascendente
        $campoOrden = $params['campoOrden'] ?? "id";
        $tipoOrden = $params['tipoOrden'] ?? "ASC";
    
        // Validar que los parámetros sean correctos
        if (!in_array($campoOrden, $camposOrdenPermitidos)) {
            $campoOrden = "id";
        }
    
        if (!in_array($tipoOrden, $tiposOrdenPermitidos)) {
            $tipoOrden = "ASC";
        }
        //En lugar de concatenar directamente los valores de $campoOrden y $tipoOrden en la consulta, 
        //utilizo una estructura switch para construir de manera segura la parte de la cláusula ORDER BY. Esto reduce el riesgo de inyecciones SQL.

        $ordenSql = "ORDER BY ";
        switch ($campoOrden) {
            case "nombre":
                $ordenSql .= "nombre ";
                break;
            case "descripcion":
                $ordenSql .= "descripcion ";
                break;
            case "precio":
                $ordenSql .= "precio ";
                break;
            case "id_categoria":
                $ordenSql .= "id_categoria ";
                break;
            default:
                $ordenSql .= "id ";
                break;
        }
        $ordenSql .= $tipoOrden;
    
        // Preparar y ejecutar la consulta
        $query = $this->db->prepare("SELECT * FROM producto " . $ordenSql);
        $query->execute();
    
        // Obtener los productos
        $products = $query->fetchAll(PDO::FETCH_OBJ);
    
        return $products;
    }
    
    
    
    //obtener un producto por id
    function getProduct($id) {
        $query = $this->db->prepare('SELECT * FROM producto WHERE id = ?');
        $query->execute([$id]);

        // $product es un producto unico seleccionado por id
        $products = $query->fetch(PDO::FETCH_OBJ);

        return $products;
    }

    /**
     * Inserta un producto en la base de datos
     */
    

    function insert($nombre, $descripcion, $precio, $id_categoria) {
        $query = $this->db->prepare('INSERT INTO producto(nombre, descripcion, precio, id_categoria) VALUES(?,?,?,?)');
        $query->execute([$nombre, $descripcion, $precio, $id_categoria]);

        return $this->db->lastInsertId();
    }
    //borrar un producto
    function deleteProduct($id) {
        $query = $this->db->prepare('DELETE FROM producto WHERE id = ?');
        $query->execute([$id]);
    }


   // Actualizar un producto
    function update($id, $nombre, $descripcion, $precio, $id_categoria) {    
    $query = $this->db->prepare('UPDATE producto SET nombre = ?, descripcion = ?, precio = ?, id_categoria = ? WHERE id = ?');
    $query->execute([$nombre, $descripcion, $precio, $id_categoria, $id]);
}

    //obtener todas las categorias
    function getCategorias() {
        $query = $this->db->prepare('SELECT * FROM categoria');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    //obtener una categoria por id
    function getCategory($id) {
        $query = $this->db->prepare('SELECT * FROM categoria WHERE id=?');
        $query->execute(array($id));
        return $query->fetch(PDO::FETCH_OBJ);
    }
    
    function insertCategory($nombre_categoria) {
        $query = $this->db->prepare('INSERT INTO categoria(nombre_categoria) VALUES(?)');
        $query->execute(array($nombre_categoria));
    }

    function deleteCategory($id) {
        $query = $this->db->prepare('DELETE FROM categoria WHERE id=?');
        $query->execute(array($id));
    }

    function updateCategory($id, $nombre_categoria) {
        $query = $this->db->prepare('UPDATE categoria SET nombre_categoria=? WHERE id=?');
        $query->execute(array($nombre_categoria, $id));
    }

    //En el caso de que no exista la tabla, la crea
    private function deploy() {
        $query = $this->db->prepare('CREATE TABLE IF NOT EXISTS categoria(id integer primary key auto_increment, nombre text)');
        $query->execute();
        $query = $this->db->prepare('CREATE TABLE IF NOT EXISTS comercio_ropa(id integer primary key auto_increment, nombre text, descripcion text, precio integer, stock integer, id_categoria integer)');
        $query->execute();
    }
    
}
