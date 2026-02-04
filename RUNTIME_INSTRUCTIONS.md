Summary
- Project PHP requirement updated to ^8.2.
- Added `Dockerfile` (php:8.2-fpm) so builds can use a consistent runtime when deploying with Docker.

Local (Laragon) — switch PHP version
1. Open Laragon.
2. Menu > PHP > Version > select a PHP 8.2 build installed (or install PHP 8.2 via Laragon's tools).
3. Restart Laragon (Menu > Restart All).
4. In project root run:

```powershell
composer update
php artisan key:generate --force
php artisan migrate --force
```

Cloud / Railpack
- Preferred: Deploy using the provided `Dockerfile` (php:8.2-fpm) so the environment uses PHP 8.2 even if the platform default differs.
- Alternative: If Railpack supports selecting a PHP runtime, configure it to `8.2` or a supported version in its build config.

Next steps (required)
- Run `composer update` locally to regenerate `composer.lock` using PHP 8.2, test the app, commit `composer.json` and `composer.lock`, then redeploy.

Notes
- I set `composer install` to not fail Docker build in case of missing local tooling; run `composer update` locally to finish dependency resolution.
