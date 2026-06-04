<?php
session_start();
require_once("db.php");

$user = $_SESSION['user'] ?? null;

if (!$user) {
    header("Location: login.php");
    exit;
}

$usuario_id = $user['id'];

// AGREGAR AL CARRITO
if (isset($_POST['agregar'])) {
    $producto_id = $_POST['producto_id'];
    $existe = $conn->query("SELECT id FROM carritos WHERE usuario_id=$usuario_id AND producto_id=$producto_id");
    if ($existe->num_rows > 0) {
        $conn->query("UPDATE carritos SET cantidad = cantidad + 1 WHERE usuario_id=$usuario_id AND producto_id=$producto_id");
    } else {
        $conn->query("INSERT INTO carritos (usuario_id, producto_id, cantidad) VALUES ($usuario_id, $producto_id, 1)");
    }
    header("Location: productos.php");
    exit;
}

// ELIMINAR DEL CARRITO
if (isset($_POST['eliminar'])) {
    $id = $_POST['id'];
    $conn->query("DELETE FROM carritos WHERE id=$id AND usuario_id=$usuario_id");
}

// VACIAR CARRITO
if (isset($_POST['vaciar'])) {
    $conn->query("DELETE FROM carritos WHERE usuario_id=$usuario_id");
}

$items = $conn->query("SELECT c.id, c.cantidad, p.nombre, p.precio, p.imagen 
    FROM carritos c 
    JOIN productos p ON c.producto_id = p.id 
    WHERE c.usuario_id = $usuario_id");

$total = 0;
$filas = [];
while ($fila = $items->fetch_assoc()) {
    $filas[] = $fila;
    $total += $fila['precio'] * $fila['cantidad'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="preheader">TIENDA RUNY - CARRITO</header>

<nav class="navbar">
    <div>
        <a href="index.php">Inicio</a>
        <a href="productos.php">Productos</a>
        <a href="carrito.php">🛒 Carrito</a>
    </div>
    <div>
        <?= $user['username'] ?> | <a href="logout.php">Salir</a>
    </div>
</nav>

<div class="form-container">
    <h2>Tu carrito</h2>

    <?php if (empty($filas)): ?>
        <p style="text-align:center">Tu carrito está vacío. <a href="productos.php">Ver productos</a></p>
    <?php else: ?>

    <div class="container">
        <?php foreach ($filas as $item): ?>
        <div class="card">
            <img src="uploads/<?= $item['imagen'] ?>">
            <h3><?= htmlspecialchars($item['nombre']) ?></h3>
            <p>$<?= $item['precio'] ?></p>
            <p>Cantidad: <?= $item['cantidad'] ?></p>
            <p><b>Subtotal: $<?= $item['precio'] * $item['cantidad'] ?></b></p>

            <form method="POST">
                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                <button name="eliminar">Quitar</button>
            </form>
        </div>
        <?php endforeach; ?>
    </div>

    <div style="text-align:center; margin-top:20px">
        <h2>Total: $<?= $total ?></h2>
        <form method="POST">
            <button name="vaciar">🗑️ Vaciar carrito</button>
        </form>
    </div>

    <?php endif; ?>
</div>

<footer class="footer">
    <p>&copy; 2026 Tienda Runy</p>
</footer>

</body>
</html>