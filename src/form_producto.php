<?php
session_start();
require_once __DIR__ . '/../settings/database.php';
include('menu_admin.php');

$mensaje = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria = $_POST['categoria'];
    $visible = isset($_POST['visible']) ? 'true' : 'false';
    $imagen = '';
if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0){
    $nombre_archivo = time() . "_" . $_FILES['imagen']['name'];
    move_uploaded_file($_FILES['imagen']['tmp_name'], "../uploads/" . $nombre_archivo);
    $imagen = "uploads/" . $nombre_archivo;
}


    $sku = 'ROP-' . time();
$sql = "INSERT INTO productos (sku, nombre, descripcion, precio, stock, categoria, imagen, visible) VALUES ('$sku', '$nombre', '$descripcion', $precio, $stock, '$categoria', '$imagen', $visible)";
    $res = pg_query($local_conn, $sql);
    if ($res) {
        header('Location: productos.php');
        exit;
    } else {
        $mensaje = "Error al guardar";
    }
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Nuevo producto</title></head>
<body>
<h2>+ Nuevo producto</h2>
<p><?= $mensaje ?></p>
<form method="POST" enctype="multipart/form-data">
  <label>Nombre:</label><br>
  <input type="text" name="nombre" required><br><br>
  <label>Descripción:</label><br>
  <textarea name="descripcion"></textarea><br><br>
  <label>Precio:</label><br>
  <input type="number" step="0.01" name="precio" required><br><br>
  <label>Stock:</label><br>
  <input type="number" name="stock" required><br><br>
  <label>Categoría:</label><br>
  <input type="text" name="categoria"><br><br>
  <label>Imagen (link):</label><br>
  <input type="file" name="imagen"><br><br>
  <label><input type="checkbox" name="visible" checked> Visible</label><br><br>
  <button type="submit">Guardar</button>
  <a href="productos.php">Cancelar</a>
</form>
</body>
</html>