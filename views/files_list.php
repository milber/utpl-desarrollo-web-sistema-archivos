<?php
require_once __DIR__ . '/../services/get_files.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema MACB - Archivos Subidos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

    <div class="container py-5">

        <?php include 'alerts.php'; ?>
        
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-secondary">
            <div>
                <h1 class="h2 font-weight-bold mb-1 text-white">Repositorio de Archivos</h1>
                <p class="text-muted small mb-0">Listado de tareas y documentos del sistema académico.</p>
            </div>
            <a href="upload_file.php" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-circle-fill me-2"></i>Subir Nuevo Archivo
            </a>
        </div>

        <div class="card border-secondary shadow-lg overflow-hidden">
            <?php if (empty($archivos)): ?>
                <div class="card-body py-5 text-center text-muted">
                    <i class="bi bi-folder-symlink h1 d-block mb-3 text-secondary"></i>
                    <p class="mb-0 font-weight-medium">No hay archivos registrados en el sistema.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light text-uppercase small font-weight-bold">
                            <tr>
                                <th class="px-4 py-3" scope="col">Nombre Original</th>
                                <th class="px-4 py-3" scope="col">Extensión</th>
                                <th class="px-4 py-3" scope="col">Tamaño</th>
                                <th class="px-4 py-3" scope="col">Fecha de Subida</th>
                                <th class="px-4 py-3 text-end" scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($archivos as $arc): ?>
                                <tr>
                                    <td class="px-4 py-3 font-weight-bold text-white">
                                        <div class="d-flex align-items-center">
                                            <?php 
                                                $ext = strtolower($arc['tipo']);
                                                if ($ext === 'pdf'): 
                                            ?>
                                                <i class="bi bi-file-earmark-pdf-fill text-danger h4 mb-0 me-3"></i>
                                            <?php else: ?>
                                                <i class="bi bi-file-earmark-image-fill text-success h4 mb-0 me-3"></i>
                                            <?php endif; ?>
                                            
                                            <span class="d-inline-block text-truncate text-dark font-weight-bold" style="max-width: 350px;" title="<?= htmlspecialchars($arc['nombre_original']) ?>">
                                                <?= htmlspecialchars($arc['nombre_original']) ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-secondary text-uppercase px-2 py-1.5">
                                            <?= htmlspecialchars($arc['tipo']) ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-body font-weight-normal">
                                        <?php 
                                            $bytes = $arc['tamanio'];
                                            if ($bytes >= 1048576) {
                                                echo number_format($bytes / 1048576, 2) . ' MB';
                                            } else {
                                                echo number_format($bytes / 1024, 2) . ' KB';
                                            }
                                        ?>
                                    </td>
                                    <td class="px-4 py-3 text-muted">
                                        <?= date('d/m/Y H:i', strtotime($arc['fecha_subida'] ?? 'now')) ?>
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <a href="/uploads/<?= urlencode($arc['nombre_archivo']) ?>" 
                                           target="_blank" 
                                           class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-box-arrow-up-right me-1"></i>Ver
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        
    </div>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>