<?php
// Forzar a PHP a usar la zona horaria de Ecuador
date_default_timezone_set('America/Guayaquil');

require_once 'create_session.php';
protect_page();

// CONTROL DE ACCESO: Solo permitir al usuario admin
// Si no existe el ID en la sesión o es diferente de 1, se le deniega el acceso
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    // Cerrar sesión si no es el usuario adminstrador
    $_SESSION = array();
    session_destroy();

    header("Location: login.php?error=acceso_denegado");
    exit();
}

require_once 'connection_db.php';

// Consultar todos los mensajes registrados, ordenados del más reciente al más antiguo
$sql = "SELECT id, nombre, correo, mensaje, fecha_registro FROM formulario_contacto ORDER BY fecha_registro DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandeja de Mensajes - UTPL</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        
        <div class="col-md-10 mb-5">
            
            <div class="card shadow-lg border-0 rounded-4 p-4">
                
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; font-size: 20px;">
                            <i class="bi bi-inbox-fill"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0">Mensajes Recibidos</h3>
                            <p class="text-muted small mb-0">Lectura de formularios de contacto</p>
                        </div>
                    </div>
                    <a href="logout.php" class="btn btn-outline-danger btn-sm rounded-3 px-3 d-inline-flex align-items-center">
                        <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                    </a>
                </div>

                <?php if ($result && $result->num_rows > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-top border-0">
                            <thead class="table-light text-secondary small fw-bold">
                                <tr>
                                    <th scope="col" class="ps-3" style="width: 7%;">ID</th>
                                    <th scope="col" style="width: 18%;">REMITENTE</th>
                                    <th scope="col" style="width: 20%;">CORREO</th>
                                    <th scope="col" style="width: 38%;">MENSAJE</th>
                                    <th scope="col" style="width: 17%;" class="pe-3">FECHA Y HORA</th>
                                </tr>
                            </thead>
                            <tbody class="text-secondary">
                                <?php while($row = $result->fetch_assoc()): ?>
                                    <tr class="border-bottom">
                                        <td class="fw-bold ps-3 text-primary">
                                            #<?php echo $row['id']; ?>
                                        </td>
                                        <td class="text-dark fw-semibold">
                                            <?php echo htmlspecialchars($row['nombre']); ?>
                                        </td>
                                        <td>
                                            <a href="mailto:<?php echo htmlspecialchars($row['correo']); ?>" class="text-decoration-none">
                                                <?php echo htmlspecialchars($row['correo']); ?>
                                            </a>
                                        </td>
                                        <td class="pe-3 lh-sm text-justify">
                                            <?php echo nl2br(htmlspecialchars($row['mensaje'])); ?>
                                        </td>
                                        <td class="pe-3 lh-sm text-justify">
                                            <?php echo date("d/m/Y H:i", strtotime($row['fecha_registro'])); ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <div class="text-muted display-1 mb-3">
                            <i class="bi bi-chat-left-dots"></i>
                        </div>
                        <h5 class="text-secondary fw-bold">No hay mensajes aún</h5>
                        <p class="text-muted small">Los mensajes que envíen desde el formulario aparecerán organizados aquí.</p>
                    </div>
                <?php endif; ?>

                <div class="border-top mt-4 pt-3 text-end">
                    <small class="text-muted">Quito, Ecuador &bull; Sistema de Administración 2026</small>
                </div>

            </div>
        </div>
    </div>
</div>

<?php 
// Cerrar los recursos de la base de datos
$result->free();
$conn->close();
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
