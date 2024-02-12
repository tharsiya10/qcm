-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  sam. 09 mai 2020 à 17:39
-- Version du serveur :  5.7.17
-- Version de PHP :  7.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE DATABASE IF NOT EXISTS `id21321017_tamoul` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `id21321017_tamoul`;


DROP TABLE IF EXISTS `notes`;
CREATE TABLE `notes` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `idYr` int(11),
  `idUser` int(11),
  `note` int(11)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `QCM_answered`;
CREATE TABLE `QCM_answered` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `idYr` int(11),
  `idQuest` int(11),
  `idUser` int(11),
  `rep` varchar(255),
  `correct` int(11)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `reponses`;
CREATE TABLE `reponses` (
  `idRep` int(11) NOT NULL,
  `idYr` int(11),
  `idQuest` int(11),
  `rep` varchar(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `idQuest` int(11) NOT NULL,
  `idYr` int(11),
  `quest` varchar(255),
  `ans_id` int(11)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `quiz`;
CREATE TABLE `quiz` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `idUser` int(11),
  `idYr` int(11),
  `nom_fichier` varchar(255)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `annee`;
CREATE TABLE `annee` (
  `idYr` int(11) NOT NULL,
  `niv` int(11),
  `year` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `idUser` int(11) NOT NULL,
  `prenom` varchar(255),
  `nom` varchar(255),
  `password` text,
  `niv` int(11)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




DROP TABLE IF EXISTS `QCM`;

--
ALTER TABLE `reponses`
  ADD PRIMARY KEY (`idRep`);

ALTER TABLE `questions`
  ADD PRIMARY KEY (`idQuest`);
-- Index pour la table `unite`
--
ALTER TABLE `annee`
  ADD PRIMARY KEY (`idYr`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT pour les tables déchargées
--
ALTER TABLE `reponses`
  MODIFY `idRep` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
ALTER TABLE `questions`
  MODIFY `idQuest` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
-- AUTO_INCREMENT pour la table `annee`
--
ALTER TABLE `annee`
  MODIFY `idYr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
