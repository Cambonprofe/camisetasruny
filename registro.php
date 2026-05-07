<?php

require_once("db.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $user = $_POST["username"];

    $pass =
    password_hash(
        $_POST["password"],
        PASSWORD_DEFAULT
    );

    $sql =
    "INSERT INTO usuarios(username,password)
    VALUES('$user','$pass')";

    if($conn->query($sql)){

        echo "Usuario registrado";

    }else{

        echo "Error";

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
        Registrarse
    </button>

</form>