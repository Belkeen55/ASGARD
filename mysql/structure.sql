-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 30 Août 2017 à 11:53
-- Version du serveur :  5.5.57-0+deb8u1
-- Version de PHP :  5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `ASGARD`
--

-- --------------------------------------------------------

--
-- Structure de la table `Codes`
--

CREATE TABLE IF NOT EXISTS `Codes` (
`Id` int(11) NOT NULL,
  `Fonction` varchar(255) DEFAULT NULL,
  `Commentaire` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Devs`
--

CREATE TABLE IF NOT EXISTS `Devs` (
`Id` int(11) NOT NULL,
  `Nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Equipements`
--

CREATE TABLE IF NOT EXISTS `Equipements` (
`Id` int(11) NOT NULL,
  `Nom` varchar(25) NOT NULL,
  `Ip` varchar(255) DEFAULT NULL,
  `Commentaires` text,
  `Id_Pieces` int(11) DEFAULT NULL,
  `Id_Typ_Equip` int(11) NOT NULL,
  `Clonage` date NOT NULL,
  `DHT22` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Etapes`
--

CREATE TABLE IF NOT EXISTS `Etapes` (
  `Id` int(11) NOT NULL,
  `Nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Logs`
--

CREATE TABLE IF NOT EXISTS `Logs` (
`Id` int(11) NOT NULL,
  `Heurodatage` datetime NOT NULL,
  `Client` varchar(255) DEFAULT NULL,
  `Id_Codes` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=619 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Mesures`
--

CREATE TABLE IF NOT EXISTS `Mesures` (
`Id` int(11) NOT NULL,
  `Heurodatage` datetime DEFAULT NULL,
  `Tempint` decimal(25,2) DEFAULT NULL,
  `Humidite` decimal(25,2) DEFAULT NULL,
  `Id_Pieces` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=71423 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Meteo`
--

CREATE TABLE IF NOT EXISTS `Meteo` (
  `Id` int(11) NOT NULL,
  `Heurodatage` datetime NOT NULL,
  `Code` varchar(255) DEFAULT NULL,
  `Temperature` decimal(25,2) DEFAULT NULL,
  `Humidite` decimal(25,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Modules`
--

CREATE TABLE IF NOT EXISTS `Modules` (
`Id` int(11) NOT NULL,
  `Nom` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Performances`
--

CREATE TABLE IF NOT EXISTS `Performances` (
`Id` int(11) NOT NULL,
  `Heurodatage` datetime NOT NULL,
  `Cpu` int(11) NOT NULL,
  `Ram` int(11) NOT NULL,
  `Temperature` int(11) NOT NULL,
  `Id_Equipements` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=363927 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Pieces`
--

CREATE TABLE IF NOT EXISTS `Pieces` (
`Id` int(11) NOT NULL,
  `Nom` varchar(255) DEFAULT NULL,
  `T_ideal` decimal(25,2) DEFAULT NULL,
  `H_ideal` decimal(25,2) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Radiateurs`
--

CREATE TABLE IF NOT EXISTS `Radiateurs` (
`Id` int(11) NOT NULL,
  `Radiateur` decimal(25,2) NOT NULL,
  `Id_Pieces` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Taches`
--

CREATE TABLE IF NOT EXISTS `Taches` (
`Id` int(11) NOT NULL,
  `Heurodatage` datetime NOT NULL,
  `Titre` varchar(255) DEFAULT NULL,
  `Commentaires` text,
  `Deploiement` datetime DEFAULT NULL,
  `Id_Devs` int(11) NOT NULL,
  `Id_Etapes` int(11) NOT NULL,
  `Id_Modules` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Typ_Equip`
--

CREATE TABLE IF NOT EXISTS `Typ_Equip` (
`Id` int(11) NOT NULL,
  `Nom` varchar(25) NOT NULL,
  `Image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Typ_Util`
--

CREATE TABLE IF NOT EXISTS `Typ_Util` (
  `Id` int(11) NOT NULL,
  `Nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateurs`
--

CREATE TABLE IF NOT EXISTS `Utilisateurs` (
`Id` int(11) NOT NULL,
  `Login` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Droits` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Codes`
--
ALTER TABLE `Codes`
 ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `Devs`
--
ALTER TABLE `Devs`
 ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `Equipements`
--
ALTER TABLE `Equipements`
 ADD PRIMARY KEY (`Id`), ADD KEY `FK_Equipements_Id_Pieces` (`Id_Pieces`), ADD KEY `FK_Equipements_Id_Typ_Equip` (`Id_Typ_Equip`);

--
-- Index pour la table `Etapes`
--
ALTER TABLE `Etapes`
 ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `Logs`
--
ALTER TABLE `Logs`
 ADD PRIMARY KEY (`Id`), ADD KEY `FK_Logs_Id_Codes` (`Id_Codes`);

--
-- Index pour la table `Mesures`
--
ALTER TABLE `Mesures`
 ADD PRIMARY KEY (`Id`), ADD KEY `FK_Mesures_Id_Pieces` (`Id_Pieces`);

--
-- Index pour la table `Meteo`
--
ALTER TABLE `Meteo`
 ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `Modules`
--
ALTER TABLE `Modules`
 ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `Performances`
--
ALTER TABLE `Performances`
 ADD PRIMARY KEY (`Id`), ADD KEY `FK_Performances_Id_Equipements` (`Id_Equipements`);

--
-- Index pour la table `Pieces`
--
ALTER TABLE `Pieces`
 ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `Radiateurs`
--
ALTER TABLE `Radiateurs`
 ADD PRIMARY KEY (`Id`), ADD KEY `FK_Radiateurs_Id_Pieces` (`Id_Pieces`);

--
-- Index pour la table `Taches`
--
ALTER TABLE `Taches`
 ADD PRIMARY KEY (`Id`), ADD KEY `FK_Taches_Id_Devs` (`Id_Devs`), ADD KEY `FK_Taches_Id_Etapes` (`Id_Etapes`), ADD KEY `FK_Taches_Id_Modules` (`Id_Modules`);

--
-- Index pour la table `Typ_Equip`
--
ALTER TABLE `Typ_Equip`
 ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `Typ_Util`
--
ALTER TABLE `Typ_Util`
 ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
 ADD PRIMARY KEY (`Id`), ADD UNIQUE KEY `login` (`Login`), ADD KEY `FK_Utilisateurs_Droits` (`Droits`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Codes`
--
ALTER TABLE `Codes`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Devs`
--
ALTER TABLE `Devs`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Equipements`
--
ALTER TABLE `Equipements`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `Logs`
--
ALTER TABLE `Logs`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=619;
--
-- AUTO_INCREMENT pour la table `Mesures`
--
ALTER TABLE `Mesures`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=71423;
--
-- AUTO_INCREMENT pour la table `Modules`
--
ALTER TABLE `Modules`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Performances`
--
ALTER TABLE `Performances`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=363927;
--
-- AUTO_INCREMENT pour la table `Pieces`
--
ALTER TABLE `Pieces`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `Radiateurs`
--
ALTER TABLE `Radiateurs`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Taches`
--
ALTER TABLE `Taches`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Typ_Equip`
--
ALTER TABLE `Typ_Equip`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Equipements`
--
ALTER TABLE `Equipements`
ADD CONSTRAINT `FK_Equipements_Id_Pieces` FOREIGN KEY (`Id_Pieces`) REFERENCES `Pieces` (`Id`),
ADD CONSTRAINT `FK_Equipements_Id_Typ_Equip` FOREIGN KEY (`Id_Typ_Equip`) REFERENCES `Typ_Equip` (`Id`);

--
-- Contraintes pour la table `Logs`
--
ALTER TABLE `Logs`
ADD CONSTRAINT `FK_Logs_Id_Codes` FOREIGN KEY (`Id_Codes`) REFERENCES `Codes` (`Id`);

--
-- Contraintes pour la table `Mesures`
--
ALTER TABLE `Mesures`
ADD CONSTRAINT `FK_Mesures_Id_Pieces` FOREIGN KEY (`Id_Pieces`) REFERENCES `Pieces` (`Id`);

--
-- Contraintes pour la table `Performances`
--
ALTER TABLE `Performances`
ADD CONSTRAINT `FK_Performances_Id_Equipements` FOREIGN KEY (`Id_Equipements`) REFERENCES `Equipements` (`Id`);

--
-- Contraintes pour la table `Radiateurs`
--
ALTER TABLE `Radiateurs`
ADD CONSTRAINT `FK_Radiateurs_Id_Pieces` FOREIGN KEY (`Id_Pieces`) REFERENCES `Pieces` (`Id`);

--
-- Contraintes pour la table `Taches`
--
ALTER TABLE `Taches`
ADD CONSTRAINT `FK_Taches_Id_Devs` FOREIGN KEY (`Id_Devs`) REFERENCES `Devs` (`Id`),
ADD CONSTRAINT `FK_Taches_Id_Etapes` FOREIGN KEY (`Id_Etapes`) REFERENCES `Etapes` (`Id`),
ADD CONSTRAINT `FK_Taches_Id_Modules` FOREIGN KEY (`Id_Modules`) REFERENCES `Modules` (`Id`);

--
-- Contraintes pour la table `Utilisateurs`
--
ALTER TABLE `Utilisateurs`
ADD CONSTRAINT `FK_Utilisateurs_Droits` FOREIGN KEY (`Droits`) REFERENCES `Typ_Util` (`Id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
