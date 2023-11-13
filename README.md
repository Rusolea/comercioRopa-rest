# comercioRopa-rest
Consigna para la Tercera Entrega

Para la tercera entrega, el objetivo es extender la funcionalidad del proyecto original agregando una API REST pública. Esta API permitirá la integración con otros sistemas y se alojará en un nuevo repositorio. El único elemento compartido con el trabajo anterior será la base de datos.

Funcionalidades de la API
Listar productos/categorías
Obtener detalles de un producto/categoría específico
Agregar nuevos productos/categorías
Actualizar productos/categorías
Eliminar productos/categorías

Endpoints para Productos
Listar Todos los Productos
GET http://localhost/TPEWEB2-ApiRest/comercioRopa-rest/api/products
Devuelve una lista de todos los productos.

Obtener Detalles de un Producto Específico
GET http://localhost/TPEWEB2-ApiRest/comercioRopa-rest/api/products/:ID
Reemplazar :ID con el ID del producto para obtener sus detalles.
Ejemplo: http://localhost/TPEWEB2-ApiRest/comercioRopa-rest/api/products/1

Agregar un Nuevo Producto
POST http://localhost/TPEWEB2-ApiRest/comercioRopa-rest/api/products
Envía un objeto JSON con los detalles del nuevo producto en el cuerpo de la petición.
{
  "nombre": "Zapatillas Flecha",
  "descripcion": "Calzado deportivo",
  "precio": 1000,
  "id_categoria": 1
}

Actualizar un Producto
PUT http://localhost/TPEWEB2-ApiRest/comercioRopa-rest/api/products/:ID
Reemplazar :ID con el ID del producto que deseas actualizar y envía los detalles actualizados en el cuerpo de la petición.
{
  "nombre": "Zapatillas Flecha Premium",
  "descripcion": "Calzado deportivo premium",
  "precio": 2000,
  "id_categoria": 1
}

Eliminar un Producto
DELETE http://localhost/TPEWEB2-ApiRest/comercioRopa-rest/api/products/:ID
Reemplazar :ID con el ID del producto que deseas eliminar.


El servicio que lista una colección entera debe poder ordenarse opcionalmente por al menos un campo de la tabla, de manera ascendente o descendente.
http://localhost/TPEWEB2-ApiRest/comercioRopa-rest/api/products?campoOrden=precio&tipoOrden=ASC