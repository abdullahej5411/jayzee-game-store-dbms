<?php
session_start();
include 'includes/db_connect.php';

if (!isset($_SESSION['UserID']) || $_SESSION['Role'] !== 'Admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = (int)$_POST['order_id'];
    $status = $conn->real_escape_string($_POST['status']);

    $query = "UPDATE orders SET Status = ? WHERE OrderID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $status, $order_id);
    $stmt->execute();

    header("Location: admin_inventory.php");
    exit();
}
$conn->close();
?>