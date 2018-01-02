-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 02. Jan 2018 um 14:55
-- Server-Version: 5.7.14
-- PHP-Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `fly`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `teaserbild`
--

CREATE TABLE `teaserbild` (
  `teaserbildId` varchar(200) NOT NULL,
  `teaserbild` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `teaserbild`
--

INSERT INTO `teaserbild` (`teaserbildId`, `teaserbild`) VALUES
('06b55046-daa3-4e30-bbba-b535d42fdb9d', 'teaser_felsen.jpg'),
('1f1ab238-85c2-4599-93e4-6cb5a898f17a', 'teaser_eisberg.jpg'),
('316ebedd-542e-4b11-884a-7742529cea5c', 'teaser_maputo.jpg'),
('5050460a-3de3-48e4-93ff-86286c96f886', 'teaser_strand2.jpg'),
('50cae089-4648-4816-8086-4b9e8ebdef81', 'teaser_foto.jpg'),
('59192706-9976-4dd3-970d-9053e8fa906b', 'teaser_test.jpg'),
('60c3d6d6-49ba-4b69-8279-7c6d0c5cd8d8', 'teaser_safari.jpg'),
('666a6d6e-582e-46d7-b5c4-1539dac18550', 'teaser_ballon.jpg'),
('894dfc1e-aa90-4403-acb5-54d5564bfb59', 'teaser_strand.jpg'),
('adcf537a-bfaf-461d-a75e-9b3df52717c7', 'teaser_kinder.jpg'),
('b36b955f-bf49-48c7-ae11-a55a76387cb3', 'teaser_namibia.jpg'),
('c7acda7f-c055-4ce3-89aa-d3af2f8a5515', 'teaser_japan.jpg'),
('d01a07d2-ba5e-4792-8ba4-08266de5a10c', 'teaser_pinguin.jpg'),
('e0b11657-23d9-4925-9504-075832f07387', 'teaser_suedafrika.jpg'),
('febc604f-9797-4391-b4a3-1baedde5d7b0', 'teaser_strauss.jpg');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `teaserbild`
--
ALTER TABLE `teaserbild`
  ADD PRIMARY KEY (`teaserbildId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
