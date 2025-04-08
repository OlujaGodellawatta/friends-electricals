<?php
session_start();


if (!isset($_SESSION['username']) || $_SESSION['username'] != "FriendsElectricals") {
    header("Location: login.php"); 
    exit();
}

include 'db.php'; 


if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id']; 

  
    if (is_numeric($delete_id)) {
        
        $delete_query = "DELETE FROM customers WHERE id = ?";
        $stmt = $conn->prepare($delete_query);
        
        
        if ($stmt) {
            $stmt->bind_param("i", $delete_id);
            
            
            if ($stmt->execute()) {
                $success_message = "Customer deleted successfully!";
            } else {
                $error_message = "Error deleting customer: " . $stmt->error; 
            }
        } else {
            $error_message = "Failed to prepare delete query: " . $conn->error; 
        }
    } else {
        $error_message = "Invalid customer ID.";
    }
}


$query = "SELECT * FROM customers";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customers - Admin Panel</title>
    <link rel="stylesheet" href="view_customer.css"> 
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">View Customers</h2>

    
    <?php if (isset($success_message)) echo "<p class='text-success'>$success_message</p>"; ?>
    <?php if (isset($error_message)) echo "<p class='text-danger'>$error_message</p>"; ?>

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['address']); ?></td>
                        <td>
                            <a href="edit_customer.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="view_customers.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this customer?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No customers found.</p>
    <?php endif; ?>
</div>
</body>
</html>
