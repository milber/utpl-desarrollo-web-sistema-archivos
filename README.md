# Sistema de Gestión de Archivos Académicos (Sistema MACB)

Este es un módulo seguro de almacenamiento, descarga y eliminación de tareas y documentos, desarrollado bajo el paradigma de **Programación Orientada a Objetos (POO)** en PHP nativo, persistencia de datos relacional y despliegue contenedorizado.

---

## 🚀 Características Principales

* **Arquitectura MVC/POO:** Separación limpia de responsabilidades utilizando un Modelo de datos (`File`), Controladores de servicios independientes y Vistas dinámicas basadas en Bootstrap 5.
* **Mecanismo de Borrado Seguro:** El sistema implementa una confirmación de doble factor en la interfaz de usuario. Para eliminar un archivo, el usuario debe ingresar manualmente su nombre exacto, validándose tanto en el Frontend (JavaScript) como en el Backend (PHP).
* **Seguridad Perimetral (Hardening de Servidor):** Blindaje absoluto de la carpeta de almacenamiento contra ataques de ejecución remota de código (RCE).
* **Trazabilidad mediante Logs:** Instrumentación de logs estructurados (`error_log`) para auditar en tiempo real los payloads de las peticiones dentro del contenedor.

---

## 📂 Arquitectura del Módulo

El flujo del borrado seguro y control de archivos está distribuido de la siguiente manera:

```text
├── models/
│   └── file.php              # Modelo de Objeto: Abstracción de datos y métodos CRUD (save/delete)
├── services/
│   ├── get_files.php         # Controlador: Consulta y listado del repositorio
│   ├── download.php          # Controlador: Descarga forzada controlada por cabeceras HTTP
│   └── delete_file.php       # Controlador: Validación de payload y orquestación de borrado
├── views/
│   ├── files_list.php        # Vista: Tabla de archivos y Modal dinámico de confirmación
│   └── alerts.php            # Componente: Manejo unificado de alertas por URL ($_GET) y de Sesión ($_SESSION)
└── config/ (o raíz)
    └── 000-default.conf      # Configuración de Apache: Reglas estrictas de seguridad para /uploads

```

## 🔒 Directivas de Seguridad Implementadas
La carpeta /var/www/html/uploads se encuentra fortificada en la configuración de Apache (000-default.conf) mediante las siguientes capas defensivas:

Denegación por Defecto (Require all denied): Ningún usuario puede acceder o listar los archivos escribiendo la URL directa en el navegador. Las descargas se gestionan de forma controlada a través de PHP.

Neutralización de Ejecución (php_flag engine off): El motor de PHP está completamente apagado dentro de la carpeta. Si se aloja un script malicioso, Apache lo procesará como texto plano inofensivo.

Remoción de Handlers: Se eliminaron los manejadores de ejecución para extensiones críticas (.php, .phtml, .pl, .py, .sh, etc.).

Aislamiento de Overrides (AllowOverride None): Se ignora el procesamiento de archivos .htaccess en este directorio para evitar que configuraciones inyectadas reescriban las reglas del servidor raíz.

---
**Autor:** Milber Champutiz Burbano  
**Institución:** Universidad Técnica Particular de Loja (UTPL)  
**Materia:** Desarrollo Web  
**Ubicación:** Quito, Ecuador  
**Año:** 2026