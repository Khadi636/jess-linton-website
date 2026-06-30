# Installation Guide

## Requirements

| Software | Minimum version |
|----------|-----------------|
| PHP      | 8.0             |
| MySQL    | 5.7 / MariaDB 10.3 |
| Apache   | 2.4 (with mod_rewrite) |

PHP extensions needed: `pdo`, `pdo_mysql`, `fileinfo`, `session`

---

## Step 1 — Create the database

```bash
mysql -u root -p
```

```sql
CREATE DATABASE jess_linton CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

---

## Step 2 — Run schema and seed

```bash
mysql -u root -p jess_linton < database/schema.sql
mysql -u root -p jess_linton < database/seed.sql
```

---

## Step 3 — Create a real admin password

The seed file contains a placeholder hash. Replace it:

```bash
php -r "echo password_hash('your_secure_password', PASSWORD_BCRYPT) . PHP_EOL;"
```

Then update the hash in the database:

```sql
UPDATE users SET password_hash = '$2y$12$your_real_hash_here' WHERE username = 'admin';
```

---

## Step 4 — Edit config.php

Open `config.php` and set your credentials:

```php
define('DB_HOST',   'localhost');
define('DB_NAME',   'jess_linton');
define('DB_USER',   'your_db_user');
define('DB_PASS',   'your_db_password');
define('SITE_URL',  'http://localhost:8080'); // update for production
define('DEV_MODE',  false);                  // set false in production
```

---

## Step 5 — Set folder permissions

The upload directory must be writable by the web server:

```bash
chmod 755 public/uploads/gallery
chown www-data:www-data public/uploads/gallery   # on Linux/Apache
```

---

## Step 6 — Configure the web server

### Option A: PHP built-in server (development only)

```bash
cd fullstack-site
php -S localhost:8080
```

Then open: `http://localhost:8080`

### Option B: Apache virtual host

```apache
<VirtualHost *:80>
  ServerName jesslinton.local
  DocumentRoot /path/to/fullstack-site
  <Directory /path/to/fullstack-site>
    AllowOverride All
    Require all granted
  </Directory>
</VirtualHost>
```

Enable mod_rewrite:

```bash
a2enmod rewrite
service apache2 restart
```

### Option C: MAMP / WAMP / Laragon

Point the document root to the `fullstack-site/` directory. The `.htaccess` handles the rest.

---

## Step 7 — Test the install

1. Open `http://localhost:8080` — homepage should display
2. Open `http://localhost:8080/admin/login.php`
3. Log in with `admin` / your chosen password
4. Dashboard should show stats: 15 CMS pages, 16 gallery images, 2 blog posts

---

## Updating SITE_URL for production

Change `SITE_URL` in `config.php` to your live domain:

```php
define('SITE_URL', 'https://www.jesslinton.co.uk');
```

Also update `sitemap.xml` in the static site folder (separate from the PHP version).

---

## Directory protection

The `.htaccess` blocks direct access to:
- `includes/`
- `database/`
- `config.php`
- `*.sql`, `*.md`, `*.log` files

These protections require Apache `mod_rewrite` to be enabled.
