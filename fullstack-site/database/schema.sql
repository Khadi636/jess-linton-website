-- ============================================================
-- Jess Linton Website — Database Schema
-- MySQL 5.7+ / MariaDB 10.3+
-- Run: mysql -u root -p jess_linton < database/schema.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS jess_linton
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE jess_linton;

-- ── Users ────────────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS users (
  id            INT UNSIGNED     NOT NULL AUTO_INCREMENT,
  username      VARCHAR(80)      NOT NULL UNIQUE,
  email         VARCHAR(255)     NOT NULL UNIQUE,
  password_hash VARCHAR(255)     NOT NULL,  -- bcrypt via password_hash()
  created_at    DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP,
  last_login    DATETIME                  DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── Pages (CMS editable content) ─────────────────────────────────────────────
-- Each page stores its editable sections as a JSON blob.
-- The PHP page templates define which keys they read.
CREATE TABLE IF NOT EXISTS pages (
  id         INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  slug       VARCHAR(120)  NOT NULL UNIQUE,  -- e.g. 'about', 'home'
  content    LONGTEXT               DEFAULT NULL,  -- JSON
  updated_at DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  updated_by INT UNSIGNED           DEFAULT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── Blog Posts ────────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS blog_posts (
  id              INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  title           VARCHAR(255)  NOT NULL,
  slug            VARCHAR(255)  NOT NULL UNIQUE,
  excerpt         TEXT                   DEFAULT NULL,
  content         LONGTEXT      NOT NULL,
  featured_image  VARCHAR(500)           DEFAULT NULL,  -- URL or path
  status          ENUM('draft','published') NOT NULL DEFAULT 'draft',
  published_at    DATETIME               DEFAULT NULL,
  created_at      DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at      DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_status_published (status, published_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── Gallery Images ────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS gallery_images (
  id            INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  title         VARCHAR(255)           DEFAULT NULL,   -- also used as alt text
  description   TEXT                   DEFAULT NULL,
  image_path    VARCHAR(500)           DEFAULT NULL,   -- relative path under uploads/gallery/
  image_url     VARCHAR(500)           DEFAULT NULL,   -- external CDN URL (fallback/legacy)
  display_order SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  created_at    DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_display_order (display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── Contact Settings (key–value store) ────────────────────────────────────────
-- Keys: email, phone, address, hcpc_number, dbs_number, copyright_year,
--       session_fee, location_text
CREATE TABLE IF NOT EXISTS contact_settings (
  id    INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `key` VARCHAR(80)   NOT NULL UNIQUE,
  value TEXT          NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── SEO Settings ──────────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS seo_settings (
  id               INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  page_slug        VARCHAR(120)  NOT NULL UNIQUE,
  title            VARCHAR(70)           DEFAULT NULL,
  meta_description VARCHAR(160)          DEFAULT NULL,
  og_image         VARCHAR(500)          DEFAULT NULL,
  updated_at       DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
