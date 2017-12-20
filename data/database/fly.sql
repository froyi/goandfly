-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 20. Dez 2017 um 07:51
-- Server-Version: 10.1.21-MariaDB
-- PHP-Version: 7.1.1

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
-- Tabellenstruktur für Tabelle `continent`
--

CREATE TABLE `continent` (
  `continentId` varchar(200) NOT NULL,
  `name` varchar(100) NOT NULL,
  `flaeche` text NOT NULL,
  `gliederung` text NOT NULL,
  `tourismus` text NOT NULL,
  `klima` text NOT NULL,
  `bild` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `continent`
--

INSERT INTO `continent` (`continentId`, `name`, `flaeche`, `gliederung`, `tourismus`, `klima`, `bild`) VALUES
('531f6786-ca98-4bf1-82cc-e8062974646c', 'Europa', 'etwa 10Mio km&sup2;', 'Aus der Sicht von Deutschland haben wir Ländergruppen zusammengefasst, die Schwerpunkte bei den Reiseangeboten bilden (Kartenskizze). Teilweise gibt es Gemeisamkeiten kulturhistorischer oder auch klimatischer Art.', 'Bedingt durch das recht gleichm&auml;&szlig;ig verteilte Netz an Metropolen (London,Paris, Rom..) und historisch interessanten St&auml;dten hat sich ein intensiver urbaner Tourismus ausgepr&auml;gt, der Bildung, Wellness als auch Sport und Shopping einschlie&szlig;t. Zunehmend finden dabei bahngebundene Varianten, als auch Flussreisen Ber&uuml;cksichtigung. Kultur bildet eine Einheit mit Natur.  Kleinere Hotels in den sch&ouml;nsten Gebirgs-und Tallagen sind zentraler Ort f&uuml;r Wanderungen und Hobbieangebote jeder Art. Hochleistungsvarianten sind in Europa die Ausnahme. Genuss, pers&ouml;nliche Zeit f&uuml;r sich und die Familie stehen im Mittelpunkt.', 'Der Norden ist kalt- bis warm gem&auml;&szlig;igt, der S&uuml;den ist suptropisch. Regionen der Gebirgsklimate. Die Niederschlagsh&auml;ufigkeit nimmt im Sommer von Skandinavien zum Mittelmeer ab, Temperaturschwankungen nehmen von West nach Ost zu.  Es existieren signifikante Ver&auml;nderungen der Regionen die Schneefall und Eisbildung aufweisen (Hochgebirge, Spitzbergen).', 'data/img/continent/europa.png');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `frage`
--

CREATE TABLE `frage` (
  `frageId` varchar(200) NOT NULL,
  `reiseId` varchar(200) NOT NULL,
  `frage` text NOT NULL,
  `antwort` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `leistung`
--

CREATE TABLE `leistung` (
  `leistungId` varchar(200) NOT NULL,
  `reiseId` varchar(200) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `neuigkeiten`
--

CREATE TABLE `neuigkeiten` (
  `newsId` varchar(200) NOT NULL,
  `titel` varchar(100) NOT NULL,
  `datum` date NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `region`
--

CREATE TABLE `region` (
  `regionId` varchar(200) NOT NULL,
  `continentId` varchar(200) NOT NULL,
  `name` varchar(100) NOT NULL,
  `beispiellaender` varchar(200) NOT NULL,
  `beschreibung` text NOT NULL,
  `bild` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `region`
--

INSERT INTO `region` (`regionId`, `continentId`, `name`, `beispiellaender`, `beschreibung`, `bild`) VALUES
('a647ec27-fe1f-48a8-932b-51899fe13825', '531f6786-ca98-4bf1-82cc-e8062974646c', 'Nordeuropa', 'Skandinavien, Gro&szlig;britannien, Irland', 'Nordeuropa deckt in unseren Offerten Reiseangebote in D&auml;nemark, Finnland, Schweden, Norwegen, Gro&szlig;britannien, Irland und Island ab (Gr&ouml;nland ist der Arktis zugeordnet). St&auml;dtereisen in alle Hauptst&auml;dte, als auch Wanderreisen stellen den touristischen Schwerpunkt dar. Kombinierbar sind die Hurtigruten, G&ouml;takanalpassagen, Autorundreisen und Sonderprogramme. Dazu z&auml;hlen z.B. Husky-Offerten, Bahnreisen in Norwegen und Gro&szligbritannien. Neben unseren ausgesuchten Offerten der Spezialisten, werden Sie bei <a href=\"diamir.php\">DIAMIR</a> (aktiv) und <a href=\"http://goandfly-bus.blueandwhite.de/\">BLUE & WHITE</a> (Bus/Bahn Europa) f&uuml;ndig.', 'data/img/region/nordeuropa.png');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `reise`
--

CREATE TABLE `reise` (
  `reiseId` varchar(200) NOT NULL,
  `kurzbeschreibung` text NOT NULL,
  `beschreibung` text NOT NULL,
  `titel` varchar(200) NOT NULL,
  `personen` varchar(50) NOT NULL,
  `reisedauer` int(3) NOT NULL,
  `flugzeit` int(3) NOT NULL DEFAULT '0',
  `sprache` varchar(50) NOT NULL,
  `terrain` int(1) NOT NULL,
  `karte` varchar(200) NOT NULL,
  `bearbeitet` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `teaser` varchar(200) NOT NULL,
  `sichtbar` date NOT NULL,
  `bild` varchar(200) NOT NULL,
  `veranstalter` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `reiseverlauf`
--

CREATE TABLE `reiseverlauf` (
  `reisverlaufId` varchar(200) NOT NULL,
  `reiseId` varchar(200) NOT NULL,
  `reisetag` int(3) NOT NULL,
  `titel` varchar(200) NOT NULL,
  `beschreibung` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `reise_region`
--

CREATE TABLE `reise_region` (
  `reiseRegionId` varchar(200) NOT NULL,
  `reiseId` varchar(200) NOT NULL,
  `regionId` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `reise_tag`
--

CREATE TABLE `reise_tag` (
  `reiseTagId` varchar(200) NOT NULL,
  `reiseId` varchar(200) NOT NULL,
  `tagId` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tag`
--

CREATE TABLE `tag` (
  `tagId` varchar(200) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `teaserbild`
--

CREATE TABLE `teaserbild` (
  `teaserbildId` varchar(200) NOT NULL,
  `teaserbild` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `termin`
--

CREATE TABLE `termin` (
  `terminId` varchar(200) NOT NULL,
  `reiseId` varchar(200) NOT NULL,
  `start` date NOT NULL,
  `ende` date NOT NULL,
  `preis` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `userId` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `passwordHash` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `continent`
--
ALTER TABLE `continent`
  ADD PRIMARY KEY (`continentId`);

--
-- Indizes für die Tabelle `frage`
--
ALTER TABLE `frage`
  ADD PRIMARY KEY (`frageId`);

--
-- Indizes für die Tabelle `leistung`
--
ALTER TABLE `leistung`
  ADD PRIMARY KEY (`leistungId`);

--
-- Indizes für die Tabelle `neuigkeiten`
--
ALTER TABLE `neuigkeiten`
  ADD PRIMARY KEY (`newsId`);

--
-- Indizes für die Tabelle `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`regionId`);

--
-- Indizes für die Tabelle `reise`
--
ALTER TABLE `reise`
  ADD PRIMARY KEY (`reiseId`);

--
-- Indizes für die Tabelle `reiseverlauf`
--
ALTER TABLE `reiseverlauf`
  ADD PRIMARY KEY (`reisverlaufId`);

--
-- Indizes für die Tabelle `reise_region`
--
ALTER TABLE `reise_region`
  ADD PRIMARY KEY (`reiseRegionId`);

--
-- Indizes für die Tabelle `reise_tag`
--
ALTER TABLE `reise_tag`
  ADD PRIMARY KEY (`reiseTagId`);

--
-- Indizes für die Tabelle `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`tagId`);

--
-- Indizes für die Tabelle `teaserbild`
--
ALTER TABLE `teaserbild`
  ADD PRIMARY KEY (`teaserbildId`);

--
-- Indizes für die Tabelle `termin`
--
ALTER TABLE `termin`
  ADD PRIMARY KEY (`terminId`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
