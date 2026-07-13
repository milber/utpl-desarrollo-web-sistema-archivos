<?php
    # parametros de conección a la bd

    // El servidor está en Docker, la BD local
    // $host = "host.docker.internal"; 

    // Base de datos y servidor en local
    $host = "127.0.0.1";

    // Base de datos en docker y servidor en docker
    //$host = "db"; 

    $user = "macb_archivos";
    $pass = "MacbArchivos2026!";
    $db   = "macb_archivos";

    $conn = new mysqli($host, $user, $pass, $db, 3306);

    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    $conn->set_charset("utf8mb4");
?>
