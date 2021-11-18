<?php 
include('dbconnection.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo CRUD sencillo - TABLA USUARIO</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="nombre">Nombre:</label><input type="text" name="nombre"><br>
        <label for="apellido">Apellido:</label><input type="text" name="apellido"><br>
        <label for="telefono">Telefono:</label><input type="text" name="telefono"><br>
        <label for="usuario">Usuario:</label><input type="email" name="usuario"><br>
        <label for="contrasena">Contraseña:</label><input type="password" name="contrasena"><br>
        <label for="nacionalidad">Nacionalidad:</label>
        <select name="nacionalidad">
            <option value="España">Español</option>
            <option value="Otro" selected="selected">Extranjero</option>
        </select> <br>
        <label for="sexo">Sexo:</label>
        <input type="radio" name="sexo" value="m">Mujer</input>
        <input type="radio" name="sexo" value="h">Hombre</input>
        <input type="submit" name="submit" value="Crear Nuevo Usuario">
    </form>
    
    <?php 
        function filtrado($datos){
            $datos = trim($datos);
            $datos = stripslashes($datos);
            $datos = htmlspecialchars($datos);

            return $datos;
        }
        // Se ha enviado el formulario vía POST, entonces procesamos la petición.

        if(isset($_POST["submit"])&&$_SERVER["REQUEST_METHOD"]=="POST"){
            $nombre= filtrado($_POST["nombre"]);
            $apellido= filtrado($_POST["apellido"]);
            $telefono= filtrado($_POST["telefono"]);
            $usuario= filtrado($_POST["usuario"]);
            $contrasena= filtrado($_POST["contrasena"]);
            $nacionalidad= filtrado($_POST["nacionalidad"]);
            $sexo= filtrado($_POST["sexo"]);
            $hash = password_hash($password, PASSWORD_DEFAULT);

            
        //Insertar en la base de datos 
        // $sql = "INSERT INTO agenda (nombre, apellido, telefono, username, password, nacionalidad, sexo )
        // VALUES ('$nombre', '$apellido', '$telefono', '$usuario', '$hash', '$nacionalidad', '$sexo')";

        $data = [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'telefono' => $telefono,
            'usuario' => $usuario,
            'contrasena' => $hash,
            'nacionalidad' => $nacionalidad,
            'sexo' => $sexo
        ];

        $sql = "INSERT INTO agenda (nombre, apellido, telefono, username, password, nacionalidad, sexo )
        VALUES (:nombre, :apellido, :telefono, :usuario, :contrasena, :nacionalidad, :sexo)";

        $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY)); 
        $stmt -> execute($data);
        // echo $sql;
        // exit;

        // use exec() because no results are returned
        // $conn->exec($sql);
        $ultimo_id = $conn->lastInsertId();
        
        //Cierre y liberacion de recursos de la BD
        $conn=null;
    
    }
        //Si el registro ha sido satisfactrio mostrar datos
        if(isset($ultimo_id)){

    ?>   
        <!-- Mostrar los datos de registro -->
        <h2>Mostrar datos enviados</h2>
        Código ID: <?=$ultimo_id?><br>
        nombre:<?php isset($nombre)? print $nombre:"";?><br>
        apellido:<?php isset($apellido)? print $apellido:"";?><br>
        telefono:<?php isset($telefono)? print $telefono:"";?><br>
        usuario:<?php isset($usuario)? print $usuario:"";?><br>
        contrasena:<?php isset($contrasena)? print $contrasena:"SIN CONTRASEÑA";?><br>
        nacionalidad:<?php isset($nacionalidad)? print $nacionalidad:"Español";?><br>
        sexo:<?php isset($sexo)&& $sexo=='h' ? print "Hombre":"Mujer";?><br>
    
        <?php }else{
                print "Se ha producido un error. Creación de nuevo usuario abortada.";
            }
        ?>
</body>
</html>