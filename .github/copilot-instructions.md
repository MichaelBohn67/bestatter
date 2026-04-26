# Copilot Instructions

Diese Hinweise gelten fuer das gesamte Repository und sollen Vorschlaege sofort an die vorhandenen Projektmuster anpassen.

## Architektur und Grenzen
- Bevorzuge serverseitige Laravel-Flows: Route -> Controller -> Service (falls mehrstufig) -> Model -> Blade.
- Lege Domain-Logik mit mehreren Writes in Services ab (z. B. `FuneralServiceCreator`, `BillingService`), nicht im Blade.
- Halte Controller schlank und nahe am Ist-Pattern in `app/Http/Controllers`.
- Domain-Routen liegen in `routes/web.php` hinter `auth` + `verified`; neue Fachseiten daran ausrichten.

## Controller-, Request- und Form-Konventionen
- Nutze in diesem Projekt standardmaessig inline `$request->validate(...)` im Controller.
- Verwende FormRequest nur dort, wo bereits einer existiert (z. B. Profilbereich).
- Bei Formularaenderungen Feldnamen konsistent zu den Extractor-Methoden halten (`address_*`-Pattern).
- Bei Customer/Deceased/Relative sowohl Entitaetsfelder als auch polymorphe `address()`-Relation beachten.

## Datenmodell-Regeln
- `FuneralService` ist die zentrale Entitaet und referenziert `Deceased` und `Customer`.
- Ein `Deceased` darf nur einen `FuneralService` haben (Unique auf `funeral_services.deceased_id`).
- Ein `FuneralService` darf nur eine `Billing` haben (Unique auf `billings.funeral_service_id`).
- SoftDeletes sind breit etabliert; Vorschlaege sollen Loeschverhalten kompatibel dazu halten.

## Lokalisierung (wichtig)
- In Blade `gettext('...')` verwenden, nicht standardmaessig `__('...')`.
- Locale wird ueber `SetLocale`-Middleware gesetzt (`app/Http/Middleware/SetLocale.php`).
- Erlaubte Locales sind `en` und `de`; Umschaltung ueber `/locale/{locale}`.
- Neue UI-Texte immer auch in `resources/lang/*/LC_MESSAGES/messages.po` nachpflegen.

## Integrationen
- OpenPLZ-Zugriffe ueber `app/Services/OpenPlzService.php` kapseln, nicht direkt in Views.
- Service-Binding in `app/Providers/AppServiceProvider.php` respektieren (Singleton).
- HTTP-Integrationen in Tests mit `Http::fake()` absichern (siehe `tests/Feature/OpenPlzServiceTest.php`).

## Dev-Workflow fuer Vorschlaege
- Setup: `composer run setup`
- Lokale Entwicklung: `composer run dev`
- Tests: `composer run test` (PHPUnit nutzt in-memory sqlite laut `phpunit.xml`)
- Frontend: `npm run dev` und `npm run build`


