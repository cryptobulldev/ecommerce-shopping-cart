# 🧩 Design Decisions – Laravel + Inertia.js + React E-Commerce Cart

This document explains the **design reasoning**, **principles**, and **trade-offs** behind the e-commerce shopping cart demo built with **Laravel 11**, **Inertia.js**, and **React**.


## 1️⃣ System Overview

The application allows users to browse products, manage a shopping cart, and simulate an order checkout.  
It also demonstrates:
- **Low-stock notifications** using Laravel Jobs/Queues  
- **Daily sales report** using Laravel Scheduler  
- A modular backend applying **SOLID**, **DRY**, and **KISS** principles  


## 2️⃣ Architecture Overview

The system follows a **layered architecture** for clarity and maintainability:

```

[HTTP Layer]
│
├── Controllers – handle requests/responses only
│
├── Services – contain business rules
│
├── Repositories – handle persistence (Eloquent / DB)
│
├── Jobs & Notifications – asynchronous background logic
│
└── Frontend (Inertia.js + React) – single-page UI layer

```

### Key Folders

| Layer         | Folder                 | Responsibility                        |
|---------------|------------------------|---------------------------------------|
| Controllers   | `app/Http/Controllers` | Handle routes and request validation  |
| Services      | `app/Services`         | Business logic (cart, product, order) |
| Repositories  | `app/Repositories`     | Data access through interfaces        |
| Jobs          | `app/Jobs`             | Queueable background work             |
| Notifications | `app/Notifications`    | Mail/alert abstraction                |
| Frontend      | `resources/js`         | React + Inertia UI components         |


## 3️⃣ Design Principles

### 🧠 **SOLID Principles**

| Principle                     | Implementation                                                      | Benefit                                  |
|-------------------------------|---------------------------------------------------------------------|------------------------------------------|
| **S – Single Responsibility** | Single role: CartService logic, CartRepository data.                | Easier testing and maintenance.          |
| **O – Open/Closed**           | New features can extend existing services without modifying them.   | Reduces regression risk.                 |
| **L – Liskov Substitution**   | Repositories follow interfaces for easy swapping (API, mock, etc.). | Increases flexibility for testing.       |
| **I – Interface Segregation** | Small domain interfaces (Cart, Product, Order) over one large one.  | Improves modularity and readability.     |
| **D – Dependency Inversion**  | Controllers use Service interfaces, not Eloquent.                   | Decouples presentation from persistence. |


### 🔁 **DRY – Don’t Repeat Yourself**

- Shared logic extracted into **Services** and **Repositories**.  
- Common React UI parts (Navbar, FlashMessage) centralized under `resources/js/Layouts` and `Components`.  
- Notifications, emails, and job dispatching reused in multiple flows.

**Outcome:** Less duplicate code → consistent logic and behavior.


### ⚙️ **KISS – Keep It Simple, Stupid**

- Avoided over-engineering: no unnecessary frameworks or complex domain events.  
- Used built-in Laravel features (Jobs, Scheduler, Notifications) to illustrate concepts.  
- Database schema and flows intentionally minimal for focus on architecture.

**Outcome:** Clear and understandable for reviewers; quick onboarding for new devs.


### 🔂 **WET – Write Everything Twice (When It Adds Clarity)**

A small amount of duplication improves explicitness:
- Each Repository explicitly declares its own Interface even if similar → clear contracts per domain.
- Certain logic (like `ProductRepository@all`) repeated for explicit intent rather than shared “god” repository.

**Outcome:** Minor duplication trades off for clarity and maintainability.


## 4️⃣ Key Design Decisions

| Area                     | Decision                                             | Reason / Trade-off                                           |
|--------------------------|------------------------------------------------------|--------------------------------------------------------------|
| **Architecture**         | Repository + Service + Controller                    | Clean separation of layers, testability, flexibility         |
| **Jobs/Queues**          | Use Laravel’s queue system for low-stock alerts      | Async processing, scalable design                            |
| **Scheduling**           | `php artisan schedule:work` triggers daily sales job | Demonstrates background tasks                                |
| **Frontend Integration** | Inertia.js with React                                | Keeps Laravel routing while enjoying React reactivity        |
| **Styling**              | Tailwind CSS                                         | Fast prototyping with utility classes                        |
| **Tooling**              | Pint + PHPStan                                       | Enforces formatting and static analysis; ensures consistency |
| **Notifications**        | Log mail driver in demo                              | Simulates notifications safely in dev                        |
| **Database**             | Schema: products, cart_items, orders, order_items.   | Demonstrates relationships without extra complexity          |


## 5️⃣ Trade-offs and Alternatives

| Trade-off                                   | Alternative                                | Rationale                                               |
|---------------------------------------------|--------------------------------------------|---------------------------------------------------------|
| Added boilerplate via Services/Repositories | Controllers directly call Eloquent         | Separation of concerns outweighs verbosity              |
| Used Inertia + React stack                  | Traditional Blade or full SPA API          | Keeps Laravel routing simplicity + React interactivity  |
| Jobs/Queues used for low stock              | Direct event listeners                     | Queueing simulates production async systems             |
| Simple cron job                             | External scheduler (e.g., AWS EventBridge) | Cron illustrates scheduling easily in local/demo setups |


## 6️⃣ Tooling & Quality Assurance

| Tool                             | Role                                  |
|----------------------------------|---------------------------------------|
| **Laravel Pint**                 | Code formatting and PSR-12 compliance |
| **PHPStan (Larastan)**           | Static analysis, type safety          |
| **ESLint + Prettier (optional)** | JS/React code consistency             |
| **GitHub Actions (optional)**    | CI/CD code-quality automation         |


## 7️⃣ Future Improvements

- Implement authentication-aware cart (per user instead of session).  
- Add unit tests for services and repositories.  
- Replace mock emails with real notifications via Mailgun/AWS SES.  
- Introduce `DiscountService` or `CouponRepository` for promo logic.  
- Extend reporting with PDF or CSV exports.


## 8️⃣ Summary

This project is intentionally simple but architecturally robust.  
By applying **SOLID**, **DRY**, and **KISS** principles while allowing small doses of **WET** for clarity, it demonstrates:

✅ Clean separation of concerns  
✅ Maintainability and testability  
✅ Realistic job scheduling and queue handling  
✅ Clear frontend integration with Inertia.js  

The focus is on **design reasoning over completeness**, making it a solid foundation for real-world, scalable Laravel applications.


