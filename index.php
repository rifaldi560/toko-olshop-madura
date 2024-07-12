<?php
session_start();

// Include your configuration file or any necessary dependencies here
require 'config.php';

// Redirect to login if user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: Auth/login.php");
    exit;
}

// Fetch products from the database
$sql = "SELECT * FROM products";
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Shop</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-image: url("bg.jpeg");
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            color: #ffffff;
            /* Set text color to white */
        }

        .bg-image {
            background-image: url("image/bg.jpeg");
            filter: blur(8px);
            -webkit-filter: blur(8px);
            position: center;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .navbar {
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .container {
            padding-top: 20px;
            z-index: 1;
            position: relative;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            background-color: rgba(255, 255, 255, 0.9);
            /* Card background color */
            color: #333333;
            /* Card text color */
            margin-bottom: 20px;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            color: #333333;
            /* Card title color */
            font-weight: bold;
        }

        .card-text {
            color: #666666;
            /* Card text color */
        }

        .btn-primary {
            background-color: #007bff;
            /* Primary button background color */
            border-color: #007bff;
            /* Primary button border color */
        }

        .btn-primary:hover {
            background-color: #0069d9;
            /* Primary button hover background color */
            border-color: #0062cc;
            /* Primary button hover border color */
        }

        .btn-secondary {
            background-color: #6c757d;
            /* Secondary button background color */
            border-color: #6c757d;
            /* Secondary button border color */
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            /* Secondary button hover background color */
            border-color: #545b62;
            /* Secondary button hover border color */
        }

        .navbar-brand,
        .nav-link {
            color: #333 !important;
        }

        .nav-link:hover {
            color: #007bff !important;
        }

        .container h1 {
            color: #ffffff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>

<body>
    <div class="bg-image"></div>

    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">Cafe Shop</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Order/cart.php">Cart</a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="Auth/logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="Auth/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-4 text-center">WARUNG MADURA
        </h1>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="image/<?php echo $product['image']; ?>" class="card-img-top"
                            alt="<?php echo $product['name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['name']; ?></h5>
                            <p class="card-text"><?php echo $product['description']; ?></p>
                            <p class="card-text"><?php echo $product['price']; ?> RP</p>
                            <a href="Order/cart.php?action=add&id=<?php echo $product['id']; ?>" class="btn btn-primary">Add
                                to Cart</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="mt-4 text-center">
            <a href="Order/cart.php" class="btn btn-secondary">View Cart</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>