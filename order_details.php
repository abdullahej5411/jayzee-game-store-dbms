<script type="text/javascript">
        var gk_isXlsx = false;
        var gk_xlsxFileLookup = {};
        var gk_fileData = {};
        function filledCell(cell) {
          return cell !== '' && cell != null;
        }
        function loadFileData(filename) {
        if (gk_isXlsx && gk_xlsxFileLookup[filename]) {
            try {
                var workbook = XLSX.read(gk_fileData[filename], { type: 'base64' });
                var firstSheetName = workbook.SheetNames[0];
                var worksheet = workbook.Sheets[firstSheetName];

                // Convert sheet to JSON to filter blank rows
                var jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1, blankrows: false, defval: '' });
                // Filter out blank rows (rows where all cells are empty, null, or undefined)
                var filteredData = jsonData.filter(row => row.some(filledCell));

                // Heuristic to find the header row by ignoring rows with fewer filled cells than the next row
                var headerRowIndex = filteredData.findIndex((row, index) =>
                  row.filter(filledCell).length >= filteredData[index + 1]?.filter(filledCell).length
                );
                // Fallback
                if (headerRowIndex === -1 || headerRowIndex > 25) {
                  headerRowIndex = 0;
                }

                // Convert filtered JSON back to CSV
                var csv = XLSX.utils.aoa_to_sheet(filteredData.slice(headerRowIndex)); // Create a new sheet from filtered array of arrays
                csv = XLSX.utils.sheet_to_csv(csv, { header: 1 });
                return csv;
            } catch (e) {
                console.error(e);
                return "";
            }
        }
        return gk_fileData[filename] || "";
        }
        </script><?php
session_start();
include 'includes/db_connect.php';

if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
$query = "SELECT o.OrderID, o.OrderDate, o.TotalAmount, o.Status 
          FROM orders o 
          WHERE o.OrderID = ? AND o.UserID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $order_id, $_SESSION['UserID']);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    die("Order not found.");
}

$query = "SELECT od.GameID, od.Quantity, od.Price, g.Title 
          FROM orderdetails od 
          JOIN games g ON od.GameID = g.GameID 
          WHERE od.OrderID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_items = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JayZee E-Store - Order Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <h1>Order Details - Order #<?php echo $order['OrderID']; ?></h1>
        <p><strong>Order Date:</strong> <?php echo $order['OrderDate']; ?></p>
        <p><strong>Total Amount:</strong> $<?php echo number_format($order['TotalAmount'], 2); ?></p>
        <p><strong>Status:</strong> <?php echo $order['Status']; ?></p>
        <h4>Items</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Game</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = $order_items->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['Title']); ?></td>
                        <td>$<?php echo number_format($item['Price'], 2); ?></td>
                        <td><?php echo $item['Quantity']; ?></td>
                        <td>$<?php echo number_format($item['Price'] * $item['Quantity'], 2); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="orders.php" class="btn btn-primary" style="margin-bottom: 1rem;">Back to Orders</a>
    </div>

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
</body>
</html>
<?php $stmt->close(); $conn->close(); ?>