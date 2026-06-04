<?php
session_start();
$user = $_SESSION['user'] ?? null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Runy Store</title>
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
            <div>
    <a href="login.php">Login</a>
    <a href="registro.php">Registrarse</a>
</div>
        <?php else: ?>
            Hola <?= $user['username'] ?> |
            <a href="logout.php">Salir</a>
        <?php endif; ?>
    </div>
</nav>

<div class="layout">

    <main class="main">

        <section class="bienvenida">
            <h1>Camisetas de Fútbol Runy</h1>
            <p>Tu tienda online de camisetas de fútbol originales.</p>
            <img class="logo" src="uploads/logo.png">
            <br>
            <a href="productos.php">
                <button class="btn">Ver productos</button>
            </a>
        </section>

   <article class="destacado">
    <h2>🏆 ¡Argentina Campeona del Mundo!</h2>
    <p>Conseguí las camisetas oficiales de la Selección Argentina ganadora del Mundial Qatar 2022.</p>
    <a href="detalle.php?id=11"><button class="btn">👕 Camiseta titular</button></a>
    <a href="detalle.php?id=12"><button class="btn">👕 Camiseta suplente</button></a>
</article>

    </main>

    <aside class="sidebar">        
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