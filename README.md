# StockFlow POS - Inventory & Point of Sale System

A complete, production-ready Point of Sale and Inventory Management System built with Laravel 11 and Bootstrap 5.

## 🚀 Features
- **Role-Based Access Control (RBAC):** Admin, Staff, and Cashier roles.
- **Inventory Management:** Manage Categories, Units, Suppliers, and Products with image uploads.
- **Smart Stock Tracking:** Real-time stock deduction and low-stock alerts.
- **Point of Sale (POS):** AJAX-powered cart system for fast billing.
- **Invoicing:** Auto-generated invoice numbers and printable receipts.
- **Dynamic Dashboard:** Real-time stats for Today's Sales and Recent Transactions.

## 🛠️ Tech Stack
- Laravel 11 (PHP 8.2)
- MySQL
- Bootstrap 5
- JavaScript (AJAX)
- Spatie Laravel-Permission

## ⚙️ Installation
1. `composer install`
2. `npm install && npm run build`
3. Copy `.env.example` to `.env` and set DB credentials.
4. `php artisan migrate:fresh --seed`
5. `php artisan storage:link`
6. `php artisan serve`

## 🔐 Demo Credentials
- **Admin:** admin@stockflow.test / password
- **Cashier:** cashier@stockflow.test / password

---
*Developed by [Muhammad Ahmad Raza]*
