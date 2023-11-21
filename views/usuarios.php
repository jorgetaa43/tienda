<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="stylesheet" href="CSS/usuarios.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <?php require "base_datos/base_datos_supermercado.php" ?>
    <style>
        .btn {
            width: 100%;
            height: 45px;
            background-color: #162938;
            border: none;
            outline: none;
            border-radius: 6px;
            -webkit-border-radius: 6px;
            -moz-border-radius: 6px;
            -ms-border-radius: 6px;
            -o-border-radius: 6px;
            cursor: pointer;
            font-size: 1em;
            color: #fff;
            font-weight: 500;
        }

        .btn:hover {
            background-color: #0a1014;
            color: #fff;
            transition: 2s;
        }
    </style>
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
                $regex2 = "/^[a-zA-Z0-9\W_]*$/";
                if(!preg_match($regex2, $temp_contrasena)) {
                    $error_contrasena = "Error, la contraseña no cumple con los carácteres requiridos o aceptados.";
                } else {
                    if(strlen($temp_contrasena) > 20 || strlen($temp_contrasena) < 8) {
                        $error_contrasena = "Error, la contraseña debe tener menos de 256.";
                    } else {
                        $contrasena_cifrada = password_hash($temp_contrasena, PASSWORD_DEFAULT);
                    }
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
    <div class="wrapper">
        <span class="icon-close"><ion-icon name="close"></ion-icon></span>
        <div class="form-box login">
            <h2>Login</h2>
            <form action="#">
                <div class="input-box">
                    <span class="icon"><ion-icon name="person"></ion-icon></span>
                    <input type="text" required>
                    <label>Usuario</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" required>
                    <label>Contraseña</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="calendar"></ion-icon></span>
                    <input type="text" required>
                    <label>Fecha de nacimiento</label>
                </div>
                <button type="submit" class="btn">Registrarse</button>
            </form>
        </div>
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
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>