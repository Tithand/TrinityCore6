# Installation

## Voraussetzungen
siehe [TrinityCore](https://trinitycore.atlassian.net/wiki/display/tc/Requirements)

## Core-Erstellung
siehe [TrinityCore](https://trinitycore.atlassian.net/wiki/display/tc/Core+Installation)

## Core-Einrichtung
siehe [TrinityCore](https://trinitycore.atlassian.net/wiki/display/tc/Server+Setup)

### Bnetserver konfigurieren
- `bnetserver.conf.dist` in `bnetserver.conf` kopieren
- Einträge in `bnetserver.conf` nach Wunsch anpassen; folgende Einträge **müssen** angepasst werden:
    - `LogsDir = "logs"` <-- Unterverzeichnis des Cores für die Log-Dateien - das Verzeichnis **muss** existieren
    - `LoginREST.ExternalAddress = <aktuelle IP>` <-- muss mit `worldserver.conf` und `realmlist`, siehe unten, übereinstimmen
    - `SourceDirectory = "<Pfad>"` <-- Quelltext-Verzeichnis, falls der Server nicht auf dem Rechner läuft, auf dem er erstellt wurde
    - `MySQLExecutable = "Pfad\mysql.exe"` <-- Ort der mysql.exe, falls der Server nicht auf dem Rechner läuft, auf dem er erstellt wurde
    - `LoginDatabaseInfo = "127.0.0.1;3306;trinity;trinity;auth"` <--  _trinity;trinity_ ersetzen durch _DB-Nutzername;DB-Passwort_, mit denen der Core zukünftig auf die Datenbank zugreifen können soll (müssen übereinstimmen mit `worldserver.conf`, `create_mysql.sql` und `config.php`, siehe unten)

### Worldserver konfigurieren
- `worldserver.conf.dist` in `worldserver.conf` kopieren
- Einträge in `worldserver.conf` nach Wunsch anpassen; folgende Einträge **müssen** angepasst werden:
    - `LogsDir = "logs"` <-- Unterverzeichnis des Cores für die Log-Dateien - das Verzeichnis **muss** existieren
    - `LoginDatabaseInfo     = "127.0.0.1;3306;trinity;trinity;auth"` <--  _trinity;trinity_ ersetzen durch _DB-Nutzername;DB-Passwort_, mit denen der Core zukünftig auf die Datenbank zugreifen können soll (müssen übereinstimmen mit `bnetserver.conf`, siehe oben, sowie `create_mysql.sql` und `config.php`, siehe unten)
    - `WorldDatabaseInfo     = "127.0.0.1;3306;trinity;trinity;world"` <-- ebenso
    - `CharacterDatabaseInfo = "127.0.0.1;3306;trinity;trinity;characters"` <-- ebenso
    - `HotfixDatabaseInfo    = "127.0.0.1;3306;trinity;trinity;hotfixes"` <-- ebenso
    - `WorldServerPort = <port>` <-- verwendeter Port (Standard `8085`), muss mit `realmlist` übereinstimmen
    - `InstanceServerPort = <port>` <-- verwendeter Port (Standard `8086`)
    - `BuildDirectory = "<Pfad>"` <-- Build-Verzeichnis, falls der Server nicht auf dem Rechner läuft, auf dem er erstellt wurde
    - `SourceDirectory = "<Pfad>"` <-- Quelltext-Verzeichnis, falls der Server nicht auf dem Rechner läuft, auf dem er erstellt wurde
    - `MySQLExecutable = "Pfad\mysql.exe"` <-- Ort der mysql.exe, falls der Server nicht auf dem Rechner läuft, auf dem er erstellt wurde
    - `SOAP.Enabled = 1` <-- nur falls SOAP zur Account-Erstellung über die Webseite verwendet werden soll

## Netzwerk-Einrichtung
Um den Server öffentlich verfügbar zu machen, müssen einige Ports geöffnet werden.

Läuft auf dem Rechner eine Sicherheitssoftware, beispielsweise eine Firewall, müssen die entsprechenden Freigaben erteilt werden. Wie dies geschieht, hängt von der installierten Sicherheitssoftware ab. Meist stellt diese beim ersten Start eines Programms automatisch eine entsprechende Rückfrage.

Zusätzlich müssen die Ports im Router freigegeben werden. Wie dies geschieht, hängt vom Router ab.

- für Bnetserver: TCP- und UDP-Port 1119
- für Login: TCP- und UDP-Port 8081
- für Worldserver: TCP- und UDP-Port 8085-8086 <-- muss mit `WorldServerPort` und `InstanceServerPort` in `worldserver.conf` übereinstimmen
- für Apache: TCP- und UDP-Port 80 <-- nur falls SOAP zur Account-Erstellung über die Webseite verwendet werden soll

## Datenbank-Erstellung
- MySQL mit vorgegebener leerer Datenbank oder einer früheren Version der Datenbank starten. Diese Anleitung geht davon aus, dass MySQL mit Root-Zugang korrekt installiert ist. MySQL läuft nun im Hintergrund und stellt den Datenbank-Zugriff bereit.
- HeidiSQL mit Nutzer und Passwort starten. Der Nutzer muss Vollzugriff besitzen. Diese Anleitung geht davon aus, dass HeidiSQL korrekt installiert ist und eine Verbindung zur Datenbank existiert. HeidiSQL ist nun die Oberfläche für Arbeiten an der Datenbank.

### alte Datenbank-Version löschen
- _**Datei->SQL-Datei laden...**_ im Menü oder mit dem entsprechenden Leistensymbol öffnen und im Repositorium nach `\sql\create` wechseln
- _**Bei Fehlern im Batchmodus anhalten**_ mit dem entsprechenden Leistensymbol ausschalten, falls es angeschaltet ist
- Datei `drop_mysql.sql` in den Abfrage-Editor von HeidiSQL laden; als Kodierung dabei **UTF-8** wählen
- _**SQL Abfrage(n) ausführen...**_ mit dem entsprechenden Leistensymbol auslösen
- **Anmerkung:** Die Ausführung dieser SQL-Datei wird Fehler erzeugen, wenn die zu löschenden Rechte und Datenbanken nicht existieren. Dies ist korrekt.
- _**Aktualisieren**_ mit dem entsprechenden Leistensymbol auslösen

### neue Datenbank erzeugen
- _**Datei->SQL-Datei laden...**_ im Menü oder mit dem entsprechenden Leistensymbol öffnen
- Datei `create_mysql.sql` in den Abfrage-Editor von HeidiSQL laden; als Kodierung dabei **UTF-8** wählen
- an folgende Stellen Standard-Nutzername und -Passwort durch die Angaben ersetzen, mit denen der Core zukünftig auf die Datenbank zugreifen können soll (müssen übereinstimmen mit `bnetserver.conf` und `worldserver.conf`, siehe oben, sowie `config.php`, siehe unten)
    - `TO 'trinity'` <-- _trinity_ ersetzen durch DB-Nutzername
    - `IDENTIFIED BY 'trinity'` <-- _trinity_ ersetzen durch DB-Passwort
- _**SQL Abfrage(n) ausführen...**_ mit dem entsprechenden Leistensymbol auslösen
- **Anmerkung:** Ist alles korrekt, sollte es weder Fehler noch Warnungen geben.
- _**Aktualisieren**_ mit dem entsprechenden Leistensymbol auslösen

### neue Datenbank füllen
- die folgenden Schritte für jede der Datenbank-Dateien ausführen
    - `auth_database.sql`
    - `characters_database.sql`
    - `hotfixes_database1.sql`, `hotfixes_database2.sql`
    - `world_database1.sql`, `world_database2.sql`, `world_database3.sql`
- in der Tabellenliste auf die zugehörige Datenbank `auth`, `characters`, `hotfixes` oder `world` wechseln
- _**Datei->SQL-Datei laden...**_ im Menü oder mit dem entsprechenden Leistensymbol öffnen und im Repositorium nach `\sql\base` wechseln
- SQL-Datei in den Abfrage-Editor von HeidiSQL laden; als Kodierung dabei **UTF-8** wählen
- **Achtung**: bietet HeidiSQL an, die Datei stattdessen direkt auszuführen, akzeptieren!
- _**SQL Abfrage(n) ausführen...**_ mit dem entsprechenden Leistensymbol auslösen, falls dies nicht direkt ausgelöst wurde
- in der Tabellenliste auf eine beliebige _andere_ Datenbank wechseln und _**Aktualisieren**_ mit dem entsprechenden Leistensymbol auslösen
- **Anmerkung:** Ist alles korrekt, sollte es weder Fehler noch Warnungen geben. Bei Problemen in der Konfigurationsdatei von MySQL (meist `my.ini`) die folgende Angabe im Abschnitt [mysqld] ändern oder hinzufügen, dann MySQL neu starten
    `max_allowed_packet=256M`

### neue Datenbank aktualisieren
- die folgenden Schritte für jede der Datenbanken ausführen
    - `auth`
    - `characters`
    - `hotfixes`
    - `world`
- in der Tabellenliste auf die zugehörige Datenbank wechseln
- _**Datei->SQL-Datei ausführen ...**_ im Menü öffnen und im Repositorium nach `\sql\updates\<datenbank>` wechseln
- sind SQL-Dateien vorhanden, alle markieren, als Kodierung **UTF-8** wählen und öffnen, um sie chronologisch auszuführen
- alternativ können die Dateien einzeln in den Abfrage-Editor geladen und von dort chronologisch ausgeführt werden
- in der Tabellenliste auf eine beliebige _andere_ Datenbank wechseln und _**Aktualisieren**_ mit dem entsprechenden Leistensymbol auslösen

### Einstellungen in der Datenbank anpassen
- in der Tabellenliste Datenbank `auth` aufklappen und auf die Tabelle `realmlist` wechseln
- auf den Reiter **Daten** wechseln
- folgende Spalten ändern und danach außerhalb der editierten Zeile klicken
    - `name` <-- gewünschter Servername
    - `address` <-- aktuelle externe IP-Adresse (öffentlicher Server, sonst LAN-IP oder `127.0.0.1`) - muss immer aktuell sein
    - `localAddress` <-- IP-Adresse im LAN (im LAN aktiver Server, sonst `127.0.0.1`)
    - `port` <-- verwendeter Port (Standard `8085`), muss mit `worldserver.conf` übereinstimmen

Nun kann die Datenbank vom Core verwendet werden. Zuerst `bnetserver.exe` starten, dann `worldserver.exe` starten.

## Account-Erstellung
Soll es möglich sein, Spielaccounts mittels SOAP über eine Webseite zu erstellen, sind die folgenden Schritte notwendig. Sie können entfallen, wenn Accounts manuell über GM-Befehle erstellt werden.

- im Repositorium nach `\www` wechseln
- `config.php` in einem Texteditor öffnen
- DB-Nutzername mit vollen Rechten zum Datenbank-Direktzugriff eintragen
    - `define('DB_USER', 'trinity');` <-- _trinity_ ersetzen durch DB-Nutzername
    - `define('DB_PASS', 'trinity');` <-- _trinity_ ersetzen durch DB-Passwort
- Zugangsdaten für Spielaccount eintragen, der für SOAP verwendet werden soll
    - `define('SOAP_USER', 'soapuser');` <-- _soapuser_ ersetzen durch SOAP-Accountname
    - `define('SOAP_PASS', 'soappass');` <-- _soappass_ ersetzen durch SOAP-Passwort
- Seitentitel anpassen, sollte mit `name` in `realmlist` übereinstimmen
    - `define('SITE_TITLE', "Registrierung");` <-- _Registrierung_ ersetzen durch gewünschten Servernamen
- im Konsolenfenster vom Worldserver SOAP-Account erstellen
    `bn c @soapuser soappass` <-- _soapuser_ und _soappass_ ersetzen durch SOAP-Accountname und SOAP-Passwort
- in HeidiSQL
    - _**Aktualisieren**_ mit dem entsprechenden Leistensymbol auslösen
    - in der Tabellenliste Datenbank `auth` aufklappen und auf die Tabelle `account` wechseln
    - auf den Reiter **Daten** wechseln
    - in Spalte `username` Eintrag `1#1` durch SOAP-Accountname ersetzen und danach außerhalb der editierten Zeile klicken
- im Konsolenfenster vom Worldserver Passwort des SOAP-Accounts an neuen Namen anpassen
    `ac s p soapuser soappass soappass` <-- _soapuser_ und _soappass_ ersetzen durch SOAP-Accountname und SOAP-Passwort
- im Konsolenfenster vom Worldserver GM-3-Privilegien an den SOAP-Account vergeben
    `ac s g user 3 -1`
- `worldserver.exe` beenden und neu starten

Nun können weitere Accounts über die Webseite erstellt werden. Dazu muss der Inhalt des Verzeichnisses `\www` über einen Apache-Server mit aktiviertem SOAP bereitgestellt werden. Die Registrierungsseite `index.php` kann beliebig angepasst werden.

## Client-Einrichtung
- im Explorer ins Unterverzeichnis `WTF` des Installationsverzeichnisses des Clients wechseln
- `Config.wtf` in einem Texteditor öffnen
- Eintrag `SET portal "<IP-Adresse>"` auf aktuelle Internet-IP-Adresse setzen (öffentlicher Server, sonst LAN-IP oder `127.0.0.1`) - muss immer aktuell sein
- `connection_patcher.exe` in das Installationsverzeichnis des Clients kopieren
- im Explorer `Wow.exe` oder `Wow-64.exe` mit Maus auf die `connection_patcher.exe` ziehen und loslassen
- die entstandene Datei zum Start des Spiels verwenden