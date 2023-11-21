-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema banco_reelfriends
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema banco_reelfriends
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `banco_reelfriends` DEFAULT CHARACTER SET utf8 ;
USE `banco_reelfriends` ;

-- -----------------------------------------------------
-- Table `banco_reelfriends`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `banco_reelfriends`.`usuario` (
  `idusuario` INT NOT NULL AUTO_INCREMENT,
  `nome_usuario` VARCHAR(60) NOT NULL,
  `email_usuario` VARCHAR(50) NOT NULL,
  `senha_usuario` VARCHAR(130) NOT NULL,
  `biografia_usuario` TEXT(350) NULL,
  PRIMARY KEY (`idusuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `banco_reelfriends`.`genero`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `banco_reelfriends`.`genero` (
  `idgenero` INT NOT NULL AUTO_INCREMENT,
  `descricao_genero` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`idgenero`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `banco_reelfriends`.`categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `banco_reelfriends`.`categoria` (
  `idcategoria` INT NOT NULL AUTO_INCREMENT,
  `descricao_categoria` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`idcategoria`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `banco_reelfriends`.`diretor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `banco_reelfriends`.`diretor` (
  `iddiretor` INT NOT NULL AUTO_INCREMENT,
  `nome_diretor` VARCHAR(60) NOT NULL,
  `biografia_diretor` TEXT(350) NULL,
  PRIMARY KEY (`iddiretor`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `banco_reelfriends`.`producao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `banco_reelfriends`.`producao` (
  `idproducao` INT NOT NULL AUTO_INCREMENT,
  `titulo_producao` VARCHAR(50) NOT NULL,
  `sinopse_producao` TEXT(500) NOT NULL,
  `genero_idgenero` INT NOT NULL,
  `categoria_idcategoria` INT NOT NULL,
  `diretor_iddiretor` INT NOT NULL,
  PRIMARY KEY (`idproducao`),
  INDEX `fk_producao_genero1_idx` (`genero_idgenero` ASC),
  INDEX `fk_producao_categoria1_idx` (`categoria_idcategoria` ASC),
  INDEX `fk_producao_diretor1_idx` (`diretor_iddiretor` ASC),
  CONSTRAINT `fk_producao_genero1`
    FOREIGN KEY (`genero_idgenero`)
    REFERENCES `banco_reelfriends`.`genero` (`idgenero`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producao_categoria1`
    FOREIGN KEY (`categoria_idcategoria`)
    REFERENCES `banco_reelfriends`.`categoria` (`idcategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producao_diretor1`
    FOREIGN KEY (`diretor_iddiretor`)
    REFERENCES `banco_reelfriends`.`diretor` (`iddiretor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `banco_reelfriends`.`usuario_segue_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `banco_reelfriends`.`usuario_segue_usuario` (
  `usuario_idusuario` INT NOT NULL,
  `usuario_idusuario1` INT NOT NULL,
  PRIMARY KEY (`usuario_idusuario`, `usuario_idusuario1`),
  INDEX `fk_usuario_has_usuario_usuario1_idx` (`usuario_idusuario1` ASC),
  INDEX `fk_usuario_has_usuario_usuario_idx` (`usuario_idusuario` ASC),
  CONSTRAINT `fk_usuario_has_usuario_usuario`
    FOREIGN KEY (`usuario_idusuario`)
    REFERENCES `banco_reelfriends`.`usuario` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_usuario_usuario1`
    FOREIGN KEY (`usuario_idusuario1`)
    REFERENCES `banco_reelfriends`.`usuario` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `banco_reelfriends`.`usuario_favorita_producao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `banco_reelfriends`.`usuario_favorita_producao` (
  `usuario_idusuario` INT NOT NULL,
  `producao_idproducao` INT NOT NULL,
  PRIMARY KEY (`usuario_idusuario`, `producao_idproducao`),
  INDEX `fk_usuario_has_producao_producao1_idx` (`producao_idproducao` ASC),
  INDEX `fk_usuario_has_producao_usuario1_idx` (`usuario_idusuario` ASC),
  CONSTRAINT `fk_usuario_has_producao_usuario1`
    FOREIGN KEY (`usuario_idusuario`)
    REFERENCES `banco_reelfriends`.`usuario` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_producao_producao1`
    FOREIGN KEY (`producao_idproducao`)
    REFERENCES `banco_reelfriends`.`producao` (`idproducao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `banco_reelfriends`.`usuario_comenta_producao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `banco_reelfriends`.`usuario_comenta_producao` (
  `usuario_idusuario` INT NOT NULL,
  `producao_idproducao` INT NOT NULL,
  `comentario` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`usuario_idusuario`, `producao_idproducao`),
  INDEX `fk_usuario_has_producao_producao2_idx` (`producao_idproducao` ASC),
  INDEX `fk_usuario_has_producao_usuario2_idx` (`usuario_idusuario` ASC),
  CONSTRAINT `fk_usuario_has_producao_usuario2`
    FOREIGN KEY (`usuario_idusuario`)
    REFERENCES `banco_reelfriends`.`usuario` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_producao_producao2`
    FOREIGN KEY (`producao_idproducao`)
    REFERENCES `banco_reelfriends`.`producao` (`idproducao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `banco_reelfriends`.`usuario_avalia_producao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `banco_reelfriends`.`usuario_avalia_producao` (
  `usuario_idusuario` INT NOT NULL,
  `producao_idproducao` INT NOT NULL,
  `nota` INT(1) NOT NULL,
  PRIMARY KEY (`usuario_idusuario`, `producao_idproducao`),
  INDEX `fk_usuario_has_producao_producao3_idx` (`producao_idproducao` ASC),
  INDEX `fk_usuario_has_producao_usuario3_idx` (`usuario_idusuario` ASC),
  CONSTRAINT `fk_usuario_has_producao_usuario3`
    FOREIGN KEY (`usuario_idusuario`)
    REFERENCES `banco_reelfriends`.`usuario` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_producao_producao3`
    FOREIGN KEY (`producao_idproducao`)
    REFERENCES `banco_reelfriends`.`producao` (`idproducao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

INSERT INTO `categoria` (`idcategoria`, `descricao_categoria`) VALUES (NULL, 'Filme'), (NULL, 'Série');

INSERT INTO `genero` (`idgenero`, `descricao_genero`) VALUES (NULL, 'Ação'), (NULL, 'Terror'), (NULL, 'Suspense'), (NULL, 'Drama'), (NULL, 'Comédia'), (NULL, 'Ficção Científica'), (NULL, 'Aventura');