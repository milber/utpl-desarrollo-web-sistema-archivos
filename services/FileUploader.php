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
    public function __construct($databaseConnection, $uploadDirectory = 'uploads') {
        $this->db = $databaseConnection;

        // Limpiamos barras iniciales o finales que se pasen por parámetro
        $cleanPath = trim($uploadDirectory, '/\\');

        // Agregando el archivo a: /var/www/html/uploads/
        $this->uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/' . $cleanPath . '/';
        
        // Verificamos si la carpeta existe en la raíz del servidor; si no, la creamos
        if (!file_exists($this->uploadDir)) {
            // El tercer parámetro 'true' permite la creación de directorios recursivos seguros
            mkdir($this->uploadDir, 0750, true);
        }
    }

    /**
     * Procesa la validación, almacenamiento en disco y delega la persistencia al modelo
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

        // Forzar a que el tipo se guarde con un formato de máximo 4 caracteres (ej: jpe para jpeg)
        $cleanExtension = substr($fileExtension, 0, 4);
        $file->setTipo($cleanExtension);
        
        // Generar un nombre hash único para evitar colisiones de archivos en el disco
        $uniqueName = bin2hex(random_bytes(16)).'-'.$file->getNombreOriginal();
        $file->setNombreArchivo($uniqueName);
        $file->setCarpeta($this->uploadDir);

        // Ruta final donde se alojará el archivo dentro del volumen de Docker
        $targetPath = $this->uploadDir . $uniqueName;

        // Mover el archivo físico desde el directorio temporal al destino definitivo
        if (move_uploaded_file($tmpName, $targetPath)) {
            return $file->save($this->db, $targetPath); 
        }

        return "El servidor no cuenta con permisos de escritura para mover el archivo al directorio destino.";
    }
}
?>