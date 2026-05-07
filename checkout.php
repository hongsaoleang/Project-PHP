<?php
session_start();

// If the cart is empty or total isn't set, send them back to the shop
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aub Shop - Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assests/css/style.css">
    <style>
        /* Ensuring the form looks like your screenshot */
        #checkout-form .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .checkout-btn-container {
            text-align: right;
            margin-top: 20px;
        }

        #checkout-btn {
            background-color: #fb774b;
            color: white;
            border: none;
            padding: 10px 30px;
        }

        #checkout-btn:hover {
            background-color: #e3663d;
        }
    </style>
</head>

<body>
    <nav class="navbar1 d-flex justify-content-between bg-light p-4 text-center shadow sticky-top">
        <ul class="list-unstyled ms-5 text-dark d-flex align-items-center gap-2">
            <img class="rounded-circle" style="width: 50px; height: 50px;" src="./assests/img/AUB.png" alt="Logo">
            <li class="fw-bold">Aub Shop</li>
        </ul>
        <ul class="d-flex list-unstyled me-5 gap-5 align-items-center">
            <li><a href="index.php" class="text-decoration-none text-black">Home</a></li>
            <li><a href="shop.php" class="text-decoration-none text-black">Shop</a></li>
            <li><a href="#" class="text-decoration-none text-black">Blog</a></li>
            <li><a href="#" class="text-decoration-none text-black">Contact Us</a></li>
        </ul>
    </nav>

    <section class="my-5 py-5">
        <div class="container text-center mt-3">
            <h2 class="form-weight-bold">Check Out</h2>
            <hr class="mx-auto" style="width: 50px; border: 2px solid #fb774b;">
        </div>

        <div class="mx-auto container" style="max-width: 800px;">
            <form id="checkout-form" method="POST" action="server/place_order.php">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Name" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="form-group col-md-6">
                        <label>Phone</label>
                        <input type="tel" class="form-control" name="phone" placeholder="Phone" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label>City</label>
                        <input type="text" class="form-control" name="city" placeholder="City" required>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label>Address</label>
                    <input type="text" class="form-control" name="address" placeholder="Address" required>
                </div>

                <div class="checkout-btn-container">
                    <p class="fw-bold">Total amount: $<?php echo number_format($_SESSION['total'], 2); ?></p>
                    <input type="submit" class="btn btn-primary" id="checkout-btn" name="place_order" value="Place Order">
                </div>

                <div class="mt-3 text-center">
                    <a href="login.php" id="login-url" class="text-decoration-none text-muted small">Do you have an account? Login</a>
                </div>
            </form>
        </div>
    </section>

    <footer class="bg-dark p-5 text-white text-center mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img class="rounded-circle mb-3" style="width: 50px; height: 50px;" src="./assests/img/AUB.png" alt="">
                    <p>We provide the best products for the most affordable prices.</p>
                </div>
                <div class="col-md-4">
                    <h5>Contact Us</h5>
                    <p>Phnom Penh, Toul Sangke<br>Phone: 093779991</p>
                </div>
                <div class="col-md-4">
                    <h5>Newsletter</h5>
                    <p>&copy; 2026 Aub Shop. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>