<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicar Sesión</title>
    <link rel="stylesheet" href="CSS/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require "base_datos/base_datos_supermercado.php" ?>
</head>
<body>
    <?php
    if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["registro"] == "Registrarse") {
        header("location: usuarios.php");
    } else if($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = $_POST["usuario"];
        $contrasena = $_POST["contrasena"];

        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
        $resultado = $conexion -> query($sql);

        if($resultado -> num_rows == 0) {
            echo "EL usuario no existe.";
        } else {
            while($fila = $resultado -> fetch_assoc()) { // En esta lína estamos separando las filas y la guardamos en $fila
                $contrasena_cifrada = $fila["contrasena"];
            }

            $acceso_valido = password_verify($contrasena, $contrasena_cifrada);

            if($acceso_valido) {
                echo "TE HAS LOGEADO CON ÉXITO";
                session_start();
                $_SESSION["usuario"] = $usuario;
                $sql = "SELECT rol FROM usuarios WHERE usuario = '$usuario'";
                $resultado = $conexion -> query($sql);
                $_SESSION["rol"] = $resultado -> fetch_assoc()["rol"];
                header("location: listado_productos.php");
            } else {
                echo "CONTRASEÑA INCORRECTA";
            }
        }
    }
    ?>

    <div class="container mt-3">
        <h1>Iniciar Sesión</h1>
        <form action="" method="post">
            <div class="mb-3">
                <label for="" class="form-label">Usuario: </label>
                <input type="text" class="form-control" name="usuario">
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Contraseña: </label>
                <input type="password" class="form-control" name="contrasena">
            </div>
            <input type="submit" class="btn btn-primary" name="registro" value="Iniciar Sesión">
            <input type="submit" class="btn btn-primary" name="registro" value="Registrarse">
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>