<?php
    // terminar session
    session_start();
    session_unset();
    session_destroy();

    // redirección a página principal
    header("Location: ../views/login.php");
    exit();
?>
