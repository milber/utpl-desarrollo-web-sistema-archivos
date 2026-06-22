<?php
require_once '../models/file.php';

class FileUploader {
    private $db;
    private $uploadDir;
    private $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png'];
    private $maxSize = 10 * 1024 * 1024; // Equivalente a 10 MB en bytes

    // Mimes permitidos en el servidor (image/jpeg cubre tanto .jpg como .jpeg)
    private $allowedMimes = [
        'application/pdf',
        'image/jpeg',
        'image/png'
    ];

    /**
     * Constructor de la clase Uploader
     */
    public function __construct($databaseConnection, $uploadDirectory = 'uploads/') {
        $this->db = $databaseConnection;

        // Normalizamos la ruta para asegurar que termine con una barra limpia '/'
        $this->uploadDir = rtrim($uploadDirectory, '/') . '/';
        
        // Verificamos si la carpeta existe en el entorno; si no, la creamos con permisos seguros
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
    }

    /**
     * Procesa la validación, almacenamiento en disco e inserción en la base de datos
     */
    public function upload($fileArray, File $file) {
        // Validar errores de carga nativos de la directiva de PHP
        if ($fileArray['error'] !== UPLOAD_ERR_OK) {
            return "Error al transferir el archivo al servidor.";
        }

        // Asignamos el nombre original y tamaño al modelo para su evaluación
        $file->setNombreOriginal($fileArray['name']);
        $file->setTamanio($fileArray['size']);
        $tmpName = $fileArray['tmp_name'];
        
        // Extraer y verificar la extensión del archivo
        $fileExtension = strtolower(pathinfo($file->getNombreOriginal(), PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $this->allowedTypes)) {
            return "Extensión no permitida (*." . implode(', *.', $this->allowedTypes) . ").";
        }

        // VALIDACIÓN DEL TIPO MIME REAL
        // Analiza el contenido real del archivo temporal dentro del contenedor Docker
        $realMime = mime_content_type($tmpName);
        if (!in_array($realMime, $this->allowedMimes)) {
            return "El contenido real del archivo no coincide con un formato permitido (Tipo MIME inválido).";
        }

        // Validar el límite de tamaño configurado (10MB)
        if ($file->getTamanio() > $this->maxSize) {
            return "El archivo excede el tamaño máximo permitido (10 MB).";
        }

        // Forzar a que el tipo se guarde con un formato de máximo 3 caracteres (ej: jpe para jpeg)
        $cleanExtension = substr($fileExtension, 0, 3);
        $file->setTipo($cleanExtension);
        
        // Criptografía: Generar un nombre hash único para evitar colisiones de archivos en el disco
        $uniqueName = bin2hex(random_bytes(16)) . '.' . $fileExtension;
        $file->setNombreArchivo($uniqueName);
        $file->setCarpeta($this->uploadDir);

        // Ruta final donde se alojará el archivo dentro del volumen de Docker
        $targetPath = $this->uploadDir . $uniqueName;

        // 4. Mover el archivo físico desde el directorio temporal al destino definitivo
        if (move_uploaded_file($tmpName, $targetPath)) {
            
            // 5. Persistencia: Preparación de la consulta SQL con sentencias preparadas para mitigar SQL Injection
            $sql = "INSERT INTO archivos (nombre_original, nombre_archivo, tipo, tamanio, carpeta, usuarios_id_usuario) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->db->prepare($sql);
            if ($stmt) {
                // Recuperamos los datos encapsulados dentro del objeto Modelo
                $nombreOriginal = $file->getNombreOriginal();
                $nombreArchivo  = $file->getNombreArchivo();
                $tipo           = $file->getTipo();
                $tamanio        = $file->getTamanio();
                $carpeta        = $file->getCarpeta();
                $usuarioId      = $file->getUsuariosIdUsuario();

                // Enlazamos las variables a los comodines de la consulta (s = string, i = entero)
                $stmt->bind_param(
                    "sssisi", 
                    $nombreOriginal, 
                    $nombreArchivo, 
                    $tipo, 
                    $tamanio, 
                    $carpeta, 
                    $usuarioId
                );
                
                try {
                    if ($stmt->execute()) {
                        $stmt->close();
                        return true; // Éxito total
                    } else {
                        unlink($targetPath);
                        return "Error al registrar los metadatos en la base de datos.";
                    }
                } 
                catch (mysqli_sql_exception $e) {
                    // Si ocurre un fallo en la base de datos, borramos el archivo físico para no dejar basura
                    unlink($targetPath);
                    $stmt->close();

                    // Detectar si el error específico es por la longitud del texto (Código de error MySQL: 1406)
                    if ($e->getCode() === 1406 || strpos($e->getMessage(), 'Data too long') !== false) {
                        return "El nombre original del archivo es demasiado largo (Máximo 50 caracteres).";
                    }

                    // Cualquier otro error de SQL imprevisto
                    return "Error de base de datos al procesar la carga: " . $e->getMessage();
                }
                // --- FIN DEL TRY-CATCH ---
            }
            return "Error crítico al preparar la consulta estructural SQL.";
        }

        return "El servidor no cuenta con permisos de escritura para mover el archivo al directorio destino.";
    }
}
?>
