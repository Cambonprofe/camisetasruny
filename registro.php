<?php
session_start();
require_once("db.php");

$error = "";
$exito = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmar = $_POST['confirmar'];

    if ($password !== $confirmar) {
        $error = "Las contraseñas no coinciden.";
    } else {
        $check = $conn->query("SELECT id FROM usuarios WHERE username='$username'");
        if ($check->num_rows > 0) {
            $error = "El usuario ya existe.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $conn->query("INSERT INTO usuarios (username, `password`, rol) 
                VALUES ('$username', '$hash', 'cliente')");
            $exito = "Registro exitoso.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="preheader">TIENDA RUNY - REGISTRO</header>

<nav class="navbar">
    <div>
        <a href="index.php">Inicio</a>
        <a href="productos.php">Productos</a>
    </div>
    <div>
        <a href="login.php">Login</a>
    </div>
</nav>

<div class="form-container">
    <h2>Crear cuenta</h2>

    <?php if ($error): ?>
        <p style="color:red"><?= $error ?></p>
    <?php endif; ?>

    <?php if ($exito): ?>
        <p style="color:green"><?= $exito ?> <a href="login.php">Iniciá sesión</a></p>
    <?php endif; ?>

    <form method="POST" class="form-producto">
        <input name="username" placeholder="Usuario" required>
        <input name="password" type="password" placeholder="Contraseña" required>
        <input name="confirmar" type="password" placeholder="Confirmar contraseña" required>
        <button type="submit">Registrarse</button>
    </form>

    <p style="text-align:center; margin-top:15px">
        ¿Ya tenés cuenta? <a href="login.php">Iniciá sesión</a>
    </p>
</div>

<footer class="footer">
    <p>&copy; 2026 Tienda Runy</p>
</footer>

</body>
</html>