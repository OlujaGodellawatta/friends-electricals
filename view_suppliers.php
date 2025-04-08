<?php
session_start();


if (!isset($_SESSION['username']) || $_SESSION['username'] != "FriendsElectricals") {
    header("Location: login.php"); 
    exit();
}

include 'db.php'; 


$query = "SELECT * FROM suppliers";
$result = $conn->query($query);


if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    
    $delete_query = "DELETE FROM suppliers WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $delete_id);
    
    if ($stmt->execute()) {
        $success_message = "Supplier deleted successfully!";
    } else {
        $error_message = "Error deleting supplier.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Suppliers - Admin Panel</title>
    <link rel="stylesheet" href="view_suppliers.css"> 
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">View Suppliers</h2>

   
    <?php if (isset($success_message)) echo "<p class='text-success'>$success_message</p>"; ?>
    <?php if (isset($error_message)) echo "<p class='text-danger'>$error_message</p>"; ?>

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
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
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['address']); ?></td>
                        <td>
                            <a href="edit_supplier.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            
                            <a href="view_suppliers.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this supplier?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No suppliers found.</p>
    <?php endif; ?>
</div>
</body>
</html>
