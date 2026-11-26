<?php
include('../settings/database.php');
session_start();
$id = $_GET['id'] ?? 0;

$sql = "SELECT url_photo FROM users WHERE id = $id";
$res = pg_query($local_conn, $sql);
$row = pg_fetch_assoc($res);

if($row and !empty($row['url_photo'])){
    $ruta = __DIR__. '/' . $user['url_photo'];
    if(file_exists($ruta)){
        unlink($ruta);
    }
    $sql = "UPDATE users SET url_photo = NULL WHERE id = $id";
    pg_query($local_conn, $sql);
}

header('Location: edit_user.php?id=' . $id);
exit;
?>