<?php
include 'db.php';
session_start();

$search = '';
if (isset($_GET['query'])) {
    $search = $conn->real_escape_string($_GET['query']);
    $sql = "SELECT * FROM products WHERE name LIKE '%$search%' OR description LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM products";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friends Electricals</title>
    
    <!-- Bootstrap & jQuery -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Custom Styles -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            color: #0d6efd;
            font-weight: bold;
        }
        .nav-link {
            color: #333;
        }
        .carousel img {
            height: 400px;
            object-fit: cover;
        }
        .card {
            transition: transform 0.3s;
        }
        .card:hover {
            transform: scale(1.03);
        }
        footer {
            background-color: #0d6efd;
            color: white;
        }
        .nav-middle {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg position-relative">
    <div class="container position-relative">
        <a class="navbar-brand" href="homepage.php">Friends Electricals</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Centered Navigation Links -->
            <ul class="navbar-nav nav-middle">
                <li class="nav-item"><a class="nav-link" href="homepage.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">Cart</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Services & Repair</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
            </ul>
            <!-- Search Form on Right -->
            <form class="d-flex ms-auto" action="homepage.php" method="GET">
                <input class="form-control me-2" type="search" placeholder="Search products" name="query" required>
                <button class="btn btn-primary" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>

<!-- Carousel -->
<div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#productCarousel" data-bs-slide-to="1"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="image1.jpg" class="d-block w-100" alt="Sale Banner">
        </div>
        <div class="carousel-item">
            <img src="image2.jpg" class="d-block w-100" alt="Discount Banner">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- Featured Products or Search Results -->
<div class="container my-5">
    <?php if (!empty($search)): ?>
        <h2 class="text-center mb-4">Search results for "<strong><?php echo htmlspecialchars($search); ?></strong>"</h2>
    <?php else: ?>
        <h2 class="text-center mb-4">Featured Products</h2>
    <?php endif; ?>

    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                            <p class="card-text text-muted">$<?php echo htmlspecialchars($row['price']); ?></p>
                            <a href="cart.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary w-100">Add to Cart</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p class="text-muted">No products found.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Footer -->
<footer class="text-center py-4">
    <p>&copy; 2025 Friends Electricals. All rights reserved.</p>
</footer>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Optional jQuery Enhancements -->
<script>
    $(document).ready(function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
    });
</script>
</body>
</html>
