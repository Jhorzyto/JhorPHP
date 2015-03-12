/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1_3306
Source Server Version : 50617
Source Host           : 127.0.0.1:3306
Source Database       : framework

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-03-06 16:45:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for historicoacessos
-- ----------------------------
DROP TABLE IF EXISTS `historicoacessos`;
CREATE TABLE `historicoacessos` (
  `historioAcessoId` int(10) NOT NULL AUTO_INCREMENT,
  `usuarioId` int(10) NOT NULL,
  `historioAcessoData` datetime NOT NULL,
  `historioAcessoComputador` varchar(20) NOT NULL,
  `historioAcessoIp` varchar(20) NOT NULL,
  PRIMARY KEY (`historioAcessoId`),
  UNIQUE KEY `In_historioAcessoId` (`historioAcessoId`) USING BTREE,
  KEY `FK_historico_usuarioId` (`usuarioId`),
  CONSTRAINT `FK_historico_usuarioId` FOREIGN KEY (`usuarioId`) REFERENCES `usuarios` (`usuarioId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of historicoacessos
-- ----------------------------

-- ----------------------------
-- Table structure for privilegios
-- ----------------------------
DROP TABLE IF EXISTS `privilegios`;
CREATE TABLE `privilegios` (
  `privilegioId` int(10) NOT NULL AUTO_INCREMENT,
  `privilegioNome` varchar(50) NOT NULL,
  PRIMARY KEY (`privilegioId`),
  UNIQUE KEY `In_privilegioId` (`privilegioId`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of privilegios
-- ----------------------------
INSERT INTO `privilegios` VALUES ('1', 'Administrador');

-- ----------------------------
-- Table structure for setores
-- ----------------------------
DROP TABLE IF EXISTS `setores`;
CREATE TABLE `setores` (
  `setorId` int(10) NOT NULL AUTO_INCREMENT,
  `setorNome` varchar(50) NOT NULL,
  PRIMARY KEY (`setorId`),
  UNIQUE KEY `In_setorId` (`setorId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of setores
-- ----------------------------
INSERT INTO `setores` VALUES ('1', 'Administrativo');

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `usuarioId` int(10) NOT NULL AUTO_INCREMENT,
  `usuarioNomeCompleto` varchar(50) NOT NULL,
  `usuarioNomeUsuario` varchar(14) NOT NULL,
  `usuarioSenha` varchar(120) NOT NULL,
  `usuarioEmail` varchar(50) NOT NULL,
  `usuarioStatusAcesso` int(2) NOT NULL DEFAULT '1',
  `privilegioId` int(2) NOT NULL,
  `setorId` int(2) NOT NULL,
  PRIMARY KEY (`usuarioId`),
  UNIQUE KEY `In_usuarioId` (`usuarioId`),
  KEY `FK_usuario_setorId` (`setorId`),
  KEY `FK_usuario_privilegioId` (`privilegioId`),
  CONSTRAINT `FK_usuario_privilegioId` FOREIGN KEY (`privilegioId`) REFERENCES `privilegios` (`privilegioId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_usuario_setorId` FOREIGN KEY (`setorId`) REFERENCES `setores` (`setorId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES ('1', 'Administrador', 'admin', '$2y$10$yZoP/FONjGymwlmWiQVrQu02pJ/JAm8XuLa5WnLd9KZvC6qGHhbTm', 'admin@admin.com', '1', '1', '1');
