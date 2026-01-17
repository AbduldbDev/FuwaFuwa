# IT Lifecycle Management System

**Project Name:** IT Lifecycle Management System  
**Company:** Fuwa Fuwa by Nippon Premium Bakery Inc.

---

## Description

The IT Lifecycle Management System is designed to manage the full lifecycle of IT assets within the company.  
It provides a centralized platform for managing assets, users, maintenance, reports, and role-based access control, ensuring smooth IT operations and timely maintenance.

---

## Features

- Asset Management (Add, Edit, Track IT assets)
- User Management (Employees, Departments, Roles & Permissions)
- Maintenance and Issue Tracking
- Reports and Analytics
- Role-Based Access Control (RBAC)
- Notifications and Alerts
- Activity Logs

---

## Tech Stack

- **Backend:** Laravel 12 (PHP 8.2+)
- **Frontend:** Bootstrap 5
- **Database:** MySQL 8+
- **Node.js:** For compiling assets and frontend dependencies
- **Composer:** For PHP dependencies

---

## Installation

### 1. Clone Repository

```bash
git clone https://github.com/AbduldbDev/FuwaFuwa.git
cd FuwaFuwa
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install laravel 12 globally

```
composer global require laravel/installer
```

### 4. Install Node Dependencies

```
npm install
```

### 5. Build Frontend Assets

```
npm run dev
# or production
npm run build
```

### 6. Environment Setup

```
cp .env.example .env
php artisan key:generate
```

#### Edit .env with your database credentials:

```
APP_NAME="Fuwa Fuwa"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fuwafuwa
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Database Setup

#### Run migrations:

```
php artisan migrate
```

#### Running the Application

```
composer run dev
```

##### Open in browser:

```
http://127.0.0.1:8000
```
