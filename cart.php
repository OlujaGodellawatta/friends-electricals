<?php
session_start();
include 'db.php';


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}


if (isset($_GET['add_to_cart'])) {
    $product_id = $_GET['add_to_cart'];
    $quantity = 1;

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }

    header("Location: cart.php"); 
    exit();
}


if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $product_id => $quantity) {
        if ($quantity > 0) {
            $_SESSION['cart'][$product_id] = $quantity;
        } else {
            unset($_SESSION['cart'][$product_id]); 
        }
    }
}


if (isset($_GET['remove_from_cart'])) {
    $product_id = $_GET['remove_from_cart'];
    unset($_SESSION['cart'][$product_id]);
    header("Location: cart.php");
    exit();
}


$cart_products = [];
if (!empty($_SESSION['cart'])) {
    $product_ids = implode(',', array_keys($_SESSION['cart']));
    $query = "SELECT * FROM products WHERE id IN ($product_ids)";
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        $cart_products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
</head>
<body>


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


<div class="container mt-5">
    <h2>Your Cart</h2>

    <?php if (empty($cart_products)): ?>
        <p>Your cart is empty. <a href="products.php">Shop Now</a></p>
    <?php else: ?>
        <form action="cart.php" method="POST">
            <div class="row">
                <?php foreach ($cart_products as $product): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $product['name']; ?></h5>
                                <p class="card-text">$<?php echo $product['price']; ?></p>

                               
                                <input type="number" name="quantity[<?php echo $product['id']; ?>]" value="<?php echo $_SESSION['cart'][$product['id']]; ?>" min="1" class="form-control mb-2">

                              
                                <a href="cart.php?remove_from_cart=<?php echo $product['id']; ?>" class="btn btn-danger">Remove</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            
            <button type="submit" name="update_cart" class="btn btn-warning">Update Cart</button>
        </form>

       
        <?php if (isset($_SESSION['username'])): ?>
            <a href="checkout.php" class="btn btn-success mt-3">Proceed to Checkout</a>
        <?php else: ?>
            <p class="mt-3">You must <a href="login.php">log in</a> or <a href="register.php">register</a> to proceed to checkout.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
