<?php
class File {
    private $id;
    private $nombreOriginal;
    private $nombreArchivo;
    private $tipo;
    private $tamanio;
    private $carpeta;
    private $fechaSubida;
    private $usuariosIdUsuario;

    public function __construct($nombreOriginal = "", $nombreArchivo = "", $tipo = "", $tamanio = 0, $carpeta = "", $usuariosIdUsuario = 0, $id = null, $fechaSubida = null) {
        $this->id = $id;
        $this->nombreOriginal = $nombreOriginal;
        $this->nombreArchivo = $nombreArchivo;
        $this->tipo = $tipo;
        $this->tamanio = $tamanio;
        $this->carpeta = $carpeta;
        $this->fechaSubida = $fechaSubida;
        $this->usuariosIdUsuario = $usuariosIdUsuario;
    }

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getNombreOriginal() { return $this->nombreOriginal; }
    public function setNombreOriginal($nombreOriginal) { $this->nombreOriginal = $nombreOriginal; }

    public function getNombreArchivo() { return $this->nombreArchivo; }
    public function setNombreArchivo($nombreArchivo) { $this->nombreArchivo = $nombreArchivo; }

    public function getTipo() { return $this->tipo; }
    public function setTipo($tipo) { $this->tipo = substr($tipo, 0, 3); }

    public function getTamanio() { return $this->tamanio; }
    public function setTamanio($tamanio) { $this->tamanio = (int)$tamanio; }

    public function getCarpeta() { return $this->carpeta; }
    public function setCarpeta($carpeta) { $this->carpeta = $carpeta; }

    public function getFechaSubida() { return $this->fechaSubida; }
    public function setFechaSubida($fechaSubida) { $this->fechaSubida = $fechaSubida; }

    public function getUsuariosIdUsuario() { return $this->usuariosIdUsuario; }
    public function setUsuariosIdUsuario($usuariosIdUsuario) { $this->usuariosIdUsuario = (int)$usuariosIdUsuario; }

    public function getTamanioFormateado() {
        if ($this->tamanio >= 1048576) {
            return number_format($this->tamanio / 1048576, 2) . ' MB';
        } elseif ($this->tamanio >= 1024) {
            return number_format($this->tamanio / 1024, 2) . ' KB';
        }
        return $this->tamanio . ' bytes';
    }

    /**
     * Guarda los metadatos del archivo en la base de datos.
     */
    public function save(\mysqli $db, string $targetPath): true|string 
    {
        // Persistencia: Preparación de la consulta SQL con sentencias preparadas para mitigar SQL Injection
        $sql = "INSERT INTO archivos (nombre_original, nombre_archivo, tipo, tamanio, carpeta, usuarios_id_usuario) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $db->prepare($sql);
        if (!$stmt) {
            return "Error crítico al preparar la consulta estructural SQL.";
        }

        // Recuperamos los datos encapsulados dentro de las propiedades de este mismo objeto
        $nombreOriginal = $this->getNombreOriginal();
        $nombreArchivo  = $this->getNombreArchivo();
        $tipo           = $this->getTipo();
        $tamanio        = $this->getTamanio();
        $carpeta        = $this->getCarpeta();
        $usuarioId      = $this->getUsuariosIdUsuario();

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
                if (file_exists($targetPath)) {
                    unlink($targetPath);
                }
                return "Error al registrar los metadatos en la base de datos.";
            }
        } 
        catch (\mysqli_sql_exception $e) {
            // Si ocurre un fallo en la base de datos, borramos el archivo físico para no dejar basura
            if (file_exists($targetPath)) {
                unlink($targetPath);
            }
            $stmt->close();

            // Detectar si el error específico es por la longitud del texto o violación del CHECK Constraint
            if ($e->getCode() === 1406 || strpos($e->getMessage(), 'Data too long') !== false) {
                return "El nombre original del archivo es demasiado largo (Máximo 50 caracteres).";
            }
            
            // Capturar si el error es debido al CHECK constraint de MIMES q
            if ($e->getCode() === 3819 || strpos($e->getMessage(), 'chk_mimes_permitidos') !== false) {
                return "El tipo de archivo no está permitido por la base de datos.";
            }

            // Cualquier otro error de SQL imprevisto
            return "Error de base de datos al procesar la carga: " . $e->getMessage();
        }
    }
}
?>
