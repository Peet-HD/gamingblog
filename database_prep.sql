/**
 * Author:  TH<>
 * Created: 11.07.2016
 */

------------------------------------------------------------------------------
-- Benutzer-ADMIN-Tabelle

DROP TABLE IF EXISTS `blog_entry`;
DROP TABLE IF EXISTS `blog_category`;
DROP TABLE IF EXISTS `comment`;
DROP TABLE IF EXISTS `chat_data`;
DROP TABLE IF EXISTS `user_admin`;
DROP TABLE IF EXISTS `user_visitor`;
DROP TABLE IF EXISTS `general_page_content`;

CREATE TABLE `user_admin` (
 `adminId` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `userName` varchar(40) NOT NULL,
 `password` varchar(100) NOT NULL,
 `email` varchar(100) NOT NULL,
 `adminLevel` tinyint(3) unsigned NOT NULL,
 `active` tinyint(1) NOT NULL,
 PRIMARY KEY (`adminId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------------------------------------------------------
-- Benutzer-BESUCHER-Tabelle

-- Tabellenstruktur für Tabelle `user_visitor`
CREATE TABLE `user_visitor` (
 `userId` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `userName` varchar(40) NOT NULL,
 `password` varchar(100) NOT NULL,
 `email` varchar(100) NOT NULL,
 `active` tinyint(1) NOT NULL DEFAULT '0',
 `activatedOnce` tinyint(1) NOT NULL DEFAULT '0',
 PRIMARY KEY (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8

-- ----------------------------------------------------------------------------

-- BLOG-Category-Tabelle
CREATE TABLE `blog_category` (
 `categoryId` int(10) unsigned NOT NULL,
 `categoryName` varchar(60) NOT NULL,
 PRIMARY KEY (`categoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- BLOG-Eintrags-Tabelle
-- Tabellenstruktur für Tabelle `blog_entry`
CREATE TABLE `blog_entry` (
 `blogId` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `title` varchar(100) NOT NULL,
 `text` mediumtext NOT NULL,
 `adminId` int(10) unsigned NOT NULL,
 `timestamp` int(10) unsigned NOT NULL,
 `categoryId` int(10) unsigned NOT NULL,
 PRIMARY KEY (`blogId`),
 KEY `adminId` (`adminId`),
 KEY `categoryId` (`categoryId`),
 CONSTRAINT `admin_id_fk` FOREIGN KEY (`adminId`) REFERENCES `user_admin` (`adminId`) ON UPDATE CASCADE,
 CONSTRAINT `category_id_fk` FOREIGN KEY (`categoryId`) REFERENCES `blog_category` (`categoryId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `comment` (
 `commentID` int(11) NOT NULL,
 `BeitragID` int(11) NOT NULL,
 `Kommentar` blob NOT NULL,
 `DatumKommentar` datetime NOT NULL,
 `Name` varchar(50) NOT NULL,
 `Email` varchar(200) DEFAULT NULL,
 PRIMARY KEY (`commentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- ----------------------------------------------------------------------------
-- CHAT-Tabelle

-- Tabellenstruktur für Tabelle `chat_data`
CREATE TABLE `chat_data` (
 `entryId` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `userId` int(11) NOT NULL,
 `adminEntry` tinyint(1) NOT NULL,
 `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 `text` varchar(50) NOT NULL,
 PRIMARY KEY (`entryId`)
) ENGINE=InnoDB AUTO_INCREMENT=709 DEFAULT CHARSET=utf8;


-- ----------------------------------------------------------------------------
-- Allgemeine Seiteninhalte-Tabelle

-- Tabellenstruktur für Tabelle `general_page_content`
CREATE TABLE `general_page_content` (
 `contendId` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `pageHtml` text NOT NULL,
 `lastChange` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`contendId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8