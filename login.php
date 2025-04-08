<?php
include 'db.php'; 
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    
    if ($email === "FriendsElectricals123@gmail.com" && $password === "FriendsElectricals123") {
        $_SESSION['username'] = "FriendsElectricals"; 
        header("Location: admin_panel.php"); 
        exit();
    }

    
    $query = "SELECT * FROM customers WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

   
    if ($user && password_verify($password, $user['password'])) {
 
        header("Location: home_al.php"); 
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Friends Electricals</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Login</h2>
    <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
    <form method="post">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <p class="mt-2">Don't have an account? <a href="register.php">Register here</a></p>
    </form>
</div>
</body>
</html>
