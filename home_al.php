<?php
include 'db.php'; 
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "friends_electricals";

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friends Electricals</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Friends Electricals</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="home_al.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
                <li class="nav-item"><a class="nav-link" href="services.php">Services & Repair</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Log out</a></li>
            </ul>
        </div>
    </div>
</nav>


<div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="image1.jpg" class="d-block w-100" alt="Sale">
        </div>
        <div class="carousel-item">
            <img src="image2.jpg" class="d-block w-100" alt="Discounts">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>


<div class="container my-5">
    <h2 class="text-center">Featured Products</h2>
    <div class="row">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>">

                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                        <p class="card-text">$<?php echo htmlspecialchars($row['price']); ?></p>
                        
                        <a href="cart.php?add_to_cart=<?php echo $row['id']; ?>" class="btn btn-primary">Add to Cart</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>


<footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2025 Friends Electricals | All Rights Reserved</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
