# 🏨 Hotel Management System (Laravel 12)

A complete role-based hotel management system built with Laravel 12, featuring room and booking management, employee roles, hotel analytics, and more. Designed for Admins, Receptionists, and Hotel Managers.

##  Admin Features

- 🛏️ Manage Rooms (CRUD)
- 🏷️ Manage Room Types
- 🧼 Manage Room Services
- 👥 Manage Employees & Roles
- 📆 Booking Management (with conflict checks)
- 📊 Hotel Reports (Monthly, Yearly, By Room Type)
- 📚 Booking Logs & Confirmation Flow
- 📅 Calendar & Room Availability
- 🔍 Booking Filtering (by status, type, etc.)

##  User Roles

- **Admin**: Full access to all features
- **Receptionist**: Bookings, calendar, limited access
- **Hotel Manager**: View reports, dashboard

##  Tech Stack

- Laravel 12 (PHP 8.2+)
- Blade + Tailwind CSS
- MySQL / SQLite
- Laravel Breeze (auth scaffolding)
- Spatie Laravel Permission
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
- Roles and demo users are seeded
- Session and queue drivers set to `database`

##  Project Highlights

- Modular route structure using middleware
- Custom `AdminLayout` with dark mode and RTL support
- Room availability checking system
- Booking logs and conflict handling via middleware
- Visual calendar for booking overview
- Search and filtering system for bookings

##  Screenshots

_Add screenshots of Dashboard, Booking Calendar, and Room Management here._

##  To-Do / Optional Improvements

- Customer-facing booking module
- Notifications (email/SMS)
- Booking payment integration
- Booking approval workflows

##  Testing

To run tests:
```bash
php artisan test
```

##  License

This project is licensed under the [MIT License](LICENSE).

---

