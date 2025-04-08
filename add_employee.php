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
    $position = trim($_POST["position"]);
    $salary = trim($_POST["salary"]);
    $address = trim($_POST["address"]);

    $query = "INSERT INTO employees (name, email, phone, position, salary, address) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssds", $name, $email, $phone, $position, $salary, $address);

    if ($stmt->execute()) {
        $success = "Employee added successfully!";
    } else {
        $error = "Error adding employee.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee - Admin Panel</title>
    <link rel="stylesheet" href="add_employee.css"> 
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Add Employee</h2>
    <?php if (isset($success)) echo "<p class='text-success'>$success</p>"; ?>
    <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>

    <form method="post">
        <div class="mb-3">
            <label>Employee Name</label>
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
            <label>Position</label>
            <input type="text" name="position" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Salary</label>
            <input type="number" step="0.01" name="salary" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control" required></textarea>
        </div>
        <button type="submit"  id="sub1" class="btn btn-primary">Add Employee</button>
    </form>
</div>
</body>
</html>
