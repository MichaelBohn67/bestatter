# Projektspezifikation – Bestatter

Stand: 2026-05-04  
Projekt: `bestatter`

## 1. Zweck und Zielbild

`bestatter` ist eine serverseitig gerenderte Laravel-Anwendung zur Verwaltung von Bestattungsfaellen. Die Anwendung soll Mitarbeitende eines Bestattungsunternehmens dabei unterstuetzen, einen Fall vom Erstkontakt bis zur Rechnungsstellung strukturiert zu erfassen und zu pflegen.

Das fachliche Zentrum ist der **Bestattungsauftrag** (`FuneralService`). Um diesen Auftrag gruppieren sich:

- verstorbene Person (`Deceased`)
- Auftraggeber / Kunde (`Customer`)
- Angehoerige (`Relative`)
- Rechnungsdaten (`Billing`)
- perspektivisch Dokumente, Friedhoefe, Kapellen und Kommunen

## 2. Produktvision

Die Anwendung soll ein leichtgewichtiges Backoffice fuer Bestattungsunternehmen sein, mit folgenden Zielen:

1. **schnelle Fallerfassung** direkt nach Erstkontakt
2. **klare Beziehungen** zwischen Verstorbenem, Auftraggeber und Auftrag
3. **nachvollziehbare Rechnungsdaten** inklusive automatischer Steuerberechnung
4. **mehrsprachige Benutzeroberflaeche** in Deutsch und Englisch
5. **erweiterbare Domaeenbasis** fuer Friedhofs-, Kapellen- und Dokumentenverwaltung

## 3. Zielgruppe und Rollen

### 3.1 Primäre Nutzer
- Mitarbeitende im Bestattungsunternehmen
- Office-/Verwaltungspersonal
- Administratoren

### 3.2 Technische Zugriffsvoraussetzungen
- Domain-Funktionen sind nur fuer **authentifizierte und verifizierte** Benutzer verfuegbar.
- Profilverwaltung ist fuer authentifizierte Benutzer verfuegbar.

## 4. Fachlicher Scope

## 4.1 Im aktuellen Projekt bereits abgedeckter Scope
- Bestattungsauftraege anlegen, anzeigen, listen, loeschen
- Verstorbene anlegen und listen
- Auftraggeber anlegen, bearbeiten und listen
- Angehoerige anlegen und listen
- Rechnungen anlegen, bearbeiten und listen
- Sprachumschaltung zwischen `de` und `en`
- OpenPLZ-Service als gekapselte externe Adress-/Ortsintegration

### 4.2 Im Modell bereits vorbereitet, aber noch nicht vollstaendig als UI-Flow umgesetzt
- Dokumente zu Verstorbenen
- Friedhoefe
- Kapellen
- Kommunen
- Vollstaendige Bearbeitung von Bestattungsauftraegen

### 4.3 Explizit ausserhalb des aktuellen MVP-Scope
- Online-Kundenportal
- Mandantenfaehigkeit
- Rollen-/Rechtemodell jenseits von Auth + Verified
- Zahlungsabwicklung
- DATEV-/Buchhaltungsintegration
- E-Mail- oder SMS-Automation
- Workflow-Engine fuer Freigaben

## 5. Fachobjekte und Beziehungen

## 5.1 Bestattungsauftrag (`FuneralService`)
Zentrale Entitaet des Systems.

**Attribute (relevant):**
- `deceased_id`
- `customer_id`
- `graveyard_id` (optional)
- `chapel_id` (optional)
- `order_number` (eindeutig)
- `status` (`draft`, `active`, `completed`, `cancelled`)
- `funeral_type`
- `funeral_date`
- `funeral_location`
- `notes`

**Beziehungen:**
- gehoert zu genau einem `Deceased`
- gehoert zu genau einem `Customer`
- kann optional einem `Graveyard` zugeordnet werden
- kann optional einer `Chapel` zugeordnet werden
- hat hoechstens eine `Billing`

## 5.2 Verstorbene Person (`Deceased`)
Erfasst Stammdaten zur verstorbenen Person.

**Attribute (relevant):**
- `first_name`
- `last_name`
- `date_of_birth`
- `date_of_death`
- `place_of_death`
- `last_address`
- `religion`

**Beziehungen:**
- hat genau einen `FuneralService`
- hat optional genau eine polymorphe `Address`
- hat viele `Document`
- hat viele `Relative`

## 5.3 Auftraggeber (`Customer`)
Person, die den Auftrag erteilt bzw. organisatorisch verantwortlich ist.

**Attribute (relevant):**
- `first_name`
- `last_name`
- `email`
- `phone`
- `address`
- `city`
- `zip`
- `relationship_to_deceased`

**Beziehungen:**
- hat viele `FuneralService`
- hat optional genau eine polymorphe `Address`

## 5.4 Angehoeriger (`Relative`)
Mit dem Verstorbenen verknuepfte Kontaktperson.

**Attribute (relevant):**
- `deceased_id`
- `first_name`
- `last_name`
- `relationship`
- `phone`
- `email`

**Beziehungen:**
- gehoert zu genau einem `Deceased`
- hat optional genau eine polymorphe `Address`

## 5.5 Rechnung (`Billing`)
Rechnungsbezogene Daten zum Bestattungsauftrag.

**Attribute (relevant):**
- `funeral_service_id`
- `invoice_number` (eindeutig)
- `status`
- `issued_at`
- `due_at`
- `subtotal`
- `tax_rate`
- `tax_amount`
- `total`
- `notes`

**Beziehungen:**
- gehoert zu genau einem `FuneralService`

## 5.6 Adresse (`Address`)
Polymorphe Adresse fuer mehrere Domänenobjekte.

**Verwendet von:**
- `Customer`
- `Deceased`
- `Relative`
- `Graveyard`
- `Commune`

**Attribute:**
- `street`
- `house_number`
- `postal_code`
- `city`
- `state`
- `country`
- `additional_info`

## 5.7 Erweiterungsobjekte
### Dokument (`Document`)
Datei-Metadaten zu einem `Deceased`.

### Friedhof (`Graveyard`)
Gehoert zu einer `Commune`, kann mehrere `Chapel` haben, hat optional eine `Address`.

### Kapelle (`Chapel`)
Gehoert zu einem `Graveyard`.

### Kommune (`Commune`)
Kann mehrere `Graveyard`-Eintraege haben und optional eine `Address` besitzen.

## 6. Fachliche Regeln und Constraints

1. **Ein Verstorbener darf nur einem Bestattungsauftrag zugeordnet sein.**  
   Technisch abgesichert ueber Unique-Index auf `funeral_services.deceased_id`.

2. **Ein Bestattungsauftrag darf nur eine Rechnung haben.**  
   Technisch abgesichert ueber Unique-Index auf `billings.funeral_service_id`.

3. **Auftragsnummern muessen eindeutig sein.**

4. **Rechnungsnummern muessen eindeutig sein.**

5. **Rechnungsfaelligkeit darf nicht vor dem Ausstellungsdatum liegen.**

6. **Steuerbetrag und Gesamtsumme werden aus `subtotal` und `tax_rate` berechnet.**
   - `tax_amount = subtotal * (tax_rate / 100)`
   - `total = subtotal + tax_amount`
   - Rundung auf 2 Nachkommastellen

7. **Soft Deletes sind Standard.**
   Loeschungen muessen kompatibel zu `deleted_at` erfolgen.

8. **Adressdaten werden getrennt vom Hauptobjekt gespeichert.**
   Bei `Customer` werden Teile der Adresse zusaetzlich redundant in den Entitaetsfeldern `address`, `city`, `zip` gehalten.

9. **UI-Texte sollen mit GNU gettext lokalisiert werden.**
   In Blade ist `gettext('...')` der Standard.

10. **Erlaubte Locales sind ausschliesslich `de` und `en`.**

## 7. Kernprozesse / Use Cases

## 7.1 UC-01 Bestattungsauftrag anlegen
**Ziel:** Ein neuer Fall wird als zusammenhaengender Auftrag erfasst.

**Eingaben:**
- Stammdaten verstorbene Person
- Stammdaten Auftraggeber
- optionale Bestattungsart
- optionales Bestattungsdatum

**Ablauf:**
1. Benutzer oeffnet Formular „Bestattungsauftrag anlegen“.
2. System validiert Pflichtfelder fuer Verstorbene und Auftraggeber.
3. System legt `Deceased` an.
4. System legt `Customer` an.
5. System legt `FuneralService` an.
6. System generiert automatisch eine eindeutige `order_number`.
7. System setzt initial den Status auf `draft`.

**Ergebnis:**
- neuer zusammenhaengender Auftrag existiert
- Benutzer wird zur Auftragsliste weitergeleitet

## 7.2 UC-02 Verstorbene Person anlegen
**Ziel:** Eine verstorbene Person wird mit optionaler Anschrift erfasst.

**Pflichtfelder:**
- `first_name`
- `last_name`

**Optionale Daten:**
- Geburts-/Sterbedatum
- Sterbeort
- letzte Anschrift
- Religion
- strukturierte Adresse

**Ergebnis:**
- `Deceased` wird angelegt
- falls Adressdaten vorliegen, wird `Address` angelegt

## 7.3 UC-03 Auftraggeber anlegen oder bearbeiten
**Ziel:** Kontakt- und Adressdaten des Auftraggebers pflegen.

**Besonderheit:**
- Adressfelder mit `address_*` werden sowohl in die polymorphe Adresse als auch teilweise in flache Customer-Felder uebertragen.

**Ergebnis:**
- `Customer` und optional `Address` werden erstellt/aktualisiert

## 7.4 UC-04 Angehoerigen anlegen
**Ziel:** Eine Kontaktperson wird einem Verstorbenen zugeordnet.

**Pflichtfelder:**
- `deceased_id`
- `first_name`
- `last_name`

**Ergebnis:**
- `Relative` wird angelegt
- optional `Address` wird angelegt

## 7.5 UC-05 Rechnung anlegen oder bearbeiten
**Ziel:** Rechnungsdaten zu einem Bestattungsauftrag erfassen.

**Pflichtfelder:**
- `funeral_service_id`
- `invoice_number`
- `status`

**Validierungen:**
- `funeral_service_id` muss existieren
- nur eine Rechnung pro Bestattungsauftrag
- `invoice_number` muss eindeutig sein
- `due_at >= issued_at`

**Systemverhalten:**
- `BillingService` normalisiert und berechnet Summenfelder

## 7.6 UC-06 Sprache wechseln
**Ziel:** Benutzer kann zwischen Deutsch und Englisch wechseln.

**Ablauf:**
1. Benutzer ruft `/locale/{locale}` auf.
2. System akzeptiert nur `de` oder `en`.
3. Sprache wird in der Session gespeichert.
4. `SetLocale`-Middleware setzt Laravel-Locale und gettext-Kontext.

## 8. Funktionale Anforderungen

## 8.1 Authentifizierung und Zugriff
- FR-01: Domain-Routen muessen hinter `auth` und `verified` liegen.
- FR-02: Profilfunktionen muessen hinter `auth` liegen.

## 8.2 Bestattungsauftraege
- FR-10: Das System muss eine paginierte Auftragsliste bereitstellen.
- FR-11: Beim Listenaufruf sollen Auftraggeber und Verstorbene eager geladen werden.
- FR-12: Das System muss neue Auftraege aus kombiniertem Formularinput erstellen koennen.
- FR-13: Jeder neue Auftrag muss mit Status `draft` angelegt werden.
- FR-14: Das System muss Soft Delete fuer Auftraege unterstuetzen.
- FR-15: Eine Detail-/Bearbeitungsseite darf vorhanden sein; Bearbeitungslogik ist derzeit fachlich noch offen bzw. unvollstaendig umgesetzt.

## 8.3 Verstorbene
- FR-20: Das System muss eine paginierte Liste von Verstorbenen bereitstellen.
- FR-21: Das System muss das Anlegen eines Verstorbenen mit optionaler Adresse unterstuetzen.
- FR-22: `date_of_birth` und `date_of_death` muessen als Datum gecastet werden.

## 8.4 Auftraggeber
- FR-30: Das System muss Auftraggeber listen, anlegen und bearbeiten koennen.
- FR-31: Das System muss `relationship_to_deceased` speichern koennen.
- FR-32: Die Felder `address`, `city` und `zip` muessen aus den `address_*`-Feldern abgeleitet werden koennen.

## 8.5 Angehoerige
- FR-40: Das System muss Angehoerige listen und anlegen koennen.
- FR-41: Ein Angehoeriger muss genau einem Verstorbenen zugeordnet werden.

## 8.6 Rechnungen
- FR-50: Das System muss Rechnungen listen, anlegen und bearbeiten koennen.
- FR-51: Rechnungsberechnung muss serverseitig stattfinden.
- FR-52: Pro Bestattungsauftrag darf nur eine Rechnung existieren.

## 8.7 Adressen
- FR-60: Adressen muessen polymorph speicherbar sein.
- FR-61: Formulare muessen das Feldschema `address_*` verwenden.

## 8.8 Lokalisierung
- FR-70: Neue UI-Texte muessen in gettext-PODateien gepflegt werden.
- FR-71: Standardisierte Blade-Lokalisierung erfolgt ueber `gettext()`.
- FR-72: Nur `de` und `en` sind zulaessige Oberflaechensprachen.

## 8.9 Externe Integrationen
- FR-80: OpenPLZ-Zugriffe muessen ausschliesslich ueber `OpenPlzService` erfolgen.
- FR-81: HTTP-Integrationen muessen testbar und via `Http::fake()` absicherbar sein.

## 9. Nichtfunktionale Anforderungen

## 9.1 Architektur
- Route -> Controller -> Service (bei mehrstufiger Logik) -> Model -> Blade
- Controller sollen schlank bleiben.
- Komplexe Schreiblogik gehoert in Services.

## 9.2 Technologie
- Backend: Laravel 12
- Sprache: PHP 8.2
- Frontend: Blade, Vite, Tailwind, Alpine.js
- Datenbank: SQLite fuer lokale Tests; weitere DBs prinzipiell moeglich

## 9.3 Datenkonsistenz
- Datenintegritaet wird sowohl ueber Validierung als auch Datenbank-Constraints abgesichert.
- Loeschverhalten soll Soft Deletes respektieren.

## 9.4 Testbarkeit
- Unit- und Feature-Tests muessen mit `php artisan test` ausfuehrbar sein.
- PHPUnit verwendet laut Projektkonfiguration eine In-Memory-SQLite-Testdatenbank.

## 9.5 Bedienbarkeit
- Serverseitig gerenderte CRUD-Flows sollen ohne komplexes JavaScript bedienbar sein.
- Formulare und Listen sollen uebersichtlich und direkt auf Fachobjekte bezogen sein.

## 10. Aktuelle technische Umsetzung

## 10.1 Routen
Vorhandene Ressourcenrouten:
- `funeral-services` (vollstaendiges Resource-Routing)
- `deceased` (`index`, `create`, `store`)
- `relatives` (`index`, `create`, `store`)
- `customers` (`index`, `create`, `store`, `edit`, `update`)
- `billings` (`index`, `create`, `store`, `edit`, `update`)

Zusatzrouten:
- `/dashboard`
- `/admin`
- `/locale/{locale}`
- Profilrouten

## 10.2 Services
- `FuneralServiceCreator`: legt `Deceased`, `Customer` und `FuneralService` in einem Flow an
- `BillingService`: normalisiert Billing-Daten und berechnet Betragsfelder
- `OpenPlzService`: kapselt die externe OpenPLZ-API

## 10.3 Middleware
- `SetLocale` setzt Laravel-Locale, System-Locale und gettext-Textdomain

## 10.4 Testsituation
Vorhandene Tests decken u. a. ab:
- Modellverhalten fuer `Deceased`, `Customer`, `FuneralService`, `Billing`, `User`
- OpenPLZ-Service mit `Http::fake()`
- Navigation / Auth / Profil-Bereiche

## 11. Akzeptanzkriterien fuer den aktuellen MVP

Ein Release des aktuellen MVP gilt als fachlich akzeptabel, wenn:

1. ein Benutzer sich anmelden und verifizieren kann,
2. ein Bestattungsauftrag mit Verstorbenem und Auftraggeber angelegt werden kann,
3. Verstorbene, Auftraggeber, Angehoerige und Rechnungen in Listen sichtbar sind,
4. Auftraggeber und Rechnungen bearbeitet werden koennen,
5. Rechnungsbetraege korrekt aus `subtotal` und `tax_rate` abgeleitet werden,
6. Sprachumschaltung zwischen Deutsch und Englisch funktioniert,
7. Tests via `php artisan test` erfolgreich durchlaufen.

## 12. Bekannte Luecken / offene Punkte

1. **Bearbeitung von Bestattungsauftraegen** ist im Controller noch nicht umgesetzt.
2. **Dokumentenverwaltung** ist im Datenmodell vorhanden, aber nicht als kompletter UI-Flow umgesetzt.
3. **Friedhof/Kapelle/Kommune** sind modelliert, aber noch nicht als End-to-End-Funktion verfuegbar.
4. **Success-Messages** in Controllern sind teilweise noch hart codiert und nicht zwingend bereits ueber gettext gepflegt.
5. **OpenPLZ** ist als Service vorhanden, aber noch nicht sichtbar als Formularintegration beschrieben.

## 13. Empfohlene naechste Ausbaustufen

### Phase 1 – Auftragsfuehrung vervollstaendigen
- Update-Flow fuer `FuneralService`
- Detailansicht fachlich ausbauen
- Statuswechsel modellieren

### Phase 2 – Dokumente und Orte
- Dokumenten-Upload und -Liste
- CRUD fuer `Graveyard`, `Chapel`, `Commune`
- OpenPLZ-gestuetzte Adresssuche in Formularen

### Phase 3 – Operative Tiefe
- Rollen und Berechtigungen
- Termin-/Aufgabenbezug je Auftrag
- Ausgabe/Export von Rechnungen und Fallunterlagen

## 14. Entwicklungsleitlinien fuer Folgearbeit

- Neue Mehrfach-Schreibvorgaenge in Services kapseln.
- Inline-Validierung im Controller beibehalten, sofern kein bestehender FormRequest-Kontext vorliegt.
- Bei Formularaenderungen das Feldmuster `address_*` beibehalten.
- Bei UI-Texten gettext-Kataloge in `resources/lang/*/LC_MESSAGES/messages.po` mitpflegen.
- Externe HTTP-Integrationen nicht direkt in Views oder Controllern implementieren.

---

Diese Spezifikation beschreibt den fachlichen und technischen Zielrahmen des aktuellen Projekts auf Basis des vorhandenen Repository-Stands. Sie trennt bewusst zwischen bereits implementierter Funktionalitaet und vorbereiteten, aber noch unvollstaendig ausgebauten Bereichen.
