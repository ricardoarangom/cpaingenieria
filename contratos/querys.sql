ALTER TABLE `cpa`.`contrat` 
DROP COLUMN `entregables`,
DROP COLUMN `actividades`,
DROP COLUMN `alcance`;

ALTER TABLE `cpa`.`contrat` 
ADD COLUMN `incs` DECIMAL(16,2) NULL AFTER `IdCargo`,
ADD COLUMN `especialidad` VARCHAR(100) NULL AFTER `incs`,
ADD COLUMN `grupo` VARCHAR(45) NULL AFTER `especialidad`,
ADD COLUMN `centrofor` VARCHAR(100) NULL AFTER `grupo`;

CREATE TABLE `cpa`.`actividadescont` (
`IdActividad` INT NOT NULL AUTO_INCREMENT,
`IdContrato` INT NULL DEFAULT 0,
`actividad` VARCHAR(100) NULL,
PRIMARY KEY (`IdActividad`));


CREATE TABLE `cpa`.`resposabilidadescont` (
`IdResponsabilidad` INT NOT NULL AUTO_INCREMENT,
`IdContrato` INT NULL DEFAULT 0,
`responsabilidad` TEXT NULL,
PRIMARY KEY (`IdResponsabilidad`));

CREATE TABLE `cpa`.`productoscont` (
`IdProducto` INT NOT NULL AUTO_INCREMENT,
`IdContrato` INT NULL DEFAULT 0,
`producto` VARCHAR(255) NULL,
PRIMARY KEY (`IdProducto`));

CREATE TABLE `cpa`.`formapagocont` (
`IdFroma` INT NOT NULL AUTO_INCREMENT,
`IdContrato` INT NULL DEFAULT 0,
`porpago` DECIMAL(6,4) NULL DEFAULT 0,
`concepto` VARCHAR(100) NULL,
PRIMARY KEY (`IdFroma`));

CREATE TABLE `cpa`.`funcionescont` (
`IdFuncion` INT NOT NULL AUTO_INCREMENT,
`IdContrato` INT NULL DEFAULT 0,
`funcion` TEXT NULL,
PRIMARY KEY (`IdFuncion`));

ALTER TABLE `cpa`.`contratistas` 
CHANGE COLUMN `replegal` `replegal` VARCHAR(100) NULL DEFAULT NULL ;

ALTER TABLE `cpa`.`contratistas` 
ADD COLUMN `IdClasedocrep` INT NULL DEFAULT 0 AFTER `ciudadn`,
ADD COLUMN `docrep` VARCHAR(10) NULL AFTER `IdClasedocrep`;

ALTER TABLE `cpa`.`contrat` 
ADD COLUMN `alcance` TEXT NULL AFTER `centrofor`;

ALTER TABLE `cpa`.`contrat` 
DROP COLUMN `objetoool`;

--  nuevo
ALTER TABLE `cpa`.`contratistas` 
ADD COLUMN `munexp` INT NULL AFTER `docrep`;

ALTER TABLE `cpa`.`contrat` 
ADD COLUMN `lugar` INT NULL DEFAULT 0 AFTER `alcance`;

ALTER TABLE `cpa`.`contrat` 
ADD COLUMN `auxilio` DECIMAL(16,2) NULL DEFAULT 0 AFTER `lugar`;

