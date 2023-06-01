# Laravel Livewire Order Management System

It was created a project to manage orders/products/categories with Laravel and add a lot of dynamic features with Laravel Livewire.

Here are a few screenshots from the application:

![Dashboard](./img/dashboard.png)
Dashboard with Chart.js integration
![Categories CRUD page](./img/categories.png)
Categories CRUD
![Products CRUD page](./img/products.png)
Products CRUD
![Orders CRUD page](./img/products.png)
Orders CRUD with the ability of export a table to .csv, .xlsx or .pdf

---
## Run The Project Locally

If you want to run it locally you should do the following steps:

### Prerequisites

PHP (at least 8.0) and Composer should be installed to proceed.

### Installation

    git clone git@github.com:deepydee/order-management-system.git
    cd oms
    cp .env.example .env
    composer install
    npm install
    php artisan key:generate
    touch database/database.sqlite
    php artisan migrate:fresh --seed
    php artisan serve

Your project will be available by http://localhost:8000

Login: 'admin@admin.com', password: 'password'
