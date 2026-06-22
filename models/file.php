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
}
?>
