<?php
// Definir zona horaria
date_default_timezone_set('America/Guayaquil');
// crear session
session_start();
require_once 'connection_db.php';

// valicación de credenciales
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'login') {
    
    $correo = htmlspecialchars(trim($_POST['correo'] ?? ''));
    $password = $_POST['password'] ?? '';

    if (empty($correo) || empty($password)) {
        header("Location: login.php?error=campos_vacios");
        exit();
    }

    // preparación de la consulta
    $sql = "SELECT id_usuario, nombre, correo, cedula, clave_segura, fecha_registro FROM usuarios WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // verificar el hash almacenado en 'clave_segura'
        if (password_verify($password, $user['clave_segura'])) {
            
            // creación de sesióm
            session_regenerate_id(true); 
            $_SESSION['user_id'] = $user['id_usuario'];
            $_SESSION['user_nombre'] = $user['nombre'];
            $_SESSION['user_correo'] = $user['correo'];
            $_SESSION['user_cedula'] = $user['cedula'];
            $_SESSION['user_fecha_registro'] = $user['fecha_registro'];
            $_SESSION['start_time'] = time();

            // Redirección a los mensajes
            header("Location: messages.php");
            exit();
        }
    }

    // mostrar error de credenciales
    header("Location: login.php?error=invalid_credentials");
    exit();
}


// redirección a página principal si la session no está creada
function protect_page() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}
