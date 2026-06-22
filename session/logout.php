<?php
    // terminar session
    session_start();
    session_unset();
    session_destroy();

    // redirección a clase principal
    header("Location: author.php");
    exit();
?>
