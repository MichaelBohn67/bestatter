### Project Guidelines for Junie

#### Overview
This is a Laravel project focused on a funeral service management system (Bestatter).

#### Technology Stack
- **Framework:** Laravel 11.x
- **Language:** PHP 8.x
- **Testing:** PHPUnit
- **Database:** SQLite (for testing)

#### Coding Standards
- Use only english words when naming variables and classes.
- Follow PSR-12 coding standards.
- Use Laravel's Eloquent ORM for database interactions.
- Ensure models use `HasFactory` and `SoftDeletes` where appropriate.
- Maintain consistency with existing model naming (e.g., `Customer`, `Deceased`, `FuneralService`).
- **Clean Code Principles:**
    - **Models:** Always use the `casts()` method instead of the `$casts` property for Laravel 11+.
    - **Type Hinting:** Strictly use return type hints for all methods, including controller actions and model accessors/relationships.
    - **Thin Controllers:** Business logic should be extracted to Service classes (e.g., `app/Services`). Controllers should only handle request validation, service calling, and response returning.
    - **Naming:** Use descriptive names for variables and methods.

#### Testing Strategy
- **Unit Tests:** Always create unit tests for models, including:
    - Mass assignable attributes (`$fillable`).
    - Hidden attributes (`$hidden`).
    - Attribute casting.
    - Model relationships.
    - Custom accessors/mutators (e.g., `full_name`).
    - Soft deletes verification.
- **Feature Tests:** Cover authentication, profile management, and core business logic.
- **Factories:** Maintain up-to-date factories for all models in `database/factories`.
- **Execution:** Run tests using `php artisan test`.

#### Development Workflow
- When adding new models:
    1. Create migration.
    2. Create model with appropriate traits and properties.
    3. Create factory.
    4. Create unit tests and verify they pass.
- Always check existing tests before submitting changes to ensure no regressions.

#### Codex Instructions
- Follow the same standards as above (PSR-12, Eloquent ORM, `casts()` method, strict return types).
- Keep controllers thin; put business logic in `app/Services` and call services from controllers.
- When adding or changing models, also update factories and unit tests as described.
- Use English naming for classes, methods, and variables.
