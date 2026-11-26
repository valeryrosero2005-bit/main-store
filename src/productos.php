<?php
session_start();
include('../settings/database.php');
include('menu_admin.php');

/*if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin'){
    header('Location: signin.html');
    exit;
}*/

$res = pg_query($local_conn, "SELECT * FROM productos ORDER BY id ASC");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Productos Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Productos - Admin</h3>
    <div>
      <a href="form_producto.php" class="btn btn-dark">+ Nuevo producto</a>
      <a href="catalogo.php" class="btn btn-outline-dark">Ver tienda</a>
      <a href="logout.php" class="btn btn-outline-danger">Salir</a>
    </div>
  </div>

  <table class="table table-bordered align-middle">
    <tr>
      <th>ID</th><th>Foto</th><th>Nombre</th><th>Precio</th><th>Stock</th><th>Visible</th><th>Acciones</th>
    </tr>
    <?php while($p = pg_fetch_assoc($res)){ ?>
    <tr>
      <td><?php echo $p['id']; ?></td>
      <td><img src="<?php echo $p['foto_url']; ?>" width="60" height="60" style="object-fit:cover"></td>
      <td><?php echo $p['nombre']; ?><br><small class="text-muted"><?php echo $p['sku']; ?></small></td>
      <td>$ <?php echo number_format($p['precio'],0,',','.'); ?></td>
      <td><?php echo $p['stock']; ?></td>
      <td><?php echo $p['visible']=='t' ? 'Sí' : 'No'; ?></td>
      <td>
        <a href="form_producto.php?id=<?php echo $p['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
        <a href="form_producto.php?eliminar=<?php echo $p['id']; ?>" onclick="return confirm('¿Eliminar este producto?')" class="btn btn-sm btn-danger">Eliminar</a>
      </td>
    </tr>
    <?php } ?>
  </table>
</div>
</body>
</html>