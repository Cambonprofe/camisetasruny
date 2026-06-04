<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

require_once("db.php");

$sql = "SELECT id, nombre, descripcion, precio, stock FROM productos";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Productos PDF</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #333; color: white; padding: 10px; }
        td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .botones { text-align: center; margin-top: 20px; }
        button { padding: 10px 20px; margin: 5px; cursor: pointer; font-size: 16px; }
        @media print { .botones { display: none; } }
    </style>
</head>
<body>

<h1>Tienda Runy - Listado de Productos</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Stock</th>
    </tr>
    <?php while ($fila = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $fila['id'] ?></td>
        <td><?= htmlspecialchars($fila['nombre']) ?></td>
        <td><?= htmlspecialchars($fila['descripcion']) ?></td>
        <td>$<?= $fila['precio'] ?></td>
        <td><?= $fila['stock'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<div class="botones">
    <button onclick="window.print()">🖨️ Imprimir / Guardar PDF</button>
    <button onclick="window.location.href='productos.php'">← Volver</button>
</div>

</body>
</html>