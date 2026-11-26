<?php
//MI LISTA COMO ADM
//localhost/main-store/src/productos.php

session_start();
include('../settings/database.php');
$id = $_GET['id'];
$sql = "SELECT * FROM productos WHERE id = $id";
$res = pg_query($local_conn, $sql);
$p = pg_fetch_assoc($res);
$colores = explode(',', $p['colores']);
$tallas = explode(',', $p['tallas']);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $p['nombre']; ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.color-dot{ width:30px; height:30px; border-radius:50%; display:inline-block; border:2px solid #ccc; cursor:pointer; }
.color-dot.active{ border:2px solid #000; }
.talla-btn.active{ background:#000; color:#fff; }
</style>
</head>
<body>
<div class="container mt-4">
  <a href="catalogo.php" class="btn btn-link">Volver al catálogo</a>
  <div class="row mt-3">
    <div class="col-12 col-md-6">
      <img src="<?php echo $p['foto_url']; ?>" class="img-fluid rounded" style="width:100%; height:400px; object-fit:cover;">
    </div>
    <div class="col-12 col-md-6">
      <h3><?php echo $p['nombre']; ?></h3>
      <h4>$ <?php echo number_format($p['precio'],0,',','.'); ?></h4>
      <p><?php echo $p['descripcion']; ?></p>
      <p><b>Disponibles:</b> <?php echo $p['stock']; ?> und.</p>
      <p><b>Tienda:</b> <?php echo $p['tienda']; ?></p>
      <p><b>Sucursal:</b> <?php echo $p['sucursal']; ?></p>
      <p><b>Ubicación:</b> Cra 50 # 50-20, Medellín, Antioquia, Colombia</p>

      <form method="POST" action="carrito.php">
        <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
        <label><b>Color:</b></label><br>
        <?php foreach($colores as $c){ $c = trim($c); ?>
          <label><input type="radio" name="color" value="<?php echo $c; ?>" required hidden> <span class="color-dot" title="<?php echo $c; ?>" style="background:<?php echo strtolower($c); ?>;"></span> <?php echo $c; ?></label>
        <?php } ?>
        <br><br>
        <label><b>Talla:</b></label><br>
        <?php foreach($tallas as $t){ $t = trim($t); ?>
          <label class="btn btn-outline-dark btn-sm m-1"><input type="radio" name="talla" value="<?php echo $t; ?>" required hidden> <?php echo $t; ?></label>
        <?php } ?>
        <br><br>
        <button class="btn btn-dark w-100">Agregar al carrito</button>
      </form>
    </div>
  </div>
</div>
<script>
document.querySelectorAll('.color-dot').forEach(d=>{
  d.addEventListener('click', ()=>{
    document.querySelectorAll('.color-dot').forEach(x=>x.classList.remove('active'));
    d.classList.add('active');
    d.parentElement.querySelector('input').checked = true;
  });
});
</script>
</body>
</html>