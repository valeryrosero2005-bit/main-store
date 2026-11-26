<?php
session_start();
include('../settings/database.php');
include('menu.php');

if(!isset($_SESSION['carrito'])) $_SESSION['carrito'] = [];

// AGREGAR
if($_POST && isset($_POST['id'])){
    $id = $_POST['id'];
    $color = $_POST['color'] ?? '';
    $talla = $_POST['talla'] ?? '';
    $key = $id.'_'.$color.'_'.$talla;

    $r = pg_query($local_conn, "SELECT * FROM productos WHERE id = $id");
    $p = pg_fetch_assoc($r);

    if(isset($_SESSION['carrito'][$key])){
        $_SESSION['carrito'][$key]['cantidad']++;
    } else {
        $_SESSION['carrito'][$key] = [
            'id' => $p['id'],
            'nombre' => $p['nombre'],
            'precio' => $p['precio'],
            'foto' => $p['foto_url'] ?? $p['foto'] ?? $p['imagen'] ?? '',
            'color' => $color,
            'talla' => $talla,
            'cantidad' => 1
        ];
    }
    header('Location: carrito.php');
    exit;
}

// ELIMINAR UNO
if(isset($_GET['quitar'])){
    unset($_SESSION['carrito'][$_GET['quitar']]);
    header('Location: carrito.php');
    exit;
}

// VACIAR
if(isset($_GET['vaciar'])){
    $_SESSION['carrito'] = [];
    header('Location: carrito.php');
    exit;
}

$total = 0;
foreach($_SESSION['carrito'] as $item){ $total += $item['precio'] * $item['cantidad']; }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Carrito</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
  <a href="catalogo.php" class="btn btn-link">Seguir comprando</a>
  <h3>Mi carrito</h3>
  <?php if(empty($_SESSION['carrito'])){ ?>
    <p>Tu carrito está vacío.</p>
  <?php } else { ?>
  <table class="table align-middle">
    <?php foreach($_SESSION['carrito'] as $key=>$item){ ?>
    <tr>
      <td><img src="<?php echo $item['foto']; ?>" width="60" height="60" style="object-fit:cover"></td>
      <td><?php echo $item['nombre']; ?><br><small><?php echo $item['color']; ?> - Talla <?php echo $item['talla']; ?></small></td>
      <td>$ <?php echo number_format($item['precio'],0,',','.'); ?></td>
      <td>x <?php echo $item['cantidad']; ?></td>
      <td><b>$ <?php echo number_format($item['precio']*$item['cantidad'],0,',','.'); ?></b></td>
      <td><a href="carrito.php?quitar=<?php echo $key; ?>" class="btn btn-sm btn-danger">X</a></td>
    </tr>
    <?php } ?>
  </table>
  <h4>Total: $ <?php echo number_format($total,0,',','.'); ?></h4>
  <a href="carrito.php?vaciar=1" class="btn btn-outline-danger">Vaciar carrito</a>
  <a href="checkout.php" class="btn btn-dark">Ir a pagar</a>
  <?php } ?>
</div>
</body>
</html>