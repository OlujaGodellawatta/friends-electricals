<?php
session_start();


if (!isset($_SESSION['username']) || $_SESSION['username'] != "FriendsElectricals") {
    header("Location: login.php");
    exit();
}

include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $address = trim($_POST["address"]);

    $query = "INSERT INTO suppliers (name, email, phone, address) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $name, $email, $phone, $address);

    if ($stmt->execute()) {
        $success = "Supplier added successfully!";
    } else {
        $error = "Error adding supplier.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Supplier - Admin Panel</title>
    <link rel="stylesheet" href="add_supplier.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Add Supplier</h2>
    <?php if (isset($success)) echo "<p class='text-success'>$success</p>"; ?>
    <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>

    <form method="post">
        <div class="mb-3">
            <label>Supplier Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-warning">Add Supplier</button>
    </form>
</div>
</body>
</html>
