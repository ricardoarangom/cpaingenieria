ALTER TABLE `contrat` 
DROP COLUMN `entregables`,
DROP COLUMN `actividades`,
DROP COLUMN `alcance`;

ALTER TABLE `contrat` 
ADD COLUMN `incs` DECIMAL(16,2) NULL AFTER `IdCargo`,
ADD COLUMN `especialidad` VARCHAR(100) NULL AFTER `incs`,
ADD COLUMN `grupo` VARCHAR(45) NULL AFTER `especialidad`,
ADD COLUMN `centrofor` VARCHAR(100) NULL AFTER `grupo`;

CREATE TABLE `actividadescont` (
`IdActividad` INT NOT NULL AUTO_INCREMENT,
`IdContrato` INT NULL DEFAULT 0,
`actividad` VARCHAR(100) NULL,
PRIMARY KEY (`IdActividad`));


CREATE TABLE `resposabilidadescont` (
`IdResponsabilidad` INT NOT NULL AUTO_INCREMENT,
`IdContrato` INT NULL DEFAULT 0,
`responsabilidad` TEXT NULL,
PRIMARY KEY (`IdResponsabilidad`));

CREATE TABLE `productoscont` (
`IdProducto` INT NOT NULL AUTO_INCREMENT,
`IdContrato` INT NULL DEFAULT 0,
`producto` VARCHAR(255) NULL,
PRIMARY KEY (`IdProducto`));

CREATE TABLE `formapagocont` (
`IdFroma` INT NOT NULL AUTO_INCREMENT,
`IdContrato` INT NULL DEFAULT 0,
`porpago` DECIMAL(6,4) NULL DEFAULT 0,
`concepto` VARCHAR(100) NULL,
PRIMARY KEY (`IdFroma`));

CREATE TABLE `funcionescont` (
`IdFuncion` INT NOT NULL AUTO_INCREMENT,
`IdContrato` INT NULL DEFAULT 0,
`funcion` TEXT NULL,
PRIMARY KEY (`IdFuncion`));

ALTER TABLE `contratistas` 
CHANGE COLUMN `replegal` `replegal` VARCHAR(100) NULL DEFAULT NULL ;

ALTER TABLE `contratistas` 
ADD COLUMN `IdClasedocrep` INT NULL DEFAULT 0 AFTER `ciudadn`,
ADD COLUMN `docrep` VARCHAR(10) NULL AFTER `IdClasedocrep`;

ALTER TABLE `contrat` 
ADD COLUMN `alcance` TEXT NULL AFTER `centrofor`;

ALTER TABLE `contrat` 
DROP COLUMN `objetoool`;

--  nuevo
ALTER TABLE `contratistas` 
ADD COLUMN `munexp` INT NULL AFTER `docrep`;

ALTER TABLE `contrat` 
ADD COLUMN `lugar` INT NULL DEFAULT 0 AFTER `alcance`;

ALTER TABLE `contrat` 
ADD COLUMN `auxilio` DECIMAL(16,2) NULL DEFAULT 0 AFTER `lugar`;

