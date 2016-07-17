Gamingblog-Summary
==================
Test-Project for a gaming-blog


TODO's for the initial setup
-----------------------------
- Prepare Virtualhost-Entry
- Prepare Hosts-Entry

- Prepare Smarty
- Prepare ZF

- Create Database and Tables (no sql in the source-code !)
- Add necessary DB-Users (check config)

Used Technologys
----------------

- ZF1
- Smarty3
- Jquery
- TinyMCE

Um das Projekt lokal lauffähig zu bekommen müssen folgende Schritte ausgeführt werden [Beispiel m. xampp]:

1) Das Projektverzeichnis in den "xampp->htdocs"-Ordner kopieren

2) Einen VHosts-Eintrag für xampp anlegen:
   Zwei Möglichkeiten:
   a) Zum Testen und Entwickeln => Gibt Fehler und Exceptions aus !!
    <VirtualHost *:80>
        DocumentRoot "../htdocs/gamingblog/public/"
        ServerName www.gamingblog.de
        ServerAlias gamingblog.de

        SetEnv APPLICATION_ENV "development"
    </VirtualHost>

   b) Zum Seite ausprobieren => Keine Fehlerausgabe, stattdessen Umleitung auf Fehlerseite !!
    <VirtualHost *:80>
        DocumentRoot "../htdocs/gamingblog/public/"
        ServerName www.gamingblog.de
        ServerAlias gamingblog.de

        SetEnv APPLICATION_ENV "production"
    </VirtualHost>

3) Hosts-Eintrag in der hosts-datei anlegen (in Windows unter [Laufwerk]:\Windows\System32\Drivers\etc\hosts
   Bsp.:
   127.0.0.1	gamingblog.de
   127.0.0.1	www.gamingblog.de


4) xampp-apache starten

5) MySQL-Daemon starten

6) Vorbereitungs-SQL unter php-my-admin ausführen
   (Die SQL-Datei mit allen Befehlen befindet sich im Projekt-Hauptverzeichnis unter "database_prep.sql")

7) Browser neu starten

8) Seite über die vordefinierte URL (z.B.: www.gamingblog.de) aufrufen

9) Benutzeranleitung lesen (Admin / User)

10) Spaß haben :)