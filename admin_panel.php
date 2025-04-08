<?php
session_start();


if (!isset($_SESSION['username']) || $_SESSION['username'] != "FriendsElectricals") {
    header("Location: login.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Friends Electricals</title>
    <link rel="stylesheet" href="admin_panel.css"> 
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Admin Panel</h2>
    <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
    
   
    <div class="text-center">

        <a href="view_customer.php" class="btn btn-info btn-lg mb-3">View Customer</a><br>

        <a href="add_product.php" class="btn btn-success btn-lg mb-3">Add Product</a><br>
        <a href="view_products.php" class="btn btn-info btn-lg mb-3">View Products</a><br>

        <a href="add_supplier.php" class="btn btn-warning btn-lg mb-3">Add Supplier</a><br>
        <a href="view_suppliers.php" class="btn btn-secondary btn-lg mb-3">View Suppliers</a><br>

        <a href="add_employee.php" class="btn btn-primary btn-lg mb-3">Add Employee</a><br>
        <a href="view_employees.php" class="btn btn-dark btn-lg mb-3">View Employees</a><br>

        <a href="logout.php" class="btn btn-danger btn-lg">Logout</a>
    </div>
</div>
</body>
</html>
