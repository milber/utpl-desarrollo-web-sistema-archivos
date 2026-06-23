<?php
// session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../connection_db.php';

$usuarioId = $_SESSION['id_usuario'] ?? 1; 
$archivos = [];
$link = $conn;
if (!$conn) {
    die("Error de Infraestructura: No se encontró una variable de conexión MySQLi válida (\$conexion, \$conn o \$db) en connection_db.php.");
}

$sql = "SELECT id, nombre_original, nombre_archivo, tipo, tamanio, fecha_subida
        FROM archivos 
        WHERE usuarios_id_usuario = ? 
        ORDER BY fecha_subida DESC";

$stmt = $link->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $usuarioId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $archivos[] = $row;
    }
    
    $stmt->close();
}
