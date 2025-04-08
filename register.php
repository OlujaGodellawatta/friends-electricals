<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $full_name = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $address = trim($_POST["address"]);
    $password = $_POST["password"];

   
    if (empty($full_name) || empty($email) || empty($phone) || empty($address) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (!preg_match("/^[0-9]+$/", $phone)) {
        $error = "Phone number must contain only digits.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } else {
        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        
        $checkQuery = "SELECT id FROM customers WHERE email = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email already registered. Please log in.";
        } else {
            
            $query = "INSERT INTO customers (full_name, email, phone, address, password) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssss", $full_name, $email, $phone, $address, $hashed_password);

            if ($stmt->execute()) {
                $_SESSION['full_name'] = $full_name;
                $_SESSION['email'] = $email;
                $_SESSION['phone'] = $phone;
                $_SESSION['address'] = $address;

                header("Location: login.php"); 
                exit();
            } else {
                $error = "Error registering customer. Please try again.";
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
    <title>Register - Friends Electricals</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Register</h2>
    <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
    <form method="post">
        <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="full_name" class="form-control" required>
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
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
        <p class="mt-2">Already have an account? <a href="login.php">Login here</a></p>
    </form>
</div>
</body>
</html>
