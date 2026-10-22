<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JayZee E-Store - Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/styles.css">
</head>


    <body>
    <div class="page-container">

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
                        session_start();
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
                font-family: 'Montserrat', sans-serif; /* Explicitly set for navbar brand */
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
                font-family: 'Montserrat', sans-serif;
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


            .form-control {
            color: #00d4ff;
            
            }



            #gameSearch {
            width: 100%;
            padding: 12px 20px;
            font-size: 16px;
            border: 1px solidrgb(255, 255, 255);
            border-radius: 20px;
            background-color:rgba(29, 29, 69, 0.7);
            color: #ffffff;
            outline: none;
            box-shadow: inset 0 0 5px rgba(255, 255, 255, 0.05);
            }

            #gameSearch::placeholder {
                color: #888;
                font-style: normal;
            }

            

            /* Make sure html and body take full height */
            html, body {
                height: 100%;
                margin: 0;
            }

            /* Flexbox layout for full page */
            .page-container {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }

            /* Main content grows to fill space */
            main {
                flex: 1;
            }

            /* Footer styling */
            .site-end {
                margin-top: auto; /* This ensures the footer will always be at the bottom */
                background: linear-gradient(135deg, rgba(74, 0, 0, 0.93), #16213e);
                color: #ddd;
                padding: 30px 15px;
                text-align: center;
                font-size: 14px;
                border-top: 1px solid #333;
            }

            /* Footer links */
            .privacy-links a,
            .social-media-follow a {
                color: #00d4ff;
                margin: 0 8px;
                text-decoration: none;
                transition: color 0.2s ease;
            }

            .privacy-links a:hover,
            .social-media-follow a:hover {
                color: #ff007a;
                text-decoration: underline;
            }


        </style>



        <div class="welcome-header text-center">
            <h1 class="main-heading">Welcome to JayZee E-Store</h1>
            <h2 class="brand-tagline">Your Ultimate Gaming Destination</h2>
        </div>





        <!-- Search Bar -->
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-6 offset-md-3">
                <input type="text" id="gameSearch" class="form-control" style="color:#888; font-weight: 300;" placeholder="Search for games..." onkeyup="searchGames()">
                </div>
            </div>
        </div>




        <div class="container">

            <form method="GET" action="home.php" style="background-color: transparent;">
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="categoryFilter" style="color: #00d4ff; font-weight: 300; text-shadow: 0 0 10px #16213e;">Filter by Category:</label>
            <select id="categoryFilter" name="category" class="form-select" style="background-color:rgba(29, 29, 69, 0.7); color:rgb(255, 255, 255); border: 1px solid #ced4da;">
                <option value="">All</option>
                <?php
                include 'includes/db_connect.php';
                $result = $conn->query("SELECT CategoryID, CategoryName FROM categories");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['CategoryID']}'" . (isset($_GET['category']) && $_GET['category'] == $row['CategoryID'] ? ' selected' : '') . " style='color:rgb(255, 255, 255);'>{$row['CategoryName']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label for="priceFilter" style="color: #00d4ff; font-weight: 300; text-shadow: 0 0 10px #16213e;">Sort by Price:</label>
            <select id="priceFilter" name="price" class="form-select" style="background-color:rgba(29, 29, 69, 0.7); color:rgb(255, 255, 255); border: 1px solid #ced4da;">
                <option value="">None</option>
                <option value="low-high" <?php echo (isset($_GET['price']) && $_GET['price'] == 'low-high') ? 'selected' : ''; ?> style="color:rgb(255, 255, 255);">Low to High</option>
                <option value="high-low" <?php echo (isset($_GET['price']) && $_GET['price'] == 'high-low') ? 'selected' : ''; ?> style="color:rgb(255, 255, 255);">High to Low</option>
                <option value="0-20" <?php echo (isset($_GET['price']) && $_GET['price'] == '0-20') ? 'selected' : ''; ?> style="color:rgb(255, 255, 255);">Under $20</option>
                <option value="20-50" <?php echo (isset($_GET['price']) && $_GET['price'] == '20-50') ? 'selected' : ''; ?> style="color:rgb(255, 255, 255);">$20 to $50</option>
                <option value="50-9999" <?php echo (isset($_GET['price']) && $_GET['price'] == '50-9999') ? 'selected' : ''; ?> style="color:rgb(255, 255, 255);">Above $50</option>
            </select>
        </div>
    </div>

    <!-- Search Button -->
    <div class="row">
        <div class="col-md-12 mb-3 text-center">
            <button type="submit" class="btn btn-primary chota">Search</button>
        </div>
    </div>
</form>

        </div>


                

        <main>
    <div class="row" id="gameList">
        <?php
        // Fetch selected filters from GET parameters
        $categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';
        $priceFilter = isset($_GET['price']) ? $_GET['price'] : '';

        $query = "SELECT g.GameID, g.Title, g.Description, g.Price, g.ReleaseDate, c.CategoryID, c.CategoryName, p.Name AS Publisher, i.Quantity AS Stock 
                FROM games g 
                LEFT JOIN categories c ON g.CategoryID = c.CategoryID 
                LEFT JOIN publishers p ON g.PublisherID = p.PublisherID 
                LEFT JOIN inventory i ON g.GameID = i.GameID 
                WHERE 1";

        // Category filter
        if (!empty($categoryFilter)) {
            $query .= " AND g.CategoryID = " . intval($categoryFilter);
        }

        // Price filter
        if ($priceFilter === 'low-high') {
            $query .= " ORDER BY g.Price ASC";
        } elseif ($priceFilter === 'high-low') {
            $query .= " ORDER BY g.Price DESC";
        } elseif ($priceFilter === '0-20') {
            $query .= " AND g.Price < 20";
        } elseif ($priceFilter === '20-50') {
            $query .= " AND g.Price BETWEEN 20 AND 50";
        } elseif ($priceFilter === '50-9999') {
            $query .= " AND g.Price > 50";
        }

        $result = $conn->query($query);

        // Fetch and display the games
        while ($game = $result->fetch_assoc()) {
            $category_id = isset($game['CategoryID']) ? $game['CategoryID'] : '0';
            echo "<div class='col-md-4 game-card' data-category='$category_id'>";
            echo "<div class='card'>";
echo "<img src='assets/images/games/{$game['GameID']}.jpg' class='card-img-top img-fluid' alt='{$game['Title']} Cover' style='height: 200px; object-fit: cover; width: 100%;'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>" . htmlspecialchars($game['Title']) . "</h5>";
            echo "<p class='card-text'>" . substr(htmlspecialchars($game['Description']), 0, 100) . "...</p>";
            echo "<p class='card-text'>Price: $" . htmlspecialchars($game['Price']) . "</p>";
            echo "<p class='card-text'>Stock: " . htmlspecialchars($game['Stock']) . "</p>";
            echo "<p class='card-text'>Publisher: " . htmlspecialchars($game['Publisher'] ?? 'Unknown') . "</p>";
            echo "<a href='product.php?id={$game['GameID']}' class='btn btn-primary me-2'>View Details</a>";
            echo "<form method='POST' action='cart.php' onsubmit='return showAddedMessage();' class='d-inline'>";
            echo "<input type='hidden' name='game_id' value='" . htmlspecialchars($game['GameID']) . "'>";
            echo "<input type='hidden' name='quantity' value='1'>";
            echo "<button type='submit' class='btn' style='background: linear-gradient(to right, #ff416c, #ff4b2b); color: white;'>Add to Cart</button>";
            echo "</form>";
            echo "</div></div></div>";
        }

        $conn->close();
        ?>
    </div>
</main>
    </div>        


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/scripts.js"></script>

        <!-- Real-time search JavaScript -->
        <script>
            function searchGames() {
                var query = document.getElementById('gameSearch').value; // Get the search query
                var gameList = document.getElementById('gameList'); // The div where we will display the results

                // Create a new AJAX request
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'search.php?query=' + query, true); // Send the search query to search.php
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        gameList.innerHTML = xhr.responseText; // Update the game list with the results
                    }
                };
                xhr.send();
            }
        </script>


        <!-- HTML -->
<footer class="footer site-end text-white py-4" style="background-image: url('assets/images/ui/neon.jpg'); background-size: cover; background-position: center;">
            <div class="end-content">
                
            <p>&copy; 2025 JayZee E-Store. All Rights Reserved.</p>
                <p class="privacy-links">
                    <a href="#">Data Privacy</a>
                    <span>|</span>
                    <a href="#">User Agreement</a>
                    <span>|</span>
                    <a href="#">Help Center</a>
                </p>

            <p class="social-media-follow">
                    Connect with Us:
                    <a href="https://www.facebook.com/abdullahej20" target="_blank">Facebook</a>
                    <a href="https://x.com/a1phazux" target="_blank">Twitter</a>
                    <a href="https://www.instagram.com/abdullah._.ej/" target="_blank">Instagream</a>
                </p>
            </div>
        </footer>

    </body>
</html>