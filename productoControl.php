<?php
require_once("producto.php");

class ProductoController {

    public static function index() {
        $productos = Producto::getAll();
        $data = [];

        while($row = $productos->fetch_assoc()) {
            $data[] = $row;
        }

        echo json_encode($data);
    }

    public static function store() {

        //  Validar que venga la imagen
        if (!isset($_FILES['imagen'])) {
            echo json_encode(["error" => "Imagen requerida"]);
            return;
        }

        $nombreImg = $_FILES['imagen']['name'];
        $tmp = $_FILES['imagen']['tmp_name'];
        $tipo = $_FILES['imagen']['type'];

        // Validación de imagen
        if ($tipo != "image/jpeg" && $tipo != "image/png") {
            echo json_encode(["error" => "Solo JPG o PNG"]);
            return;
        }

        // nombre único
        $nombreFinal = time() . "_" . $nombreImg;

        // mover archivo
        move_uploaded_file($tmp, "uploads/" . $nombreFinal);

    
        Producto::create(
            $_POST["nombre"],
            $_POST["descripcion"],
            $_POST["precio"],
            $_POST["stock"],
            $nombreFinal
        );

        echo json_encode(["mensaje" => "Producto creado con imagen"]);
    }

    public static function destroy($id) {
        Producto::delete($id);
        echo json_encode(["mensaje" => "Producto eliminado"]);
    }
    
    
    
    public static function updateImage() {

    if (!isset($_FILES['imagen']) || !isset($_POST['id'])) {
        echo json_encode(["error" => "Datos incompletos"]);
        return;
    }

    $id = $_POST['id'];

    $nombreImg = $_FILES['imagen']['name'];
    $tmp = $_FILES['imagen']['tmp_name'];
    $tipo = $_FILES['imagen']['type'];

    if ($tipo != "image/jpeg" && $tipo != "image/png") {
        echo json_encode(["error" => "Solo JPG o PNG"]);
        return;
    }

    $nombreFinal = uniqid() . "_" . $nombreImg;

    move_uploaded_file($tmp, "uploads/" . $nombreFinal);

    Producto::updateImagen($id, $nombreFinal);

    echo json_encode(["mensaje" => "Imagen actualizada"]);
}
}
?>