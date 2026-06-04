<?php
session_start();
$user = $_SESSION['user'] ?? null;

$exito = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];
    $exito = "¡Mensaje enviado! Te responderemos a la brevedad.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contacto - Runy Store</title>
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

<div class="form-container">
    <h2>Contacto</h2>

    <?php if ($exito): ?>
        <p style="color:green"><?= $exito ?></p>
    <?php endif; ?>

    <form method="POST" class="form-producto">
        <input name="nombre" placeholder="Tu nombre" required>
        <input name="email" type="email" placeholder="Tu email" required>
        <textarea name="mensaje" placeholder="Tu mensaje" required 
            style="padding:8px; border:1px solid #ccc; border-radius:5px; width:300px; height:100px"></textarea>
        <button type="submit">Enviar mensaje</button>
    </form>

    <div style="margin-top:30px; text-align:center">
        <p>📧 runy@tienda.com</p>
        <p>📱 11-1234-5678</p>
    </div>
</div>

<footer class="footer">
    <p>&copy; 2026 Tienda Runy — Todos los derechos reservados</p>
    <p>Desarrollado con PHP y MySQL</p>
</footer>

</body>
</html>