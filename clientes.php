<?php
session_start();
require_once("db.php");

$user = $_SESSION['user'] ?? null;
$esAdmin = $user && $user['rol'] === 'admin';

if (!$esAdmin) {
    header("Location: login.php");
    exit;
}

// CREAR
if (isset($_POST['crear'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $conn->query("INSERT INTO clientes (nombre, apellido, email, telefono, direccion) 
        VALUES ('$nombre', '$apellido', '$email', '$telefono', '$direccion')");
}

// ELIMINAR
if (isset($_POST['eliminar'])) {
    $id = $_POST['id'];
    $conn->query("DELETE FROM clientes WHERE id=$id");
}

// EDITAR
if (isset($_POST['editar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $conn->query("UPDATE clientes SET 
        nombre='$nombre', apellido='$apellido', email='$email', 
        telefono='$telefono', direccion='$direccion' 
        WHERE id=$id");
}

$clientes = $conn->query("SELECT * FROM clientes");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="preheader">TIENDA RUNY - CLIENTES</header>

<nav class="navbar">
    <div>
        <a href="index.php">Inicio</a>
        <a href="productos.php">Productos</a>
        <a href="clientes.php">Clientes</a>
    </div>
    <div>
        <?= $user['username'] ?> | <a href="logout.php">Salir</a>
    </div>
</nav>

<div class="form-container">
    <h2>Agregar cliente</h2>
    <form method="POST" class="form-producto">
        <input name="nombre" placeholder="Nombre" required>
        <input name="apellido" placeholder="Apellido" required>
        <input name="email" type="email" placeholder="Email" required>
        <input name="telefono" placeholder="Teléfono">
        <input name="direccion" placeholder="Dirección">
        <button name="crear">Agregar cliente</button>
    </form>
</div>

<div class="container">
<?php while($c = $clientes->fetch_assoc()): ?>
<div class="card">
    <h3><?= htmlspecialchars($c['nombre']) ?> <?= htmlspecialchars($c['apellido']) ?></h3>
    <p>📧 <?= htmlspecialchars($c['email']) ?></p>
    <p>📱 <?= htmlspecialchars($c['telefono']) ?></p>
    <p>📍 <?= htmlspecialchars($c['direccion']) ?></p>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $c['id'] ?>">
        <button name="eliminar" onclick="return confirmarEliminar()">Eliminar</button>
    </form>

    <form method="POST">
        <input type="hidden" name="id" value="<?= $c['id'] ?>">
        <input name="nombre" value="<?= $c['nombre'] ?>">
        <input name="apellido" value="<?= $c['apellido'] ?>">
        <input name="email" value="<?= $c['email'] ?>">
        <input name="telefono" value="<?= $c['telefono'] ?>">
        <input name="direccion" value="<?= $c['direccion'] ?>">
        <button name="editar">Editar</button>
    </form>
</div>
<?php endwhile; ?>
</div>

<footer class="footer">
    <p>&copy; 2026 Tienda Runy</p>
</footer>

<script>
    function confirmarEliminar() {
        return confirm("¿Estás seguro que querés eliminar este cliente?");
    }
</script>

</body>
</html>