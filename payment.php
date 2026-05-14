<?php
session_start();

// If no order info in session, redirect home
if (!isset($_SESSION['order_id'])) {
    header('location: index.php');
    exit;
}

require_once('server/connection.php');

$order_id       = $_SESSION['order_id'];
$order_cost     = $_SESSION['order_cost'];
$transaction_id = $_SESSION['transaction_id'];
$user_name      = $_SESSION['user_name'];
$user_email     = $_SESSION['user_email'];
$user_phone     = $_SESSION['user_phone'];
$user_city      = $_SESSION['user_city'];
$user_address   = $_SESSION['user_address'];

// Handle Pay Now
$payment_success = false;
if (isset($_POST['pay_now'])) {
    $update_order = $con->prepare("UPDATE orders SET order_status = 'paid' WHERE order_id = ?");
    $update_order->bind_param("i", $order_id);
    $update_order->execute();

    // Update payment record as completed
    $update_payment = $con->prepare("UPDATE payments SET transaction_id = ? WHERE order_id = ?");
    $completed_txn = $transaction_id . '-PAID-' . time();
    $update_payment->bind_param("si", $completed_txn, $order_id);
    $update_payment->execute();

    $payment_success = true;

    // Clear order session
    unset($_SESSION['order_id']);
    unset($_SESSION['order_cost']);
    unset($_SESSION['order_status']);
    unset($_SESSION['transaction_id']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_phone']);
    unset($_SESSION['user_city']);
    unset($_SESSION['user_address']);
}

// Fetch order items
$get_items = $con->prepare("SELECT * FROM order_items WHERE order_id = ?");
$get_items->bind_param("i", $order_id);
$get_items->execute();
$order_items = $get_items->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aub Shop - Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="./assests/css/style.css">
    <style>
        .payment-container {
            max-width: 800px;
            margin: 50px auto;
        }

        .order-summary {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            background: #f9f9f9;
        }

        .order-summary h4 {
            color: #333;
            margin-bottom: 15px;
            border-bottom: 2px solid #fb774b;
            padding-bottom: 10px;
        }

        .payment-box {
            background: #fff;
            border: 2px solid #fb774b;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            margin-top: 30px;
        }

        .payment-box h3 {
            color: #fb774b;
            margin-bottom: 15px;
        }

        .pay-now-btn {
            background-color: #fb774b;
            color: white;
            border: none;
            padding: 15px 50px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
        }

        .pay-now-btn:hover {
            background-color: #e3663d;
        }

        .success-msg {
            color: #28a745;
            font-size: 20px;
            font-weight: bold;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .summary-row:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 1.1em;
            color: #fb774b;
        }

        .cart-item-row {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            gap: 15px;
        }

        .cart-item-row img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }

        .cart-item-row:last-child {
            border-bottom: none;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar1 d-flex justify-content-between bg-light p-4 text-center shadow">
        <ul class="list-unstyled ms-5 text-dark d-flex align-items-center gap-2">
            <img class="rounded-circle" style="width: 50px; height: 50px;" src="./assests/img/AUB.png" alt="Logo">
            <li class="fw-bold">Aub Shop</li>
        </ul>
        <ul class="d-flex list-unstyled me-5 gap-5 text-decoration-none">
            <li><a href="index.php" class="text-decoration-none text-black">Home</a></li>
            <li><a href="Shop.html" class="text-decoration-none text-black">Shop</a></li>
            <li><a href="contact.html" class="text-decoration-none text-black">Contact Us</a></li>
        </ul>
    </nav>

    <?php if ($payment_success): ?>
        <!-- Payment Success -->
        <div class="container payment-container text-center">
            <div class="payment-box">
                <h3>&#127873; Payment Successful!</h3>
                <p class="success-msg">Your order has been paid successfully.</p>
                <hr>
                <p><strong>Order ID:</strong> #<?php echo $order_id; ?></p>
                <p><strong>Transaction ID:</strong> <?php echo $transaction_id; ?>-PAID</p>
                <p><strong>Total Paid:</strong> $<?php echo number_format($order_cost, 2); ?></p>
                <p>Thank you for your purchase, <?php echo htmlspecialchars($user_name); ?>!</p>
                <a href="index.php" class="btn btn-dark mt-3">Continue Shopping</a>
            </div>
        </div>
    <?php else: ?>
        <!-- Payment Page - Before Pay -->
        <div class="container payment-container">
            <h2 class="text-center my-4">Payment</h2>
            <hr class="mx-auto" style="width: 50px; border: 2px solid #fb774b;">

            <!-- Order Summary -->
            <div class="order-summary mb-4">
                <h4>Order Summary</h4>

                <p><strong>Order ID:</strong> #<?php echo $order_id; ?></p>
                <p><strong>Transaction ID:</strong> <?php echo $transaction_id; ?></p>

                <!-- Customer Info -->
                <h5 class="mt-3">Customer Information</h5>
                <div class="summary-row">
                    <span>Name:</span>
                    <span><?php echo htmlspecialchars($user_name); ?></span>
                </div>
                <div class="summary-row">
                    <span>Email:</span>
                    <span><?php echo htmlspecialchars($user_email); ?></span>
                </div>
                <div class="summary-row">
                    <span>Phone:</span>
                    <span><?php echo htmlspecialchars($user_phone); ?></span>
                </div>
                <div class="summary-row">
                    <span>City:</span>
                    <span><?php echo htmlspecialchars($user_city); ?></span>
                </div>
                <div class="summary-row">
                    <span>Address:</span>
                    <span><?php echo htmlspecialchars($user_address); ?></span>
                </div>

                <!-- Order Items -->
                <h5 class="mt-3">Order Items</h5>
                <?php while ($item = $order_items->fetch_assoc()): ?>
                    <div class="cart-item-row">
                        <img src="./assests/img/<?php echo $item['product_image']; ?>" alt="<?php echo $item['product_name']; ?>">
                        <div style="flex: 1;">
                            <p class="mb-0 fw-bold"><?php echo $item['product_name']; ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>

                <!-- Total -->
                <div class="summary-row" style="font-size: 1.2em; margin-top: 15px;">
                    <span>Total:</span>
                    <span>$<?php echo number_format($order_cost, 2); ?></span>
                </div>
            </div>

            <!-- Payment Box -->
            <div class="payment-box">
                <h3>&#128179; Ready to Pay</h3>
                <p>Please review your order details above and click <strong>Pay Now</strong> to complete your purchase.</p>
                <form method="POST" action="">
                    <button type="submit" name="pay_now" class="pay-now-btn">&#128178; Pay Now - $<?php echo number_format($order_cost, 2); ?></button>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <!-- Footer -->
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
<?php $con->close(); ?>