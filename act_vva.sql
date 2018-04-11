-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2017 at 01:42 AM
-- Server version: 5.6.15-log
-- PHP Version: 5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `act_vva`
--

-- --------------------------------------------------------

--
-- Table structure for table `activite`
--

CREATE TABLE IF NOT EXISTS `activite` (
  `CODEANIM` char(8) NOT NULL,
  `DATEACT` date NOT NULL,
  `NOENCADRANT` int(3) DEFAULT NULL,
  `CODEETATACT` char(2) NOT NULL,
  `HRRDVACT` time DEFAULT NULL,
  `PRIXACT` decimal(7,2) DEFAULT NULL,
  `HRDEBUTACT` time DEFAULT NULL,
  `HRFINACT` time DEFAULT NULL,
  `DATEANNULATIONACT` date DEFAULT NULL,
  `OBJECTIFACT` char(255) DEFAULT NULL,
  PRIMARY KEY (`CODEANIM`,`DATEACT`),
  KEY `I_FK_ACTIVITE_ANIMATION` (`CODEANIM`),
  KEY `I_FK_ACTIVITE_ENCADRANT` (`NOENCADRANT`),
  KEY `I_FK_ACTIVITE_ETAT_ACT` (`CODEETATACT`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activite`
--

INSERT INTO `activite` (`CODEANIM`, `DATEACT`, `NOENCADRANT`, `CODEETATACT`, `HRRDVACT`, `PRIXACT`, `HRDEBUTACT`, `HRFINACT`, `DATEANNULATIONACT`, `OBJECTIFACT`) VALUES
('canoe', '2017-04-18', 1, '1', '13:30:00', '15.00', '14:00:00', '15:30:00', NULL, NULL),
('canoe', '2017-04-20', 1, '1', '14:30:00', '15.00', '15:00:00', '19:30:00', NULL, NULL),
('canoe', '2017-04-21', 1, '1', '11:30:00', '15.00', '12:00:00', '13:30:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `animation`
--

CREATE TABLE IF NOT EXISTS `animation` (
  `CODEANIM` char(8) NOT NULL,
  `CODETYPEANIM` char(5) NOT NULL,
  `NOMANIM` char(40) DEFAULT NULL,
  `DATECREATIONANIM` date DEFAULT NULL,
  `DATEVALIDITEANIM` date DEFAULT NULL,
  `DUREEANIM` double(5,0) DEFAULT NULL,
  `LIMITEAGE` int(2) DEFAULT NULL,
  `TARIFANIM` decimal(7,2) DEFAULT NULL,
  `NBREPLACEANIM` int(2) DEFAULT NULL,
  `DESCRIPTANIM` char(255) DEFAULT NULL,
  `COMMENTANIM` char(255) DEFAULT NULL,
  `DIFFICULTEANIM` char(40) DEFAULT NULL,
  PRIMARY KEY (`CODEANIM`),
  KEY `I_FK_ANIMATION_TYPE_ANIM` (`CODETYPEANIM`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `animation`
--

INSERT INTO `animation` (`CODEANIM`, `CODETYPEANIM`, `NOMANIM`, `DATECREATIONANIM`, `DATEVALIDITEANIM`, `DUREEANIM`, `LIMITEAGE`, `TARIFANIM`, `NBREPLACEANIM`, `DESCRIPTANIM`, `COMMENTANIM`, `DIFFICULTEANIM`) VALUES
('canoe', 'sport', 'Canoë', '1970-01-01', '1970-01-01', 2, 5, '15.00', 20, 'pareil que le kayak', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `conversation`
--

CREATE TABLE IF NOT EXISTS `conversation` (
  `NOCONVERSATION` int(5) NOT NULL AUTO_INCREMENT,
  `LOISANT1` int(5) NOT NULL,
  `LOISANT2` int(5) NOT NULL,
  PRIMARY KEY (`NOCONVERSATION`),
  KEY `I_FK_CONVERSATION_LOISANT` (`LOISANT1`),
  KEY `I_FK_CONVERSATION_LOISANT2` (`LOISANT2`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `conversation`
--

INSERT INTO `conversation` (`NOCONVERSATION`, `LOISANT1`, `LOISANT2`) VALUES
(1, 0, 1),
(2, 0, 18);

-- --------------------------------------------------------

--
-- Table structure for table `encadrant`
--

CREATE TABLE IF NOT EXISTS `encadrant` (
  `NOENCADRANT` int(3) NOT NULL,
  `USER` char(8) NOT NULL,
  `NOMENCADRANT` char(40) DEFAULT NULL,
  `PRENOMENCADRANT` char(30) DEFAULT NULL,
  `DATENAISENCADRANT` date DEFAULT NULL,
  `ADRMAILENCADRANT` char(50) DEFAULT NULL,
  `ETATSERVICE` char(200) DEFAULT NULL,
  PRIMARY KEY (`NOENCADRANT`),
  UNIQUE KEY `I_FK_ENCADRANT_PROFIL` (`USER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `encadrant`
--

INSERT INTO `encadrant` (`NOENCADRANT`, `USER`, `NOMENCADRANT`, `PRENOMENCADRANT`, `DATENAISENCADRANT`, `ADRMAILENCADRANT`, `ETATSERVICE`) VALUES
(1, 'encadran', 'pete', 'roger', '2016-11-08', 'feaa@eadz.com', 'fezofl'),
(35, 'enca', 'bob', 'bobi', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `etat_act`
--

CREATE TABLE IF NOT EXISTS `etat_act` (
  `CODEETATACT` char(2) NOT NULL,
  `NOMETATACT` char(25) DEFAULT NULL,
  PRIMARY KEY (`CODEETATACT`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `etat_act`
--

INSERT INTO `etat_act` (`CODEETATACT`, `NOMETATACT`) VALUES
('1', 'disponible'),
('2', 'indisponible');

-- --------------------------------------------------------

--
-- Table structure for table `inscription`
--

CREATE TABLE IF NOT EXISTS `inscription` (
  `NOLOISANT` int(6) NOT NULL,
  `NOINSCRIP` bigint(4) NOT NULL,
  `CODEANIM` char(8) NOT NULL,
  `DATEACT` date NOT NULL,
  `DATEINSCRIP` date DEFAULT NULL,
  `REMARQUEINSCRIP` char(255) DEFAULT NULL,
  `DATE_ANNULATION` date DEFAULT NULL,
  PRIMARY KEY (`NOLOISANT`,`NOINSCRIP`),
  KEY `I_FK_INSCRIPTION_LOISANT` (`NOLOISANT`),
  KEY `I_FK_INSCRIPTION_ACTIVITE` (`CODEANIM`,`DATEACT`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `loisant`
--

CREATE TABLE IF NOT EXISTS `loisant` (
  `NOLOISANT` int(6) NOT NULL,
  `USER` char(8) NOT NULL,
  `NOMLOISANT` char(40) DEFAULT NULL,
  `PRENOMLOISANT` char(30) DEFAULT NULL,
  `SEXE` varchar(1) DEFAULT NULL,
  `DATEDEBSEJOUR` date DEFAULT NULL,
  `DATEFINSEJOUR` date DEFAULT NULL,
  `DATENAISLOISANT` date DEFAULT NULL,
  `PHOTOLOISANT` longblob,
  `INTERET` text,
  `DESCRIPTION` text,
  `TAILLE` int(11) DEFAULT NULL,
  PRIMARY KEY (`NOLOISANT`),
  UNIQUE KEY `I_FK_LOISANT_PROFIL` (`USER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loisant`
--

INSERT INTO `loisant` (`NOLOISANT`, `USER`, `NOMLOISANT`, `PRENOMLOISANT`, `SEXE`, `DATEDEBSEJOUR`, `DATEFINSEJOUR`, `DATENAISLOISANT`, `PHOTOLOISANT`, `INTERET`, `DESCRIPTION`, `TAILLE`) VALUES
INSERT INTO `loisant` (`NOLOISANT`, `USER`, `NOMLOISANT`, `PRENOMLOISANT`, `SEXE`, `DATEDEBSEJOUR`, `DATEFINSEJOUR`, `DATENAISLOISANT`, `PHOTOLOISANT`, `INTERET`, `DESCRIPTION`, `TAILLE`) VALUES
(1, 'aandrews', 'Andrews', 'Andrea', 'F', '2010-05-05', '2018-05-05', '1995-07-03', NULL, 'Homme', '', 170),
(2, 'acarr7q', 'Carr', 'Amy', 'M', '2010-05-05', '2018-05-05', '1968-09-27', NULL, 'LesDeux', NULL, 178),
(3, 'acunning', 'Cunningham', 'Andrew', 'F', '2010-05-05', '2018-05-05', '1987-05-07', NULL, 'Femme', NULL, 199),
(4, 'amarshal', 'Marshall', 'Amy', 'M', '2010-05-05', '2018-05-05', '1964-03-25', NULL, 'Femme', NULL, 184),
(5, 'amason6c', 'Mason', 'Anthony', 'M', '2010-05-05', '2018-05-05', '1975-01-02', NULL, 'Homme', NULL, 150),
(6, 'amoore6l', 'Moore', 'Ann', 'F', '2010-05-05', '2018-05-05', '1985-08-12', NULL, 'Homme', NULL, 190),
(7, 'amorris1', 'Morris', 'Andrew', 'M', '2010-05-05', '2018-05-05', '1962-09-03', NULL, 'Homme', NULL, 181),
(8, 'aparker1', 'Parker', 'Amanda', 'F', '2010-05-05', '2018-05-05', '1978-06-10', NULL, 'LesDeux', NULL, 168),
(9, 'areid13', 'Reid', 'Annie', 'F', '2010-05-05', '2018-05-05', '1960-07-02', NULL, 'LesDeux', NULL, 196),
(10, 'asims77', 'Sims', 'Amy', 'M', '2010-05-05', '2018-05-05', '1983-03-19', NULL, 'Femme', NULL, 177),
(11, 'astephen', 'Stephens', 'Andrew', 'F', '2010-05-05', '2018-05-05', '1987-08-20', NULL, 'LesDeux', NULL, 175),
(12, 'awest6u', 'West', 'Amy', 'F', '2010-05-05', '2018-05-05', '2002-05-14', NULL, 'LesDeux', NULL, 192),
(13, 'bcruze', 'Cruz', 'Beverly', 'F', '2010-05-05', '2018-05-05', '1987-12-03', NULL, 'Femme', NULL, 182),
(14, 'bcunning', 'Cunningham', 'Barbara', 'F', '2010-05-05', '2018-05-05', '1977-11-15', NULL, 'Homme', NULL, 207),
(15, 'bgarrett', 'Garrett', 'Bobby', 'F', '2010-05-05', '2018-05-05', '1970-03-12', NULL, 'Femme', NULL, 188),
(16, 'bgonzale', 'Gonzales', 'Brandon', 'F', '2010-05-05', '2018-05-05', '1964-12-30', NULL, 'Homme', NULL, 185),
(17, 'bhamilto', 'Hamilton', 'Billy', 'M', '2010-05-05', '2018-05-05', '1985-05-09', NULL, 'Femme', NULL, 197),
(18, 'bhayes15', 'Hayes', 'Brandon', 'M', '2010-05-05', '2018-05-05', '1996-04-29', NULL, 'LesDeux', NULL, 175),
(19, 'bmorriso', 'Morrison', 'Bonnie', 'F', '2010-05-05', '2018-05-05', '1973-10-05', NULL, 'Homme', NULL, 207),
(20, 'candrews', 'Andrews', 'Carol', 'F', '2010-05-05', '2018-05-05', '1962-01-20', NULL, 'Homme', NULL, 152),
(21, 'caustin1', 'Austin', 'Carol', 'M', '2010-05-05', '2018-05-05', '1970-12-16', NULL, 'Femme', NULL, 185),
(22, 'caustin8', 'Austin', 'Craig', 'M', '2010-05-05', '2018-05-05', '1970-03-28', NULL, 'LesDeux', NULL, 194),
(23, 'cbrown7y', 'Brown', 'Carl', 'F', '2010-05-05', '2018-05-05', '1981-01-04', NULL, 'Homme', NULL, 201),
(24, 'cgardner', 'Gardner', 'Carol', 'F', '2010-05-05', '2018-05-05', '1960-05-10', NULL, 'LesDeux', NULL, 152),
(25, 'cgutierr', 'Gutierrez', 'Carol', 'M', '2010-05-05', '2018-05-05', '1989-05-20', NULL, 'Homme', NULL, 189),
(26, 'chicks6p', 'Hicks', 'Craig', 'M', '2010-05-05', '2018-05-05', '1968-12-16', NULL, 'LesDeux', NULL, 207),
(27, 'chunt1o', 'Hunt', 'Charles', 'M', '2010-05-05', '2018-05-05', '1965-12-23', NULL, 'Homme', NULL, 163),
(28, 'cpayne70', 'Payne', 'Cheryl', 'F', '2010-05-05', '2018-05-05', '1966-01-05', NULL, 'Femme', NULL, 205),
(29, 'crichard', 'Richardson', 'Christina', 'F', '2010-05-05', '2018-05-05', '1969-04-11', NULL, 'LesDeux', NULL, 194),
(30, 'crose7s', 'Rose', 'Clarence', 'M', '2010-05-05', '2018-05-05', '1979-01-06', NULL, 'Femme', NULL, 153),
(31, 'cross1v', 'Ross', 'Charles', 'M', '2010-05-05', '2018-05-05', '1972-11-20', NULL, 'Femme', NULL, 176),
(32, 'cschmidt', 'Schmidt', 'Christine', 'M', '2010-05-05', '2018-05-05', '2002-06-18', NULL, 'Femme', NULL, 150),
(33, 'cwatkins', 'Watkins', 'Charles', 'M', '2010-05-05', '2018-05-05', '1975-10-24', NULL, 'Femme', NULL, 191),
(34, 'ddaniels', 'Daniels', 'Donna', 'F', '2010-05-05', '2018-05-05', '1984-05-22', NULL, 'Femme', NULL, 165),
(35, 'delliott', 'Elliott', 'Dorothy', 'F', '2010-05-05', '2018-05-05', '2001-04-17', NULL, 'LesDeux', NULL, 168),
(36, 'dfowlers', 'Fowler', 'Deborah', 'M', '2010-05-05', '2018-05-05', '1962-07-14', NULL, 'Femme', NULL, 207),
(37, 'dgardner', 'Gardner', 'Debra', 'M', '2010-05-05', '2018-05-05', '1996-01-27', NULL, 'Femme', NULL, 195),
(38, 'dholmes7', 'Holmes', 'Diane', 'M', '2010-05-05', '2018-05-05', '1969-06-01', NULL, 'LesDeux', NULL, 196),
(39, 'dmartine', 'Martinez', 'David', 'M', '2010-05-05', '2018-05-05', '1988-03-09', NULL, 'LesDeux', NULL, 203),
(40, 'dmason16', 'Mason', 'Diana', 'M', '2010-05-05', '2018-05-05', '1977-03-19', NULL, 'Homme', NULL, 169),
(41, 'dparker1', 'Parker', 'Diana', 'F', '2010-05-05', '2018-05-05', '1962-05-30', NULL, 'LesDeux', NULL, 160),
(42, 'dstanley', 'Stanley', 'Douglas', 'M', '2010-05-05', '2018-05-05', '1981-06-25', NULL, 'Homme', NULL, 184),
(43, 'dstewart', 'Stewart', 'Deborah', 'F', '2010-05-05', '2018-05-05', '2000-06-12', NULL, 'Homme', NULL, 185),
(44, 'dwells1u', 'Wells', 'Daniel', 'M', '2010-05-05', '2018-05-05', '1984-09-14', NULL, 'Femme', NULL, 154),
(45, 'ebellf', 'Bell', 'Ernest', 'M', '2010-05-05', '2018-05-05', '1990-09-12', NULL, 'Femme', NULL, 180),
(46, 'eblackt', 'Black', 'Eric', 'F', '2010-05-05', '2018-05-05', '1984-08-02', NULL, 'Homme', NULL, 163),
(47, 'ebowman7', 'Bowman', 'Ernest', 'M', '2010-05-05', '2018-05-05', '1992-04-20', NULL, 'LesDeux', NULL, 156),
(48, 'ereyes7j', 'Reyes', 'Elizabeth', 'F', '2010-05-05', '2018-05-05', '1960-08-11', NULL, 'Femme', NULL, 161),
(49, 'fchavez1', 'Chavez', 'Frank', 'M', '2010-05-05', '2018-05-05', '1984-02-02', NULL, 'Homme', NULL, 150),
(50, 'fmoore1j', 'Moore', 'Frank', 'M', '2010-05-05', '2018-05-05', '2004-02-10', NULL, 'Femme', NULL, 156),
(51, 'fsanchez', 'Sanchez', 'Frances', 'M', '2010-05-05', '2018-05-05', '1984-05-02', NULL, 'Femme', NULL, 173),
(52, 'fwillis1', 'Willis', 'Fred', 'F', '2010-05-05', '2018-05-05', '1979-11-27', NULL, 'Homme', NULL, 174),
(53, 'gfowler6', 'Fowler', 'George', 'M', '2010-05-05', '2018-05-05', '1960-12-16', NULL, 'Homme', NULL, 178),
(54, 'gphillip', 'Phillips', 'George', 'M', '2010-05-05', '2018-05-05', '1994-09-25', NULL, 'Femme', NULL, 193),
(55, 'grussell', 'Russell', 'Gloria', 'F', '2010-05-05', '2018-05-05', '1983-05-17', NULL, 'Homme', NULL, 165),
(56, 'hclark6x', 'Clark', 'Helen', 'M', '2010-05-05', '2018-05-05', '1985-07-15', NULL, 'Homme', NULL, 185),
(57, 'iaustin1', 'Austin', 'Irene', 'M', '2010-05-05', '2018-05-05', '2004-09-17', NULL, 'Homme', NULL, 153),
(58, 'ipalmer1', 'Palmer', 'Irene', 'F', '2010-05-05', '2018-05-05', '1993-06-30', NULL, 'Femme', NULL, 197),
(59, 'jcarr7c', 'Carr', 'Jesse', 'M', '2010-05-05', '2018-05-05', '1961-12-03', NULL, 'LesDeux', NULL, 205),
(60, 'jgibson7', 'Gibson', 'Jack', 'M', '2010-05-05', '2018-05-05', '1969-04-23', NULL, 'Homme', NULL, 152),
(61, 'jgreenep', 'Greene', 'Jacqueline', 'F', '2010-05-05', '2018-05-05', '1990-09-04', NULL, 'LesDeux', NULL, 176),
(62, 'jhansonb', 'Hanson', 'Joseph', 'M', '2010-05-05', '2018-05-05', '1981-09-03', NULL, 'Femme', NULL, 185),
(63, 'jhart79', 'Hart', 'Joyce', 'F', '2010-05-05', '2018-05-05', '1969-04-17', NULL, 'LesDeux', NULL, 184),
(64, 'jkennedy', 'Kennedy', 'Jacqueline', 'M', '2010-05-05', '2018-05-05', '1990-11-13', NULL, 'Homme', NULL, 192),
(65, 'jkimr', 'Kim', 'Johnny', 'F', '2010-05-05', '2018-05-05', '1984-05-31', NULL, 'Femme', NULL, 150),
(66, 'jlong71', 'Long', 'Joyce', 'F', '2010-05-05', '2018-05-05', '1967-04-06', NULL, 'Homme', NULL, 174),
(67, 'jlopez6z', 'Lopez', 'Juan', 'M', '2010-05-05', '2018-05-05', '1971-02-21', NULL, 'Homme', NULL, 150),
(68, 'jmartine', 'Martinez', 'Justin', 'F', '2010-05-05', '2018-05-05', '1973-04-18', NULL, 'LesDeux', NULL, 167),
(69, 'jmccoy7n', 'Mccoy', 'Joe', 'M', '2010-05-05', '2018-05-05', '1968-01-27', NULL, 'Homme', NULL, 188),
(70, 'jmillsj', 'Mills', 'Julia', 'F', '2010-05-05', '2018-05-05', '1964-10-08', NULL, 'LesDeux', NULL, 190),
(71, 'jnguyen7', 'Nguyen', 'Judy', 'M', '2010-05-05', '2018-05-05', '1969-12-09', NULL, 'Femme', NULL, 200),
(72, 'jpalmer7', 'Palmer', 'Janice', 'F', '2010-05-05', '2018-05-05', '1968-06-10', NULL, 'Femme', NULL, 150),
(73, 'jsnyder1', 'Snyder', 'Jason', 'M', '2010-05-05', '2018-05-05', '1963-04-14', NULL, 'Femme', NULL, 182),
(74, 'jwardm', 'Ward', 'Jane', 'F', '2010-05-05', '2018-05-05', '1977-01-14', NULL, 'Femme', NULL, 188),
(75, 'jwilliam', 'Williams', 'James', 'F', '2010-05-05', '2018-05-05', '1969-11-21', NULL, 'LesDeux', NULL, 202),
(76, 'jwillis7', 'Willis', 'Jerry', 'F', '2010-05-05', '2018-05-05', '1963-03-29', NULL, 'LesDeux', NULL, 150),
(77, 'jwood7t', 'Wood', 'Joan', 'M', '2010-05-05', '2018-05-05', '1998-08-30', NULL, 'Homme', NULL, 159),
(78, 'kduncan1', 'Duncan', 'Kimberly', 'M', '2010-05-05', '2018-05-05', '1960-03-24', NULL, 'Homme', NULL, 197),
(79, 'kmcdonal', 'Mcdonald', 'Karen', 'F', '2010-05-05', '2018-05-05', '1965-06-06', NULL, 'Homme', NULL, 181),
(80, 'lberry6b', 'Berry', 'Larry', 'F', '2010-05-05', '2018-05-05', '1966-03-25', NULL, 'Femme', NULL, 175),
(81, 'lharper7', 'Harper', 'Louis', 'M', '2010-05-05', '2018-05-05', '1985-12-13', NULL, 'Femme', NULL, 201),
(82, 'lhernand', 'Hernandez', 'Larry', 'F', '2010-05-05', '2018-05-05', '1989-05-04', NULL, 'Homme', NULL, 152),
(83, 'lmartin6', 'Martin', 'Lori', 'M', '2010-05-05', '2018-05-05', '1971-04-26', NULL, 'LesDeux', NULL, 204),
(84, 'lmontgom', 'Montgomery', 'Larry', 'F', '2010-05-05', '2018-05-05', '1994-12-22', NULL, 'Homme', NULL, 187),
(85, 'lwest10', 'West', 'Louis', 'F', '2010-05-05', '2018-05-05', '1966-10-25', NULL, 'Femme', NULL, 190),
(86, 'madams7h', 'Adams', 'Margaret', 'M', '2010-05-05', '2018-05-05', '1970-08-25', NULL, 'LesDeux', NULL, 152),
(87, 'mblack1k', 'Black', 'Martin', 'M', '2010-05-05', '2018-05-05', '1990-07-10', NULL, 'Homme', NULL, 182),
(88, 'mday5', 'Day', 'Martha', 'M', '2010-05-05', '2018-05-05', '1987-05-04', NULL, 'Femme', NULL, 207),
(89, 'mford7l', 'Ford', 'Margaret', 'M', '2010-05-05', '2018-05-05', '2000-09-12', NULL, 'LesDeux', NULL, 209),
(90, 'mray81', 'Ray', 'Margaret', 'M', '2010-05-05', '2018-05-05', '1986-11-28', NULL, 'Homme', NULL, 193),
(91, 'msulliva', 'Sullivan', 'Matthew', 'F', '2010-05-05', '2018-05-05', '1975-10-24', NULL, 'Homme', NULL, 204),
(92, 'nwatsonl', 'Watson', 'Norma', 'M', '2010-05-05', '2018-05-05', '1960-07-23', NULL, 'LesDeux', NULL, 207),
(93, 'pburtony', 'Burton', 'Paul', 'M', '2010-05-05', '2018-05-05', '1979-02-14', NULL, 'Femme', NULL, 201),
(94, 'pdunn17', 'Dunn', 'Phillip', 'F', '2010-05-05', '2018-05-05', '1996-02-02', NULL, 'Femme', NULL, 200),
(95, 'pfox6s', 'Fox', 'Pamela', 'M', '2010-05-05', '2018-05-05', '1997-10-04', NULL, 'Homme', NULL, 202),
(96, 'pfrazier', 'Frazier', 'Phillip', 'F', '2010-05-05', '2018-05-05', '1963-11-16', NULL, 'Homme', NULL, 184),
(97, 'pgibson1', 'Gibson', 'Philip', 'M', '2010-05-05', '2018-05-05', '1973-03-16', NULL, 'Homme', NULL, 209),
(98, 'pgraham1', 'Graham', 'Patricia', 'M', '2010-05-05', '2018-05-05', '1968-06-21', NULL, 'LesDeux', NULL, 202),
(99, 'pkelly1w', 'Kelly', 'Phyllis', 'M', '2010-05-05', '2018-05-05', '1986-08-08', NULL, 'Femme', NULL, 153),
(100, 'plawson2', 'Lawson', 'Patrick', 'F', '2010-05-05', '2018-05-05', '1974-08-26', NULL, 'LesDeux', NULL, 155),
(101, 'pstewart', 'Stewart', 'Pamela', 'M', '2010-05-05', '2018-05-05', '2000-05-31', NULL, 'LesDeux', NULL, 163),
(102, 'pwagner6', 'Wagner', 'Philip', 'M', '2010-05-05', '2018-05-05', '1965-11-24', NULL, 'LesDeux', NULL, 199),
(103, 'pwatsond', 'Watson', 'Phillip', 'M', '2010-05-05', '2018-05-05', '1992-10-29', NULL, 'Homme', NULL, 182),
(104, 'pwoodsk', 'Woods', 'Philip', 'F', '2010-05-05', '2018-05-05', '1977-10-03', NULL, 'Homme', NULL, 169),
(105, 'rcole1h', 'Cole', 'Roy', 'F', '2010-05-05', '2018-05-05', '1999-07-20', NULL, 'Femme', NULL, 166),
(106, 'rcole8', 'Cole', 'Rebecca', 'M', '2010-05-05', '2018-05-05', '1995-09-28', NULL, 'LesDeux', NULL, 172),
(107, 'rmoreno7', 'Moreno', 'Russell', 'F', '2010-05-05', '2018-05-05', '1994-09-24', NULL, 'Femme', NULL, 201),
(108, 'rreed18', 'Reed', 'Raymond', 'F', '2010-05-05', '2018-05-05', '1993-07-30', NULL, 'Homme', NULL, 200),
(109, 'rwells3', 'Wells', 'Raymond', 'M', '2010-05-05', '2018-05-05', '1980-10-18', NULL, 'Femme', NULL, 201),
(110, 'ryoung74', 'Young', 'Ralph', 'F', '2010-05-05', '2018-05-05', '1985-12-07', NULL, 'LesDeux', NULL, 164),
(111, 'sgomez6y', 'Gomez', 'Sean', 'M', '2010-05-05', '2018-05-05', '1977-04-21', NULL, 'LesDeux', NULL, 176),
(112, 'sgutierr', 'Gutierrez', 'Scott', 'F', '2010-05-05', '2018-05-05', '1984-09-13', NULL, 'Femme', NULL, 166),
(113, 'sharper7', 'Harper', 'Sarah', 'M', '2010-05-05', '2018-05-05', '1983-02-23', NULL, 'LesDeux', NULL, 166),
(114, 'sharris1', 'Harris', 'Sara', 'M', '2010-05-05', '2018-05-05', '1987-08-30', NULL, 'Homme', NULL, 180),
(115, 'slee1n', 'Lee', 'Sarah', 'F', '2010-05-05', '2018-05-05', '1963-11-20', NULL, 'Femme', NULL, 161),
(116, 'smartin7', 'Martin', 'Sean', 'F', '2010-05-05', '2018-05-05', '1994-11-13', NULL, 'Femme', NULL, 173),
(117, 'sparker1', 'Parker', 'Sarah', 'F', '2010-05-05', '2018-05-05', '1998-02-12', NULL, 'Homme', NULL, 190),
(118, 'spowell1', 'Powell', 'Susan', 'M', '2010-05-05', '2018-05-05', '1991-11-01', NULL, 'Homme', NULL, 206),
(119, 'sroberts', 'Roberts', 'Samuel', 'F', '2010-05-05', '2018-05-05', '2002-12-03', NULL, 'Homme', NULL, 151),
(120, 'sscott7d', 'Scott', 'Susan', 'F', '2010-05-05', '2018-05-05', '1965-10-24', NULL, 'Femme', NULL, 208),
(121, 'ssimmons', 'Simmons', 'Sandra', 'M', '2010-05-05', '2018-05-05', '1991-07-05', NULL, 'Femme', NULL, 202),
(122, 'sstephen', 'Stephens', 'Samuel', 'M', '2010-05-05', '2018-05-05', '1966-08-15', NULL, 'Homme', NULL, 153),
(123, 'staylor7', 'Taylor', 'Shirley', 'M', '2010-05-05', '2018-05-05', '1992-03-16', NULL, 'Femme', NULL, 167),
(124, 'sweaver8', 'Weaver', 'Shirley', 'F', '2010-05-05', '2018-05-05', '1968-05-19', NULL, 'LesDeux', NULL, 205),
(125, 'tblackg', 'Black', 'Timothy', 'M', '2010-05-05', '2018-05-05', '1982-12-22', NULL, 'Femme', NULL, 196),
(126, 'tcoleman', 'Coleman', 'Terry', 'M', '2010-05-05', '2018-05-05', '1986-01-22', NULL, 'Homme', NULL, 203),
(127, 'tcruz14', 'Cruz', 'Teresa', 'F', '2010-05-05', '2018-05-05', '1963-11-23', NULL, 'Femme', NULL, 158),
(128, 'tcunning', 'Cunningham', 'Terry', 'M', '2010-05-05', '2018-05-05', '1997-04-23', NULL, 'LesDeux', NULL, 191),
(129, 'tharris1', 'Harris', 'Todd', 'F', '2010-05-05', '2018-05-05', '1993-06-16', NULL, 'LesDeux', NULL, 195),
(130, 'tsnyderv', 'Snyder', 'Tina', 'F', '2010-05-05', '2018-05-05', '1997-01-30', NULL, 'Homme', NULL, 167),
(131, 'vgonzale', 'Gonzales', 'Victor', 'F', '2010-05-05', '2018-05-05', '1992-10-20', NULL, 'Femme', NULL, 151),
(132, 'vsnyder1', 'Snyder', 'Virginia', 'F', '2010-05-05', '2018-05-05', '1977-09-17', NULL, 'Homme', NULL, 166),
(133, 'wcarr6v', 'Carr', 'William', 'F', '2010-05-05', '2018-05-05', '1961-11-11', NULL, 'Homme', NULL, 193),
(134, 'wlopez7i', 'Lopez', 'Wayne', 'M', '2010-05-05', '2018-05-05', '1979-05-09', NULL, 'LesDeux', NULL, 176),
(135, 'wpayne12', 'Payne', 'Wayne', 'M', '2010-05-05', '2018-05-05', '1991-05-06', NULL, 'Femme', NULL, 162),
(136, 'wrichard', 'Richardson', 'Wayne', 'M', '2010-05-05', '2018-05-05', '1962-05-17', NULL, 'Homme', NULL, 152),
(137, 'wwest7z', 'West', 'William', 'F', '2010-05-05', '2018-05-05', '1981-12-21', NULL, 'Femme', NULL, 179);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `NOMESSAGE` int(32) NOT NULL AUTO_INCREMENT,
  `NOLOISANT` int(5) NOT NULL,
  `CONTENU` longtext,
  `DATETIME` datetime DEFAULT NULL,
  `NOCONVERSATION` int(5) NOT NULL,
  PRIMARY KEY (`NOMESSAGE`,`NOCONVERSATION`),
  KEY `I_FK_MESSAGE_LOISANT` (`NOLOISANT`),
  KEY `I_FK_MESSAGE_CONV` (`NOCONVERSATION`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`NOMESSAGE`, `NOLOISANT`, `CONTENU`, `DATETIME`, `NOCONVERSATION`) VALUES
(7, 0, 'vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv', '2017-04-05 23:18:17', 1),
(6, 0, 'ola chica', '2017-04-05 23:13:52', 1),
(8, 0, 'salut bb\r\n', '2017-04-06 14:40:58', 1),
(9, 1, 'ola', '2017-04-06 14:41:28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `planning`
--

CREATE TABLE IF NOT EXISTS `planning` (
  `NOENCADRANT` int(3) NOT NULL,
  `CODEANIM` char(8) NOT NULL,
  `DATEACT` date NOT NULL,
  PRIMARY KEY (`NOENCADRANT`,`CODEANIM`,`DATEACT`),
  KEY `I_FK_PLANNING_ENCADRANT` (`NOENCADRANT`),
  KEY `I_FK_PLANNING_ACTIVITE` (`CODEANIM`,`DATEACT`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `profil`
--

CREATE TABLE IF NOT EXISTS `profil` (
  `USER` char(8) NOT NULL,
  `MDP` char(10) DEFAULT NULL,
  `NOMPROFIL` char(40) DEFAULT NULL,
  `PRENOMPROFIL` char(30) DEFAULT NULL,
  `DATEINSPRO` date DEFAULT NULL,
  `DATEVALIDITE` date DEFAULT NULL,
  `TYPEPROFIL` char(2) DEFAULT NULL,
  PRIMARY KEY (`USER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profil`
--

INSERT INTO `profil` (`USER`, `MDP`, `NOMPROFIL`, `PRENOMPROFIL`, `DATEINSPRO`, `DATEVALIDITE`, `TYPEPROFIL`) VALUES
('aandrews', 'bBxShiqc', 'Andrews', 'Andrea', '2010-05-05', '2018-05-05', 'lo'),
('acarr7q', 'bYEI9QZbJx', 'Carr', 'Amy', '2010-05-05', '2018-05-05', 'lo'),
('acunning', 'IQtme95QN6', 'Cunningham', 'Andrew', '2010-05-05', '2018-05-05', 'lo'),
('amarshal', 'V5BPiGhk', 'Marshall', 'Amy', '2010-05-05', '2018-05-05', 'lo'),
('amason6c', 'HBcTYENs4i', 'Mason', 'Anthony', '2010-05-05', '2018-05-05', 'lo'),
('amoore6l', 'l3WCv3n5', 'Moore', 'Ann', '2010-05-05', '2018-05-05', 'lo'),
('amorris1', 'm5vnmc5K9', 'Morris', 'Andrew', '2010-05-05', '2018-05-05', 'lo'),
('aparker1', 'WxAuystGS5', 'Parker', 'Amanda', '2010-05-05', '2018-05-05', 'lo'),
('areid13', 'guELRo', 'Reid', 'Annie', '2010-05-05', '2018-05-05', 'lo'),
('asims77', 'OggnQqldlM', 'Sims', 'Amy', '2010-05-05', '2018-05-05', 'lo'),
('astephen', 'U3ulvkW931', 'Stephens', 'Andrew', '2010-05-05', '2018-05-05', 'lo'),
('awest6u', 'w6JvWTXY0S', 'West', 'Amy', '2010-05-05', '2018-05-05', 'lo'),
('bcruze', 'ONA1qJ38OR', 'Cruz', 'Beverly', '2010-05-05', '2018-05-05', 'lo'),
('bcunning', 'SvlFMpMpv', 'Cunningham', 'Barbara', '2010-05-05', '2018-05-05', 'lo'),
('bgarrett', 'iAdetI0yeI', 'Garrett', 'Bobby', '2010-05-05', '2018-05-05', 'lo'),
('bgonzale', 'H6TwIC0', 'Gonzales', 'Brandon', '2010-05-05', '2018-05-05', 'lo'),
('bhamilto', 'x7mAooydC', 'Hamilton', 'Billy', '2010-05-05', '2018-05-05', 'lo'),
('bhayes15', 'sZ1pvvT14y', 'Hayes', 'Brandon', '2010-05-05', '2018-05-05', 'lo'),
('bmorriso', 'BGHCia3Xcn', 'Morrison', 'Bonnie', '2010-05-05', '2018-05-05', 'lo'),
('candrews', 'wW3mWkDQvJ', 'Andrews', 'Carol', '2010-05-05', '2018-05-05', 'lo'),
('caustin1', '1MOtJcK', 'Austin', 'Carol', '2010-05-05', '2018-05-05', 'lo'),
('caustin8', 'fiR1DXdfO', 'Austin', 'Craig', '2010-05-05', '2018-05-05', 'lo'),
('cbrown7y', 'vrcxGLLzZf', 'Brown', 'Carl', '2010-05-05', '2018-05-05', 'lo'),
('cgardner', 'zAon92', 'Gardner', 'Carol', '2010-05-05', '2018-05-05', 'lo'),
('cgutierr', '38BC2qlwI', 'Gutierrez', 'Carol', '2010-05-05', '2018-05-05', 'lo'),
('chicks6p', 'E2N6v5i', 'Hicks', 'Craig', '2010-05-05', '2018-05-05', 'lo'),
('chunt1o', '11dYuM', 'Hunt', 'Charles', '2010-05-05', '2018-05-05', 'lo'),
('cpayne70', '3vllINA072', 'Payne', 'Cheryl', '2010-05-05', '2018-05-05', 'lo'),
('crichard', 'TfirD0V', 'Richardson', 'Christina', '2010-05-05', '2018-05-05', 'lo'),
('crose7s', '9eHG3E96SL', 'Rose', 'Clarence', '2010-05-05', '2018-05-05', 'lo'),
('cross1v', 'mHkIPdKHh', 'Ross', 'Charles', '2010-05-05', '2018-05-05', 'lo'),
('cschmidt', 'zTvvnDf', 'Schmidt', 'Christine', '2010-05-05', '2018-05-05', 'lo'),
('cwatkins', 'NImbCdcyXP', 'Watkins', 'Charles', '2010-05-05', '2018-05-05', 'lo'),
('ddaniels', 'pW7UWy', 'Daniels', 'Donna', '2010-05-05', '2018-05-05', 'lo'),
('delliott', 'B1C3ERlE', 'Elliott', 'Dorothy', '2010-05-05', '2018-05-05', 'lo'),
('dfowlers', 'T2aXxyQIOW', 'Fowler', 'Deborah', '2010-05-05', '2018-05-05', 'lo'),
('dgardner', 'HnzpsEbb', 'Gardner', 'Debra', '2010-05-05', '2018-05-05', 'lo'),
('dholmes7', 'rkXao2TX', 'Holmes', 'Diane', '2010-05-05', '2018-05-05', 'lo'),
('dmartine', 'KQSD7Yd', 'Martinez', 'David', '2010-05-05', '2018-05-05', 'lo'),
('dmason16', 'BOAYXStea2', 'Mason', 'Diana', '2010-05-05', '2018-05-05', 'lo'),
('dparker1', 'vZ8Ltj8KFM', 'Parker', 'Diana', '2010-05-05', '2018-05-05', 'lo'),
('dstanley', 'PERT4Cm', 'Stanley', 'Douglas', '2010-05-05', '2018-05-05', 'lo'),
('dstewart', 'lH27rXaSS7', 'Stewart', 'Deborah', '2010-05-05', '2018-05-05', 'lo'),
('dwells1u', '1s0M93', 'Wells', 'Daniel', '2010-05-05', '2018-05-05', 'lo'),
('ebellf', 'X19MjRnw1g', 'Bell', 'Ernest', '2010-05-05', '2018-05-05', 'lo'),
('eblackt', 'dVquagEG', 'Black', 'Eric', '2010-05-05', '2018-05-05', 'lo'),
('ebowman7', 'azWEOhPYAS', 'Bowman', 'Ernest', '2010-05-05', '2018-05-05', 'lo'),
('enca', 'enca', 'bobi', 'bob', '2010-05-05', '2018-05-05', NULL),
('encadran', 'encadrant', 'encadrant', 'encadrant', '2010-05-05', '2018-05-05', 'en'),
('ereyes7j', 'j4lY8685UQ', 'Reyes', 'Elizabeth', '2010-05-05', '2018-05-05', 'lo'),
('fchavez1', 'T29ZuJLXxN', 'Chavez', 'Frank', '2010-05-05', '2018-05-05', 'lo'),
('fmoore1j', 'GayX2iQGM', 'Moore', 'Frank', '2010-05-05', '2018-05-05', 'lo'),
('fsanchez', 'tVapH8OQ', 'Sanchez', 'Frances', '2010-05-05', '2018-05-05', 'lo'),
('fwillis1', 'xIaSYi7QpT', 'Willis', 'Fred', '2010-05-05', '2018-05-05', 'lo'),
('gfowler6', 'L4Kase4EiF', 'Fowler', 'George', '2010-05-05', '2018-05-05', 'lo'),
('gphillip', 'dkvXDJJz', 'Phillips', 'George', '2010-05-05', '2018-05-05', 'lo'),
('grussell', 'TyzssFxV2p', 'Russell', 'Gloria', '2010-05-05', '2018-05-05', 'lo'),
('hclark6x', 'mJ5NLJ', 'Clark', 'Helen', '2010-05-05', '2018-05-05', 'lo'),
('iaustin1', 'YRcIaM', 'Austin', 'Irene', '2010-05-05', '2018-05-05', 'lo'),
('ipalmer1', 'aGlJzXQFLo', 'Palmer', 'Irene', '2010-05-05', '2018-05-05', 'lo'),
('jcarr7c', 'WUaC0tnWnx', 'Carr', 'Jesse', '2010-05-05', '2018-05-05', 'lo'),
('jgibson7', 'NvuobNd47', 'Gibson', 'Jack', '2010-05-05', '2018-05-05', 'lo'),
('jgreenep', 'Arh2w0yj', 'Greene', 'Jacqueline', '2010-05-05', '2018-05-05', 'lo'),
('jhansonb', 'B29ceEP7G', 'Hanson', 'Joseph', '2010-05-05', '2018-05-05', 'lo'),
('jhart79', '66KjnR2XTn', 'Hart', 'Joyce', '2010-05-05', '2018-05-05', 'lo'),
('jkennedy', 'B29QmEKIb', 'Kennedy', 'Jacqueline', '2010-05-05', '2018-05-05', 'lo'),
('jkimr', '7o8lTp', 'Kim', 'Johnny', '2010-05-05', '2018-05-05', 'lo'),
('jlong71', 'C6l1V2RDH6', 'Long', 'Joyce', '2010-05-05', '2018-05-05', 'lo'),
('jlopez6z', 'ylYRWRes', 'Lopez', 'Juan', '2010-05-05', '2018-05-05', 'lo'),
('jmartine', 'ZXSAbAI', 'Martinez', 'Justin', '2010-05-05', '2018-05-05', 'lo'),
('jmccoy7n', 'iiE6IM', 'Mccoy', 'Joe', '2010-05-05', '2018-05-05', 'lo'),
('jmillsj', 'gBk2WW', 'Mills', 'Julia', '2010-05-05', '2018-05-05', 'lo'),
('jnguyen7', '5390xdps', 'Nguyen', 'Judy', '2010-05-05', '2018-05-05', 'lo'),
('jpalmer7', 'HwcGpiFQe', 'Palmer', 'Janice', '2010-05-05', '2018-05-05', 'lo'),
('jsnyder1', '4x6ycrh00N', 'Snyder', 'Jason', '2010-05-05', '2018-05-05', 'lo'),
('jwardm', 'BsDURV', 'Ward', 'Jane', '2010-05-05', '2018-05-05', 'lo'),
('jwilliam', '79lAtTPCZ', 'Williams', 'James', '2010-05-05', '2018-05-05', 'lo'),
('jwillis7', 'PxWCnCjx', 'Willis', 'Jerry', '2010-05-05', '2018-05-05', 'lo'),
('jwood7t', 'cDmK7KMG', 'Wood', 'Joan', '2010-05-05', '2018-05-05', 'lo'),
('kduncan1', 'uMSS6AU4b', 'Duncan', 'Kimberly', '2010-05-05', '2018-05-05', 'lo'),
('kmcdonal', 'ffKF03', 'Mcdonald', 'Karen', '2010-05-05', '2018-05-05', 'lo'),
('lberry6b', 'oSNTm79bJ8', 'Berry', 'Larry', '2010-05-05', '2018-05-05', 'lo'),
('lharper7', '6KIJAWel', 'Harper', 'Louis', '2010-05-05', '2018-05-05', 'lo'),
('lhernand', 'uPZJld', 'Hernandez', 'Larry', '2010-05-05', '2018-05-05', 'lo'),
('lmartin6', 'GtJzgQiYFz', 'Martin', 'Lori', '2010-05-05', '2018-05-05', 'lo'),
('lmontgom', 'eHPg1UmDBM', 'Montgomery', 'Larry', '2010-05-05', '2018-05-05', 'lo'),
('lwest10', 'nMCL7OTBF4', 'West', 'Louis', '2010-05-05', '2018-05-05', 'lo'),
('madams7h', 'BP5DmArPbd', 'Adams', 'Margaret', '2010-05-05', '2018-05-05', 'lo'),
('mblack1k', 'ks4IQEYK', 'Black', 'Martin', '2010-05-05', '2018-05-05', 'lo'),
('mday5', 'MZyjbSAaXW', 'Day', 'Martha', '2010-05-05', '2018-05-05', 'lo'),
('mford7l', 'a3Zo7fHqJf', 'Ford', 'Margaret', '2010-05-05', '2018-05-05', 'lo'),
('mray81', 'EUTsUupV', 'Ray', 'Margaret', '2010-05-05', '2018-05-05', 'lo'),
('msulliva', '26Iv3mQ', 'Sullivan', 'Matthew', '2010-05-05', '2018-05-05', 'lo'),
('nwatsonl', '9ORqVxlSVJ', 'Watson', 'Norma', '2010-05-05', '2018-05-05', 'lo'),
('pburtony', 'd1dkkIKCd8', 'Burton', 'Paul', '2010-05-05', '2018-05-05', 'lo'),
('pdunn17', 'XpInqNUbZT', 'Dunn', 'Phillip', '2010-05-05', '2018-05-05', 'lo'),
('pfox6s', 'eyUPF33kH', 'Fox', 'Pamela', '2010-05-05', '2018-05-05', 'lo'),
('pfrazier', 'cOcBjyGVZr', 'Frazier', 'Phillip', '2010-05-05', '2018-05-05', 'lo'),
('pgibson1', 'vAJMAMET', 'Gibson', 'Philip', '2010-05-05', '2018-05-05', 'lo'),
('pgraham1', 'Yz3fstJQKS', 'Graham', 'Patricia', '2010-05-05', '2018-05-05', 'lo'),
('pkelly1w', 'FmzzDbYgaV', 'Kelly', 'Phyllis', '2010-05-05', '2018-05-05', 'lo'),
('plawson2', '7jhMkVGi', 'Lawson', 'Patrick', '2010-05-05', '2018-05-05', 'lo'),
('pstewart', 'jGKdEhs83E', 'Stewart', 'Pamela', '2010-05-05', '2018-05-05', 'lo'),
('pwagner6', 'vwNa4ChXC', 'Wagner', 'Philip', '2010-05-05', '2018-05-05', 'lo'),
('pwatsond', 'VFPP80j', 'Watson', 'Phillip', '2010-05-05', '2018-05-05', 'lo'),
('pwoodsk', 'Nb9mH1tp', 'Woods', 'Philip', '2010-05-05', '2018-05-05', 'lo'),
('rcole1h', 'C8lvd4V', 'Cole', 'Roy', '2010-05-05', '2018-05-05', 'lo'),
('rcole8', 'qam5GoxQ', 'Cole', 'Rebecca', '2010-05-05', '2018-05-05', 'lo'),
('rmoreno7', 'nzzxo4exTY', 'Moreno', 'Russell', '2010-05-05', '2018-05-05', 'lo'),
('rreed18', 'SSMbrnGNaz', 'Reed', 'Raymond', '2010-05-05', '2018-05-05', 'lo'),
('rwells3', 'bfXPFHC', 'Wells', 'Raymond', '2010-05-05', '2018-05-05', 'lo'),
('ryoung74', '4EIOp7Rx', 'Young', 'Ralph', '2010-05-05', '2018-05-05', 'lo'),
('sgomez6y', 'r3HAop4K', 'Gomez', 'Sean', '2010-05-05', '2018-05-05', 'lo'),
('sgutierr', 'FpHjqD', 'Gutierrez', 'Scott', '2010-05-05', '2018-05-05', 'lo'),
('sharper7', 'O01qIL', 'Harper', 'Sarah', '2010-05-05', '2018-05-05', 'lo'),
('sharris1', '18QXhEWEm', 'Harris', 'Sara', '2010-05-05', '2018-05-05', 'lo'),
('slee1n', 'YTZGpHdR1P', 'Lee', 'Sarah', '2010-05-05', '2018-05-05', 'lo'),
('smartin7', 'ChfFToI', 'Martin', 'Sean', '2010-05-05', '2018-05-05', 'lo'),
('sparker1', 'sFoOla', 'Parker', 'Sarah', '2010-05-05', '2018-05-05', 'lo'),
('spowell1', 'oyNIxaR4dP', 'Powell', 'Susan', '2010-05-05', '2018-05-05', 'lo'),
('sroberts', '1rpZyACs', 'Roberts', 'Samuel', '2010-05-05', '2018-05-05', 'lo'),
('sscott7d', 'tJKg7gT33a', 'Scott', 'Susan', '2010-05-05', '2018-05-05', 'lo'),
('ssimmons', '4eH1sI', 'Simmons', 'Sandra', '2010-05-05', '2018-05-05', 'lo'),
('sstephen', 'ISzFIHFwhn', 'Stephens', 'Samuel', '2010-05-05', '2018-05-05', 'lo'),
('staylor7', 'ITHn1FT', 'Taylor', 'Shirley', '2010-05-05', '2018-05-05', 'lo'),
('sweaver8', 'MNgTglNR0V', 'Weaver', 'Shirley', '2010-05-05', '2018-05-05', 'lo'),
('tblackg', '4ZhQsf', 'Black', 'Timothy', '2010-05-05', '2018-05-05', 'lo'),
('tcoleman', 'nu4UvEKg', 'Coleman', 'Terry', '2010-05-05', '2018-05-05', 'lo'),
('tcruz14', 'ymBjazYW', 'Cruz', 'Teresa', '2010-05-05', '2018-05-05', 'lo'),
('tcunning', 'QxCr0X', 'Cunningham', 'Terry', '2010-05-05', '2018-05-05', 'lo'),
('test', 'test', 'test', 'test', '2010-05-05', '2018-05-05', 'lo'),
('tgonzale', 'n7k84j', 'Gonzales', 'Tammy', '2010-05-05', '2018-05-05', 'lo'),
('tharris1', '9frUAnLF0p', 'Harris', 'Todd', '2010-05-05', '2018-05-05', 'lo'),
('tsnyderv', 'ZJuVQekd', 'Snyder', 'Tina', '2010-05-05', '2018-05-05', 'lo'),
('vgonzale', 'ETMmwK09j', 'Gonzales', 'Victor', '2010-05-05', '2018-05-05', 'lo'),
('vsnyder1', 'K7IPJBQH3Z', 'Snyder', 'Virginia', '2010-05-05', '2018-05-05', 'lo'),
('wcarr6v', 'jagW4npe', 'Carr', 'William', '2010-05-05', '2018-05-05', 'lo'),
('wlopez7i', '2hxseOTLwb', 'Lopez', 'Wayne', '2010-05-05', '2018-05-05', 'lo'),
('wpayne12', 'HqMN2GZ', 'Payne', 'Wayne', '2010-05-05', '2018-05-05', 'lo'),
('wrichard', 'y2PJoqG', 'Richardson', 'Wayne', '2010-05-05', '2018-05-05', 'lo'),
('wwest7z', 'JFTVo0Po', 'West', 'William', '2010-05-05', '2018-05-05', 'lo');

-- --------------------------------------------------------

--
-- Table structure for table `relation`
--

CREATE TABLE IF NOT EXISTS `relation` (
  `NORELATION` int(6) NOT NULL AUTO_INCREMENT,
  `LOISANT1` tinyint(4) DEFAULT NULL,
  `LOISANT2` tinyint(4) DEFAULT NULL,
  `L1AIME` tinyint(1) DEFAULT NULL,
  `L2AIME` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`NORELATION`),
  KEY `AIMANT` (`LOISANT1`),
  KEY `AIMEE` (`LOISANT2`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `relation`
--

INSERT INTO `relation` (`NORELATION`, `LOISANT1`, `LOISANT2`, `L1AIME`, `L2AIME`) VALUES
(3, 0, 1, 1, 1),
(5, 1, 18, 1, 1),
(6, 0, 18, 1, 1),
(7, 2, 22, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `type_anim`
--

CREATE TABLE IF NOT EXISTS `type_anim` (
  `CODETYPEANIM` char(5) NOT NULL,
  `NOMTYPEANIM` char(50) DEFAULT NULL,
  PRIMARY KEY (`CODETYPEANIM`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `type_anim`
--

INSERT INTO `type_anim` (`CODETYPEANIM`, `NOMTYPEANIM`) VALUES
('carte', 'Jeux de Cartes'),
('deten', 'Détente'),
('gre', 'fezfze'),
('sport', 'Sport');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activite`
--
ALTER TABLE `activite`
  ADD CONSTRAINT `activite_ibfk_1` FOREIGN KEY (`CODEANIM`) REFERENCES `animation` (`CODEANIM`),
  ADD CONSTRAINT `activite_ibfk_2` FOREIGN KEY (`NOENCADRANT`) REFERENCES `encadrant` (`NOENCADRANT`),
  ADD CONSTRAINT `activite_ibfk_3` FOREIGN KEY (`CODEETATACT`) REFERENCES `etat_act` (`CODEETATACT`);

--
-- Constraints for table `animation`
--
ALTER TABLE `animation`
  ADD CONSTRAINT `animation_ibfk_1` FOREIGN KEY (`CODETYPEANIM`) REFERENCES `type_anim` (`CODETYPEANIM`);

--
-- Constraints for table `encadrant`
--
ALTER TABLE `encadrant`
  ADD CONSTRAINT `encadrant_ibfk_1` FOREIGN KEY (`USER`) REFERENCES `profil` (`USER`);

--
-- Constraints for table `inscription`
--
ALTER TABLE `inscription`
  ADD CONSTRAINT `inscription_ibfk_1` FOREIGN KEY (`NOLOISANT`) REFERENCES `loisant` (`NOLOISANT`),
  ADD CONSTRAINT `inscription_ibfk_2` FOREIGN KEY (`CODEANIM`, `DATEACT`) REFERENCES `activite` (`CODEANIM`, `DATEACT`),
  ADD CONSTRAINT `inscription_ibfk_3` FOREIGN KEY (`CODEANIM`) REFERENCES `activite` (`CODEANIM`);

--
-- Constraints for table `loisant`
--
ALTER TABLE `loisant`
  ADD CONSTRAINT `loisant_ibfk_1` FOREIGN KEY (`USER`) REFERENCES `profil` (`USER`);

--
-- Constraints for table `planning`
--
ALTER TABLE `planning`
  ADD CONSTRAINT `planning_ibfk_1` FOREIGN KEY (`NOENCADRANT`) REFERENCES `encadrant` (`NOENCADRANT`),
  ADD CONSTRAINT `planning_ibfk_2` FOREIGN KEY (`CODEANIM`, `DATEACT`) REFERENCES `activite` (`CODEANIM`, `DATEACT`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;