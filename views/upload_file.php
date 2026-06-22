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
    <style>
        .custom-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
        .icon-circle {
            width: 60px;
            height: 60px;
            font-size: 24px;
        }
    </style>
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

                <form action="procesar_subida.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    
                    <div class="mb-4">
                        <label for="documento" class="form-label fw-semibold text-secondary small text-uppercase">Seleccionar Archivo</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-muted border-end-0 rounded-start-3">
                                <i class="bi bi-file-earmark-text"></i>
                            </span>
                            <input class="form-control border-start-0 rounded-end-3" type="file" id="documento" name="documento" required>
                            <div class="invalid-feedback">
                                Por favor, selecciona un archivo válido para continuar.
                            </div>
                        </div>
                        <div class="form-text text-muted small mt-2 ps-1">
                            <i class="bi bi-info-circle me-1"></i> Formatos admitidos: PDF, JPG, PNG (Máx. 10MB)
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
      const forms = document.querySelectorAll('.needs-validation')
      Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }
          form.classList.add('was-validated')
        }, false)
      })
    })()
</script>

<script src="../js/bootstrap.min.js"></script>
</body>
</html>
