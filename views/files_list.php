<?php
require_once '../session/create_session.php';
protect_page(); // Tu función de validación de sesión activa
require_once __DIR__ . '/../services/get_files.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema MACB - Archivos Subidos</title>
    <link class="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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
            <div class="d-flex gap-2">
                <a href="../session/logout.php" class="btn btn-outline-danger shadow-sm">
                    <i class="bi bi-box-arrow-left me-2"></i>Cerrar Sesión
                </a>
                <a href="upload_file.php" class="btn btn-primary shadow-sm">
                    <i class="bi bi-plus-circle-fill me-2"></i>Subir Nuevo Archivo
                </a>
            </div>
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
                                                $ext = strtolower($arc['tipo'] ?? 'desconocido');
                                                if ($ext === 'pdf'): 
                                            ?>
                                                <i class="bi bi-file-earmark-pdf-fill text-danger h4 mb-0 me-3"></i>
                                            <?php else: ?>
                                                <i class="bi bi-file-earmark-image-fill text-success h4 mb-0 me-3"></i>
                                            <?php endif; ?>
                                            
                                            <span class="d-inline-block text-truncate text-dark font-weight-bold" style="max-width: 350px;" title="<?= htmlspecialchars($arc['nombre_original'] ?? 'Sin nombre') ?>">
                                                <?= htmlspecialchars($arc['nombre_original'] ?? 'Sin nombre') ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-secondary text-uppercase px-2 py-1.5">
                                            <?= htmlspecialchars($arc['tipo'] ?? 'N/A') ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-body font-weight-normal">
                                        <?php 
                                            $bytes = $arc['tamanio'] ?? 0;
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
                                        <div class="d-inline-flex gap-1">
                                            <a href="../services/download.php?file=<?= urlencode($arc['nombre_archivo'] ?? '') ?>" 
                                               class="btn btn-sm btn-outline-info">
                                                <i class="bi bi-cloud-arrow-down me-1"></i>Descargar
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger btn-delete-trigger"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal"
                                                    data-id="<?= $arc['id'] ?? 0 ?>"
                                                    data-nombre="<?= htmlspecialchars($arc['nombre_original'] ?? 'Archivo') ?>">
                                                <i class="bi bi-trash3-fill"></i> Eliminar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" isset-modal-focus tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-danger shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title fw-bold" id="deleteModalLabel"><i class="bi bi-exclamation-triangle-fill me-2"></i>¿Eliminar archivo definitivamente?</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="../services/delete_file.php" method="POST" id="formDeleteSecure">
                    <div class="modal-body text-dark">
                        <p>Esta acción destruirá el archivo del servidor y no podrá recuperarse.</p>
                        <p class="mb-3">Para confirmar, escribe el nombre exacto del archivo: <br><strong id="txtNombreArchivoMatch" class="text-danger"></strong></p>

                        <input type="hidden" name="id_archivo" id="modalIdArchivo">
                        <input type="hidden" name="nombre_original" id="modalNombreOriginal">

                        <input type="text"
                               class="form-control rounded-3"
                               id="inputNombreConfirmacion" 
                               name="nombre_confirmacion"
                               placeholder="Escribe el nombre aquí..."
                               autocomplete="off"
                               required>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-sm btn-danger fw-bold" id="btnConfirmarBorrado" disabled>
                            <i class="bi bi-trash3-fill me-1"></i>Eliminar Registro
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const deleteButtons = document.querySelectorAll('.btn-delete-trigger');
            const modalIdInput = document.getElementById('modalIdArchivo');
            const modalNombreInput = document.getElementById('modalNombreOriginal');
            const txtLabelMatch = document.getElementById('txtNombreArchivoMatch');
            const inputConfirm = document.getElementById('inputNombreConfirmacion');
            const btnSubmit = document.getElementById('btnConfirmarBorrado');

            deleteButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.getAttribute('data-id');
                    const nombre = btn.getAttribute('data-nombre');

                    modalIdInput.value = id;
                    modalNombreInput.value = nombre;
                    txtLabelMatch.textContent = nombre;

                    inputConfirm.value = "";
                    btnSubmit.disabled = true;
                });
            });

            inputConfirm.addEventListener('input', () => {
                if (inputConfirm.value.trim() === modalNombreInput.value.trim()) {
                    btnSubmit.disabled = false;
                } else {
                    btnSubmit.disabled = true;
                }
            });
        });
    </script>
</body>
</html>