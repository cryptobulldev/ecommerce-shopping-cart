# 🛒 Laravel 11 + Inertia.js + React – E-Commerce Cart Demo

This project is a **simple, modular e-commerce shopping cart system** built with **Laravel 11**, **Inertia.js**, and **React**.

It demonstrates how to design a clean backend using modern architectural principles — applying **SOLID**, **DRY**, and **KISS** patterns — while keeping code readable, testable, and easy to extend.


## 🚀 Features

- 🧱 **Clean Architecture (Repository + Service + Controller)**
- 🛍️ **Cart System** – browse, add, update, and remove products
- ⚡ **Low-Stock Notification** – background job triggered when stock runs low
- 📊 **Daily Sales Report** – scheduled cron job that emails a summary
- 🎨 **Frontend:** Inertia.js + React + Tailwind CSS
- 🧰 **Developer Tooling:** Laravel Pint + PHPStan (Larastan)
- 📨 **Notifications & Queues:** fully asynchronous job dispatching



## 🏗️ Project Structure

```
ecommerce-cart/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   ├── CartController.php
│   │   │   ├── OrderController.php
│   │   │   ├── ProductController.php
│   │   │   ├── ProfileController.php
│   │   │   └── Controller.php
│   │   ├── Middleware/
│   │   │   └── HandleInertiaRequests.php
│   │   └── Requests/
│   │       ├── Auth/
│   │       │   └── LoginRequest.php
│   │       └── ProfileUpdateRequest.php
│   │
│   ├── Jobs/
│   │   ├── DailySalesReportJob.php
│   │   └── LowStockNotificationJob.php
│   │
│   ├── Mail/
│   │   └── DailySalesReportMail.php
│   │
│   ├── Models/
│   │   ├── CartItem.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   ├── Product.php
│   │   └── User.php
│   │
│   ├── Notifications/
│   │   └── LowStockNotification.php
│   │
│   ├── Providers/
│   │   └── AppServiceProvider.php
│   │
│   ├── Repositories/
│   │   ├── Interfaces/
│   │   │   ├── CartRepositoryInterface.php
│   │   │   ├── OrderRepositoryInterface.php
│   │   │   └── ProductRepositoryInterface.php
│   │   └── Eloquent/
│   │       ├── CartRepository.php
│   │       ├── OrderRepository.php
│   │       └── ProductRepository.php
│   │
│   └── Services/
│       ├── CartService.php
│       ├── OrderService.php
│       └── ProductService.php
│
├── bootstrap/
│
├── config/
│
├── database/
│   ├── factories/
│   │   ├── ProductFactory.php
│   │   └── UserFactory.php
│   ├── migrations/
│   ├── seeders/
│   └── database.sqlite
│
├── public/
│
├── resources/
│   ├── css/
│   ├── js/
│   │   ├── Components/
│   │   │   ├── ApplicationLogo.jsx
│   │   │   ├── Button.jsx
│   │   │   ├── DangerButton.jsx
│   │   │   ├── Dropdown.jsx
│   │   │   ├── FlashMessage.jsx
│   │   │   ├── InputError.jsx
│   │   │   ├── InputLabel.jsx
│   │   │   ├── Modal.jsx
│   │   │   ├── NavLink.jsx
│   │   │   ├── PrimaryButton.jsx
│   │   │   ├── ResponsiveNavLink.jsx
│   │   │   ├── SecondaryButton.jsx
│   │   │   └── TextInput.jsx
│   │   │
│   │   ├── Layouts/
│   │   │   ├── AuthenticatedLayout.jsx
│   │   │   └── GuestLayout.jsx
│   │   │
│   │   ├── Pages/
│   │   │   ├── Auth/
│   │   │   ├── Cart/
│   │   │   ├── Products/
│   │   │   ├── Profile/
│   │   │   │   ├── Partials/
│   │   │   │   │   └── Edit.jsx
│   │   │   │   ├── Dashboard.jsx
│   │   │   │   └── Welcome.jsx
│   │   │
│   │   ├── app.jsx
│   │   └── bootstrap.js
│   │
│   └── views/
│       ├── emails/
│       └── app.blade.php
│
├── routes/
│   ├── web.php
│   ├── auth.php
│   └── console.php
│
├── storage/
│
├── tests/
│   ├── Feature/
│   │   ├── Auth/
│   │   │   ├── AuthenticationTest.php
│   │   │   ├── EmailVerificationTest.php
│   │   │   ├── PasswordResetTest.php
│   │   │   └── RegistrationTest.php
│   │   ├── CartControllerTest.php
│   │   ├── OrderControllerTest.php
│   │   ├── ProductControllerTest.php
│   │   └── ProfileTest.php
│   │
│   └── Unit/
│       ├── CartServiceTest.php
│       ├── OrderServiceTest.php
│       ├── ProductServiceTest.php
│       ├── RepositoriesTest.php
│       ├── JobsTest.php
│       └── MailAndNotificationTest.php
│
├── phpstan.neon
├── pint.json
├── composer.json
├── Design_Doc.md
├── package.json
└── README.md

```


## ⚙️ Setup Instructions

### 1️⃣ Install dependencies

```bash
composer install
npm install

```

### 2️⃣ Environment setup

Copy .env.example and configure your environment:

```bash
cp .env.example .env
php artisan key:generate

```

### 3️⃣ Run migrations & seed demo data

```bash
php artisan migrate --seed 

# or

php artisan migrate:fresh --seed

```

### 4️⃣ Run local dev servers

```bash

npm run dev
php artisan serve

```

### 5️⃣ Background workers (optional)

```bash

php artisan queue:work
php artisan schedule:work

```



## 🧩 Developer Workflow

🧰 Tooling Commands

| Command            | Description                                    |
| ------------------ | ---------------------------------------------- |
| `composer format`  | Format PHP code with **Laravel Pint**          |
| `composer lint`    | Run static analysis via **PHPStan (Larastan)** |
| `php artisan test` | Run backend test suite (**PHPUnit**)           |
| `npm run build`    | Production frontend build                      |



## 🧪 Testing

Backend Tests

Laravel 11 includes built-in PHPUnit:

```bash

php artisan test

```

You can create additional test files under:

```swift

tests/Feature/
tests/Unit/

```


## ⚡ Static Analysis

Ensures type safety and code consistency:

```bash

composer lint

```


## 🎨 Code Style

Uses Laravel Pint for consistent PSR-12 formatting.

```bash

composer format

```

Example composer.json snippet:

```json

"scripts": {
  "format": "vendor/bin/pint",
  "lint": "vendor/bin/phpstan analyse"
}

```


## 🧠 Design Principles Summary

| Principle           | Implementation                                  | Result                             |
| ------------------- | ----------------------------------------------- | ---------------------------------- |
| **SOLID**           | Repository + Service + Controller layers        | Extensible, testable code          |
| **DRY**             | Reuse of logic and UI components                | Reduced duplication                |
| **KISS**            | Built-in Laravel features, minimal dependencies | Simplicity and clarity             |
| **WET (selective)** | Explicit interfaces for clarity                 | Slight duplication for readability |


📖 Full details in [Design_Doc.md](Design_Doc.md)


## 🧰 Development Tools

| Tool                   | Role                   |
| ---------------------- | ---------------------- |
| **Laravel Pint**       | Auto-formatting        |
| **PHPStan + Larastan** | Static analysis        |
| **PHPUnit**            | Backend testing        |
| **Inertia.js + React** | Full-stack integration |
| **Tailwind CSS**       | Styling                |
| **React Hot Toast**    | Instant UI feedback    |



## 🕒 Jobs & Scheduling

| Job                       | Trigger                        | Description                 |
| ------------------------- | ------------------------------ | --------------------------- |
| `LowStockNotificationJob` | When product stock < threshold | Sends admin notification    |
| `DailySalesReportJob`     | Scheduled daily                | Generates and emails report |

- Run scheduled job manually

```bash

php artisan schedule:run

```


## 🧠 Design Philosophy

- Backend first: focus on maintainable domain logic.
- Frontend simple but responsive: Inertia.js bridges Laravel & React seamlessly.
- Clean code, minimal dependencies: everything implemented with core Laravel.
- Quality enforced via tools: Pint & PHPStan guard consistency and safety.


## 🧾 License
Stack: Laravel 11 · PHP 8.2 · React 18 · Tailwind CSS
