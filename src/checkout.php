<?php
session_start();
include('../settings/database.php');

if(!isset($_SESSION['user_id'])){
    header('Location: signin.html');
    exit;
}
if(empty($_SESSION['carrito'])){
    header('Location: catalogo.php');
    exit;
}

$total = 0;
foreach($_SESSION['carrito'] as $item){ $total += $item['precio'] * $item['cantidad']; }

if($_POST){
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $metodo = $_POST['metodo_pago'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO pedidos (user_id, total, nombre_cliente, direccion, telefono, metodo_pago) VALUES ($user_id, $total, '$nombre', '$direccion', '$telefono', '$metodo') RETURNING id";
    $res = pg_query($local_conn, $sql);
    $row = pg_fetch_assoc($res);
    $pedido_id = $row['id'];

    foreach($_SESSION['carrito'] as $item){
        $pid = $item['id'];
        $nom = $item['nombre'];
        $pre = $item['precio'];
        $cant = $item['cantidad'];
        $col = $item['color'];
        $tal = $item['talla'];
        pg_query($local_conn, "INSERT INTO pedido_detalle (pedido_id, producto_id, nombre, precio, cantidad, color, talla) VALUES ($pedido_id, $pid, '$nom', $pre, $cant, '$col', '$tal')");
        pg_query($local_conn, "UPDATE productos SET stock = stock - $cant WHERE id = $pid");
    }

    $_SESSION['carrito'] = [];
    $_SESSION['ultimo_pedido'] = $pedido_id;
    header('Location: gracias.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Checkout</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4" style="max-width:600px">
  <a href="carrito.php" class="btn btn-link">Volver al carrito</a>
  <h3>Checkout - Total: $ <?php echo number_format($total,0,',','.'); ?></h3>
  <form method="POST">
    <label>Nombre completo</label><input name="nombre" class="form-control mb-2" required value="<?php echo $_SESSION['firstname'] ?? ''; ?>">
    <label>Dirección</label><input name="direccion" class="form-control mb-2" required placeholder="Cra 50 # 50-20, Medellín">
    <label>Teléfono</label><input name="telefono" class="form-control mb-2" required>
    <label>Método de pago</label>
    <select name="metodo_pago" class="form-select mb-3">
      <option value="Contraentrega">Contraentrega</option>
      <option value="Nequi">Nequi</option>
      <option value="Transferencia">Transferencia</option>
      <option value="Tarjeta">Tarjeta</option>
    </select>
    <button class="btn btn-dark w-100">Confirmar pedido</button>
  </form>
</div>
</body>
</html>