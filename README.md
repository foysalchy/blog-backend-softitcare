# Backend Setup (Laravel API)

This is the backend API built with Laravel and Sanctum authentication.

## Requirements

- PHP 8.1 or higher
- Composer
- MySQL 

## Installation Steps

1. **Clone the project**:
   ```bash
     git clone https://github.com/foysalchy/blog-backend-softitcare.git
   

2. **Install PHP dependencies**:
composer install

3. **Setup environment file**:
    |--cp .env.example .env
    |--Configure .env:
    |--Set your database details (DB_DATABASE, DB_USERNAME, DB_PASSWORD)
    |--Set APP_URL (example: http://localhost:8000)

4. **Run migrations and seeders**:
php artisan migrate:fresh --seed

if any issue with seeder please upload menuaaly database.sql file

5. **Start the development server**:
php artisan serve