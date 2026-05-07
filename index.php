
<?php
session_start();
$user = $_SESSION['user'] ?? null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Runy Store</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="preheader">
    BIENVENIDO A MI PÁGINA DE CAMISETAS DE FÚTBOL
</div>

<div class="navbar">
    <div class="nav-links">
        <a href="index.php">Inicio</a>
        <a href="productos.php">Productos</a>
        <a href="#">Contacto</a>
    </div>

    <div class="login">
        <?php if(!$user): ?>
            <a href="login.php">Login</a>
        <?php else: ?>
            Hola <?= $user['username'] ?> |
            <a href="logout.php">Salir</a>
        <?php endif; ?>
    </div>
</div>

<div class="main">

<h1>Camisetas de Futbol Runy</h1>

<h3>¿Qué es una camiseta de futbol?</h3>
<p>Una camiseta de futbol es una prenda de vestir que se utiliza para jugar.</p>

<img class="logo" src="uploads/logo.png">

<br>

<a href="productos.php">
    <button class="btn">Ver productos</button>
</a>

</div>

</body>
</html>