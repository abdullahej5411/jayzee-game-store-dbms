



<?php
include 'includes/db_connect.php';

$query = isset($_GET['query']) ? $_GET['query'] : '';
$query = $conn->real_escape_string($query);

// Build base query
$sql = "SELECT g.GameID, g.Title, g.Description, g.Price, g.ReleaseDate, c.CategoryName, p.Name AS Publisher, i.Quantity AS Stock
        FROM games g
        LEFT JOIN categories c ON g.CategoryID = c.CategoryID
        LEFT JOIN publishers p ON g.PublisherID = p.PublisherID
        LEFT JOIN inventory i ON g.GameID = i.GameID";

// If query is not empty, add filter
if (!empty($query)) {
    $sql .= " WHERE g.Title LIKE '$query%'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($game = $result->fetch_assoc()) {
        echo "<div class='col-md-4 game-card'>";
        echo "<div class='card'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . htmlspecialchars($game['Title']) . "</h5>";
        echo "<p class='card-text'>" . substr(htmlspecialchars($game['Description']), 0, 100) . "...</p>";
        echo "<p class='card-text'>Price: \${$game['Price']}</p>";
        echo "<p class='card-text'>Stock: {$game['Stock']}</p>";
        echo "<p class='card-text'>Publisher: " . htmlspecialchars($game['Publisher'] ?? 'Unknown') . "</p>";
        echo "<a href='product.php?id={$game['GameID']}' class='btn btn-primary'>View Details</a>";
        echo "</div></div></div>";
    }
} else {
    echo "<p class='text-center' style='color: #00d4ff;'>No games found.</p>";
}

$conn->close();
?>
