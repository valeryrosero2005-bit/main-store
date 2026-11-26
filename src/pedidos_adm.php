<?php
session_start();
include('../settings/database.php');
include('menu_admin.php');

if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin'){
    header('Location: signin.html');
    exit;
}

// Cambiar estado
if (isset($_GET['cambiar'])) {
    $id = (int)$_GET['cambiar'];
    $estado = $_GET['estado'];
    pg_query($local_conn, "UPDATE pedidos SET estado = '$estado' WHERE id = $id");
    header('Location: pedidos_adm.php');
    exit;
}

$res = pg_query($local_conn, "SELECT * FROM pedidos ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Pedidos Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Pedidos - Admin</h3>
    <div>
      <a href="productos.php" class="btn btn-outline-dark">Productos</a>
      <a href="catalogo.php" class="btn btn-outline-dark">Ver tienda</a>
      <a href="logout.php" class="btn btn-outline-danger">Salir</a>
    </div>
  </div>
  <?php while($p = pg_fetch_assoc($res)){ ?>
    <div class="card mb-3">
      <div class="card-body">
        <b>Pedido #<?php echo $p['id']; ?></b> - <?php echo $p['fecha']; ?> - Total: $ <?php echo number_format($p['total'],0,',','.'); ?> - <span class="badge bg-dark"><?php echo $p['estado']; ?></span><br>
        <small><?php echo $p['nombre_cliente']; ?> - <?php echo $p['direccion']; ?> - <?php echo $p['telefono']; ?> - <?php echo $p['metodo_pago']; ?></small>
        <hr>
        <?php
        $pid = $p['id'];
        $det = pg_query($local_conn, "SELECT * FROM pedido_detalle WHERE pedido_id = $pid");
        while($d = pg_fetch_assoc($det)){
          echo $d['nombre'] . " - " . $d['color'] . " - Talla " . $d['talla'] . " x " . $d['cantidad'] . "<br>";
        }
        ?>
        <div class="mt-2">
<form method="POST" action="actualizar_estado.php">
    <input type="hidden" name="id" value="...">
    <button ...>Pendiente</button>
    <button ...>Enviado</button>
    <button ...>Entregado</button>
</form>
          </div>
      </div>
    </div>
  <?php } ?>
</div>
</body>
</html>