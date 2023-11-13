<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Aquí puedes incluir tus archivos PHP y realizar pruebas
require_once 'app/models/product.model.php';
require_once 'app/controllers/product.api.controller.php';
var_dump($_GET);
//insertar un producto
/$nombre = 'Remera';
$descripcion = 'Remera de algodon';
$precio = 1000;
$id_categoria = 1;
$model = new ProductModel();
$model->insertProduct($nombre, $descripcion, $precio, $id_categoria);
//mensaje para saber si se inserto
echo "Se inserto el producto";





// Instancia del controlador para pruebas
$controller = new ProductApiController();
$controller->get() // Deberías ver la salida de var_dump() si se llega a ejecutar este método
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Funciona</h1>
    
    
</body>
</html>
