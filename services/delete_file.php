<?php
require_once '../session/create_session.php';
protect_page(); // Validar sesión activa

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../views/files_list.php");
    exit();
}

require_once __DIR__ . '/../connection_db.php';
require_once '../models/file.php';

$link = $conn;
if (!$link) {
    die("Error de conexión a la base de datos.");
}

$idArchivo = $_POST['id_archivo'] ?? 0;
$nombreConfirmacion = trim($_POST['nombre_confirmacion'] ?? '');
$nombreOriginal = trim($_POST['nombre_original'] ?? '');
$usuarioId = $_SESSION['id_usuario'] ?? 1;

// El nombre ingresado debe coincidir exactamente con el original
if ($nombreConfirmacion !== $nombreOriginal || empty($nombreConfirmacion)) {
    $_SESSION['error_upload'] = "El nombre ingresado no coincide con el archivo que deseas eliminar.";
    header("Location: ../views/files_list.php");
    exit();
}

$fileModel = new File();
$resultado = $fileModel->delete($link, $idArchivo, $usuarioId);

if ($resultado === true) {
    $_SESSION['error_upload'] = "Archivo eliminado correctamente.";
} else {
    $_SESSION['error_upload'] = "Error: " . $resultado;
}

header("Location: ../views/files_list.php");
exit();
?>
