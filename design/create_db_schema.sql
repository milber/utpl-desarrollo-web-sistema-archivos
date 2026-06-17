-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema macb_ape
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `macb_archivos` ;

-- -----------------------------------------------------
-- Schema macb_ape
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `macb_ape` DEFAULT CHARACTER SET utf8 ;
USE `macb_archivos` ;

-- -----------------------------------------------------
-- Table `macb_archivos`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `macb_archivos`.`usuarios` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `cedula` VARCHAR(10) NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `correo` VARCHAR(100) NOT NULL,
  `clave_segura` VARCHAR(255) NOT NULL,
  `fecha_registro` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE INDEX `cedula_UNIQUE` (`cedula` ASC) VISIBLE,
  UNIQUE INDEX `correo_UNIQUE` (`correo` ASC) VISIBLE,
  PRIMARY KEY (`id_usuario`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `macb_archivos`.`formulario_contacto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `macb_ape`.`formulario_contacto` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `correo` VARCHAR(45) NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `mensaje` LONGTEXT NOT NULL,
  `fecha_registro` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- User for app
CREATE USER IF NOT EXISTS 'macb_app'@'localhost'
IDENTIFIED BY 'MacbApp2026!';

-- Permisos sobre la base
GRANT ALL PRIVILEGES
ON macb_ape.*
TO 'macb_app'@'localhost';

FLUSH PRIVILEGES;


-- -----------------------------------------------------
-- Inserción de Usuario Administrador
-- -----------------------------------------------------
USE `macb_archivos` ;

INSERT INTO `usuarios`
(cedula, nombre, correo, clave_segura)
VALUES
(
  '9999999999',
  'Usuario Administrador',
  'admin@admin.com',
  '$2y$10$deTbZS.i3oEcOKY2OEJ1UeHypLc8tU/zrl2K3thRZysaoXvkQ1Wfe'
);
