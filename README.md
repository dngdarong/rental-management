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

## Dashboard:

- Provides an at-a-glance overview of key metrics: Total Rooms, Occupied Rooms, Available Rooms, and Total Tenants.

- Features a dynamic Monthly Revenue Chart (powered by Chart.js) displaying financial performance over the last 12 months.

## Room Management:

- Add/Edit/Delete Rooms: Full CRUD capabilities for individual rooms.

- Room Details: Manages room_number, room_type, status (available, occupied, under maintenance), and price.

- Room Type Assignment: Allows assigning rooms to predefined room types.

## Room Type Management:

- Create/Edit/Delete Room Types: Manages categories of rooms (e.g., Single, Double, AC, Non-AC).

- Default Pricing: Assigns a default_price to each room type, which can be overridden at the individual room level.

## Tenant Management:

- Register/Edit Tenants: Comprehensive management of tenant information including full_name, email, phone, address, gender, and start_date.

- Room Assignment: Facilitates assigning tenants to available rooms, automatically updating room status.

## Rent Management:

- Record Rent: Allows administrators to manually record monthly rent charges for tenants.

- Track Payment Status: Monitors rent status (Paid, Due, Partial).

- Invoice Generation (Conceptual): Designed to support future invoice generation based on rent records.

## Payment Management:

- Record Payments: Logs individual payment transactions.

- View Payment History: Provides a detailed history of payments by tenant, with filtering options by month and payment method.

- Rent Status Update: Payments automatically update the status of associated rent records (e.g., from 'Due' to 'Partial' or 'Paid').

## Maintenance Request Management:

- View/Update Requests: Allows administrators to view all maintenance requests and update their status (Pending, In Progress, Completed, Cancelled).

- Admin Notes: Ability to add internal notes to requests.

## Admin User Management (SuperAdmin only):

- Role-Based Access: Implements a super_admin role with exclusive access to manage other admin_tenant accounts.

- Create/Edit/Delete Admin Tenants: Super Admins can create new admin users, update their details, and delete them (with safeguards to prevent self-deletion or super admin deletion).

## Admin Profile & Settings:

- Allows the logged-in administrator to update their personal details (name, email) and change their password.

- Profile Image Upload: Supports uploading and managing a profile image for the admin user, with a Gravatar fallback.

Technologies Used
Framework: Laravel 10+

Database: MySQL

Authentication: Laravel Breeze (Blade with Alpine.js)

Frontend Styling: Tailwind CSS

Charting: Chart.js

PHP Libraries: Carbon (for date/time handling), Laravel Eloquent ORM

Authorization: Laravel Gates

Installation & Setup
To set up and run this project locally:

Clone the repository:

git clone <repository_url> rental-management
cd rental-management

Install Composer dependencies:

composer install

Install Node.js dependencies:

npm install

Create your .env file:

cp .env.example .env

Generate an application key:

php artisan key:generate

Configure your .env file:

Set your MySQL database credentials (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

Configure your mail driver for password reset functionality (e.g., Mailpit, SMTP).

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rental_management_db
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp # or log for testing without sending real emails
MAIL_HOST=localhost # e.g., localhost for Mailpit, smtp.mailtrap.io for Mailtrap
MAIL_PORT=1025 # e.g., 1025 for Mailpit, 2525 for Mailtrap
MAIL_USERNAME=null # or your SMTP username
MAIL_PASSWORD=null # or your SMTP password
MAIL_ENCRYPTION=null # or tls/ssl
MAIL_FROM_ADDRESS="no-reply@rentalapp.com"
MAIL_FROM_NAME="${APP_NAME}"

Run database migrations and seeders:

php artisan migrate:fresh --seed

This will create all necessary tables and seed a super_admin user (superadmin@example.com with password password) and a default admin_tenant user (admin@example.com with password password).

Link storage for profile images:

php artisan storage:link

Compile frontend assets:

npm run dev

Start the Laravel development server:

php artisan serve

Accessing the Application
Login Page: Navigate to http://127.0.0.1:8000/

Admin Dashboard: After logging in, you will be redirected to http://127.0.0.1:8000/admin/dashboard

Default Admin Credentials:

Super Admin:

Email: superadmin@example.com

Password: password

Admin Tenant:

Email: admin@example.com

Password: password

(Note: If you modified the UserSeeder with your own personal admin, use those credentials.)

Future Enhancements
Tenant-facing portal for viewing rent, payments, and submitting maintenance requests.

Automated rent generation.

Advanced reporting and export options (PDF/CSV).

Notification system for overdue rents or new maintenance requests.

More robust search and filtering options across all modules.