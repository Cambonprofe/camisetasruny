<?php
require_once("productoController.php");

$request = $_SERVER['REQUEST_METHOD'];

if ($request == "GET") {
    ProductoController::index();
}

if ($request == "POST") {
    ProductoController::store();
}

if ($request == "DELETE") {
    parse_str($_SERVER['QUERY_STRING'], $params);
    ProductoController::destroy($params['id']);
}
?>