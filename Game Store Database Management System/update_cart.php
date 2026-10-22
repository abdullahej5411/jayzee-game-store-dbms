<?php
session_start();
include 'includes/db_connect.php';

if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_id']) && isset($_POST['quantity'])) {
    $cart_id = (int)$_POST['cart_id'];
    $quantity = (int)$_POST['quantity'];

    // Verify the cart item belongs to the user
    $query = "SELECT c.GameID, i.Quantity AS Stock 
              FROM cart c 
              JOIN inventory i ON c.GameID = i.GameID 
              WHERE c.CartID = ? AND c.UserID = ? AND c.Status = 'active'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $cart_id, $_SESSION['UserID']);
    $stmt->execute();
    $cart_item = $stmt->get_result()->fetch_assoc();

    if ($cart_item) {
        if ($quantity <= $cart_item['Stock'] && $quantity > 0) {
            $query = "UPDATE cart SET Quantity = ? WHERE CartID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $quantity, $cart_id);
            $stmt->execute();
        } else {
            echo "<div class='alert alert-warning'>Not enough stock available or invalid quantity.</div>";
        }
    }
    header("Location: cart.php");
    exit();
}
$conn->close();
?>