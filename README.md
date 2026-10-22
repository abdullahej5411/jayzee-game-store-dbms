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
.
|-- .gitignore
|-- README.md
|-- assets/
|   |-- css/
|   |   `-- styles.css          # Main styling & animations
|   |-- js/
|   |   `-- scripts.js          # Client-side scripts & category filters
|   |-- videos/
|   |   `-- home.mp4            # Background video
|   `-- images/
|       |-- games/              # Game cover artwork (4.jpg to 53.jpg)
|       `-- ui/                 # UI assets (adobe.png, neon.jpg, icon.png, etc.)
|-- database/
|   `-- tables/                 # MySQL database SQL dump files
|       |-- cart.sql
|       |-- categories.sql
|       |-- games.sql
|       |-- inventory.sql
|       |-- orderdetails.sql
|       |-- orders.sql
|       |-- payments.sql
|       |-- publishers.sql
|       |-- reviews.sql
|       `-- users.sql
|-- includes/
|   `-- db_connect.php          # MySQL database connection configuration
|-- tools/
|   `-- hash_password.php       # Utility password hashing helper
|-- index.php                   # Application entry point
|-- home.php                    # Main store page & catalog
|-- product.php                 # Individual game showcase & reviews
|-- cart.php                    # Shopping cart
|-- order_summary.php           # Order checkout
|-- order_confirmation.php      # Order summary receipt
|-- orders.php                  # Customer order history
|-- order_details.php           # Order items breakdown
|-- admin_inventory.php         # Admin inventory & orders management
|-- login.php                   # User login
|-- register.php                # User registration
|-- logout.php                  # Session termination
|-- search.php                  # AJAX search API
|-- add_review.php              # Review submission action
|-- update_cart.php             # Cart quantity update action
|-- remove_cart.php             # Cart removal action
`-- update_order_status.php     # Admin order status update action
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
   - Move or clone the project folder into your web server root (e.g., `C:/xampp/htdocs/game-store`).

3. **Set Up the Database**:
   - Open **phpMyAdmin** (`http://localhost/phpmyadmin`).
   - Create a new database named `gamestoredb`.
   - Import all table `.sql` files located inside `database/tables/`.
     *(Recommended import order: `users.sql`, `categories.sql`, `publishers.sql`, `games.sql`, `inventory.sql`, `cart.sql`, `orders.sql`, `orderdetails.sql`, `payments.sql`, `reviews.sql`)*.

4. **Configure Database Connection**:
   - Check `includes/db_connect.php`:
     ```php
     $conn = new mysqli("localhost", "root", "", "gamestoredb");
     ```
   - Adjust MySQL username or password if your local setup differs.

5. **Run the Application**:
   - Open your browser and navigate to:
     ```text
     http://localhost/<your-project-folder-name>/
     ```

---

## License

This project is open-source and available under the [MIT License](LICENSE).
