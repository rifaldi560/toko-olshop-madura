<?php
require '../config.php';
session_start();

// Retrieve cart items for the current user
$sql = "SELECT products.name, products.price, cart.quantity FROM cart 
        JOIN products ON cart.product_id = products.id 
        WHERE cart.user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$cart_items = $stmt->fetchAll();

// Calculate total
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Clear the cart after checkout
$sql_clear_cart = "DELETE FROM cart WHERE user_id = ?";
$stmt_clear_cart = $pdo->prepare($sql_clear_cart);
$stmt_clear_cart->execute([$_SESSION['user_id']]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Checkout</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            padding-top: 20px;
        }

        .btn-home {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Checkout Confirmed</h1>
        <p>Your order has been confirmed.</p>
        <h3>Total: <?php echo $total; ?> USD</h3>
        <a href="../index.php" class="btn btn-primary btn-home">Back to Home</a>
    </div>
</body>

</html>