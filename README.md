# 🛒 Laravel Multi-Auth E-Commerce Platform

This project is a simple e-commerce platform built with **Laravel**, featuring a multi-authentication system for both **admin** and **user** roles. The project includes product management, shopping cart functionality, password reset via email, and more.

## 🔐 Authentication System

- Separate login/register pages for `admin` and `user` using **multi-auth guards**.
- Middleware for protecting routes based on user roles.
- Custom logout and session handling.

## 🛍️ E-Commerce Features

- Product listing, categories, and detailed product views.
- Shopping cart with:
  - Add/Remove/Update quantity.
  - Persistent cart for authenticated users.

## 🔁 Forgot & Reset Password

- Users can reset their password via email.
- Admins and users have separate reset flows.
- Email verification and reset handled via **Laravel's Password Broker**.
- Uses custom email templates.

## 📧 Email Setup

- Works with **Mailpit** or any SMTP server.
- Reset password and password change notifications are sent to registered email addresses.

## 🔌 API Support

This project also includes RESTful API endpoints built with Laravel and authenticated using **Sanctum**. APIs are available for:

- User authentication (login/register)
- Password reset
- Product listing & filtering
- Shopping cart (add, update, delete items)
- User profile management

The API is useful for mobile apps or frontend frameworks like React or Vue.

### 🧪 Example API Endpoint

```http
POST /api/auth/admin/login
Content-Type: application/json

{
  "email": "test@admin.com",
  "password": 100200300
}
```

## 🧪 Tech Stack

- Laravel 10+
- Sanctum for API authentication
- Bootstrap for frontend styling
- Multi-auth using guards (`admin`, `user`)
- MySQL

## 🧪 Tech Stack

- Laravel 10+  
- Sanctum for API authentication  
- Bootstrap for frontend styling  
- Multi-auth using guards (`admin`, `user`)  
- MySQL  

## ⚙️ Prerequisites

- PHP 8.1 or higher  
- Composer (Laravel package manager)  
- MySQL 5.7 or higher  
- JavaScript libraries like Axios and Toastr are used for frontend interactivity (no Node.js required)

## ✨ Features

- Multi-authentication system for admins and users  
- Product management (create, edit, delete) with image handling  
- Shopping cart with session and database persistence  
- Password reset with email verification  
- Fully integrated API with Sanctum authentication  
- Responsive UI styled with Bootstrap  

## 🚀 How to Run

1. Clone the repo:
   ```bash
   git clone https://github.com/m-alghazali1/your-project-name.git
   cd your-project-name 
   ```
   
2. Install dependencies:
    ```bash
    composer install 
    ```

3. Create .env file:
    ```bash
    cp .env.example .env 
    ```

4. Configure your .env file (Database and Mail settings):

5. Generate app key:    
    ```bash
    php artisan key:generate 
    ```

6. Run database migrations and seeders (if any):
    ```bash
    php artisan migrate
    php artisan db:seed 
    ```

7. Start the local development server:
    ```bash
    php artisan serve 
    ```

## 🌐 Application URLs

| Role          | URL                                      | Description                        |
|---------------|------------------------------------------|----------------------------------|
| Public        | http://127.0.0.1:8000/products           | Product listing page (public)      |
| Product Detail| http://127.0.0.1:8000/products/{id}      | Product details page               |
| Category Prod | http://127.0.0.1:8000/products/category/{id} | Products by category page       |
| Admin Login   | http://127.0.0.1:8000/app/admin/login    | Admin login page                  |
| User Login    | http://127.0.0.1:8000/app/user/login     | User login page                   |
| Admin Panel   | http://127.0.0.1:8000/admin/data          | Admin dashboard (after login)     |
| Admin Categories | http://127.0.0.1:8000/admin/categories | Admin categories management       |
| Admin Products| http://127.0.0.1:8000/admin/products      | Admin products management         |
| Cart          | http://127.0.0.1:8000/cart                | User cart page (requires login)   |


## 👤 Demo Accounts

### Admin
- Email: test@admin.com
- Password: 100200300

### User
- Email: test@user.com
- Password: 100200300

## 📡 API Endpoints

| Method | Endpoint                     | Description            | Auth |
|--------|------------------------------|------------------------|------|
| POST   | /api/app/user/login          | User login             | ❌   |
| POST   | /api/app/user/register       | User registration      | ❌   |
| POST   | /api/app/admin/login         | Admin login            | ❌   |
| POST   | /api/app/admin/register      | Admin registration     | ❌   |
| POST   | /api/logout                  | Logout (user/admin)    | ✅   |
| GET    | /api/products                | List all products      | ❌   |
| GET    | /api/products/{id}           | Product details        | ❌   |
| GET    | /api/products/category/{id}  | Products by category   | ❌   |
| GET    | /api/cart                   | View cart items         | ✅   |
| POST   | /api/cart/add               | Add item to cart        | ✅   |
| PUT    | /api/cart/update/{id}       | Update item quantity    | ✅   |
| DELETE | /api/cart/remove/{id}       | Remove item from cart   | ✅   |

✅ = Requires login via Bearer Token  
❌ = Public access

## 👤 Demo Accounts

### Admin
- Email: test@admin.com
- Password: 100200300

### User
- Email: test@user.com
- Password: 100200300
