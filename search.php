<?php
include 'db.php';
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

$searchTerm = isset($_GET['query']) ? trim($_GET['query']) : '';
$searchTerm = htmlspecialchars($searchTerm);

$sql = "SELECT * FROM products WHERE name LIKE '%$searchTerm%' OR description LIKE '%$searchTerm%'";

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results - Friends Electricals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
    <h2 class="mb-4">Search Results for "<?php echo htmlspecialchars($searchTerm); ?>"</h2>
    
    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                            <p class="card-text text-muted">$<?php echo htmlspecialchars($row['price']); ?></p>
                            <a href="cart.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary w-100">Add to Cart</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-muted">No products found matching your search.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
