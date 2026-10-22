<?php
session_start();
include 'includes/db_connect.php';

if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

$cart_count = 0;
$user_id = $_SESSION['UserID'];
$count_query = "SELECT SUM(Quantity) as total_items FROM cart WHERE UserID = ? AND Status = 'active'";
$stmt = $conn->prepare($count_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$cart_count = $result['total_items'] ?? 0;
$stmt->close();


$user_id = $_SESSION['UserID'];
$grand_total = 0;
$cart_items = [];

$query = "SELECT c.CartID, c.GameID, g.Title, c.PriceAtAdd AS Price, c.Quantity, i.Quantity AS Stock 
          FROM cart c 
          JOIN games g ON c.GameID = g.GameID 
          LEFT JOIN inventory i ON g.GameID = i.GameID 
          WHERE c.UserID = ? AND c.Status = 'active'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$stock_available = true;
while ($item = $result->fetch_assoc()) {
    if ($item['Quantity'] > ($item['Stock'] ?? 0)) {
        $stock_available = false;
        break;
    }
    $cart_items[] = $item;
    $grand_total += $item['Price'] * $item['Quantity'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_order'])) {
    if (empty($cart_items)) {
        $error_message = "Cart is empty. Cannot place order.";
    } elseif (!$stock_available) {
        $error_message = "Some items are out of stock. Please update your cart.";
    } else {
        $conn->begin_transaction();
        try {
            $query = "INSERT INTO orders (UserID, TotalAmount, OrderDate, Status) VALUES (?, ?, NOW(), 'Pending')";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("id", $user_id, $grand_total);
            $stmt->execute();
            $order_id = $conn->insert_id;
            $stmt->close();

            $order_items = [];
            $game_ids = [];
            foreach ($cart_items as $item) {
                $subtotal = $item['Price'] * $item['Quantity'];
                $order_items[] = "($order_id, {$item['GameID']}, {$item['Quantity']}, $subtotal)";
                $query = "UPDATE inventory SET Quantity = Quantity - ? WHERE GameID = ?";
                $inventory_stmt = $conn->prepare($query);
                $inventory_stmt->bind_param("ii", $item['Quantity'], $item['GameID']);
                $inventory_stmt->execute();
                $inventory_stmt->close();
                $game_ids[] = $item['GameID'];
            }

            if (!empty($order_items)) {
                $order_details_query = "INSERT INTO orderdetails (OrderID, GameID, Quantity, Price) VALUES " . implode(',', $order_items);
                $conn->query($order_details_query);
            }

            if (!empty($game_ids)) {
                $placeholders = implode(',', array_fill(0, count($game_ids), '?'));
                $delete_query = "DELETE FROM cart WHERE UserID = ? AND GameID IN ($placeholders) AND Status = 'active'";
                $delete_stmt = $conn->prepare($delete_query);
                $types = str_repeat('i', count($game_ids) + 1);
                $params = array_merge([$user_id], $game_ids);
                $delete_stmt->bind_param($types, ...$params);
                $delete_stmt->execute();
                $delete_stmt->close();
            }

            $payment_method = $_POST['payment_method'] ?? 'Credit Card';
            $query = "INSERT INTO payments (OrderID, PaymentMethod, PaymentStatus) VALUES (?, ?, 'Completed')";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("is", $order_id, $payment_method);
            $stmt->execute();
            $stmt->close();

            $conn->commit();
            header("Location: order_confirmation.php?order_id=" . $order_id);
            exit();
        } catch (Exception $e) {
            $conn->rollback();
            $error_message = "Order placement failed: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Store - Order Summary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
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
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="orders.php">Orders</a>
                </li>
                <?php if ($_SESSION['Role'] === 'Admin') { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_inventory.php">Manage Inventory</a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['Username']); ?>)</a>
                </li>
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
        font-weight: 300;
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

    <div class="container mt-4">
        <h1>Order Summary</h1>
        <?php if (isset($error_message)) { ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php } ?>
        <?php if (!$stock_available && !empty($cart_items)) { ?>
            <div class="alert alert-danger">Some items are out of stock. Please update your cart.</div>
        <?php } elseif (empty($cart_items)) { ?>
            <div class="alert alert-info">Your cart is empty.</div>
        <?php } else { ?>
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th style="color: #ff007a; text-shadow: 0 0 10px #ff007a;">Game</th>
                        <th style="color: #ff007a; text-shadow: 0 0 10px #ff007a;">Price</th>
                        <th style="color: #ff007a; text-shadow: 0 0 10px #ff007a;">Quantity</th>
                        <th style="color: #ff007a; text-shadow: 0 0 10px #ff007a;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['Title']); ?></td>
                            <td>$<?php echo number_format($item['Price'], 2); ?></td>
                            <td><?php echo $item['Quantity']; ?></td>
                            <td>$<?php echo number_format($item['Price'] * $item['Quantity'], 2); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <h4  style="color: #00d4ff; text-shadow: 0 0 10px rgba(70, 70, 171, 0.95);">Grand Total: $<?php echo number_format($grand_total, 2); ?></h4>
            <form method="POST">
                <div class="mb-3">
                    <label for="payment_method" class="form-label" style="color: #ff007a; text-shadow: 0 0 10px #ff007a;">Payment Method:</label>
                    <select name="payment_method" id="payment_method" class="form-select w-25" required>
                        <option value="Credit Card">Credit Card</option>
                        <option value="PayPal">PayPal</option>
                        <option value="Cash on Delivery">Cash on Delivery</option>
                    </select>
                </div>
                <button type="submit" name="confirm_order" class="btn btn-success" style="margin-bottom: 1rem;">Confirm Order</button>
            </form>
        <?php } ?>
    </div>

<footer class="footer text-white py-4" style="background-image: url('assets/images/ui/neon.jpg'); background-size: cover; background-position: center;">
    <div class="footer-content fooooooter">
        <p>&copy; 2025 Game Store. All Rights Reserved.</p>
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
</body>
</html>
<?php $stmt->close(); $conn->close(); ?>