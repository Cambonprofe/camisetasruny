<?php
require_once("db.php");

class Producto {

    public static function getAll() {
        global $conn;
        $sql = "SELECT * FROM productos";
        return $conn->query($sql);
    }

    public static function create($nombre, $descripcion, $precio, $stock, $imagen) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, imagen) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdis", $nombre, $descripcion, $precio, $stock, $imagen);

    return $stmt->execute();
}
    

    public static function delete($id) {
        global $conn;

        $stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
    public static function updateImagen($id, $imagen) {
    global $conn;

    $stmt = $conn->prepare("UPDATE productos SET imagen = ? WHERE id = ?");
    $stmt->bind_param("si", $imagen, $id);

    return $stmt->execute();
}
}
?>
