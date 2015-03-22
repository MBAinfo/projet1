-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 22 Mars 2015 à 14:35
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `gfs_projet`
--
CREATE DATABASE IF NOT EXISTS `gfs_projet` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `gfs_projet`;

-- --------------------------------------------------------

--
-- Structure de la table `gfs_hashtag`
--

DROP TABLE IF EXISTS `gfs_hashtag`;
CREATE TABLE IF NOT EXISTS `gfs_hashtag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) NOT NULL,
  `id_message` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tag` (`tag`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Contenu de la table `gfs_hashtag`
--

INSERT INTO `gfs_hashtag` (`id`, `tag`, `id_message`) VALUES
(1, '@stephan', 1),
(2, '@stephan', 2),
(3, '@benjamin', 2),
(4, '@guillaume', 2),
(5, '@stephan', 3),
(6, '#projetMBA', 3),
(7, '@stephan', 4),
(8, '@guillaume', 4),
(9, '@benjamin', 4),
(10, '@jdo', 4),
(11, '#039', 4),
(12, '#projetMBA', 4),
(13, '@stephan', 5),
(14, '#projetMBA', 5),
(15, '@stephan', 6),
(16, '@benjamin', 6),
(17, '#todo', 6),
(18, '#projetMBA', 6),
(19, '@stephan', 7),
(20, '@guillaume', 7),
(21, '@stephan', 8),
(22, '@', 8),
(23, '#039', 8),
(24, '#', 8),
(25, '#039', 8),
(26, '@stephan', 9),
(27, '#document', 9),
(28, '#projetMBA', 9),
(29, '@stephan', 10),
(30, '#039', 10),
(31, '#projetMBA', 10);

-- --------------------------------------------------------

--
-- Structure de la table `gfs_msg`
--

DROP TABLE IF EXISTS `gfs_msg`;
CREATE TABLE IF NOT EXISTS `gfs_msg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `gfs_msg`
--

INSERT INTO `gfs_msg` (`id`, `message`, `created_at`) VALUES
(1, '@stephan : bonjour, ceci est un message sans hashtag. Il apparaÃ®tra partout !', '2015-03-22 14:11:03'),
(2, '@stephan : salut les gens ! @benjamin @guillaume', '2015-03-22 14:12:09'),
(3, '@stephan : je crÃ©e le projet #projetMBA', '2015-03-22 14:12:32'),
(4, '@stephan : j''associe des users au projet #projetMBA @guillaume @benjamin @jdo', '2015-03-22 14:13:16'),
(5, '@stephan : coucou aux users du #projetMBA !', '2015-03-22 14:13:49'),
(6, '@stephan : @benjamin #todo paramÃ©trer le serveur GFS #projetMBA', '2015-03-22 14:14:16'),
(7, '@stephan : @guillaume ceci est un message privÃ© ! :-)', '2015-03-22 14:14:53'),
(8, '@stephan : test % '' " ` -- # @ /* // /'' faille sql ', '2015-03-22 14:15:39'),
(9, '@stephan : #document document.txt #projetMBA', '2015-03-22 14:16:52'),
(10, '@stephan : j''ai uploadÃ© un fichier top secret ! #projetMBA', '2015-03-22 14:17:47');

-- --------------------------------------------------------

--
-- Structure de la table `gfs_users`
--

DROP TABLE IF EXISTS `gfs_users`;
CREATE TABLE IF NOT EXISTS `gfs_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `gfs_users`
--

INSERT INTO `gfs_users` (`id`, `login`, `password`, `email`, `role`, `created_at`) VALUES
(1, 'stephan', 'f965a4a1b587c4e3c1892642aed563e43902502b', 'stephan.audonnet@live.fr', 1, '2015-01-19'),
(3, 'benjamin', 'fe09bc2ef2737a3258f978e26226dcbac1b3f948', 'benj.guillaume@gmail.com', 1, '2015-01-18'),
(4, 'jdo', '82c734466c6593fd0273cc1b00d0dd12b5bd8dd8', 'jd@olek.fr', 2, '2015-01-18'),
(5, 'guillaume', '2450ec3ccdf9492f0296810ab160876644aa9cff', 'crystalnoir@hotmail.com', 1, '2015-01-20');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
