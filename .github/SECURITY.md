# Security Policy

## Supported versions
This repository does not currently publish separate supported release lines.
Report issues against the default branch and include the commit hash or deployed version if known.

## Reporting a vulnerability
Please do not open public GitHub issues for security vulnerabilities.

Use one of these private paths instead:
- GitHub Security Advisories for this repository, if enabled
- a private maintainer contact defined by the repository owners

When reporting, include:
- affected area (`app/`, `routes/`, `resources/views/`, dependency, CI)
- reproduction steps
- potential impact
- screenshots or logs if they help

## Project-specific notes
- External HTTP integration exists via `app/Services/OpenPlzService.php`
- Authentication, password reset, and profile flows come from Laravel Breeze and project overrides in `app/Http/Controllers/Auth` and `app/Http/Controllers/ProfileController.php`
- Locale handling is customized in `app/Http/Middleware/SetLocale.php`

