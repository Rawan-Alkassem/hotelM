# 🏨 Hotel Management System (Laravel 12)

A complete role-based hotel management system built with Laravel 12, featuring room and booking management, employee roles, hotel analytics, API access for customers and visitors, and more. Designed for Admins, Receptionists, and Hotel Managers.

##  Admin Features

- 🛏️ Manage Rooms (CRUD)
- 🏷️ Manage Room Types
- 🧼 Manage Room Services
- 👥 Manage Employees & Roles
- 📆 Booking Management (with conflict checks)
- 📧 Email Notifications when Admin creates a booking
- 📊 Hotel Reports (Monthly, Yearly, By Room Type)
- 📚 Booking Logs & Confirmation Flow
- 📅 Calendar & Room Availability
- 🔍 Booking Filtering (by status, type, etc.)
- 📧 Email Notification when creating a booking by the admin
##  API Features

The project provides RESTful API endpoints for customers and public visitors to interact with hotel services.

### Visitors (unauthenticated):
- View available rooms
- Check room types and services

### Customers (authenticated):
- Register and login
- Book rooms via API
- View their booking history

> API authentication is managed using Laravel Sanctum.

##  User Roles

- **Admin**: Full access to all features
- **Receptionist**: Bookings, calendar, limited access
- **Hotel Manager**: View reports, dashboard
- **Customer**: Can interact via API only

##  Tech Stack

- Laravel 12 (PHP 8.2+)
- Blade + Tailwind CSS
- MySQL / SQLite
- Laravel Breeze (auth scaffolding)
- Spatie Laravel Permission
- Laravel Sanctum (API authentication)
- Vite for asset bundling
- Composer + NPM

##  Installation Steps

### 1. Clone the project:
```bash
git clone https://github.com/Rawan-Alkassem/hotelM.git
cd hotelM
```

### 2. Install backend & frontend dependencies:
```bash
composer install
npm install
```

### 3. Configure environment:
```bash
cp .env.example .env
php artisan key:generate
```

Set up database in `.env` (MySQL or use default SQLite):
```env
DB_CONNECTION=sqlite
# or configure MySQL
# DB_DATABASE=your_db
# DB_USERNAME=root
# DB_PASSWORD=your_password
```

### 4. Run migration & seeders:
```bash
php artisan migrate --seed
```

### 5. Link storage:
```bash
php artisan storage:link
```

### 6. Compile frontend:
```bash
npm run dev   # for development
npm run build # for production
```

### 7. Serve the app:
```bash
php artisan serve
```

---

##  Authentication & Access

- Laravel Breeze for authentication
- Spatie Laravel Permission for roles
- Laravel Sanctum for API token authentication
- Roles and demo users are seeded
- Session and queue drivers set to `database`

##  Project Highlights

- Modular route structure using middleware
- Custom `AdminLayout` with dark mode and RTL support
- Room availability checking system
- Booking logs and conflict handling via middleware
- Visual calendar for booking overview
- Search and filtering system for bookings
- API endpoints for booking and room listing
- Email notifications on booking creation


- Customer-facing web module
- Payment integration for bookings
- SMS notifications
- Booking approval workflows

