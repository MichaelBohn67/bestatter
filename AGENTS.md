# AGENTS Guide
## Project at a glance
- Stack: Laravel 12 + PHP 8.2, Blade + Vite/Tailwind (`composer.json`, `package.json`).
- Domain focus: funeral-case management (deceased, customers/relatives, funeral orders, billing).
- Most domain behavior is server-rendered via Blade views; JS is minimal (`resources/js/app.js`).
## Core architecture (read this first)
- HTTP entrypoints live in `routes/web.php`; domain routes are behind `auth` + `verified`.
- Controllers orchestrate validation + persistence in `app/Http/Controllers/*Controller.php`.
- Services hold multi-step write logic:
  - `app/Services/FuneralServiceCreator.php` creates `Deceased` + `Customer` + `FuneralService` in one flow.
  - `app/Services/BillingService.php` normalizes values and computes `tax_amount`/`total`.
- Eloquent models in `app/Models` define relations and casts; soft deletes are standard across domain entities.
- UI lives in `resources/views/*`; layout and nav are component-based (`x-app-layout`, `x-input-*`).
## Data model patterns that matter
- `FuneralService` is central and links to `Deceased`, `Customer`, optional `Graveyard` and `Chapel`, and one `Billing`.
- DB constraints enforce one-to-one style links:
  - unique `funeral_services.deceased_id` (`2026_01_14_173027_add_unique_index_to_funeral_services_deceased_id.php`)
  - unique `billings.funeral_service_id` (`2026_01_14_173035_create_billings_table.php`)
- Addresses are polymorphic (`addresses` table with `morphs('addressable')`), used by `Customer`, `Deceased`, `Relative`, `Graveyard`, `Commune`.
- Controllers often map `address_*` request fields manually into both entity fields and `address()` relation (see `CustomerController`).
## Localization convention (project-specific)
- This app uses GNU gettext in Blade (`gettext('...')`), not Laravel `__('...')` in most views.
- Locale handling is custom middleware: `app/Http/Middleware/SetLocale.php` (sets `App::setLocale`, env locale, textdomain).
- Locale switch route is `/locale/{locale}` with only `en` and `de` (`routes/web.php`).
- Translation catalogs are `.po/.mo` files in `resources/lang/{en,de}/LC_MESSAGES/messages.*`.
## Developer workflows
- First-time setup: `composer run setup`
- Local dev: `composer run dev` (app server, queue listener, pail logs, vite)
- Tests: `composer run test` (in-memory sqlite via `phpunit.xml`; many tests use `RefreshDatabase`)
- Frontend only: `npm run dev` / `npm run build`
## Integration points
- External API: OpenPLZ via `app/Services/OpenPlzService.php` using Laravel HTTP client.
- Service is container-singleton-bound in `app/Providers/AppServiceProvider.php`.
- Behavior is tested with `Http::fake()` in `tests/Feature/OpenPlzServiceTest.php`.
## Practical editing guidance for agents
- Follow existing style: inline `$request->validate(...)` in controllers unless a FormRequest already exists.
- Preserve soft-delete semantics and existing unique constraints when adding relations/migrations.
- When touching forms, keep request field names aligned with controller extractors (especially `address_*` fields).
- If adding UI strings, update gettext catalogs (`messages.po`) instead of only changing Blade text.
