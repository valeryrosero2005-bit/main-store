<?php
session_start();
include('../settings/database.php');

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header('Location: signin.html');
    exit;
}

$id = $_POST['id'] ?? '';
$estado = $_POST['estado'] ?? '';

if (in_array($estado, ['pendiente','enviado','entregado'])) {
    $id = (int)$id;
    $estado = pg_escape_string($local_conn, $estado);
    pg_query($local_conn, "UPDATE pedidos SET estado = '$estado' WHERE id = $id");
}

header('Location: pedidos_adm.php');
exit;
?>