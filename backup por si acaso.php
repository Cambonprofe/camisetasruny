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

    // 🔍 1. Buscar imagen actual
    $result = $conn->query("SELECT imagen FROM productos WHERE id=$id");
    $row = $result->fetch_assoc();

    // 🧹 2. Borrar imagen anterior si existe
    if ($row['imagen'] && file_exists("uploads/" . $row['imagen'])) {
        unlink("uploads/" . $row['imagen']);
    }

    // 📥 3. Subir nueva imagen
    $nombreImg = $_FILES['imagen']['name'];
    $tmp = $_FILES['imagen']['tmp_name'];

    $nombreFinal = uniqid() . "_" . $nombreImg;

    move_uploaded_file($tmp, "uploads/" . $nombreFinal);

    // 💾 4. Guardar en BD
    $conn->query("UPDATE productos SET imagen='$nombreFinal' WHERE id=$id");
}

$productos = Producto::getAll();
?>

<!DOCTYPE html>
<html>
<head>
<style>
.card{
    border:1px solid black;
    padding:10px;
    margin:10px;
    width:200px;
}
.container{
    display:flex;
    flex-wrap:wrap;
}
</style>
</head>
<body>

<h1>Tienda Runy</h1>

<!-- LOGIN / LOGOUT -->
<?php if (!$user): ?>
    <a href="login.php">Login</a>
<?php else: ?>
    <p>Hola <?= $user['username'] ?> (<?= $user['rol'] ?>)</p>
    <a href="logout.php">Logout</a>
<?php endif; ?>

<!-- SOLO ADMIN -->
<?php if ($esAdmin): ?>
<h2>Crear producto</h2>
<form method="POST" enctype="multipart/form-data">
    <input name="nombre" placeholder="Nombre">
    <input name="descripcion" placeholder="Desc">
    <input name="precio" type="number">
    <input name="stock" type="number">
    
    <input type="file" name="imagen" required>

    <button name="crear">Crear</button>
</form>
<?php endif; ?>

<!-- PRODUCTOS -->
<div class="container">

<?php while($p = $productos->fetch_assoc()): ?>
<div class="card">
    <img src="uploads/<?= $p['imagen'] ?>" width="150">
    <h3><?= htmlspecialchars($p['nombre']) ?></h3>
    <p><?= htmlspecialchars($p['descripcion']) ?></p>
    <p>$<?= $p['precio'] ?></p>
    <p>Stock: <?= $p['stock'] ?></p>
    
    <?php if ($esAdmin): ?>
        <!-- ELIMINAR -->
        <form method="POST">
            <input type="hidden" name="id" value="<?= $p['id'] ?>">
            <button name="eliminar">Eliminar</button>
        </form>
        <!-- actualizar imagen -->
        
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $p['id'] ?>">
            <input type="file" name="imagen" required>
            <button name="actualizar_imagen">Subir imagen</button>
        </form>

        <!-- EDITAR -->
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

</body>
</html>