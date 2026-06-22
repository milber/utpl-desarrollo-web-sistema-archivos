<?php
require_once '../session/create_session.php';
protect_page(); // Tu función de validación de sesión activa
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Archivos - Sistema MACB</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            <?php include 'alerts.php'; ?>

            <div class="card custom-card p-4 mt-3">
                <div class="text-center mb-4">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center icon-circle mb-3">
                        <i class="bi bi-cloud-arrow-up-fill"></i>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark">Subir Archivo</h3>
                    <p class="text-muted small">Carga tus documentos digitales al servidor de forma segura</p>
                </div>

                <form action="../services/upload_file_service.php" method="POST" enctype="multipart/form-data" class="needs-validation" id="formUploader" novalidate>
                    
                    <div class="mb-4">
                        <label for="documento" class="form-label fw-semibold text-secondary small text-uppercase">Seleccionar Archivo</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-muted border-end-0 rounded-start-3">
                                <i class="bi bi-file-earmark-text"></i>
                            </span>
                            <input class="form-control border-start-0 rounded-end-3" 
                                   type="file"
                                   id="documento"
                                   name="documento"
                                   accept=".pdf, .jpg, ,jpeg, .png, application/pdf, image/jpeg, image/png"
                                   required>
                            <div class="invalid-feedback" id="feedback-documento">
                                Por favor, selecciona un archivo válido para continuar.
                            </div>
                        </div>
                        <div class="form-text text-muted small mt-2 ps-1">
                            <i class="bi bi-info-circle me-1"></i> Formatos admitidos: PDF, JPG, JPEG, PNG (Máx. 10MB)
                        </div>
                    </div>

                    <div class="d-grid gap-2 pt-2">
                        <button type="submit" class="btn btn-primary btn-lg rounded-3 fs-6 fw-semibold shadow-sm">
                            <i class="bi bi-file-earmark-arrow-up me-2"></i> Iniciar Carga
                        </button>
                        <a href="panel.php" class="btn btn-outline-secondary btn-sm rounded-3 mt-2 border-0 text-muted">
                            <i class="bi bi-arrow-left me-1"></i> Volver al Inicio
                        </a>
                    </div>
                </form>

            </div>
            
            <div class="text-center mt-4 border-top pt-3">
                <small class="text-muted text-uppercase tracking-wider" style="font-size: 11px;">
                    Quito, Ecuador &bull; UTPL 2026
                </small>
            </div>
            
        </div>
    </div>
</div>

<script>
    (() => {
      'use strict'
      const form = document.getElementById('formUploader');
      const fileInput = document.getElementById('documento');
      const feedback = document.getElementById('feedback-documento');

      // Tipos MIME permitidos que corresponden a PDF, JPG y PNG
      const allowedMimes = [
          'application/pdf',
          'image/jpeg',
          'image/png'
      ];
      
      // Peso máximo: 10 MB en bytes (10 * 1024 * 1024)
      const maxSizeBytes = 10485760;

      form.addEventListener('submit', event => {
        // Inicializar validación personalizada limpia
        fileInput.setCustomValidity('');
        feedback.innerHTML = "Por favor, selecciona un archivo válido para continuar.";

        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const fileMime = file.type;
            const fileSize = file.size;

            // 1. Validación estricta del tipo MIME en el Navegador
            if (!allowedMimes.includes(fileMime)) {
                fileInput.setCustomValidity('invalid_mime');
                feedback.innerHTML = "<strong>Error:</strong> El contenido real del archivo no es un formato válido (Solo PDF, JPG, PNG).";
                event.preventDefault();
                event.stopPropagation();
            }
            
            // 2. Validación complementaria de peso (Máx 10MB)
            if (fileSize > maxSizeBytes) {
                fileInput.setCustomValidity('invalid_size');
                feedback.innerHTML = "<strong>Error:</strong> El archivo excede el límite máximo permitido de 10 MB.";
                event.preventDefault();
                event.stopPropagation();
            }
        }

        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
        form.classList.add('was-validated')
      }, false)

      // Resetear la validación visual si el usuario cambia el archivo seleccionado
      fileInput.addEventListener('change', () => {
          fileInput.setCustomValidity('');
          form.classList.remove('was-validated');
      });
    })()
</script>

<script src="../js/bootstrap.min.js"></script>
</body>
</html>
