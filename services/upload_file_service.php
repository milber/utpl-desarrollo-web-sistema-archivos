<?php
// Inicializar
require_once '../session/create_session.php';
protect_page(); 

// Impports la base de datos y los componentes de POO
require_once '../connection_db.php';
require_once '../models/file.php';
require_once 'FileUploader.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['documento'])) {
    
    // Captura del ID del usuario desde la sesión activa de la aplicación
    $userId = $_SESSION['id_usuario'] ?? ($_SESSION['user_id'] ?? null);

    if (!$userId) {
        header("Location: upload_file.php?error=acceso_denegado");
        exit();
    }

    // INSTANCIACIÓN POO: Crear el objeto 
    $archivoModelo = new File();
    $archivoModelo->setUsuariosIdUsuario($userId);

    // INSTANCIACIÓN POO: Crear el servicio de carga apuntando a la carpeta destino
    // 'uploads' es el nombre del directorio local
    $uploader = new FileUploader($conn, 'uploads');

    // Ejecutar la lógica de validación y persistencia
    $resultado = $uploader->upload($_FILES['documento'], $archivoModelo);

    if ($resultado === true) {
        header("Location: ../views/upload_file.php?status=upload_success");
        exit();
    } else {
        $_SESSION['upload_err_msg'] = $resultado;
        header("Location: ../views/upload_file.php?error=upload_error");
        exit();
    }
} else {
    header("Location: ../views/upload_file.php");
    exit();
}
?>