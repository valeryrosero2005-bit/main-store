<?php session_start(); $id = $_SESSION['ultimo_pedido'] ?? ''; ?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body><div class="container mt-5 text-center">
<h2>¡Gracias por tu compra!</h2>
<p>Tu pedido #<?php echo $id; ?> quedó registrado como pendiente.</p>
<a href="catalogo.php" class="btn btn-dark">Seguir comprando</a>
<a href="mis_pedidos.php" class="btn btn-outline-dark">Ver mis pedidos</a>
</div></body></html>
