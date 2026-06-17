<?php
    // Archivo que maneja las alertas de la aplicación

    // --- MANEJO DE ERRORES ---
    if (isset($_GET['error'])) {
        $mensaje = "";
        $tipo = "danger"; // Color rojo de Bootstrap

        switch ($_GET['error']) {
            case 'cedula_duplicada':
                $mensaje = "<strong>Error:</strong> Esta cédula ya está registrada.";
                break;
            case 'correo_duplicado':
                $mensaje = "<strong>Error:</strong> Este correo electrónico ya está en uso.";
                break;
            case 'acceso_denegado':
                $mensaje = "<strong>Seguridad:</strong> Acceso no autorizado para ver los mensajes.";
                break;
            case 'campos_vacios':
            case 'campos_invalidos':
                $mensaje = "<strong>¡Atención!</strong> Por favor, llena todos los campos correctamente.";
                break;
            case 'invalid_credentials':
                $mensaje = "<strong>Error:</strong> Correo o contraseña incorrectos.";
                break;
            case 'clave_actual_incorrecta':
                $mensaje = "<strong>Error:</strong> La contraseña actual ingresada es incorrecta.";
                break;
            case 'reg_error':
            case 'db_error':
                $mensaje = "<strong>Error:</strong> Ocurrió un problema con la base de datos. Intenta de nuevo.";
                break;
            default:
                $mensaje = "Ocurrió un error inesperado.";
        }

        if ($mensaje !== "") {
            echo '
            <div class="alert alert-' . $tipo . ' alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> ' . $mensaje . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }

    // --- MANEJO DE ÉXITOS ---
    if (isset($_GET['status'])) {
        $mensaje_exito = "";

        switch ($_GET['status']) {
            // ¡AQUÍ ES DONDE DEBE ESTAR!
            case 'message_success':
                $mensaje_exito = "<strong>¡Enviado!</strong> Tu mensaje ha sido registrado con éxito. El autor se pondrá en contacto contigo.";
                break;
            case 'reg_success':
                $mensaje_exito = "<strong>¡Éxito!</strong> Tu cuenta ha sido creada. Ya puedes iniciar sesión.";
                break;
            case 'update_success':
                $mensaje_exito = "<strong>¡Actualizado!</strong> Tu información de perfil se guardó correctamente.";
                break;
            case 'password_success':
                $mensaje_exito = "<strong>¡Seguridad!</strong> Tu contraseña ha sido actualizada con éxito.";
                break;
        }

        if ($mensaje_exito !== "") {
            echo '
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> ' . $mensaje_exito . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
?>
