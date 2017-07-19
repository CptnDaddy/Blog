-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 02. Jun 2017 um 00:23
-- Server-Version: 10.1.16-MariaDB
-- PHP-Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `blog`
--

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `getpermissions`
--
CREATE TABLE `getpermissions` (
`userid` int(11)
,`name` varchar(20)
,`permissionid` int(11)
,`permission` varchar(20)
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `getposts`
--
CREATE TABLE `getposts` (
`id` int(11)
,`title` varchar(50)
,`post` varchar(50000)
,`name` varchar(20)
,`date` timestamp
,`haspic` tinyint(1)
);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `permission`
--

CREATE TABLE `permission` (
  `id` int(11) NOT NULL,
  `permission` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `permission`
--

INSERT INTO `permission` (`id`, `permission`) VALUES
(1, 'Einstellungen ändern'),
(2, 'Posts verfassen'),
(3, 'Posts bearbeiten'),
(4, 'User erstellen'),
(5, 'User bearbeiten'),
(6, 'Rechte ändern');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `post` varchar(50000) DEFAULT NULL,
  `fk_author` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `haspic` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `posts`
--

INSERT INTO `posts` (`id`, `title`, `post`, `fk_author`, `date`, `haspic`) VALUES
(1, 'Lorem ipsum ', '<p><strong>Lorem ipsum</strong> dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. &nbsp;&nbsp;</p><ul><li>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. &nbsp;&nbsp;</li></ul><p>Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. &nbsp;&nbsp;</p><p><em>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. &nbsp;&nbsp;</em></p><p>Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis. &nbsp;&nbsp;</p><p>At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, At accusam aliquyam diam diam dolore dolores duo eirmod eos erat, et nonumy sed tempor et et invidunt justo labore Stet clita ea et gubergren, kasd magna no rebum. sanctus sea sed takimata ut vero voluptua. est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur</p>', 1, '2017-06-01 15:55:41', 0),
(3, 'Programmieren', '<p>Des is der gr&ouml;&szlig;te....</p><p>...</p><p>...</p><p>...</p><p>Tomat&ouml;</p>', 1, '2017-06-01 19:30:24', 0),
(4, 'TODO LIST', '<p>Tomato</p><p>Tom&auml;t&ouml;</p><p>Kartoffel</p><p>Kart&ouml;ffel</p>', 1, '2017-06-01 19:30:51', 0),
(6, 'abcabc', '<p>adfafwafwaf124312412</p><p>412</p><p>412</p><p>4</p>', 1, '2017-06-01 19:31:20', 0),
(7, '1241241', '<p>420</p><p>420</p><p>420</p><p>420</p><p>&nbsp;</p>', 1, '2017-06-01 19:31:26', 0),
(8, '123412', '<p>124124124411</p>', 1, '2017-06-01 19:31:32', 0),
(9, 'asfa14314', '<p>1fasfaf</p>', 1, '2017-06-01 19:31:44', 0),
(10, '125412512sadfa', '<p>21414124saffafaffasfas</p><p>f</p><p>asf</p><p>as</p><p>fa</p>', 1, '2017-06-01 19:31:49', 0),
(11, '21590213ujfa', '<p>POIUMMEL</p>', 1, '2017-06-01 19:31:56', 0),
(20, 'Suchtest lololol', '<p>Lorem ipsum dolor sit amet</p>', 10, '2017-06-01 21:37:57', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `settings`
--

CREATE TABLE `settings` (
  `title` varchar(30) NOT NULL,
  `logo` varchar(30) NOT NULL,
  `shortbio` varchar(150) NOT NULL,
  `navpic` tinyint(1) NOT NULL DEFAULT '0',
  `favicon` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `settings`
--

INSERT INTO `settings` (`title`, `logo`, `shortbio`, `navpic`, `favicon`) VALUES
('Blog', 'Mein Blog', 'this is funny', 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `name`, `password`) VALUES
(1, 'admin', 'a8be042e5da5f52e7c122c234f0a5a7c'),
(2, 'CptnDaddy', '2ad4df4d8472d092d1bd5abd0ccc7c8e'),
(7, 'Kjosu', 'fca5197b100c2d50e78cb933c63141fa'),
(10, 'TestUser', '827ccb0eea8a706c4c34a16891f84e7b');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_hat_permission`
--

CREATE TABLE `user_hat_permission` (
  `userid` int(11) DEFAULT NULL,
  `permissionid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `user_hat_permission`
--

INSERT INTO `user_hat_permission` (`userid`, `permissionid`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(2, 1),
(2, 6),
(2, 1),
(2, 6),
(2, 1),
(2, 6),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(7, 2),
(7, 3),
(10, 1),
(10, 2),
(10, 3);

-- --------------------------------------------------------

--
-- Struktur des Views `getpermissions`
--
DROP TABLE IF EXISTS `getpermissions`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getpermissions`  AS  select `h`.`userid` AS `userid`,`u`.`name` AS `name`,`h`.`permissionid` AS `permissionid`,`p`.`permission` AS `permission` from ((`user_hat_permission` `h` join `users` `u` on((`u`.`id` = `h`.`userid`))) join `permission` `p` on((`p`.`id` = `h`.`permissionid`))) ;

-- --------------------------------------------------------

--
-- Struktur des Views `getposts`
--
DROP TABLE IF EXISTS `getposts`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getposts`  AS  select `p`.`id` AS `id`,`p`.`title` AS `title`,`p`.`post` AS `post`,`u`.`name` AS `name`,`p`.`date` AS `date`,`p`.`haspic` AS `haspic` from (`posts` `p` join `users` `u` on((`u`.`id` = `p`.`fk_author`))) ;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_author` (`fk_author`);

--
-- Indizes für die Tabelle `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`title`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `user_hat_permission`
--
ALTER TABLE `user_hat_permission`
  ADD KEY `user_hat_permission_ibfk_1` (`userid`),
  ADD KEY `user_hat_permission_ibfk_2` (`permissionid`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT für Tabelle `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`fk_author`) REFERENCES `users` (`id`);

--
-- Constraints der Tabelle `user_hat_permission`
--
ALTER TABLE `user_hat_permission`
  ADD CONSTRAINT `user_hat_permission_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_hat_permission_ibfk_2` FOREIGN KEY (`permissionid`) REFERENCES `permission` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
