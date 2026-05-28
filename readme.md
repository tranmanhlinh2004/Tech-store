# docongnghe.com - packages can thiet

Project nay gom Laravel backend trong `backend/`, Blade/static frontend trong `frontend/`, va file SQL mau trong `database/`.

## Runtime can cai

- PHP `^8.3`
- Composer `2.x`
- Node.js va npm
- Database:
  - Mac dinh: SQLite, can bat PHP extensions `pdo_sqlite` va `sqlite3`
  - Neu dung file `database/tech_shop_db.sql`: MySQL/MariaDB, can bat PHP extension `pdo_mysql`

## PHP extensions nen co

Laravel va cac package trong project can cac extension PHP thong dung sau:

- `ctype`
- `curl`
- `dom`
- `fileinfo`
- `filter`
- `hash`
- `mbstring`
- `openssl`
- `pcre`
- `pdo`
- `session`
- `tokenizer`
- `xml`
- `xmlwriter`

Nen bat them `intl`, `gd`, `zip` neu moi truong dev/test hoac tooling yeu cau.

## Composer packages

Nam trong `backend/composer.json`.

### Dependencies chay app

- `laravel/framework` `^13.7`
- `laravel/tinker` `^3.0`

### Dependencies dev/test

- `fakerphp/faker` `^1.23`
- `laravel/pail` `^1.2.5`
- `laravel/pao` `^1.0.6`
- `laravel/pint` `^1.27`
- `mockery/mockery` `^1.6`
- `nunomaduro/collision` `^8.6`
- `phpunit/phpunit` `^12.5.12`

## npm packages

Nam trong `backend/package.json`.

- `@tailwindcss/vite` `^4.0.0`
- `concurrently` `^9.0.1`
- `laravel-vite-plugin` `^3.1`
- `tailwindcss` `^4.0.0`
- `vite` `^8.0.0`

## Lenh setup nhanh

Chay trong thu muc `backend/`:

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
npm install
```

Neu dung SQLite:

```powershell
New-Item -ItemType File -Force database/database.sqlite
php artisan migrate --seed
```

Neu dung MySQL/MariaDB, tao database va cau hinh `.env`, sau do import `database/tech_shop_db.sql` hoac chay migration:

```powershell
php artisan migrate --seed
```

## Chay project

Chay Laravel:

```powershell
php artisan serve
```

Chay Vite dev server trong terminal khac:

```powershell
npm run dev
```

Hoac chay script dev tong hop:

```powershell
composer run dev
```

Build frontend assets:

```powershell
npm run build
```
