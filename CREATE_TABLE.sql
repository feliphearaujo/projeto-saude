-- MySQL Workbench Synchronization
-- Generated: 2023-10-26 14:45
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: diego

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE SCHEMA IF NOT EXISTS `banco_saude` DEFAULT CHARACTER SET utf8 ;

CREATE TABLE IF NOT EXISTS `banco_saude`.`paciente` (
  `idpaciente` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NULL DEFAULT NULL,
  `cpf` VARCHAR(15) NULL DEFAULT NULL,
  `telefone` VARCHAR(15) NULL DEFAULT NULL,
  `email` VARCHAR(100) NULL DEFAULT NULL,
  `senha` VARCHAR(45) NULL DEFAULT NULL,
  `particular` CHAR(1) NULL DEFAULT NULL,
  PRIMARY KEY (`idpaciente`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `banco_saude`.`medico` (
  `idmedico` INT(11) NOT NULL AUTO_INCREMENT,
  `idespecialidade` INT(11) NOT NULL,
  `nome` VARCHAR(100) NULL DEFAULT NULL,
  `crm` VARCHAR(45) NULL DEFAULT NULL,
  `email` VARCHAR(100) NULL DEFAULT NULL,
  `senha` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idmedico`),
  CONSTRAINT `fk_medico_especialidade1`
    FOREIGN KEY (`idespecialidade`)
    REFERENCES `banco_saude`.`especialidade` (`idespecialidade`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `banco_saude`.`consulta` (
  `idconsulta` INT(11) NOT NULL AUTO_INCREMENT,
  `idpaciente` INT(11) NOT NULL,
  `idmedico` INT(11) NOT NULL,
  `data` DATE NULL DEFAULT NULL,
  `hora` TIME NULL DEFAULT NULL,
  `finalizada` CHAR(1) NULL DEFAULT NULL,
  `observacao` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`idconsulta`),
  CONSTRAINT `fk_consulta_paciente`
    FOREIGN KEY (`idpaciente`)
    REFERENCES `banco_saude`.`paciente` (`idpaciente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_consulta_medico1`
    FOREIGN KEY (`idmedico`)
    REFERENCES `banco_saude`.`medico` (`idmedico`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `banco_saude`.`receituario` (
  `idreceituario` INT(11) NOT NULL,
  `idconsulta` INT(11) NOT NULL,
  `descricao` TEXT NULL DEFAULT NULL,
  PRIMARY KEY (`idreceituario`),
  CONSTRAINT `fk_receituario_consulta1`
    FOREIGN KEY (`idconsulta`)
    REFERENCES `banco_saude`.`consulta` (`idconsulta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `banco_saude`.`especialidade` (
  `idespecialidade` INT(11) NOT NULL AUTO_INCREMENT,
  `especialidade` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idespecialidade`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
