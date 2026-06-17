# Sistema de Formulario de Contacto- Proyecto Académico UTPL

Este es un proyecto académico desarrollado para la materia de **Desarrollo Web** en la carrera de **Tecnologías de la Información**. La aplicación consiste en un sistema que muestre una página informativa, y presente un formulario de contacto. Además se ha agregado que un usuario admin pueed listar los mensajes de contacto recibidos.

## 🛠️ Stack Tecnológico
* **Lenguaje:** PHP 8.x
* **Base de Datos:** MySQL 8.0
* **Frontend:** HTML5, CSS3, JavaScript (ES6+)
* **Framework CSS:** Bootstrap 5.3 (Estilos modernos y responsivos)
* **Iconografía:** Bootstrap Icons

## 📋 Requerimientos Técnicos
1.  **Servidor Web:** Apache (recomendado a través de XAMPP, WAMP o Laragon).
2.  **PHP:** Versión 7.4 o superior (Compatible con PHP 8).
3.  **Gestor de BD:** MySQL / MariaDB.
4.  **Extensión MySQLi:** Habilitada en PHP para la conexión a la base de datos.

## 🚀 Configuración e Instalación

### 1. Clona el proyecto
https://github.com/milber/utpl-desarrollo_web-apeb1


### 2. Preparación de la Base de Datos
Debes ejecutar el script de SQL proporcionado en https://github.com/milber/utpl-desarrollo_web-apeb1/blob/master/design/create_db_schema.sql para configurar el entorno. El script realiza lo siguiente:

* Crea el esquema `macb_ape`.
* Crea la tabla `usuarios` con restricciones de unicidad para Cédula y Correo.
* Crea un usuario de base de datos específico (`macb_app`) con permisos restringidos por seguridad.
* Crea la tabla `formulario contacto`.
* Inserta un usuario **Administrador** por defecto.

**Pasos:**
1. Abre MySQL Workbench ,phpMyAdmin o cualquier cliente de base de datos que permita acceso a MySQL.
2. Coneectate con un usuario con los privilegios para crear un schema
3. Copia y pega el contenido del archivo de creación de base de datos.
4. Ejecuta el script completo.

**Credenciales de Administrador por defecto:**
* **Usuario:** `admin@admin.com`
* **Contraseña:** `Pa55word`

### 3. Funcionamiento en ambiente de desarrollo
1. Asegúrate de que el archivo de conexión (`connection_db.php`) tenga las credenciales del usuario `macb_app` creadas en el script SQL.
2. Inicia los módulos de Apache y MySQL, puedes usar el tu panel de control (XAMPP).
3. Abre tu navegador y accede a `http://localhost:8080/`. Nota, el puerto puede cambiar de acuerdo a tu configuració local.

## 📂 Estructura del Proyecto
* `index.php`: Carátula académica y redirección inicial.
* `login.php`: Formularios de acceso para el usuario admin.
* `create_session.php`: Crea la sessión.
* `author.php`: Visualización de información pública del autro.
* `contact.php`: Interfaces de formulario de contacto.
* `insert_contact.php`: Lógica de procesamiento el formulario de contacto.
* `alerts.php`: Componente centralizado de mensajes y notificaciones.


# Sistema de Formulario de Contacto - Proyecto Académico UTPL

URL de inicio:  https://milber.free.nf/index.html

Para ingresar como adminstrador:  https://milber.free.nf/login.php


* `correo`      : admin@admin.com
* `contraseña` : Pa55word

Nota: Se agregó una página para que el administrador revise los mensajes recibidos


---
**Autor:** Milber Champutiz Burbano  
**Institución:** Universidad Técnica Particular de Loja (UTPL)  
**Materia:** Desarrollo Web  
**Ubicación:** Quito, Ecuador  
**Año:** 2026