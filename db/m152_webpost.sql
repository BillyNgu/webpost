-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 28, 2018 at 06:24 AM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `m152_webpost`
--
CREATE DATABASE IF NOT EXISTS `m152_webpost` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `m152_webpost`;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `idComment` int(11) NOT NULL AUTO_INCREMENT,
  `titleComment` varchar(50) DEFAULT NULL,
  `commentary` text,
  `datePost` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifyDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `idUser` int(11) DEFAULT NULL,
  PRIMARY KEY (`idComment`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`idComment`, `titleComment`, `commentary`, `datePost`, `modifyDate`, `idUser`) VALUES
(47, 'Bonjour', 'Je suis Simon.', '2018-03-22 07:38:29', NULL, 16),
(84, 'WAIT', 'WAIT I SAID', '2018-03-22 14:18:07', NULL, 12),
(85, 'Bienvenue', 'Bienvenue sur le site WebPost', '2018-03-22 14:19:25', NULL, 12),
(93, 'THIS IS SHIT', 'AS FUCK 2\r\n', '2018-03-27 19:29:37', '2018-03-27 19:29:37', 11),
(94, 'Stop this shit', 'Stop smiling', '2018-03-27 19:18:40', '2018-03-27 19:38:56', 11),
(95, 'test', 'no image', '2018-03-27 20:18:30', NULL, 11);

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `idMedia` int(11) NOT NULL AUTO_INCREMENT,
  `typeMedia` varchar(50) NOT NULL,
  `nameMedia` text NOT NULL,
  `idComment` int(11) NOT NULL,
  PRIMARY KEY (`idMedia`),
  KEY `idComment` (`idComment`),
  KEY `idComment_2` (`idComment`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`idMedia`, `typeMedia`, `nameMedia`, `idComment`) VALUES
(8, 'image/jpeg', '84-WWDTM_logo_clr_stacked_highres.jpg', 84),
(9, 'image/jpeg', '85-1510755737.jpg', 85),
(12, 'image/png', '93-chrome_2017-01-11_20-52-13.png', 93),
(13, 'image/gif', '94-471ea881145186234499406963_700wa_0.gif', 94);

-- --------------------------------------------------------

--
-- Table structure for table `reinitkey`
--

DROP TABLE IF EXISTS `reinitkey`;
CREATE TABLE IF NOT EXISTS `reinitkey` (
  `idReinitkey` int(11) NOT NULL AUTO_INCREMENT,
  `keyValue` varchar(100) NOT NULL,
  `ExpirationDate` date NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idReinitkey`),
  KEY `fk_reinitkey_users_idx` (`idUser`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `salt` text NOT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `nickname` (`nickname`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idUser`, `firstname`, `lastname`, `nickname`, `email`, `password`, `salt`) VALUES
(11, 'Loic', 'Dubas', 'lodub', 'lodub@google.ch', 'ae47ca086b0ec4039fb7fa8132b05bd0fdc67c3d', 'e4e12fe1f2a68b4eef04e465a129286b95199dac'),
(12, 'Jorge', 'Goncalves', 'jorevan', 'goncj@google.ch', '5c02566c209028a05cd96e28a0d6a254972aa9bd', '1c929ccf2b0d2fa66b3ad8a4ec7a3be70c27ec8e'),
(14, 'Gregory', 'Preisig', 'chocolat2', 'gregp@google.ch', '63e258d20c8bdb8040b12c7888e9d9b09c830e18', '132487ef8cbd1a08512e113606586d4fd22eb6eb'),
(16, 'Simon', 'Cirilli', 'simcir', 'ciris@google.ch', '10c23613e600cb77f309cabf4c49598dd9a5a4ca', 'b31fd0868dc383d4a134e1578b17611853d57a23');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `reinitkey`
--
ALTER TABLE `reinitkey`
  ADD CONSTRAINT `reinitkey_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
