<?php
// 1. Inicializar
require_once '../session/create_session.php';
protect_page(); 

// 2. Importar la conexión a la base de datos y los componentes de POO
require_once 'connection_db.php';
require_once 'Archivo.php';
require_once 'FileUploader.php';

// Verificar que la petición sea estrictamente por el método POST y contenga el archivo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['documento'])) {
    
    // Captura del ID del usuario desde la sesión activa de la aplicación
    // Ajusta la clave ('id_usuario' o 'user_id') según cómo lo maneje tu create_session.php
    $userId = $_SESSION['id_usuario'] ?? ($_SESSION['user_id'] ?? null);

    if (!$userId) {
        // Si por alguna razón no hay ID de usuario en la sesión, denegar el proceso
        header("Location: subir_archivo.php?error=acceso_denegado");
        exit();
    }

    // 3. INSTANCIACIÓN POO: Crear el objeto Entidad (Modelo) y pasarle el ID del dueño
    $archivoModelo = new Archivo();
    $archivoModelo->setUsuariosIdUsuario($userId);

    // 4. INSTANCIACIÓN POO: Crear el servicio de carga apuntando a la carpeta destino
    // 'uploads' es el nombre del directorio local dentro de tu entorno de Docker
    $uploader = new FileUploader($conn, 'uploads');

    // 5. Ejecutar la lógica de validación y persistencia
    $resultado = $uploader->upload($_FILES['documento'], $archivoModelo);

    if ($resultado === true) {
        // Redirección exitosa: alerts.php pintará el banner verde de confirmación
        header("Location: subir_archivo.php?status=upload_success");
        exit();
    } else {
        // Redirección con error: Guardamos el mensaje específico devuelto por la clase en la sesión
        $_SESSION['upload_err_msg'] = $resultado;
        header("Location: subir_archivo.php?error=upload_error");
        exit();
    }
} else {
    // Si intentan entrar al archivo directamente escribiendo la URL en el navegador sin enviar nada
    header("Location: subir_archivo.php");
    exit();
}
?>