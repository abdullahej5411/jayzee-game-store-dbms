<?php
session_start();
include 'includes/db_connect.php';

if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
$query = "SELECT o.OrderID, o.OrderDate, o.TotalAmount, o.Status, p.PaymentMethod 
          FROM orders o 
          LEFT JOIN payments p ON o.OrderID = p.OrderID 
          WHERE o.OrderID = ? AND o.UserID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $order_id, $_SESSION['UserID']);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    die("Order not found.");
}

$details_query = "SELECT g.Title, od.Quantity, od.Price 
                  FROM orderdetails od 
                  JOIN games g ON od.GameID = g.GameID 
                  WHERE od.OrderID = ?";
$details_stmt = $conn->prepare($details_query);
$details_stmt->bind_param("i", $order_id);
$details_stmt->execute();
$order_details = $details_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JayZee E-Store - Order Confirmation</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: #e0e0e0;
            overflow-x: hidden;
            line-height: 1.6;
        }

        .navbar {
            background: rgb(0, 6, 48);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 2rem;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }

        .navbar.scrolled {
            background: rgba(26, 26, 46, 1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .navbar-brand, .nav-link {
            color: #00d4ff;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .navbar-brand:hover, .nav-link:hover {
            color: #ff007a;
            text-shadow: 0 0 10px #ff007a, 0 0 20px #ff007a;
        }

        .nav-link {
            margin-left: 1.5rem;
            font-size: 1.1rem;
        }

        .btn {
            background: linear-gradient(45deg, #00d4ff, #ff007a);
            color: #fff;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 212, 255, 0.4);
            background: linear-gradient(45deg, #ff007a, #00d4ff);
        }

        main {
            padding: 6rem 0 4rem;
            min-height: calc(100vh - 80px);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        h1 {
            font-size: 2.5rem;
            color: #00d4ff;
            text-align: center;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            animation: fadeInDown 1s ease;
        }

        .card {
            background: rgba(32, 32, 52, 0.9);
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.4s ease;
            transform-style: preserve-3d;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .card:hover {
            transform: rotateY(10deg) scale(1.05);
            box-shadow: 0 15px 30px rgba(0, 212, 255, 0.2);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            color: #fff;
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }

        .card-text {
            color: #b0b0b0;
            font-size: 0.95rem;
            
        }

        .table {
            background: rgba(32, 32, 52, 0.7);
            color: #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
        }

        .table th, .table td {
            padding: 1rem;
            vertical-align: middle;
        }

        .alert {
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: rgba(0, 255, 0, 0.1);
            border-left: 5px solid #00ff00;
        }

        footer {
            background: linear-gradient(135deg,rgba(74, 0, 0, 0.93) 0%, #16213e 100%);
            color: #b0b0b0;
            text-align: center;
            padding: 2rem 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            animation: fadeInUp 1s ease;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .navbar-nav {
                background: rgba(26, 26, 46, 0.95);
                margin-top: 0.5rem;
                padding: 0.5rem;
                border-radius: 10px;
            }

            .nav-link {
                margin: 0.5rem 0;
            }

            h1 {
                font-size: 2rem;
            }

            .card {
                margin: 0 1rem 2rem;
            }
        }

        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #1a1a2e;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, #00d4ff, #ff007a);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #ff007a, #00d4ff);
        }

        .thank-you {
            color: #00ff00;
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1rem;
            text-transform: uppercase;
        }

        .lead {
            color: #b0b0b0;
            font-size: 1.1rem;
            text-align: center;
            margin-bottom: 3rem;
        }

        #bgVideo {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        object-fit: cover;
        z-index: -1;
        opacity: 0.4; /* optional: for a dark overlay look */
        filter: brightness(60%); /* optional: darken video for contrast */
        }

        .content {
        position: relative;
        z-index: 1;
        color: white; /* so it stands out against the video */
        }



    </style>
</head>
<body>

<video autoplay muted loop id="bgVideo">
  <source src="assets/videos/home.mp4" type="video/mp4">
  Your browser does not support the video tag.
</video>


<nav class="navbar navbar-expand-lg navbar-light" style="background-image: url('assets/images/ui/neon.jpg'); background-size: cover; background-position: center;">
    <div class="container-fluid">
                    <a class="navbar-brand d-flex align-items-center" href="home.php">
                <img src="assets/images/ui/adobe.png" alt="Store Icon" 
                    style="width: 90px; height: 40px; object-fit: contain; margin-right: -15px; margin-left: -20px;">
                <span style="color: #00d4ff; font-weight: 700; text-shadow: 0 0 10px #00d4ff; margin-right:0.4rem">JayZee</span>
                <span style="color: #ff007a; font-weight: 700; text-shadow: 0 0 10px #ff007a;">E-Store</span>
            </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon" style="filter: drop-shadow(0 0 5px #00d4ff);"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
                <li class="nav-item"><a class="nav-link" href="orders.php">Orders</a></li>
                <?php if ($_SESSION['Role'] === 'Admin') { ?>
                    <li class="nav-item"><a class="nav-link" href="admin_inventory.php">Manage Inventory</a></li>
                <?php } ?>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['Username']); ?>)</a></li>
            </ul>
        </div>
    </div>
</nav>
<style>
    .navbar {
        background: linear-gradient(135deg,rgba(74, 0, 0, 0.93) 0%, #16213e 100%);
        padding: 1rem 2rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
    }

    .navbar-brand {
        font-size: 1.5rem;
        transition: transform 0.3s ease;
    }

    .navbar-brand:hover {
        transform: scale(1.1);
    }

    .nav-link {
        color: #00d4ff;
        font-weight: 600;
        padding: 0.5rem 1.5rem;
        margin: 0 0.5rem;
        border-radius: 20px;
        transition: all 0.3s ease;
        position: relative;
    }

    .nav-link:hover {
        color: #ff007a;
        background: transparent;
        text-shadow: 0 0 10px #ff007a;
        transform: translateY(-2px);
    }

    .navbar-toggler {
        border: none;
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(0, 212, 255, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    @media (max-width: 768px) {
        .navbar-nav {
            background: rgba(26, 26, 46, 0.95);
            padding: 1rem;
            border-radius: 10px;
            margin-top: 0.5rem;
        }

        .nav-link {
            margin: 0.5rem 0;
            padding: 0.5rem 1rem;
        }
    }
</style>

    <main>
        <div class="container">
            <h1 style="color: #00d4ff; text-shadow: 0 0 10px #00d4ff;" >Order Confirmation</h1>
            <div class="thank-you">Thank You for Your Purchase!</div>
            <p class="lead">Your order has been successfully placed. Below are the details of your purchase.</p>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" style="color: #ff007a; text-shadow: 0 0 10px #16213e;">Order Summary</h5>
                    <p class="card-text"><strong>Order ID:</strong> #<?php echo $order['OrderID']; ?></p>
                    <p class="card-text"><strong>Order Date:</strong> <?php echo date('F d, Y H:i:s', strtotime($order['OrderDate'])); ?></p>
                    <p class="card-text"><strong>Total Amount:</strong> $<?php echo number_format($order['TotalAmount'], 2); ?></p>
                    <p class="card-text"><strong>Payment Method:</strong> <?php echo htmlspecialchars($order['PaymentMethod'] ?? 'N/A'); ?></p>
                    <p class="card-text"><strong>Status:</strong> <?php echo htmlspecialchars($order['Status']); ?></p>

                    <div class="order-details-table">
                        <h6 class="card-title" style="color: #ff007a; text-shadow: 0 0 10px #16213e;">Order Items</h6>
                        <table class="table table-striped table-dark" style="opacity: 80%;">
                            <thead>
                                <tr>
                                    <th style="color: #00d4ff; text-shadow: 0 0 10px #16213e;">Game</th>
                                    <th style="color: #00d4ff; text-shadow: 0 0 10px #16213e;">Quantity</th>
                                    <th style="color: #00d4ff; text-shadow: 0 0 10px #16213e;">Price</th>
                                    <th style="color: #00d4ff; text-shadow: 0 0 10px #16213e;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($item = $order_details->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['Title']); ?></td>
                                        <td><?php echo $item['Quantity']; ?></td>
                                        <td>$<?php echo number_format($item['Price'], 2); ?></td>
                                        <td>$<?php echo number_format($item['Price'] * $item['Quantity'], 2); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <p class="card-text">A confirmation email has been sent to your registered email address. You can track your order status in the <a href="orders.php" style="color: #00d4ff;">Orders</a> section.</p>

                    <div class="mt-4">
                        <a href="home.php" class="btn">Continue Shopping</a>
                        <a href="orders.php" class="btn">View Your Orders</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

<!-- HTML -->
<footer class="footer text-white py-4" style="background-image: url('assets/images/ui/neon.jpg'); background-size: cover; background-position: center;">
    <div class="footer-content fooooooter">
        <p>&copy; 2025 JayZee E-Store. All Rights Reserved.</p>
        <p class="footer-links">
            <a href="#">Privacy Policy</a>
            <span>|</span>
            <a href="#">Terms of Service</a>
            <span>|</span>
            <a href="#">FAQ</a>
        </p>
        <p class="footer-social">
            Follow Us:
            <a href="https://www.facebook.com/abdullahej20" target="_blank">Facebook</a>
            <a href="https://x.com/a1phazux" target="_blank">Twitter</a>
            <a href="https://www.instagram.com/abdullah._.ej/" target="_blank">Instagram</a>
        </p>
    </div>
</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('scroll', () => {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
<?php $stmt->close(); $details_stmt->close(); $conn->close(); ?>