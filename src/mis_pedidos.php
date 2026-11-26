<?php
session_start();
include('../settings/database.php');
include('menu.php');

if(!isset($_SESSION['user_id'])){
    header('Location: signin.html');
    exit;
}
$user_id = $_SESSION['user_id'];
$res = pg_query($local_conn, "SELECT * FROM pedidos WHERE user_id = $user_id ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mis pedidos</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
  <a href="catalogo.php" class="btn btn-link">Volver a la tienda</a>
  <h3>Mis pedidos</h3>
  <?php if(pg_num_rows($res)==0){ ?>
    <p>Aún no tienes pedidos.</p>
  <?php } else { ?>
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
          echo $d['nombre'] . " - " . $d['color'] . " - Talla " . $d['talla'] . " x " . $d['cantidad'] . " = $ " . number_format($d['precio']*$d['cantidad'],0,',','.') . "<br>";
        }
        ?>
      </div>
    </div>
  <?php } ?>
  <?php } ?>
</div>
</body>
</html>