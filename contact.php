<?php
include 'db.php'; 
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_feedback'])) {
    if (isset($_SESSION['username'])) {
        $name = $_SESSION['username'];
        $email = $_SESSION['email'];
    } else {
        $name = $_POST['name'];
        $email = $_POST['email'];
    }

    $feedback = $_POST['feedback'];

    $query = "INSERT INTO feedback (name, email, feedback) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $name, $email, $feedback);

    if ($stmt->execute()) {
        $success_message = "Thank you for your feedback!";
    } else {
        $error_message = "There was an error submitting your feedback. Please try again.";
    }
}


if (isset($_GET['delete_feedback'])) {
    $feedback_id = $_GET['delete_feedback'];

    
    $query = "DELETE FROM feedback WHERE id = ? AND email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $feedback_id, $_SESSION['email']);

    if ($stmt->execute()) {
        $delete_message = "Feedback deleted successfully.";
    } else {
        $delete_message = "There was an error deleting your feedback. Please try again.";
    }
}


$feedback_query = "SELECT * FROM feedback WHERE email = ?";
$stmt = $conn->prepare($feedback_query);
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$feedback_result = $stmt->get_result();




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Friends Electricals</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- Navigation Bar -->
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

<!-- Contact Us Form -->
<div class="container my-5">
    <h2 class="text-center">Contact Us</h2>

    <!-- Success/Error Message -->
    <?php if (isset($success_message)) : ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>
    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <?php if (isset($delete_message)) : ?>
        <div class="alert alert-info"><?php echo $delete_message; ?></div>
    <?php endif; ?>

    <!-- Feedback Form -->
    <form action="contact.php" method="POST">
        <?php if (isset($_SESSION['username'])): ?>
            <input type="hidden" name="name" value="<?php echo $_SESSION['username']; ?>">
            <input type="hidden" name="email" value="<?php echo $_SESSION['email']; ?>">
        <?php else: ?>
            <div class="mb-3">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Your Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="feedback" class="form-label">Your Feedback</label>
            <textarea name="feedback" id="feedback" class="form-control" rows="4" required></textarea>
        </div>
        <button type="submit" name="submit_feedback" class="btn btn-primary">Submit Feedback</button>
    </form>

    <!-- Display User's Feedback -->
    <h3 class="mt-5">Your Feedback:</h3>
    <?php if ($feedback_result->num_rows > 0): ?>
        <ul class="list-group">
            <?php while ($row = $feedback_result->fetch_assoc()): ?>
                <li class="list-group-item">
                    <p><?php echo htmlspecialchars($row['feedback']); ?></p>
                    <small>Submitted on: <?php echo $row['created_at']; ?></small>
                    <!-- Delete Button -->
                    <a href="contact.php?delete_feedback=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm float-end">Delete</a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>You have not submitted any feedback yet.</p>
    <?php endif; ?>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2025 Friends Electricals | All Rights Reserved</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
