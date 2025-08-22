# Laravel 12 Admin Template

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![PHP](https://img.shields.io/badge/php-8.2+-blue.svg)](https://www.php.net/)
[![Laravel](https://img.shields.io/badge/laravel-12-red.svg)](https://laravel.com/)

## Overview

**Laravel 12 Admin Template** is a professional boilerplate designed for building scalable, maintainable, and production-ready web applications with an admin dashboard. This repository integrates a pre-built admin interface, fully configured Blade and Vue 3 components, authentication scaffolding, and development-ready configurations. It serves as a starting point for developers who want to accelerate project setup without compromising code quality or maintainability.

This template is ideal for developers aiming to adhere to **industry-standard coding practices**, **conventional commits**, and **clean Git workflows** suitable for both solo and team projects.

---

## Key Features

- Laravel 12 ready and fully configured
- Blade templating + Vue 3 components for reactive UI
- Pre-built admin dashboard with sample widgets and layout
- Authentication scaffolding (login, registration, password reset)
- Predefined routing and controller structure for rapid development
- Integration-ready for databases: MySQL / MariaDB (Eloquent ORM)
- Conventional Commit-ready workflow
- Easy to extend and integrate with additional modules
- Clean directory structure for maintainability

---

## Technology Stack

| Layer | Technology / Tool |
|-------|------------------|
| Backend | PHP 8.2+, Laravel 12 |
| Frontend | Blade, Vue.js 3, Tailwind CSS |
| Database | MySQL / MariaDB, Eloquent ORM |
| Asset Management | Vite, npm, Laravel Mix (optional) |
| Testing | PHPUnit, Laravel Test Utilities |
| Code Quality | PHP-CS-Fixer, ESLint, Prettier |
| Dev Tools | Composer, npm/yarn, Git |

---

## Installation & Setup

Follow these steps to get the project running locally:

```bash
# Clone the repository
git clone https://github.com/EasyToBuildWithKane/laravel-admin-template.git
cd laravel-12-template-admin

# Install PHP dependencies
composer install

# Copy environment file and generate application key
cp .env.example .env
php artisan key:generate

# Install Node dependencies & build frontend assets
npm install
npm run dev

# Run database migrations
php artisan migrate

# Optional: seed a demo admin user
php artisan db:seed
