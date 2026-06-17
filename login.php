<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        /* Estilo opcional para que el mensaje rojo se vea más vibrante */
        .invalid-feedback {
            font-size: 0.8em;
            font-weight: 500;
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            
            <?php include 'alerts.php'; ?>

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    
                    <div class="collapse show multi-collapse" id="login-form">
                        <h3 class="text-center mb-4 fw-bold">Bienvenido</h3>

                        <!-- Formulario de login  -->
                        <form action="create_session.php" method="POST" class="needs-validation" novalidate>
                            <input type="hidden" name="accion" value="login">
                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">CORREO ELECTRÓNICO</label>
                                <input type="email" name="correo" class="form-control" required>
                                <div class="invalid-feedback">Por favor, ingrese un correo válido.</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">CONTRASEÑA</label>
                                <input type="password" name="password" class="form-control" required>
                                <div class="invalid-feedback">La contraseña es obligatoria.</div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 shadow-sm">Entrar</button>
                        </form>
                    </div>

                    <div class="collapse multi-collapse" id="register-form">
                        <h3 class="text-center mb-4 fw-bold">Nueva Cuenta</h3>

                        <!-- Formulario de registro de nueva cuenta  -->
                        <form action="register.php" method="POST" class="needs-validation" novalidate onsubmit="return validatePasswords()">
                            <input type="hidden" name="accion" value="record">
                            
                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">NOMBRE</label>
                                <input type="text" name="nombre" class="form-control" required>
                                <div class="invalid-feedback">El nombre es requerido.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">CÉDULA</label>
                                <input type="text"
                                    name="cedula"
                                    id="cedula"
                                    class="form-control"
                                    required
                                    pattern="\d{10}"
                                    maxlength="10"
                                    minlength="10"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                <div class="invalid-feedback">La cédula debe tener exactamente 10 dígitos numéricos.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">CORREO</label>
                                <input type="email" name="correo" class="form-control" required>
                                <div class="invalid-feedback">Correo inválido.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">CONTRASEÑA</label>
                                <input type="password"
                                    id="reg_password"
                                    name="password"
                                    class="form-control"
                                    required
                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}">
                                <!-- Mensaje formato de la cedula -->
                                <div id="password-help" class="form-text text-info mt-2 fw-medium" style="font-size: 0.85rem;">
                                    La contraseña debe tener al menos 6 caracteres, incluyendo una mayúscula, una minúscula y un número.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">CONFIRMAR CONTRASEÑA</label>
                                <input type="password" id="confirm_password" class="form-control" required>
                                <div id="password-error" class="text-danger small mt-1 d-none">Las contraseñas no coinciden.</div>
                            </div>

                            <button type="submit" class="btn btn-success w-100 shadow-sm">Crear Cuenta</button>
                        </form>
                        <div class="text-center mt-4">
                            <span class="text-muted small">¿Ya tienes cuenta?</span><br>
                            <button type="button" class="btn btn-link text-decoration-none fw-bold" data-bs-toggle="collapse" data-bs-target=".multi-collapse">Inicia Sesión</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/bootstrap.min.js"></script>

<script>
    // Stilos de validación de campos
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

    // 2. Validación de contraseñas
    function validatePasswords() {
        const password = document.getElementById('reg_password').value;
        const confirm = document.getElementById('confirm_password').value;
        const errorElement = document.getElementById('password-error');

        if (password !== confirm) {
            errorElement.classList.remove('d-none');
            return false;
        }
        
        errorElement.classList.add('d-none');
        return true;
    }
</script>

<script>
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');

    // Lista de errores que deben mostrar el formulario de registro
    const erroresRegistro = ['cedula_duplicada', 'correo_duplicado', 'reg_error'];

    if (erroresRegistro.includes(error)) {
        // Lógica para alternar el collapse de Bootstrap
        const registerCollapse = new bootstrap.Collapse(document.getElementById('register-form'), { toggle: true });
        document.getElementById('login-form').classList.remove('show');
    }
</script>

<script>
    const passwordInput = document.getElementById('reg_password');
    const passwordHelp = document.getElementById('password-help');

    // Expresión regular que evalua el formato de la contraseña
    const passwordRegExp = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/;

    passwordInput.addEventListener('input', function() {
        if (passwordInput.value === "") {
            // Si está vacío, vuelve al color azul/info original
            passwordHelp.classList.remove('text-danger', 'text-success');
            passwordHelp.classList.add('text-info');
        } else if (passwordRegExp.test(passwordInput.value)) {
            // Si cumple los requisitos, se pone verde
            passwordHelp.classList.remove('text-info', 'text-danger');
            passwordHelp.classList.add('text-success');
        } else {
            // Si NO cumple mientras escribe, se pone ROJO
            passwordHelp.classList.remove('text-info', 'text-success');
            passwordHelp.classList.add('text-danger');
        }
    });
</script>

</body>
</html>