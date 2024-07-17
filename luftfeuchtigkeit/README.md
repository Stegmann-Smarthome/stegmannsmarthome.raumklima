# Raumklima
Beschreibung des Moduls.

### Inhaltsverzeichnis

1. [Funktionsumfang](#1-funktionsumfang)
2. [Voraussetzungen](#2-voraussetzungen)
3. [Software-Installation](#3-software-installation)
4. [Einrichten der Instanzen in IP-Symcon](#4-einrichten-der-instanzen-in-ip-symcon)
5. [Statusvariablen und Profile](#5-statusvariablen-und-profile)
6. [WebFront](#6-webfront)
7. [PHP-Befehlsreferenz](#7-php-befehlsreferenz)

### 1. Funktionsumfang

Diese Modul wird genutzt um die Luftfeuchtigkeit in einem Raum / an einem Ort zu überwachen.
Sobald ein Grenzwert überschritten ist, wird der Benutzer optisch darüber informiert.
Optional ist es möglich sich eine Nachricht im Frontend anzeigen zu lassen bzw. sich auf das Handy schicken zu lassen.

### 2. Voraussetzungen

- IP-Symcon ab Version 7.1

### 3. Software-Installation

* Über den Module Store das 'Raumklima'-Modul installieren.
* Alternativ über das Module Control folgende URL hinzufügen: 

### 4. Einrichten der Instanzen in IP-Symcon

 Unter 'Instanz hinzufügen' kann das 'Raumklima'-Modul mithilfe des Schnellfilters gefunden werden.  
	- Weitere Informationen zum Hinzufügen von Instanzen in der [Dokumentation der Instanzen](https://www.symcon.de/service/dokumentation/konzepte/instanzen/#Instanz_hinzufügen)

__Konfigurationsseite__:

Auf der Konfigurationsseite

Name                                      | Beschreibung
----------------------------------------- | -----------------------------------------------
Quelle (Ist-Luftfeuchtigkeit)             | Auswahl des Sensors    
Kachel Visualisierung (Push-Nachricht)    | Auswahl der Visualisierungs-ID
Push Nachrichten: An / Aus                | An- und Auschalten der Push-Benachrichtigung

### 5. Statusvariablen und Profile

Die Statusvariablen/Kategorien werden automatisch angelegt. Das Löschen einzelner kann zu Fehlfunktionen führen.

#### Statusvariablen

Name                 | Typ         | Beschreibung
-------------------- | ----------- | ------------------------------------------------------
Luftfeuchtigkeit     | Link        | Darstellung der aktuellen Luftfeuchtigkeit
Status               | Boolean     | Stellt den aktuellen Status dar
Grenzwert            | Integer     | Aktueller Grenzwert ab dem der Status gewechselt wird
Meldeverzögerung     | Integer     | Nach dieser Zeit, wird eine Push-Nachricht versendet

#### Profile

Name                        | Typ
--------------------------- | -------
SS.Klima.Status             | Boolean
SS.Klima.Grenzwert          | Integer
SS.Klima.Meldeverzoegerung  | Integer

### 6. WebFront

Im Webfrontend lässt sich der Grenzwert und die Meldeverzögerung einstellen.
Die Meldeverzögerung gibt an wann die Nachricht an das Webfrontend gesendet werden soll.

### 7. PHP-Befehlsreferenz

Das Modul bietet keine direkten Funktionsaufrufe.

### 8. Versionshistorie

- 16.07.2024: v1.0 Erstrelease

## Spenden

Dieses Modul ist für die nicht kommzerielle Nutzung kostenlos, Schenkungen als Unterstützung für den Autor werden hier akzeptiert:    

[![PayPal](https://img.shields.io/badge/PayPal-spenden-00457C.svg?style=for-the-badge&logo=paypal)](https://www.paypal.com/donate/?hosted_button_id=4JE2SXBZKHY56)

## Lizenz

[![Licence](https://img.shields.io/badge/License-CC_BY--NC--SA_4.0-EF9421.svg?style=for-the-badge&logo=creativecommons)](https://creativecommons.org/licenses/by-nc-sa/4.0/)