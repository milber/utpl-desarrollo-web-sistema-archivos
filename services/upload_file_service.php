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

    // 3. INSTANCIACIÓN POO: Crear el objeto Entidad (Modelo) y pasarle el ID del dueño
    $archivoModelo = new File();
    $archivoModelo->setUsuariosIdUsuario($userId);

    // 4. INSTANCIACIÓN POO: Crear el servicio de carga apuntando a la carpeta destino
    // 'uploads' es el nombre del directorio local dentro de tu entorno de Docker
    $uploader = new FileUploader($conn, 'uploads');

    // 5. Ejecutar la lógica de validación y persistencia
    $resultado = $uploader->upload($_FILES['documento'], $archivoModelo);

    if ($resultado === true) {
        // Redirección exitosa: alerts.php pintará el banner verde de confirmación
        header("Location: ../views/upload_file.php?status=upload_success");
        exit();
    } else {
        // Redirección con error: Guardamos el mensaje específico devuelto por la clase en la sesión
        $_SESSION['upload_err_msg'] = $resultado;
        header("Location: ../views/upload_file.php?error=upload_error");
        exit();
    }
} else {
    // Si intentan entrar al archivo directamente escribiendo la URL en el navegador sin enviar nada
    header("Location: ../views/upload_file.php");
    exit();
}
?>