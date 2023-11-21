<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cestas del usuario</title>
    <link rel="stylesheet" href="CSS/cestas_usuario.css">
    <?php require "base_datos/base_datos_supermercado.php" ?>
</head>
<body> 
    <?php
    session_start();
    $usuario = $_SESSION["usuario"];
    ?>
    <table >
        <caption>Cestas de <?php echo $usuario ?></caption>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql = "SELECT p.nombreProducto, p.imagen, p.precio, pc.cantidad FROM productos p JOIN productos_cestas pc ON(p.id_producto = pc.idProducto) INNER JOIN cestas c ON(c.id_cesta = pc.idCesta) WHERE c.cestas_usuario = '$usuario'";
        $resultado = $conexion -> query($sql);
        $totalCompra = 0;
        while($fila = $resultado -> fetch_assoc()) {?>
            <tr>
                <td><?php echo $fila["nombreProducto"]; ?></td>
                <td><img width="80px" height="80px" src="<?php echo $fila["imagen"]; ?>"></td>
                <td><?php echo $fila["precio"]; ?></td>
                <td><?php echo $fila["cantidad"]; ?></td>
            </tr>
            <?php $totalCompra += ($fila["cantidad"] * $fila["precio"]); ?>
        <?php
        }?>
        <tr>
            <th >Total de la compra</th>
            <th colspan="3">
                <?php 
                    echo $totalCompra;
                ?>
            </th>
        </tr>
        </tbody>
    </table>
    
    <?php
    if(isset($_POST["confirmarCompra"]) && $_POST["confirmarCompra"] == "Finalizar compra") {
        $sql = "INSERT INTO pedidos VALUES(null, '$usuario', '$totalCompra', null)";
        $conexion -> query($sql);

        $sql = "SELECT id_cesta FROM cestas WHERE cestas_usuario = '$usuario'";
        $resultado = $conexion -> query($sql);
        $idCesta = $resultado->fetch_assoc()["id_cesta"];

        $sql = "SELECT * FROM productos_cestas WHERE idCesta = '".$idCesta."'";
            $resultado = $conexion->query($sql);
            $contador = 1;
        while ($fila = $resultado->fetch_assoc()){
            $sql = "SELECT * FROM productos WHERE id_producto = '".$fila["idProducto"]."'";
            $resultadoo = $conexion->query($sql);
            
            while ($filaa = $resultadoo->fetch_assoc()){
                $sql = "SELECT id_pedido FROM pedidos WHERE usuario = '$usuario';";
                $id_pedido = $conexion->query($sql)->fetch_assoc()["id_pedido"];
                $sql = "INSERT INTO linea_pedidos VALUES($contador,'".$fila["idProducto"]."','$id_pedido','".$filaa["precio"]."','".$fila["cantidad"]."');";
                $contador = $contador+1;
                $conexion->query($sql);
            }
        }
    }
    ?>
        <form action="" method="post">
            <input type="submit" name="confirmarCompra" value="Finalizar compra">
        </form>
</body>
</html>