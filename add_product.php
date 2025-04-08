<?php
session_start();


if (!isset($_SESSION['username']) || $_SESSION['username'] != "FriendsElectricals") {
    header("Location: login.php"); 
    exit();
}

include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $price = trim($_POST["price"]);
    
   
    $uploadDirectory = 'uploads/';  
    $uploadFile = $uploadDirectory . basename($_FILES["image"]["name"]);

   
    if ($_FILES["image"]["error"] != 0) {
        echo "Error uploading file: " . $_FILES["image"]["error"];
    } else {
       
        if (!is_dir($uploadDirectory)) {
            echo "Uploads directory does not exist.";
        } elseif (!is_writable($uploadDirectory)) {
            echo "Uploads directory is not writable.";
        } else {
            
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $uploadFile)) {
                
                $query = "INSERT INTO products (name, price, image) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sss", $name, $price, $uploadFile);

                if ($stmt->execute()) {
                    $success = "Product added successfully!";
                } else {
                    $error = "Error adding product.";
                }
            } else {
                echo "Failed to upload file.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Admin Panel</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin-panel.css"> 
</head>
<body>
<div class="container mt-5">
  
    <h2 class="text-center text-primary">Add Product</h2>
    
   
    <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

  
    <div class="card shadow-lg">
        <div class="card-header text-center">
            <h3>Add a New Product</h3>
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="productName" class="form-label">Product Name</label>
                    <input type="text" name="name" id="productName" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="productPrice" class="form-label">Price</label>
                    <input type="text" name="price" id="productPrice" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="productImage" class="form-label">Product Image</label>
                    <input type="file" name="image" id="productImage" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Add Product</button>
            </form>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
