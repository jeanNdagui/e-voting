-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 12 jan. 2022 à 12:00
-- Version du serveur :  10.4.19-MariaDB
-- Version de PHP : 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tp_vote`
--

-- --------------------------------------------------------

--
-- Structure de la table `Admin`
--

CREATE TABLE `Admin` (
  `id` int(10) NOT NULL,
  `login` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Blockchain`
--

CREATE TABLE `Blockchain` (
  `index` int(10) NOT NULL,
  `hash` varchar(100) NOT NULL,
  `previousHash` varchar(100) NOT NULL,
  `data` varchar(50) NOT NULL,
  `timestamp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Candidate`
--

CREATE TABLE `Candidate` (
  `candidate_id` varchar(10) NOT NULL,
  `candidate_name` varchar(80) NOT NULL,
  `candidate_party` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Voter`
--

CREATE TABLE `Voter` (
  `voter_id` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `cni` varchar(100) NOT NULL,
  `voted` int(10) NOT NULL,
  `contact_no` varchar(10) NOT NULL,
  `password` varchar(100) NOT NULL,
  `voter_key` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Blockchain`
--
ALTER TABLE `Blockchain`
  ADD PRIMARY KEY (`index`);

--
-- Index pour la table `Candidate`
--
ALTER TABLE `Candidate`
  ADD PRIMARY KEY (`candidate_id`),
  ADD UNIQUE KEY `name` (`candidate_name`);

--
-- Index pour la table `Voter`
--
ALTER TABLE `Voter`
  ADD PRIMARY KEY (`voter_id`),
  ADD UNIQUE KEY `cni` (`cni`),
  ADD UNIQUE KEY `contact_no` (`contact_no`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Admin`
--
ALTER TABLE `Admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
