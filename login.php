<?php
session_start();
include 'includes/db_connect.php';

if (isset($_SESSION['UserID'])) {
    header("Location: home.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT UserID, Username, Password, Role FROM users WHERE Email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['Password'])) {
        $_SESSION['UserID'] = $user['UserID'];
        $_SESSION['Username'] = $user['Username'];
        $_SESSION['Role'] = $user['Role'];
        header("Location: home.php");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Game Store - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Background Video -->
<video autoplay muted loop id="bgVideo">
  <source src="assets/videos/home.mp4" type="video/mp4">
  Your browser does not support the video tag.
</video>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light" style="background-image: url('assets/images/ui/neon.jpg'); background-size: cover; background-position: center;">
    <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="home.php">
                <img src="assets/images/ui/adobe.png" alt="Store Icon" 
                    style="width: 90px; height: 40px; object-fit: contain; margin-right: -15px; margin-left: -20px;">
                <span style="color: #00d4ff; font-weight: 700; text-shadow: 0 0 10px #00d4ff; margin-right:0.4rem">JayZee</span>
                <span style="color: #ff007a; font-weight: 700; text-shadow: 0 0 10px #ff007a;">E-Store</span>
            </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
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
    border: 1px solid #4b4b5e;
    border-radius: 40px;
    background-color: #2e2e42;
    color: #ffffff;
    outline: none;
    box-shadow: inset 0 0 5px rgba(255, 255, 255, 0.05);
    }

    #gameSearch::placeholder {
        color: #888;
        font-style: italic;
    }

    
</style>





<!-- Login Form -->
<main class="d-flex justify-content-center align-items-center" style="min-height: 100vh; padding-top: 80px;">
    <div class="card p-4 bg-dark text-light shadow-lg" style="max-width: 400px; width: 100%; border-radius: 1rem;">
        <h2 class="text-center mb-4" style="color: #00d4ff; text-shadow: 0 0 6px #00d4ff; margin-top:1rem;">Login</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" autocomplete="off">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control bg-dark text-light border-secondary" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control bg-dark text-light border-secondary" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100" style="background: linear-gradient(45deg, #00d4ff, #ff007a); border: none; margin-top: 0.5rem;">Login</button>
        </form>
    </div>
</main>

<!-- Footer -->
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

<!-- JavaScript + SheetJS logic (for xlsx loading) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
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
              var jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1, blankrows: false, defval: '' });
              var filteredData = jsonData.filter(row => row.some(filledCell));
              var headerRowIndex = filteredData.findIndex((row, index) =>
                  row.filter(filledCell).length >= filteredData[index + 1]?.filter(filledCell).length
              );
              if (headerRowIndex === -1 || headerRowIndex > 25) {
                  headerRowIndex = 0;
              }
              var csv = XLSX.utils.aoa_to_sheet(filteredData.slice(headerRowIndex));
              return XLSX.utils.sheet_to_csv(csv, { header: 1 });
          } catch (e) {
              console.error(e);
              return "";
          }
      }
      return gk_fileData[filename] || "";
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
