<?php 
include('dbconnection.php');

$micontrasena = 'sal123';
// $mihash = password_hash($micontrasena, PASSWORD_DEFAULT);

    $sql = "SELECT password FROM agenda WHERE id = :identificador";

    $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY)); 


    $stmt -> execute(array(':identificador' => 4));
    $user_view = $stmt->fetchAll();
    // $stmt -> execute(array(':identificador' => 3));
    // $user_view3 = $stmt->fetchAll();
    // var_dump($user_view);
    // var_dump($user_view3);

    $mibdhash = $user_view[0]["password"];
    // echo $mibdhash;

    if(password_verify($micontrasena, $mibdhash)):
        echo "Acceso autorizado";
    else:
        echo "Acceso denegado";
    endif
?>