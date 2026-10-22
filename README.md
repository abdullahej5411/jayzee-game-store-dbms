# JayZee Game Store Database Management System

A dynamic, full-featured web-based Game Store and Inventory Management System built using PHP, MySQL, Bootstrap 5, and JavaScript.

---

## Features

- **Storefront Catalog**: Interactive game catalog with filtering by categories, price ranges, and real-time live search.
- **Product Details & Media**: Detailed game information, embedded YouTube trailers, and customer reviews/ratings.
- **Shopping Cart**: Real-time cart management with quantity adjustments, stock availability checking, and removal options.
- **Checkout & Orders**: Multi-step checkout with simulated payment options, order confirmation receipts, and customer order history.
- **Admin Inventory Dashboard**: Secure administrative dashboard to manage inventory stock, restock products, and update order fulfillment statuses.
- **User Authentication**: Secure user registration and login system with password hashing (`PASSWORD_DEFAULT`).

---

## Directory Structure

```text
Game Store Database/
|-- .gitignore
|-- README.md
|-- Game Store Database Management System/
|   |-- assets/
|   |   |-- css/
|   |   |   `-- styles.css
|   |   |-- js/
|   |   |   `-- scripts.js
|   |   |-- videos/
|   |   |   `-- home.mp4
|   |   `-- images/
|   |       |-- games/          # Game cover artwork (4.jpg to 53.jpg)
|   |       `-- ui/             # UI elements and backgrounds
|   |-- includes/
|   |   `-- db_connect.php      # MySQL database connection configuration
|   |-- tools/
|   |   `-- hash_password.php   # Utility password hashing helper
|   |-- index.php               # Application entry point
|   |-- home.php                # Main store page & catalog
|   |-- product.php             # Individual game showcase & reviews
|   |-- cart.php                # Shopping cart
|   |-- order_summary.php       # Order checkout
|   |-- order_confirmation.php  # Order summary receipt
|   |-- orders.php              # Customer order history
|   |-- order_details.php       # Order items breakdown
|   |-- admin_inventory.php     # Admin inventory & orders management
|   |-- login.php               # User login
|   |-- register.php            # User registration
|   |-- logout.php              # Session termination
|   |-- search.php              # AJAX search API
|   |-- add_review.php          # Review submission action
|   |-- update_cart.php         # Cart quantity update action
|   |-- remove_cart.php         # Cart removal action
|   `-- update_order_status.php # Admin order status update action
|
`-- Game Store Database Management System_gamestoredb Files/
    `-- tables/                 # MySQL database SQL dump files
        |-- cart.sql
        |-- categories.sql
        |-- games.sql
        |-- inventory.sql
        |-- orderdetails.sql
        |-- orders.sql
        |-- payments.sql
        |-- publishers.sql
        |-- reviews.sql
        `-- users.sql
```

---

## Prerequisites

- [XAMPP](https://www.apachefriends.org/) (or WampServer / LAMP stack with PHP 7.4+ and MySQL / MariaDB)
- Web browser (Chrome, Firefox, Edge, etc.)
- Git

---

## Installation & Setup

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/<your-username>/<your-repo-name>.git
   ```

2. **Move to Web Server Directory**:
   - Move or copy the project folder to your local server root (e.g., `C:/xampp/htdocs/` for XAMPP).

3. **Set Up the Database**:
   - Open **phpMyAdmin** (`http://localhost/phpmyadmin`).
   - Create a new database named `gamestoredb`.
   - Import all table `.sql` files located inside `Game Store Database Management System_gamestoredb Files/tables/`.
     *(Import in order: `users.sql`, `categories.sql`, `publishers.sql`, `games.sql`, `inventory.sql`, `cart.sql`, `orders.sql`, `orderdetails.sql`, `payments.sql`, `reviews.sql`)*.

4. **Configure Database Connection**:
   - Check `Game Store Database Management System/includes/db_connect.php`:
     ```php
     $conn = new mysqli("localhost", "root", "", "gamestoredb");
     ```
   - Adjust MySQL username or password if your local setup differs.

5. **Run the Application**:
   - Open your browser and navigate to:
     ```text
     http://localhost/Game%20Store%20Database/Game%20Store%20Database%20Management%20System/
     ```

---

## License

This project is open-source and available under the [MIT License](LICENSE).
