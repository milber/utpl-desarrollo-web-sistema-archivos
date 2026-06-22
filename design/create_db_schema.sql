-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema macb_archivos
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `macb_archivos` ;

-- -----------------------------------------------------
-- Schema macb_archivos
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `macb_archivos` DEFAULT CHARACTER SET utf8 ;
USE `macb_archivos` ;

-- -----------------------------------------------------
-- Table `macb_archivos`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `macb_archivos`.`usuarios` (
  `id_usuario` INT NOT NULL AUTO_INCREMENT,
  `cedula` VARCHAR(10) NOT NULL,
  `nombre` VARCHAR(100) NOT NULL,
  `correo` VARCHAR(100) NOT NULL,
  `fecha_registro` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `clave_segura` VARCHAR(255) NOT NULL,
  UNIQUE INDEX `cedula_UNIQUE` (`cedula` ASC) VISIBLE,
  UNIQUE INDEX `correo_UNIQUE` (`correo` ASC) VISIBLE,
  PRIMARY KEY (`id_usuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `macb_archivos`.`archivos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `macb_archivos`.`archivos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre_original` VARCHAR(50) NOT NULL,
  `nombre_archivo` VARCHAR(100) NULL,
  `tipo` VARCHAR(3) NOT NULL,
  `tamanio` INT NOT NULL,
  `carpeta` VARCHAR(45) NOT NULL,
  `fecha_subida` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuarios_id_usuario` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_archivos_usuarios_idx` (`usuarios_id_usuario` ASC) VISIBLE,
  CONSTRAINT `fk_archivos_usuarios`
    FOREIGN KEY (`usuarios_id_usuario`)
    REFERENCES `macb_archivos`.`usuarios` (`id_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


-- -----------------------------------------------------
-- Creación de Usuario de Aplicación
-- -----------------------------------------------------
CREATE USER IF NOT EXISTS 'macb_archivos'@'%'
IDENTIFIED BY 'MacbArchivos2026!';

-- Permisos sobre la base
GRANT ALL PRIVILEGES
ON macb_archivos.*
TO 'macb_archivos'@'%';

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
