-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Tempo de geração: 19-Set-2022 às 13:44
-- Versão do servidor: 8.0.18
-- versão do PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `jifs`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogador`
--

DROP TABLE IF EXISTS `jogador`;
CREATE TABLE IF NOT EXISTS `jogador` (
  `id_jogador` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `matricula` int(10) NOT NULL,
  `data_nascimento` date NOT NULL,
   `id_turma` VARCHAR(5),
  PRIMARY KEY (`id_jogador`)
) ENGINE= INNODB CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogador_modalidade`
--

DROP TABLE IF EXISTS `jogador_modalidade`;
CREATE TABLE IF NOT EXISTS `jogador_modalidade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_jogador` int(11),
  `id_modalidade` int(11),
  PRIMARY KEY (`id`)
)  ENGINE= INNODB CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Estrutura da tabela `modalidade`
--

DROP TABLE IF EXISTS `modalidade`;
CREATE TABLE IF NOT EXISTS `modalidade` (
  `id_modalidade` int(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(20),
  PRIMARY KEY (`id_modalidade`)
)  ENGINE= INNODB CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Estrutura da tabela `turma`
--

DROP TABLE IF EXISTS `turma`;
CREATE TABLE IF NOT EXISTS `turma` (
  `id_turma` VARCHAR(5) NOT NULL,
  `curso` varchar(20) NOT NULL,
  `ano` int(1) NOT NULL,
  PRIMARY KEY (`id_turma`)
)  ENGINE= INNODB CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `adm`
--

DROP TABLE IF EXISTS `adm`;
CREATE TABLE IF NOT EXISTS `adm` (
  `id_adm` int(11) NOT NULL AUTO_INCREMENT,
  `cargo` varchar(20) NOT NULL,
  `usuario` varchar(60) NOT NULL,
  `senha` varchar(16) NOT NULL,
  `id_representante` int(11),
  PRIMARY KEY (`id_adm`)
) ENGINE= INNODB CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Estrutura da tabela `representante`
--

DROP TABLE IF EXISTS `representante`;
CREATE TABLE IF NOT EXISTS `representante` (
  `id_representante` int(11) NOT NULL AUTO_INCREMENT,
  `id_turma` VARCHAR(5),
  PRIMARY KEY (`id_representante`)
)  ENGINE= INNODB CHARSET=utf8mb4;

COMMIT;

ALTER TABLE `jogador`
ADD FOREIGN KEY (`id_turma`)
REFERENCES turma(`id_turma`);

ALTER TABLE `jogador_modalidade`
ADD FOREIGN KEY (`id_jogador`)
REFERENCES jogador(`id_jogador`);

ALTER TABLE `jogador_modalidade`
ADD FOREIGN KEY (`id_modalidade`)
REFERENCES modalidade(`id_modalidade`);


ALTER TABLE `adm`
ADD FOREIGN KEY (`id_representante`)
REFERENCES representante(`id_representante`);

ALTER TABLE `representante`
ADD FOREIGN KEY (`id_turma`)
REFERENCES turma(`id_turma`);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;