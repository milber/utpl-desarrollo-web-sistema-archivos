<?php
 // Forzar a PHP a usar la zona horaria de Ecuador
date_default_timezone_set('America/Guayaquil');

require_once 'connection_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura y limpieza básica de los datos del formulario
    $nombre  =  htmlspecialchars(trim($_POST['contacto_nombre'] ?? ''));
    $correo  = filter_var($_POST['contacto_correo'], FILTER_SANITIZE_EMAIL);
    $mensaje = trim($_POST['contacto_mensaje'] ?? '');

    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($correo) || empty($mensaje)) {
        header("Location: contact.php?error=campos_vacios");
        exit();
    }

    // Validar formato de correo electrónico
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        header("Location: contact.php?error=campos_invalidos");
        exit();
    }

    // Preparar la sentencia SQL de inserción
    $sql = "INSERT INTO formulario_contacto (correo, nombre, mensaje) VALUES (?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sss", $correo, $nombre, $mensaje);
        
        // Ejecutar la consulta y verificar
        if ($stmt->execute()) {
            // Éxito: Redirige con un estado exitoso
            header("Location: contact.php?status=message_success");
        } else {
            // Error de Base de Datos
            header("Location: contact.php?error=db_error");
        }
        
        $stmt->close();
    } else {
        header("Location: contact.php?error=db_error");
    }
    
    $conn->close();
    exit();
} else {
    // Si se intenta acceder al archivo directamente por GET, se les regresa al formulario
    header("Location: contact.php");
    exit();
}
