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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            padding-top: 20px;
        }

        .btn-confirm {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Checkout</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo number_format($item['price'], 2, ',', '.'); ?> USD</td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td><?php echo number_format($item['price'] * $item['quantity'], 2, ',', '.'); ?> USD</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h3>Total: <?php
        $total = 0;
        foreach ($cart_items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        echo number_format($total, 2, ',', '.'); ?> USD
        </h3>
        <a href="confirm_checkout.php" class="btn btn-primary btn-confirm">Confirm Purchase</a>
        <a href="cart.php" class="btn btn-secondary">Back to Cart</a>
    </div>
</body>

</html>