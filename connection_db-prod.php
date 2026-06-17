<?php
    # parametros de conección a la bd

    // El servidor está en Docker, la BD local
    $host = "sql213.infinityfree.com"; 

    // Base de datos y servidor en local
    //$host = "localhost";

    // Base de datos en docker y servidor en docker
    //$host = "db"; 

    $user = "if0_41969548";
    $pass = "MeleahIwa100";
    $db   = "if0_41969548_macb_ape";

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    $conn->set_charset("utf8mb4");
?>


/*

Nombre de usuario MYSQL
if0_41969548


Hostname MySQL
sql213.infinityfree.com

Contraseña MySQL
MeleahIwa100

Puerto MySQL (opcional)
3306

Nombre de la base de datos	Acciones
if0_41969548_macb_ape


*/
