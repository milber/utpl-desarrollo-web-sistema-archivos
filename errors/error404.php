<?php
// error404.php
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404 - Sistema MACB</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <style>
        .icon-circle { width: 80px; height: 80px; font-size: 40px; }
        .custom-card { border-radius: 1rem; border: none; box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1); }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            
            <div class="card custom-card p-5 text-center mt-3">
                <div class="mb-4">
                    <div class="bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center icon-circle mb-3">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark">Página no encontrada</h3>
                    <p class="text-muted small">Lo sentimos, el recurso que buscas no existe o ha sido movido.</p>
                </div>

                <div class="d-grid gap-2 pt-2">
                    <a href="../views/files_list.php" class="btn btn-primary btn-lg rounded-3 fs-6 fw-semibold shadow-sm">
                        <i class="bi bi-house-door me-2"></i> Volver al Listado
                    </a>
                </div>
            </div>
            
            <div class="text-center mt-4 border-top pt-3">
                <small class="text-muted text-uppercase tracking-wider" style="font-size: 11px;">
                    Quito, Ecuador &bull; UTPL 2026
                </small>
            </div>
            
        </div>
    </div>
</div>

<script src="../js/bootstrap.min.js"></script>
</body>
</html>