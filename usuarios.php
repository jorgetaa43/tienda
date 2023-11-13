<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="stylesheet" href="CSS/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require "base_datos/base_datos_supermercado.php" ?>
</head>
<body>
    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["registro"] == "Iniciar Sesión") {
            header("location: iniciar_sesion.php");
        } else if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["registro"] == "Registrarse") {
            $temp_usuario = $_POST["usuario"];
            $temp_contrasena = $_POST["contrasena"];
            $temp_fecha_nacimiento = $_POST["fecha_nacimiento"];

            /* Validación usuario */
            if(strlen($temp_usuario) == 0) {
                $error_usuario = "Este campo es obligatorio";
            } else {
                $regex1 = "/^[a-zA-Z_]*$/";
                if(!preg_match($regex1, $temp_usuario)) {
                    $error_usuario = "Error, el usuario solo puede tener letras y barrabaja.";
                } else {
                    if(strlen($temp_usuario) < 4 || strlen($temp_usuario) > 12) {
                        $error_usuario = "Error, el usuario debe de tener entre 4 y 12 carácteres.";
                    } else {
                        $usuario = $temp_usuario;
                    }
                }
            }

            /* Validación contraseña */
            if(strlen($temp_contrasena) == 0) {
                $error_contrasena = "Este campo es obligatorio";
            } else {
                if(strlen($temp_contrasena) > 255) {
                    $error_contrasena = "Error, la contraseña debe tener menos de 256.";
                } else {
                    $contrasena_cifrada = password_hash($temp_contrasena, PASSWORD_DEFAULT);
                }
            }

            /* Validación fecha de nacimiento */
            if(strlen($temp_fecha_nacimiento) == 0) {
                $error_fecha_nacimiento = "Este campo es obligatorio";
            } else {    
                $fechaHoy = date("o-m-d");       
                $añoHoy = (int) explode("-",$fechaHoy)[0];
                $año = (int)explode("-",$temp_fecha_nacimiento)[0];
                $mes = (int)explode("-",$temp_fecha_nacimiento)[1];
                $mesHoy = (int)explode("-",$fechaHoy)[1];

                if ($añoHoy - $año > 12 && $mesHoy - $mes >= 0 && $añoHoy - $año < 120) {
                    $fecha_nacimiento = $temp_fecha_nacimiento;
                } else {
                    $error_fecha_nacimiento = "Error, la fecha no está entre el rango permitido.";
                }
            }
        }
    ?>
    <div class="container mt-3">
        <h1>Registrarse</h1>
        <form action="" method="post">
            <label for="" class="form-label">Usuario: </label>
            <input type="text" class="form-control" name="usuario" placeholder="Introduzca el usuario">
            <?php
                if (isset($error_usuario)) {
                    echo $error_usuario;
                }
            ?>

            <br>

            <label for="" class="form-label">Contraseña: </label>
            <input type="password" class="form-control" name="contrasena" placeholder="Introduzca la contraseña">
            <?php
                if (isset($error_contrasena)) {
                    echo $error_contrasena;
                }
            ?>

            <br>

            <label for="" class="form-label">Fecha de nacimiento: </label>
            <input type="date" class="form-control" name="fecha_nacimiento">
            <?php
                if (isset($error_fecha_nacimiento)) {
                    echo $error_fecha_nacimiento;
                }
            ?>

            <br>

            <div id="button">
                <input type="submit" class="btn btn-primary" id="boton" name="registro" value="Registrarse">
                <input type="submit" class="btn btn-primary" name="registro" value="Iniciar Sesión">
            </div>
            

        </form>
    </div>
    <?php
        if (isset($usuario) && isset($contrasena_cifrada) && isset($fecha_nacimiento)) {
            echo "<h3>Usuario: " . $usuario . "</h3>";
            echo "<h3>Contraseña: " . $contrasena_cifrada . "</h3>";
            echo "<h3>Fecha de nacimiento: " . $fecha_nacimiento . "</h3>";

            $sql = "INSERT INTO usuarios(usuario, contrasena, fecha_nacimiento)
                Values('$usuario', '$contrasena_cifrada', '$fecha_nacimiento')";
            
            $conexion -> query($sql);

            $sql = "INSERT INTO cestas(cestas_usuario, precioTotal)
                Values('$usuario', 0)";
            
            $conexion -> query($sql);
        }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>