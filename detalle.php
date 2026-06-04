<?php
session_start();
require_once("db.php");

$user = $_SESSION['user'] ?? null;

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: productos.php");
    exit;
}

$result = $conn->query("SELECT * FROM productos WHERE id=$id");
$p = $result->fetch_assoc();

if (!$p) {
    header("Location: productos.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($p['nombre']) ?> - Runy Store</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="preheader">
    BIENVENIDO A MI PÁGINA DE CAMISETAS DE FÚTBOL
</header>

<nav class="navbar">
    <div class="nav-links">
        <a href="index.php">Inicio</a>
        <a href="productos.php">Productos</a>
        <?php if ($user && $user['rol'] === 'admin'): ?>
            <a href="clientes.php">Clientes</a>
        <?php endif; ?>
        <?php if ($user && $user['rol'] === 'cliente'): ?>
            <a href="carrito.php">🛒 Carrito</a>
        <?php endif; ?>
        <a href="contacto.php">Contacto</a>
    </div>
    <div class="login">
        <?php if(!$user): ?>
            <a href="login.php">Login</a>
            <a href="registro.php">Registrarse</a>
        <?php else: ?>
            Hola <?= $user['username'] ?> |
            <a href="logout.php">Salir</a>
        <?php endif; ?>
    </div>
</nav>

<div class="layout">
    <main class="main">
        <section class="bienvenida">
            <img src="uploads/<?= $p['imagen'] ?>" style="width:300px; height:300px; object-fit:contain;">
            <h1><?= htmlspecialchars($p['nombre']) ?></h1>
            <p><?= htmlspecialchars($p['descripcion']) ?></p>
            <p><b>$<?= $p['precio'] ?></b></p>
            <p>Stock: <?= $p['stock'] ?></p>

            <?php if ($user && $user['rol'] === 'cliente'): ?>
                <form method="POST" action="carrito.php">
                    <input type="hidden" name="producto_id" value="<?= $p['id'] ?>">
                    <button name="agregar" class="btn">🛒 Agregar al carrito</button>
                </form>
            <?php endif; ?>

            <a href="index.php"><button class="btn">← Volver</button></a>
        </section>
    </main>

    <aside class="sidebar">
        <h3>Categorías</h3>
        <ul>
            <li><a href="#">Clubes nacionales</a></li>
            <li><a href="#">Selecciones</a></li>
            <li><a href="#">Edición limitada</a></li>
        </ul>
        <h3>Contacto</h3>
        <p>📧 runy@tienda.com</p>
        <p>📱 11-1234-5678</p>
    </aside>
</div>

<footer class="footer">
    <p>&copy; 2026 Tienda Runy — Todos los derechos reservados</p>
    <p>Desarrollado con PHP y MySQL</p>
</footer>

</body>
</html>