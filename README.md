# DinePay

DinePay is a modern restaurant ordering and payment system built with Laravel 12.  
This project is designed to simplify restaurant operations through QR-based ordering, digital payments, and role-based management dashboards.

The application allows customers to browse menus, add items to cart, place orders, and complete payments seamlessly.  
On the management side, admins, cashiers, and chefs each have their own workflow and dashboard access.

This project is currently under active development as part of a fullstack portfolio focused on real-world restaurant digitalization.

---

## Features

### Customer Features
- Browse restaurant menu
- View menu categories
- Add items to cart
- Update cart quantity dynamically
- Remove items from cart
- Checkout page with order summary
- Session-based cart management
- Responsive customer interface
- USD currency formatting for international readiness

### Payment Features
- Cash payment workflow
- QRIS payment integration (Midtrans)
- Payment status handling
- Order confirmation flow

### Admin Features
- Dashboard management
- Menu management
- Category management
- Order management
- Employee management
- Role & permission management

### Cashier Features
- Confirm cash payments
- Monitor incoming orders

### Chef Features
- Update cooking status
- Manage kitchen order flow

---

## Tech Stack

### Backend
- Laravel 12
- PHP 8.2
- MySQL

### Frontend
- Blade Template Engine
- Bootstrap 5
- TailwindCSS
- Vite
- JavaScript

### Additional Tools
- Midtrans Payment Gateway
- Laravel Breeze
- Session-based Cart System

---

## Project Status

The project is currently in active development.

Current progress includes:
- Customer menu flow
- Cart system
- Dynamic quantity update
- Checkout page
- Session handling improvements
- Responsive UI adjustments

Upcoming features:
- Midtrans QRIS integration
- Admin dashboard
- Authentication & authorization
- Role-based access control
- Analytics dashboard
- Deployment optimization

---

## Installation

Clone the repository:

```bash
git clone https://github.com/muhamadmuhibudin/dinepay.git
```

Move into the project directory:

```bash
cd dinepay
```

Install dependencies:

```bash
composer install
npm install
```

Copy environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Configure your database inside `.env`

```env
DB_DATABASE=dinepayapp
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations and seeders:

```bash
php artisan migrate --seed
```

Start the development server:

```bash
composer run dev
```

---

## Folder Structure

```bash
app/
├── Http/
├── Models/
├── Providers/

database/
├── factories/
├── migrations/
├── seeders/

resources/
├── assets/
├── views/

routes/
├── web.php
```

---

## Architecture Goals

This project is being developed with a production-oriented mindset.

Main focus areas:
- Clean and maintainable code
- Scalable project structure
- Separation of concerns
- Reusable UI components
- Real-world payment workflow
- Role-based authorization
- Developer-friendly architecture

---

## Screenshots

Screenshots will be added as the project progresses.

Planned previews:
- Customer menu page
- Cart page
- Checkout page
- Admin dashboard
- Cashier dashboard
- Chef dashboard

---

## Learning Goals

This project is part of my journey to improve as a fullstack Laravel developer by building a real-world restaurant management system.

Main learning focus:
- Laravel application architecture
- Payment gateway integration
- Role & permission management
- Fullstack workflow
- Backend & frontend integration
- Deployment preparation
- Production-ready development practices

---

## Roadmap

- [x] Menu listing
- [x] Cart management
- [x] Checkout page
- [ ] Midtrans QRIS integration
- [ ] Authentication system
- [ ] Role-based dashboards
- [ ] Order tracking
- [ ] Reporting dashboard
- [ ] API integration
- [ ] Deployment
- [ ] Automated testing

---

## Contributing

This project is currently maintained as a personal portfolio and learning project.

Suggestions, feedback, and discussions are always welcome.

---

## License

This project is open-sourced under the MIT License.