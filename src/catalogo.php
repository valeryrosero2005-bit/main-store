<?php
session_start();
include('../settings/database.php');
include('menu.php');

$buscar = $_GET['buscar'] ?? '';
$tienda = $_GET['tienda'] ?? '';
$orden = $_GET['orden'] ?? '';

$sql = "SELECT * FROM productos WHERE visible = true";
if($buscar != ''){
    $sql .= " AND nombre ILIKE '%$buscar%'";
}
if($tienda != ''){
    $sql .= " AND tienda = '$tienda'";
}
if($orden == 'menor'){
    $sql .= " ORDER BY precio ASC";
} elseif($orden == 'mayor'){
    $sql .= " ORDER BY precio DESC";
} else {
    $sql .= " ORDER BY id ASC";
}
$res = pg_query($local_conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Catálogo de productos</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.card-img-top{ height:200px; object-fit:cover; }
.color-dot{ width:22px; height:22px; border-radius:50%; display:inline-block; border:1px solid #ccc; }
</style>
</head>
<body>
<div class="container mt-4">
  <h3>Catálogo de productos</h3>
  <form method="GET" class="row g-2 mb-4">
    <div class="col-12 col-md-5">
      <input type="text" name="buscar" class="form-control" placeholder="Buscar nombre o descripción" value="<?php echo $buscar; ?>">
    </div>
    <div class="col-6 col-md-2">
      <select name="tienda" class="form-select">
        <option value="">Tienda</option>
        <option value="Ropa Store" <?php if($tienda=='Ropa Store') echo 'selected'; ?>>Ropa Store</option>
      </select>
    </div>
    <div class="col-6 col-md-3">
      <select name="orden" class="form-select">
        <option value="">Ordenar</option>
        <option value="menor" <?php if($orden=='menor') echo 'selected'; ?>>Menor precio</option>
        <option value="mayor" <?php if($orden=='mayor') echo 'selected'; ?>>Mayor precio</option>
      </select>
    </div>
    <div class="col-12 col-md-2">
      <button class="btn btn-dark w-100">Filtrar</button>
    </div>
  </form>

  <div class="row">
  <?php while($p = pg_fetch_assoc($res)){ ?>
    <div class="col-12 col-sm-6 col-md-4 col-xl-3 mb-4">
      <div class="card h-100">
        <img src="<?php echo $p['foto_url']; ?>" class="card-img-top" alt="<?php echo $p['nombre']; ?>">
        <div class="card-body">
          <small class="text-muted"><?php echo $p['tienda']; ?></small>
          <h6><?php echo $p['nombre']; ?></h6>
          <p><b>$ <?php echo number_format($p['precio'],0,',','.'); ?></b></p>
          <a href="detalle_producto.php?id=<?php echo $p['id']; ?>" class="btn btn-outline-dark w-100">Ver detalle</a>
        </div>
      </div>
    </div>
  <?php } ?>
  </div>
</div>
</body>
</html>