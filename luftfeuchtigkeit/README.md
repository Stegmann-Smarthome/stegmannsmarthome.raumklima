# Luftfeuchtigkeit

### Inhaltsverzeichnis

1. [Funktionsumfang](#1-funktionsumfang)
2. [Voraussetzungen](#2-voraussetzungen)
3. [Software-Installation](#3-software-installation)
4. [Einrichten der Instanzen in IP-Symcon](#4-einrichten-der-instanzen-in-ip-symcon)
5. [Statusvariablen und Profile](#5-statusvariablen-und-profile)
6. [WebFront](#6-webfront)
7. [PHP-Befehlsreferenz](#7-php-befehlsreferenz)

### 1. Funktionsumfang

Mit diesem Modul lässt sich die Luftfeuchtigkeit in einem Raum / an einem Ort überwachen.
Sobald ein ausgewählter Grenzwert überschritten ist, wird der Benutzer darüber informiert.
Optional ist es möglich sich eine Nachricht im Frontend anzeigen zu lassen.
Die eingestellt Meldeverzögerung gibt an, nach wie vielen Minuten die Nachricht gesendet werden soll, nachdem der Grenzwert überschritten wurde und überschritten bleibt.

### 2. Voraussetzungen

- IP-Symcon ab Version 7.1

### 3. Software-Installation

* Das Modul läst sich per Modul-Controk, über folgende URL hinzufügen:
  https://github.com/Stegmann-Smarthome/stegmannsmarthome.raumklima.git
  
### 4. Einrichten der Instanzen in IP-Symcon

 Unter 'Instanz hinzufügen' kann das 'Luftfeuchtigkeit'-Modul mithilfe des Schnellfilters gefunden werden.  
	- Weitere Informationen zum Hinzufügen von Instanzen in der [Dokumentation der Instanzen](https://www.symcon.de/service/dokumentation/konzepte/instanzen/#Instanz_hinzufügen)

__Konfigurationsseite__:

Auf der Konfigurationsseite des Moduls, 

Name                                      | Beschreibung
----------------------------------------- | -----------------------------------------------
Quelle (Ist-Luftfeuchtigkeit)             | Auswahl des Sensors  
Kachel Visualisierung (Push-Nachricht)    | Auswahl der Visualisierungs-ID
Push Nachrichten: An / Aus                | An- und Auschalten der Push-Benachrichtigung (Frontend)

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

- 17.07.2024: v1.0 Erstrelease

## Spenden

Dieses Modul ist für die nicht kommzerielle Nutzung kostenlos, Schenkungen als Unterstützung für den Autor werden hier akzeptiert:    

[![PayPal](https://img.shields.io/badge/PayPal-spenden-00457C.svg?style=for-the-badge&logo=paypal)](https://www.paypal.com/donate/?hosted_button_id=4JE2SXBZKHY56)

## Lizenz

[![Licence](https://img.shields.io/badge/License-CC_BY--NC--SA_4.0-EF9421.svg?style=for-the-badge&logo=creativecommons)](https://creativecommons.org/licenses/by-nc-sa/4.0/)