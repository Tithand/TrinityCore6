<========================== TrinityCore 6 ==========================>

Dies ist eine Webseite zur Registrierung von Spielaccouns mittels
SOAP für TrinityCore6.

PHP
---
Folgende Optionen müssen in der php.ini aktiviert sein:

short_open_tag = On
extension=php_mysql.dll
extension=php_mysqli.dll
extension=php_pdo_mysql.dll
extension=php_soap.dll

Core
----
In der worldserver.conf des Cores muss SOAP aktiviert sein.

SOAP.Enabled = 1

Es muss ein Account existieren, der GM-3-Rechte besitzt, auf den SOAP
zugreifen kann. Nutzer und Passwort müssen in der config.php dieser
Webseite eingetragen werden, ebenso wie die Zugangsdaten zur MySQL-
Datenbank.