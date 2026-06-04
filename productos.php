<?php
session_start();
require_once("db.php");
require_once("Producto.php");

$user = $_SESSION['user'] ?? null;
$esAdmin = $user && $user['rol'] === 'admin';

// CREAR
if ($esAdmin && isset($_POST['crear'])) {

    $nombreImg = $_FILES['imagen']['name'];
    $tmp = $_FILES['imagen']['tmp_name'];

    // generar nombre único
    $nombreFinal = time() . "_" . $nombreImg;

    move_uploaded_file($tmp, "uploads/" . $nombreFinal);

    Producto::create(
        $_POST['nombre'],
        $_POST['descripcion'],
        $_POST['precio'],
        $_POST['stock'],
        $nombreFinal
    );
}

// ELIMINAR
if ($esAdmin && isset($_POST['eliminar'])) {
    Producto::delete($_POST['id']);
}

// EDITAR
if ($esAdmin && isset($_POST['editar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    $conn->query("UPDATE productos 
        SET nombre='$nombre', descripcion='$descripcion', precio='$precio', stock='$stock'
        WHERE id=$id");
}

if ($esAdmin && isset($_POST['actualizar_imagen'])) {

    $id = $_POST['id'];

    // imagen actual
    $result = $conn->query("SELECT imagen FROM productos WHERE id=$id");
    $row = $result->fetch_assoc();

    // borrar imagen anterior si existe
    if ($row['imagen'] && file_exists("uploads/" . $row['imagen'])) {
        unlink("uploads/" . $row['imagen']);
    }

    // subir nueva imagen
    $nombreImg = $_FILES['imagen']['name'];
    $tmp = $_FILES['imagen']['tmp_name'];

    $nombreFinal = uniqid() . "_" . $nombreImg;

    move_uploaded_file($tmp, "uploads/" . $nombreFinal);

    // update BD
    $conn->query("UPDATE productos SET imagen='$nombreFinal' WHERE id=$id");
}

$productos = Producto::getAll();
?>


<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="preheader">
    TIENDA RUNY - PRODUCTOS
</div>

<div class="navbar">
    <div>
        <a href="index.php">Inicio</a>
        <a href="productos.php">Productos</a>
        <a href="clientes.php">Clientes</a>
        <?php if ($user && $user['rol'] === 'cliente'): ?>
    <a href="carrito.php">🛒 Carrito</a>
<?php endif; ?>
        <?php if ($esAdmin): ?>
            <a href="exportar_excel.php">📥 Exportar a Excel</a>
            <a href="exportar_pdf.php">📄 Exportar a PDF</a>
        <?php endif; ?>
    </div>

    <div>
        <?php if(!$user): ?>
            <a href="login.php">Login</a>
        <?php else: ?>
            <?= $user['username'] ?> |
            <a href="logout.php">Salir</a>
        <?php endif; ?>
    </div>
</div>

<div class="main">
    <h1>Tienda Runy</h1>
</div>

<?php if ($esAdmin): ?>
<div class="form-container">

<h2>Crear producto</h2>

<form method="POST" enctype="multipart/form-data" class="form-producto">
    
    <input name="nombre" placeholder="Nombre" required>
    <input name="descripcion" placeholder="Descripción">
    <input name="precio" type="number" placeholder="Precio" required>
    <input name="stock" type="number" placeholder="Stock" required>
    
    <input type="file" name="imagen" required>

    <button name="crear">Crear producto</button>

</form>

</div>
<?php endif; ?>

<div class="container">

<?php while($p = $productos->fetch_assoc()): ?>
<div class="card">

    <img src="uploads/<?= $p['imagen'] ?>">

    <h3><?= htmlspecialchars($p['nombre']) ?></h3>
    <p><?= htmlspecialchars($p['descripcion']) ?></p>
    <p><b>$<?= $p['precio'] ?></b></p>
    <p>Stock: <?= $p['stock'] ?></p>
    <?php if ($user && $user['rol'] === 'cliente'): ?>
    <form method="POST" action="carrito.php">
        <input type="hidden" name="producto_id" value="<?= $p['id'] ?>">
        <button name="agregar">🛒 Agregar al carrito</button>
    </form>
<?php endif; ?>

    <?php if ($esAdmin): ?>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $p['id'] ?>">
        <button name="eliminar" onclick="return confirmarEliminar()">Eliminar</button>
        </form>

        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $p['id'] ?>">
            <input type="file" name="imagen">
            <button name="actualizar_imagen">Subir imagen</button>
        </form>

        <form method="POST">
            <input type="hidden" name="id" value="<?= $p['id'] ?>">
            <input name="nombre" value="<?= $p['nombre'] ?>">
            <input name="descripcion" value="<?= $p['descripcion'] ?>">
            <input name="precio" value="<?= $p['precio'] ?>">
            <input name="stock" value="<?= $p['stock'] ?>">
            <button name="editar">Editar</button>
        </form>
    <?php endif; ?>

</div>
<?php endwhile; ?>

</div>
<script>
    function confirmarEliminar() {
        return confirm("¿Estás seguro que querés eliminar este producto?");
    }
</script>

</body>
</html>
</body>
</html>