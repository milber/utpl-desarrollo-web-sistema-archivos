<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - UTPL</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-7 mb-5">
            
            <?php include 'alerts.php'; ?>

            <div class="card shadow-lg border-0 rounded-4 p-4">
                
                <div class="d-flex align-items-center mb-4 border-bottom pb-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; font-size: 20px;">
                        <i class="bi bi-send-fill"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">Formulario de Contacto</h3>
                        <p class="text-muted small mb-0">Envía un mensaje directamente a Miber</p>
                    </div>
                </div>

                <form action="insert_contact.php" method="POST" class="needs-validation" novalidate>
                    <div class="row g-3">
                        
                        <div class="col-12">
                            <label class="form-label text-secondary small fw-bold">NOMBRE COMPLETO</label>
                            <input type="text" name="contacto_nombre" class="form-control rounded-3" 
                                   value="<?php echo htmlspecialchars($_SESSION['user_nombre'] ?? ''); ?>" required>
                            <div class="invalid-feedback">Por favor, ingresa tu nombre.</div>
                        </div>

                        <div class="col-12">
                            <label class="form-label text-secondary small fw-bold">CORREO ELECTRÓNICO</label>
                            <input type="email" name="contacto_correo" class="form-control rounded-3" 
                                   value="<?php echo htmlspecialchars($_SESSION['user_correo'] ?? ''); ?>" required>
                            <div class="invalid-feedback">Por favor, ingresa un correo electrónico válido.</div>
                        </div>

                        <div class="col-12">
                            <label class="form-label text-secondary small fw-bold">MENSAJE</label>
                            <textarea name="contacto_mensaje" class="form-control rounded-3" rows="4" placeholder="Escribe tu mensaje aquí..." required></textarea>
                            <div class="invalid-feedback">El campo de mensaje no puede estar vacío.</div>
                        </div>

                        <div class="col-12 mt-4">
                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                <a href="author.php" class="text-decoration-none text-muted small">
                                    <i class="bi bi-arrow-left me-1"></i> Volver al Autor
                                </a>
                                <button type="submit" class="btn btn-primary px-5 rounded-3 shadow-sm">
                                    Enviar Mensaje <i class="bi bi-send ms-2"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    // Script para desactivar el envío si hay campos vacíos
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>