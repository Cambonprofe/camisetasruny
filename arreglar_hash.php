<?php
// arreglar_hash.php — BORRAR después de ejecutar
require_once("db.php");
$hash = password_hash("1234", PASSWORD_DEFAULT);
$sql = "UPDATE usuarios SET `password`='$hash' WHERE username='admin'";
$conn->query($sql);
echo "Hash actualizado: " . $hash;
?>