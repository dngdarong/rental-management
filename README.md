<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Rental Management System - Admin Panel

This project is a comprehensive Rental Management System (Admin Panel) built using the Laravel framework. It provides administrators with a robust and intuitive interface to manage various aspects of a rental business, focusing specifically on the backend operations without a tenant-facing portal.

## Project Overview

The primary goal of this system is to streamline the administrative tasks associated with property rentals, offering a centralized platform for managing rooms, room types, tenants, rent records, payments, and maintenance requests. It is designed for single or multiple administrators (with role-based access for Super Admins) to efficiently oversee rental operations.

## Key Features

The system is built around a CRUD (Create, Read, Update, Delete) paradigm for core entities and includes the following functionalities:

* Dashboard:

  * Provides an at-a-glance overview of key metrics: Total Rooms, Occupied Rooms, Available Rooms, and Total Tenants.

  * Features a dynamic Monthly Revenue Chart (powered by Chart.js) displaying financial performance over the last 12 months.

* Room Management:

  * Add/Edit/Delete Rooms: Full CRUD capabilities for individual rooms.

  * Room Details: Manages `room_number`, `room_type`, `status` (available, occupied, under maintenance), and `price`.

  * Room Type Assignment: Allows assigning rooms to predefined room types.

* Room Type Management:

  * Create/Edit/Delete Room Types: Manages categories of rooms (e.g., Single, Double, AC, Non-AC).

  *Default Pricing: Assigns a `default_price` to each room type, which can be overridden at the individual room level.

* Tenant Management:

  * Register/Edit Tenants: Comprehensive management of tenant information including `full_name`, `email`, `phone`, `address`, `gender`, and `start_date`.

  * Room Assignment: Facilitates assigning tenants to available rooms, automatically updating room status.

* Rent Management:

  * Record Rent: Allows administrators to manually record monthly rent charges for tenants.

  * Track Payment Status: Monitors rent status (Paid, Due, Partial).

  * Invoice Generation (Conceptual): Designed to support future invoice generation based on rent records.

* Payment Management:

  * Record Payments: Logs individual payment transactions.

  * View Payment History: Provides a detailed history of payments by tenant, with filtering options by month and payment method.

  * Rent Status Update: Payments automatically update the status of associated rent records (e.g., from 'Due' to 'Partial' or 'Paid').

* Maintenance Request Management:

  * View/Update Requests: Allows administrators to view all maintenance requests and update their status (Pending, In Progress, Completed, Cancelled).

  * Admin Notes: Ability to add internal notes to requests.

* Admin User Management (SuperAdmin only):

  * Role-Based Access: Implements a `super_admin` role with exclusive access to manage other `admin_tenant` accounts.

  * Create/Edit/Delete Admin Tenants: Super Admins can create new admin users, update their details, and delete them (with safeguards to prevent self-deletion or super admin deletion).

* Admin Profile & Settings:

  * Allows the logged-in administrator to update their personal details (name, email) and change their password.

  * Profile Image Upload: Supports uploading and managing a profile image for the admin user, with a Gravatar fallback.

## Technologies Used

* Framework: Laravel 10+

* Database: MySQL

* Authentication: Laravel Breeze (Blade with Alpine.js)

* Frontend Styling: Tailwind CSS

* Charting: Chart.js

* PHP Libraries: Carbon (for date/time handling), Laravel Eloquent ORM

* Authorization: Laravel Gates

## Installation & Setup
To set up and run this project locally:

### 1. Prerequisites
Ensure you have the following software installed on your system:

* PHP (8.2 or higher): Laravel 10+ requires PHP 8.2 or newer.

* Composer: PHP dependency manager. [Download Composer](https://getcomposer.org/Composer-Setup.exe)

* Node.js & npm: For frontend asset compilation. [Download Node.js (includes npm)](https://nodejs.org/en/download)

* MySQL Database Server: Or another compatible database (e.g., MariaDB).

* Web Server (e.g., Apache, Nginx): Or use Laravel's built-in development server. If using XAMPP/WAMP/Laragon, these are usually included.

* Git: For cloning the repository. [Download Git](https://git-scm.com/downloads)

* PowerShell Execution Policy (Windows only): If you encounter errors running `npm` or `php artisan` commands, you might need to adjust PowerShell's execution policy. Open PowerShell as Administrator and run:

```
Set-ExecutionPolicy RemoteSigned
```
Type `Y` to confirm, then close the admin PowerShell and open a new regular one.

### 2. Clone the Repository
First, clone the project from GitHub to your local machine:
```
git clone <YOUR_GITHUB_REPOSITORY_URL> rental-management
cd rental-management
```
(Replace `<YOUR_GITHUB_REPOSITORY_URL>` with the actual URL of your project's GitHub repository.)

### 3. Install PHP Dependencies
Install all the backend dependencies using Composer:
```
composer install
```
### 4. Install Node.js Dependencies
Install all the frontend dependencies using npm:
```
npm install
```
### 5. Configure Environment Variables
Create your environment configuration file by copying the example:
```
cp .env.example .env
# If using PowerShell and 'cp' doesn't work, try:
# Copy-Item .\.env.example .\.env
```
Then, open the newly created `.env` file in a text editor and update the following sections:

### a. Application Key
Generate a unique application key:
```
php artisan key:generate
# If using PowerShell and 'artisan' doesn't work, try:
# .\php artisan key:generate
```
### b. Database Connection
Configure your MySQL database credentials. Make sure your MySQL server is running and the database name exists.
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1  # Usually localhost or 127.0.0.1
DB_PORT=3306       # Default MySQL port
DB_DATABASE=rental_management_db  # Choose a name for your database
DB_USERNAME=root                  # Your MySQL username
DB_PASSWORD=                      # Your MySQL password (leave blank if no password)
```
Troubleshooting Database Connection: If you get "No connection could be made because the target machine actively refused it", ensure your MySQL server (e.g., via XAMPP control panel) is running.

### c. Mail Configuration (for Password Reset)
Configure your mail driver. For local development, Mailpit is highly recommended.

Using Mailpit (Recommended for Local Development):
If you have Mailpit running (e.g., via Docker, or separately on `localhost:1025`), use these settings:
```
MAIL_MAILER=smtp
MAIL_HOST=localhost
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="no-reply@yourdomain.com" # Your application's "from" address
MAIL_FROM_NAME="${APP_NAME}"
```
### Using a Real SMTP Service (e.g., Gmail, Mailtrap, SendGrid):
Replace with your actual service credentials.
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io # Example: smtp.gmail.com, smtp.sendgrid.net
MAIL_PORT=2525             # Example: 465 (SSL) / 587 (TLS) for others
MAIL_USERNAME=your_smtp_username
MAIL_PASSWORD=your_smtp_password
MAIL_ENCRYPTION=tls        # Or 'ssl'
MAIL_FROM_ADDRESS="your_app_email@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```
### 6. Run Database Migrations and Seeders
This step will create all necessary database tables and populate them with initial data (including `super_admin`, `admin_tenant`, and `tenant` users, along with sample room types, rooms, tenants, rents, payments, and maintenance requests).
```
php artisan migrate:fresh --seed
# If using PowerShell and 'artisan' doesn't work, try:
# .\php artisan migrate:fresh --seed
```
### 7. Create Storage Link
This command creates a symbolic link from `public/storage` to `storage/app/public`, which is essential for making uploaded files (like profile images) publicly accessible via URL.
```
php artisan storage:link
# If using PowerShell and 'artisan' doesn't work, try:
# .\php artisan storage:link
```
### 8. Compile Frontend Assets
Compile your Tailwind CSS and JavaScript assets.
```
npm run dev
# Or for production-ready assets:
# npm run build
```
### 9. Start the Development Server
You can use Laravel's built-in development server to run your application:
```
php artisan serve
# If using PowerShell and 'artisan' doesn't work, try:
# .\php artisan serve
```
## How to Use the Application
Once the development server is running, access the application in your web browser:

### 1. Access the Login Page: Open `http://127.0.0.1:8000/` in your browser.

### 2. Login with Admin Credentials: Use the following default credentials (or your custom seeded ones):

* Super Admin (Full Rights):

  * Email: `superadmin@example.com`

  * Password: `password`

* Admin Tenant (Admin Panel Access, No Admin User Creation):

  * Email: `admin@example.com`

  * Password: `password`

* Tenant (No Admin Panel Access):

  * Email: `tenant@example.com`

  * Password: `password`
    (Note: If you try to log in as a 'Tenant' and access admin pages, you will be redirected or denied access as per the role-based security.)

### 3. Explore the Dashboard: After successful login, you'll be redirected to the Admin Dashboard (`/admin/dashboard`), showing key metrics and a revenue chart.

### 4. Navigate Modules: Use the sidebar to navigate through different management sections:

* Rooms: Add, edit, delete, and view rental rooms.

* Room Types: Manage categories and default pricing for rooms.

* Tenants: Register new tenants, assign them to rooms, and manage their details.

* Rents: Record monthly rent charges and track their status.

* Payments: Record individual payments and view payment history.

* Maintenance: View and update the status of maintenance requests.

* Manage Admins (SuperAdmin Only): Create, edit, and delete other     `admin_tenant` accounts.

### 5. Manage Your Profile: Click on your avatar/name in the top right corner to access "Settings" (`/profile`), where you can update your name, email, password, and profile image.

* Future Enhancements

  * Tenant-facing portal for viewing rent, payments, and submitting maintenance requests.

  * Automated rent generation.

  * Advanced reporting and export options (PDF/CSV).

  * Notification system for overdue rents or new maintenance requests.

  * More robust search and filtering options across all modules.