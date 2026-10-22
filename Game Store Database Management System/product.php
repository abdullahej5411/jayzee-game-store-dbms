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
</script>
<?php
session_start();
include 'includes/db_connect.php';
$game_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$query = "SELECT g.Title, g.Description, g.Price, g.ReleaseDate, i.Quantity AS Stock, c.CategoryName, p.Name AS Publisher, g.TrailerURL 
          FROM games g 
          LEFT JOIN categories c ON g.CategoryID = c.CategoryID 
          LEFT JOIN publishers p ON g.PublisherID = p.PublisherID 
          LEFT JOIN inventory i ON g.GameID = i.GameID 
          WHERE g.GameID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $game_id);
$stmt->execute();
$game = $stmt->get_result()->fetch_assoc();
$stmt->close();
$conn->close();
if (!$game) {
    die("Game not found.");
}

// Process the TrailerURL to extract YouTube video ID and create embed URL
$trailerEmbedUrl = '';
if (!empty($game['TrailerURL'])) {
    // Extract video ID from YouTube URL (supports formats like https://www.youtube.com/watch?v=VIDEO_ID or https://youtu.be/VIDEO_ID)
    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $game['TrailerURL'], $match)) {
        $videoId = $match[1];
        $trailerEmbedUrl = "https://www.youtube.com/embed/{$videoId}?enablejsapi=1&rel=0";
    }
}
// Fallback to a sample YouTube video if TrailerURL is empty or invalid
if (empty($trailerEmbedUrl)) {
    $trailerEmbedUrl = "https://www.youtube.com/embed/dQw4w9WgXcQ?enablejsapi=1&rel=0"; // Rick Astley - Never Gonna Give You Up (for demo)
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Store - <?php echo htmlspecialchars($game['Title']); ?></title>
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
                <?php
                if (isset($_SESSION['UserID'])) {
                    echo "<li class='nav-item'><a class='nav-link' href='orders.php'>Orders</a></li>";
                    if ($_SESSION['Role'] === 'Admin') {
                        echo "<li class='nav-item'><a class='nav-link' href='admin_inventory.php'>Manage Inventory</a></li>";
                    }
                    echo "<li class='nav-item'><a class='nav-link' href='logout.php'>Logout (" . htmlspecialchars($_SESSION['Username']) . ")</a></li>";
                } else {
                    echo "<li class='nav-item'><a class='nav-link' href='login.php'>Login</a></li>";
                    echo "<li class='nav-item'><a class='nav-link' href='register.php'>Register</a></li>";
                }
                ?>
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

    body {
    color: #ffffff; /* Light text for visibility */
    background-color: rgba(0, 0, 0, 0.7); /* fallback */
    position: relative;
    z-index: 1;
}

#bgVideo {
    position: fixed;
    right: 0;
    bottom: 0;
    min-width: 100%;
    min-height: 100%;
    z-index: -1;
    opacity: 0.3; /* lower brightness for better contrast */
}

.container {
    background-color: rgba(0, 0, 0, 0.6); /* semi-transparent black bg for readability */
    padding: 2rem;
    border-radius: 10px;
    margin-top: 100px;
}

label, input, textarea {
    color: white !important;
}
.form-control {
    background-color: rgba(255, 255, 255, 0.1);
    color: white;
    border: 1px solid #ccc;
}

/* Style all input, select, textarea fields */
input[type="number"],
textarea,
input[type="text"],
input[type="email"],
input[type="password"],
.form-control {
    background-color: rgba(255, 255, 255, 0.08);
    color: #fff;
    border: 1px solid #666;
    transition: background-color 0.3s, border-color 0.3s;
}

/* On focus (click) or hover, keep subtle glow */
input[type="number"]:hover,
textarea:hover,
input[type="number"]:focus,
textarea:focus,
.form-control:focus {
    background-color: rgba(255, 255, 255, 0.15);
    border-color: #00d4ff;
    outline: none;
    color: #fff;
}

/* Prevent full white background after focus */
input[type="number"]:not(:focus),
textarea:not(:focus),
.form-control:not(:focus) {
    background-color: rgba(255, 255, 255, 0.08);
    color: #fff;
}

.trailer-box {
    position: relative;
}

/* Placeholder background for iframe before video loads */
.trailer-box .video-placeholder {
    width: 100%;
    height: 350px;
    background: #000;
    display: block;
}
</style>

<div class="container mt-4">
<h1 class="text-center" style="color: #00d4ff; text-shadow: 0 0 10px #00d4ff;"><?php echo htmlspecialchars($game['Title']); ?></h1>
    <div class="row">
        <!-- Game Information (Left Side) -->
        <div class="col-md-6">
            <!-- Game Details without unnecessary blocks, with bright text -->
            <div class="mb-4">
                <p style="text-align: justify;"><strong style="color: #ff007a; text-shadow: 0 0 10px #ff007a;">Description:</strong> <span class="text-light"><?php echo htmlspecialchars($game['Description']); ?></span></p>                <p><strong style="color: #ff007a; text-shadow: 0 0 10px #ff007a;">Price:</strong> <span class="text-success">$<?php echo number_format($game['Price'], 2); ?></span></p>
                <p><strong style="color: #ff007a; text-shadow: 0 0 10px #ff007a;">Category:</strong> <span class="text-light"><?php echo htmlspecialchars($game['CategoryName']); ?></span></p>
                <p><strong style="color: #ff007a; text-shadow: 0 0 10px #ff007a;">Publisher:</strong> <span class="text-light"><?php echo htmlspecialchars($game['Publisher']); ?></span></p>
                <p><strong style="color: #ff007a; text-shadow: 0 0 10px #ff007a;">Release Date:</strong> <span class="text-light"><?php echo $game['ReleaseDate']; ?></span></p>
                <p><strong style="color: #ff007a; text-shadow: 0 0 10px #ff007a;">Stock:</strong> <span class="text-light"><?php echo $game['Stock']; ?></span></p>
            </div>

            <?php if (isset($_SESSION['UserID'])) { ?>
                <!-- Add to Cart in a simple form -->
                <div class="mb-4">
                    <form action="cart.php" method="POST">
                        <input type="hidden" name="game_id" value="<?php echo $game_id; ?>">
                        <div class="mb-3">
                            <label for="quantity" class="form-label text-light">Quantity:</label>
                            <input type="number" class="form-control w-25" id="quantity" name="quantity" value="1" min="1" max="<?php echo $game['Stock']; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary" <?php echo $game['Stock'] <= 0 ? 'disabled' : ''; ?>>Add to Cart</button>
                    </form>
                </div>

                <!-- Review Section in a cleaner format -->
                <div class="mb-4">
                    <h4 class="text-light" style="color: #00d4ff; text-shadow: 0 0 10px #00d4ff ; ">Leave a Review</h4>
                    <form action="add_review.php" method="POST">
                        <input type="hidden" name="game_id" value="<?php echo $game_id; ?>">
                        <div class="mb-3">
                            <label for="rating" class="form-label text-light">Rating (1-5):</label>
                            <input type="number" class="form-control w-25" id="rating" name="rating" min="1" max="5" required>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label text-light">Comment:</label>
                            <textarea class="form-control" id="comment" name="comment" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Submit Review</button>
                    </form>
                </div>

                <!-- Displaying Reviews without borders, just text -->
                <?php
                $conn = new mysqli("localhost", "root", "", "gamestoredb");
                $query = "SELECT r.Rating, r.Comment, r.ReviewDate, u.Username 
                          FROM reviews r 
                          JOIN users u ON r.UserID = u.UserID 
                          WHERE r.GameID = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $game_id);
                $stmt->execute();
                $reviews = $stmt->get_result();
                if ($reviews->num_rows > 0) {
                        echo "<h4 class='mt-4 text-light' style='color: #00d4ff; text-shadow: 0 0 10px #00d4ff;'>Reviews</h4>";                    while ($review = $reviews->fetch_assoc()) {
                        echo "<div class='mb-2'>";
                        echo "<p class='text-light'><strong>{$review['Username']}</strong> rated it {$review['Rating']}/5 on {$review['ReviewDate']}</p>";
                        echo "<p class='text-light'>{$review['Comment']}</p>";
                        echo "</div>";
                    }
                }
                $conn->close();
                ?>
            <?php } ?>
        </div>

        <!-- Game Trailer (Right Side) -->
        <div class="col-md-6">
            <div class="trailer-box" style="
                background: #1a1a2e;
                border-radius: 10px;
                overflow: hidden;
                margin-bottom: 1.5rem;
                position: relative;
                text-align: center;">
                <iframe id="gameTrailer" src="<?php echo $trailerEmbedUrl; ?>" class="video-placeholder" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>

            </div>
        </div>
    </div>
</div>


<footer class="footer text-white py-4" style="background-image: url('assets/images/ui/neon.jpg'); background-size: cover; background-position: center;">
    <div class="footer-content">
        <p>© 2025 Game Store. All Rights Reserved.</p>
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