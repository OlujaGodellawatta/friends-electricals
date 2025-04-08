<?php
session_start();


if (!isset($_SESSION['username']) || $_SESSION['username'] != "FriendsElectricals") {
    header("Location: login.php");
    exit();
}

include 'db.php'; 


if (isset($_GET['delete'])) {
    $product_id = $_GET['delete'];

    $query = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        $message = "Product deleted successfully!";
    } else {
        $message = "Error deleting product.";
    }
}


$query = "SELECT * FROM products";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products - Admin Panel</title>
    <link rel="stylesheet" href="view_products.css">
</head>
<body>
<div class="container">
    <h2 class="text-center">View Products</h2>
    <?php if (isset($message)) echo "<p class='text-success'>$message</p>"; ?>

    
    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            while ($product = $result->fetch_assoc()) {
                $image_path = $product['image']; 
                echo '<tr>';
                echo '<td>';
                
                if (!empty($image_path) && file_exists($image_path)) {
                    echo "<img src=\"$image_path\" alt=\"Product Image\" width=\"100\" height=\"100\">";
                } else {
                    echo "No Image";
                }
                echo '</td>';
                echo '<td>' . $product['name'] . '</td>';
                echo '<td>' . $product['category'] . '</td>';
                echo '<td>' . $product['price'] . '</td>';
                echo '<td>' . $product['stock'] . '</td>';
                echo '<td><a href="view_products.php?delete=' . $product['id'] . '" class="btn btn-danger">Delete</a></td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
