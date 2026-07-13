<?php
require_once '../session/create_session.php';
protect_page(); // Validar que el usuario esté autenticado

// Validar que se haya enviado un nombre de archivo válido
if (empty($_GET['file'])) {
    die("Petición inválida.");
}

// Limpiar el nombre para evitar ataques de salto de directorio (Directory Traversal)
$fileName = basename($_GET['file']);

// Definir la ruta física absoluta dentro del contenedor Docker
$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
$filePath = $uploadDir . $fileName;

// Verificar que el archivo realmente exista en el almacenamiento
if (!file_exists($filePath)) {
    die("El archivo solicitado no existe en el repositorio.");
}

// Detectar el tipo MIME real del archivo en disco
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $filePath);
finfo_close($finfo);

// Forzar la descarga del archivo enviando las cabeceras HTTP correctas
header('Content-Description: File Transfer');
header('Content-Type: ' . $mimeType);
header('Content-Disposition: attachment; filename="' . $fileName . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($filePath));

// Limpiar el búfer de salida del sistema para evitar archivos corruptos
ob_clean();
flush();

// Leer el archivo de forma binaria interna y enviarlo al navegador
readfile($filePath);
exit;
?>