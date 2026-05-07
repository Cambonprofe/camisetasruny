<?php

session_start();

require_once("db.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $user = $_POST["username"];

    $pass = $_POST["password"];

    $sql =
    "SELECT * FROM usuarios
    WHERE username='$user'";

    $result = $conn->query($sql);

    if($result->num_rows > 0){

        $usuario =
        $result->fetch_assoc();

        if(
            password_verify(
                $pass,
                $usuario["password"]
            )
        ){

            $_SESSION["user"] = $usuario;

            header("Location: productos.php");

        }else{

            echo "Contraseña incorrecta";

        }

    }else{

        echo "Usuario no encontrado";

    }

}
?>

<form method="POST">

    <input
    type="text"
    name="username"
    placeholder="Usuario">

    <input
    type="password"
    name="password"
    placeholder="Password">

    <button>
        Login
    </button>

</form>