<?php
session_start();
include 'includes/db_connect.php';

if (!isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

$cart_id = isset($_POST['cart_id']) ? (int)$_POST['cart_id'] : 0;
$user_id = $_SESSION['UserID'];

// Delete the cart item
$query = "DELETE FROM cart WHERE CartID = ? AND UserID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $cart_id, $user_id);
$stmt->execute();

header("Location: cart.php");
exit();

$stmt->close();
$conn->close();
?>