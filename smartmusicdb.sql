-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2023 at 08:35 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `smartmusicdb`

-- --------------------------------------------------------

CREATE TABLE `Artista` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `data_nascimento` date NOT NULL,
  `nacionalidade` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `Musica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `duracao` varchar(4) NOT NULL,
  `ano` int(11) DEFAULT NULL,
  `album_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `album_id` (`album_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `Album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `data_lancamento` date DEFAULT NULL,
  `artista_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `artista_id` (`artista_id`),
  CONSTRAINT `album_ibfk_1` FOREIGN KEY (`artista_id`) REFERENCES `artista` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Inserindo registros para a tabela `artista`
INSERT INTO `Artista` (`nome`, `data_nascimento`, `nacionalidade`) VALUES
('Beyoncé', '1981-09-04', 'Estados Unidos'),
('Ed Sheeran', '1991-02-17', 'Reino Unido'),
('Rihanna', '1988-02-20', 'Barbados'),
('Bruno Mars', '1985-10-08', 'Estados Unidos'),
('Adele', '1988-05-05', 'Reino Unido');

-- Inserindo registros para a tabela `album`
INSERT INTO `Album` (`titulo`, `data_lancamento`, `artista_id`) VALUES
('Lemonade', '2016-04-23', 1),
('÷ (Divide)', '2017-03-03', 2),
('Anti', '2016-01-28', 3),
('24K Magic', '2016-11-18', 4),
('25', '2015-11-20', 5);

-- Inserindo registros para a tabela `musica`
INSERT INTO `Musica` (`titulo`, `duracao`, `ano`, `album_id`) VALUES
('Formation', '04:52', NULL, 1),
('Shape of You', '03:54', 2017, 2),
('Work (feat. Drake)', '03:39', 2016, 3),
('24K Magic', '03:46', NULL, 4),
('Hello', '04:55', 2015, 5);

COMMIT;
