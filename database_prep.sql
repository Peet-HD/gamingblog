/**
 * Author:  TH<>
 * Created: 11.07.2016
 */

-- ----------------------------------------------------------------------------
-- Benutzer-ADMIN-Tabelle

DROP TABLE IF EXISTS `blog_commentary`;
DROP TABLE IF EXISTS `blog_entry`;
DROP TABLE IF EXISTS `blog_category`;
DROP TABLE IF EXISTS `chat_data`;
DROP TABLE IF EXISTS `user_admin`;
DROP TABLE IF EXISTS `user_visitor`;
DROP TABLE IF EXISTS `general_page_content`;

CREATE TABLE `user_admin` (
 `adminId` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'The admin-primary-key',
 `userName` varchar(40) NOT NULL COMMENT 'The visible admin-name',
 `password` varchar(100) NOT NULL COMMENT 'The password for the admin-user',
 `email` varchar(100) NOT NULL COMMENT 'The email for the admin-user',
 `active` tinyint(1) NOT NULL COMMENT 'The flag, which defines if the admin-account can be used to login',
 `lastLogin` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`adminId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8

-- ----------------------------------------------------------------------------
-- Benutzer-BESUCHER-Tabelle

-- Tabellenstruktur für Tabelle `user_visitor`

CREATE TABLE `user_visitor` (
 `userId` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'The visitor-primary-key',
 `userName` varchar(40) NOT NULL COMMENT 'The visible user-name',
 `password` varchar(100) NOT NULL COMMENT 'The password for the visitor-user',
 `email` varchar(100) NOT NULL COMMENT 'The email for the visitor-user',
 `active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'The flag, which defines if the user-account can be used to login',
 `activatedOnce` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'The flag, which defines, if the user-account has been activated once',
 `lastLogin` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'The last login-time of the user',
 PRIMARY KEY (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8


-- ----------------------------------------------------------------------------

-- BLOG-Category-Tabelle
CREATE TABLE `blog_category` (
 `categoryId` int(10) unsigned NOT NULL COMMENT 'The category-primary-key' AUTO_INCREMENT,
 `categoryName` varchar(60) NOT NULL COMMENT 'The describing category-name',
 PRIMARY KEY (`categoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- BLOG-Eintrags-Tabelle
-- Tabellenstruktur für Tabelle `blog_entry`
CREATE TABLE `blog_entry` (
 `blogId` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'The blog-entry-primary-key',
 `title` varchar(100) NOT NULL COMMENT 'The describing entry-title',
 `text` mediumtext NOT NULL COMMENT 'The entry-html-content',
 `adminId` int(10) unsigned NOT NULL COMMENT 'The associated admin-id (who created the blog-entry)',
 `timestamp` int(10) unsigned NOT NULL COMMENT 'The creation-timestamp',
 `categoryId` int(10) unsigned NOT NULL COMMENT 'The associated blog-category-id',
 PRIMARY KEY (`blogId`),
 KEY `adminId` (`adminId`),
 KEY `categoryId` (`categoryId`),
 CONSTRAINT `admin_id_fk` FOREIGN KEY (`adminId`) REFERENCES `user_admin` (`adminId`) ON UPDATE CASCADE,
 CONSTRAINT `category_id_fk` FOREIGN KEY (`categoryId`) REFERENCES `blog_category` (`categoryId`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE blog_commentary (
 commentId int(11) NOT NULL AUTO_INCREMENT COMMENT 'The comment-primary-key',
 blogId int(10) unsigned NOT NULL COMMENT 'The associated blog-id to the comment',
 text text NOT NULL COMMENT 'The comment-text',
 userId int(10) unsigned DEFAULT NULL COMMENT 'The associated user-id to the comment',
 timestamp datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The creation-timestamp',
 PRIMARY KEY (commentId),
 KEY blogId (blogId),
 KEY commentId (commentId),
 KEY commentId_2 (commentId),
 CONSTRAINT blog_commentary_ibfk_1 FOREIGN KEY (blogId) REFERENCES blog_entry (blogId) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;
-- ----------------------------------------------------------------------------
-- CHAT-Tabelle

-- Tabellenstruktur für Tabelle `chat_data`
CREATE TABLE `chat_data` (
 `entryId` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'The chatline-primary-key',
 `userId` int(11) NOT NULL COMMENT 'The associated user-id (who wrote the chat-message)',
 `adminEntry` tinyint(1) NOT NULL COMMENT 'The information, if the msg is from an admin',
 `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'The creation-timestamp',
 `text` varchar(50) NOT NULL COMMENT 'The chat-message-text',
 PRIMARY KEY (`entryId`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


-- ----------------------------------------------------------------------------
-- Allgemeine Seiteninhalte-Tabelle

-- Tabellenstruktur für Tabelle `general_page_content`
CREATE TABLE `general_page_content` (
 `contentId` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'The primary-content-key',
 `pageHtml` text NOT NULL COMMENT 'The page-html-content',
 `lastChange` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The last-change-timestamp',
 PRIMARY KEY (`contentId`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;


-- Test-Data ===================================================================
-- DATA-Inserts
-- Blog-Category
INSERT INTO `blog_category` (`categoryId`, `categoryName`) VALUES (NULL, 'UI / UX');
INSERT INTO `blog_category` (`categoryId`, `categoryName`) VALUES (NULL, 'Technik');
INSERT INTO `blog_category` (`categoryId`, `categoryName`) VALUES (NULL, 'Source');
INSERT INTO `blog_category` (`categoryId`, `categoryName`) VALUES (NULL, 'Multiplayer');
INSERT INTO `blog_category` (`categoryId`, `categoryName`) VALUES (NULL, 'GFX');

-- General-Page-Content
SET sql_mode='NO_AUTO_VALUE_ON_ZERO';
INSERT INTO `general_page_content` (`contentId`, `pageHtml`, `lastChange`) VALUES (0,
'<h3>&Uuml;ber das Spiel "Tree-Hopper"</h3>
<p>Im Spiel steuert man einen kleinen Vogel welcher.. &nbsp;Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', CURRENT_TIMESTAMP);
INSERT INTO `general_page_content` (`contentId`, `pageHtml`, `lastChange`) VALUES (1,
'<h3>&Uuml;ber die Spieleschmiede "Lucky-Birds-Dev"</h3>
<p>Unser kleiner Entwicklerverein existiert schon seit 5 Jahren.&nbsp;Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', CURRENT_TIMESTAMP);
INSERT INTO `general_page_content` (`contentId`, `pageHtml`, `lastChange`) VALUES (2,
'<h1>Impressum</h1>
<p>Das Impressum bezieht sich sowohl auf die Internetpr&auml;senz auf <a>gamingblog.de</a></p>
<h4>Verantwortlich f&uuml;r dieses Angebot und Inhalt / Angaben gem&auml;&szlig; &sect; 5 TMG:<br /> Peter Bresic<br /> Thorsten Hufen<br /><br /></h4>
<h4>Inhaltlich Verantwortlicher gem&auml;&szlig; &sect; 55 Abs. 2 RStV:</h4>
<p><br /> Peter Bresic<br /> Thorsten Hufen<br /><br /></p>
<div id="Haftungsausschluss" class="rechtsausschluss">
<h3>Haftungsausschluss:</h3>
<br />
<h4>Haftung f&uuml;r Inhalte</h4>
Die Inhalte unserer Seiten wurden mit gr&ouml;&szlig;ter Sorgfalt erstellt. F&uuml;r die Richtigkeit, Vollst&auml;ndigkeit und Aktualit&auml;t der Inhalte k&ouml;nnen wir jedoch keine Gew&auml;hr &uuml;bernehmen. Als Diensteanbieter sind wir gem&auml;&szlig; &sect; 7 Abs.1 TMG f&uuml;r eigene Inhalte auf diesen Seiten nach den allgemeinen Gesetzen verantwortlich. Nach &sect;&sect; 8 bis 10 TMG sind wir als Diensteanbieter jedoch nicht verpflichtet, &uuml;bermittelte oder gespeicherte fremde Informationen zu &uuml;berwachen oder nach Umst&auml;nden zu forschen, die auf eine rechtswidrige T&auml;tigkeit hinweisen. Verpflichtungen zur Entfernung oder Sperrung der Nutzung von Informationen nach den allgemeinen Gesetzen bleiben hiervon unber&uuml;hrt. Eine diesbez&uuml;gliche Haftung ist jedoch erst ab dem Zeitpunkt der Kenntnis einer konkreten Rechtsverletzung m&ouml;glich. Bei Bekanntwerden von entsprechenden Rechtsverletzungen werden wir diese Inhalte umgehend entfernen.</div>
<div id="HaftungLinks" class="rechtsausschluss">
<h4>Haftung f&uuml;r Links</h4>
Unser Angebot enth&auml;lt Links zu externen Webseiten Dritter, auf deren Inhalte wir keinen Einfluss haben. Deshalb k&ouml;nnen wir f&uuml;r diese fremden Inhalte auch keine Gew&auml;hr &uuml;bernehmen. F&uuml;r die Inhalte der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber der Seiten verantwortlich. Die verlinkten Seiten wurden zum Zeitpunkt der Verlinkung auf m&ouml;gliche Rechtsverst&ouml;&szlig;e &uuml;berpr&uuml;ft. Rechtswidrige Inhalte waren zum Zeitpunkt der Verlinkung nicht erkennbar. Eine permanente inhaltliche Kontrolle der verlinkten Seiten ist jedoch ohne konkrete Anhaltspunkte einer Rechtsverletzung nicht zumutbar. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Links umgehend entfernen.</div>
<div id="Urheberrecht" class="rechtsausschluss">
<h4>Urheberrecht</h4>
Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem deutschen Urheberrecht. Die Vervielf&auml;ltigung, Bearbeitung, Verbreitung und jede Art der Verwertung au&szlig;erhalb der Grenzen des Urheberrechtes bed&uuml;rfen der schriftlichen Zustimmung des jeweiligen Autors bzw. Erstellers. Downloads und Kopien dieser Seite sind nur f&uuml;r den privaten, nicht kommerziellen Gebrauch gestattet. Soweit die Inhalte auf dieser Seite nicht vom Betreiber erstellt wurden, werden die Urheberrechte Dritter beachtet. Insbesondere werden Inhalte Dritter als solche gekennzeichnet. Sollten Sie trotzdem auf eine Urheberrechtsverletzung aufmerksam werden, bitten wir um einen entsprechenden Hinweis. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Inhalte umgehend entfernen.</div>
<div id="Datenschutz" class="rechtsausschluss">
<h4>Datenschutz</h4>
Die Nutzung unserer Webseite ist in der Regel ohne Angabe personenbezogener Daten m&ouml;glich. Soweit auf unseren Seiten personenbezogene Daten (beispielsweise Name, Anschrift oder eMail-Adressen) erhoben werden, erfolgt dies, soweit m&ouml;glich, stets auf freiwilliger Basis. Diese Daten werden ohne Ihre ausdr&uuml;ckliche Zustimmung nicht an Dritte weitergegeben. Wir weisen darauf hin, dass die Daten&uuml;bertragung im Internet (z.B. bei der Kommunikation per E-Mail) Sicherheitsl&uuml;cken aufweisen kann. Ein l&uuml;ckenloser Schutz der Daten vor dem Zugriff durch Dritte ist nicht m&ouml;glich. Der Nutzung von im Rahmen der Impressumspflicht ver&ouml;ffentlichten Kontaktdaten durch Dritte zur &Uuml;bersendung von nicht ausdr&uuml;cklich angeforderter Werbung und Informationsmaterialien wird hiermit ausdr&uuml;cklich widersprochen. Die Betreiber der Seiten behalten sich ausdr&uuml;cklich rechtliche Schritte im Falle der unverlangten Zusendung von Werbeinformationen, etwa durch Spam-Mails, vor.</div>', CURRENT_TIMESTAMP);
INSERT INTO `general_page_content` (`contentId`, `pageHtml`, `lastChange`) VALUES (3,
'<h3>Datenschutz</h3>
<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', CURRENT_TIMESTAMP);

-- User-Visitor-Accounts
-- Notice, the password for both test-admin-users is "safepw1$"
INSERT INTO `user_admin` (`adminId`, `userName`, `password`, `email`, `active`) VALUES (NULL, 'lucky_admin', '$2y$10$NoZOr/uQ1pfzPVQlEdnhE.5IOQIPSbZstsakb7iKMcgrdm1zuS6eO', 'irgendeinemail@keinevorhandenedomain.de', '1');
INSERT INTO `user_admin` (`adminId`, `userName`, `password`, `email`, `active`) VALUES (NULL, 'peethd_admin', '$2y$10$NoZOr/uQ1pfzPVQlEdnhE.5IOQIPSbZstsakb7iKMcgrdm1zuS6eO', 'irgendeinemail2@keinevorhandenedomain.de', '1');

-- Notice, the password for both test-visitor-users is "safeuser1$"
INSERT INTO `user_visitor` (`userId`, `userName`, `password`, `email`, `active`, `activatedOnce`) VALUES (NULL, 'test_user_active', '$2y$10$B/UaKZEi8FLMjMnJwq5.f.039C0fZGb64pmtw3RFIngrvTzAhKk4W', 'irgendeinemail3@keinevorhandenedomain.de', '1', '1');
INSERT INTO `user_visitor` (`userId`, `userName`, `password`, `email`, `active`, `activatedOnce`) VALUES (NULL, 'test_user_inactive', '$2y$10$B/UaKZEi8FLMjMnJwq5.f.039C0fZGb64pmtw3RFIngrvTzAhKk4W', 'irgendeinemail3@keinevorhandenedomain.de', '0', '0');