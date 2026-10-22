<?php
session_start();
include 'includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['UserID'])) {
    $user_id = $_SESSION['UserID'];
    $game_id = (int)$_POST['game_id'];
    $rating = (int)$_POST['rating'];
    $comment = $conn->real_escape_string($_POST['comment']);

    if ($rating >= 1 && $rating <= 5) {
        $query = "INSERT INTO reviews (UserID, GameID, Rating, Comment) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiis", $user_id, $game_id, $rating, $comment);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: product.php?id=$game_id");
    exit();
}
$conn->close();
?>