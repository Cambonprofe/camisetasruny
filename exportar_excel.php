<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

require_once("db.php");

// Headers para forzar descarga como .xls (compatible con Excel, sin librería)
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=productos.xls");
header("Pragma: no-cache");
header("Expires: 0");

$sql = "SELECT id, nombre, descripcion, precio, stock, created_at FROM productos";
$result = $conn->query($sql);

// Cabecera de la tabla
echo "<table border='1'>";
echo "<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Descripción</th>
    <th>Precio</th>
    <th>Stock</th>
    <th>Fecha creación</th>
</tr>";

// Filas con datos
while ($fila = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$fila['id']}</td>
        <td>{$fila['nombre']}</td>
        <td>{$fila['descripcion']}</td>
        <td>{$fila['precio']}</td>
        <td>{$fila['stock']}</td>
        <td>{$fila['created_at']}</td>
    </tr>";
}

echo "</table>";
?>