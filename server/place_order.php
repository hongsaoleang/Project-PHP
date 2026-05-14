<?php
session_start();

// If cart is empty, send back to shop
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('location: index.php');
    exit;
}

// Handle place order
if (isset($_POST['place_order'])) {

    // 1. Get form data
    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $phone   = trim($_POST['phone']);
    $city    = trim($_POST['city']);
    $address = trim($_POST['address']);

    // 2. Basic validation
    if (empty($name) || empty($email) || empty($phone) || empty($city) || empty($address)) {
        die('All fields are required.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Please enter a valid email address.');
    }

    // 3. Connect to database
    require_once('connection.php');

    // 4. Check if user exists by email, or create a new one
    $check_user = $con->prepare("SELECT user_id FROM users WHERE user_email = ?");
    $check_user->bind_param("s", $email);
    $check_user->execute();
    $user_result = $check_user->get_result();

    if ($user_result->num_rows > 0) {
        $user = $user_result->fetch_assoc();
        $user_id = $user['user_id'];
    } else {
        // Create new user
        $create_user = $con->prepare("INSERT INTO users (user_name, user_email, user_password) VALUES (?, ?, '')");
        $create_user->bind_param("ss", $name, $email);
        $create_user->execute();
        $user_id = $con->insert_id;
    }

    // 5. Insert order into orders table
    $order_cost   = $_SESSION['total'];
    $order_status = 'on_hold';
    $phone_int    = (int)$phone;
    $insert_order = $con->prepare("INSERT INTO orders (order_cost, order_status, user_id, user_phone, user_city, user_address) VALUES (?, ?, ?, ?, ?, ?)");
    $insert_order->bind_param("dsiiss", $order_cost, $order_status, $user_id, $phone_int, $city, $address);
    $insert_order->execute();
    $order_id = $con->insert_id;

    // 6. Insert each product as an order item
    foreach ($_SESSION['cart'] as $product_id => $product) {
        $p_id    = $product['product_id'];
        $p_name  = $product['product_name'];
        $p_image = $product['product_image'];

        $insert_item = $con->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_image, user_id) VALUES (?, ?, ?, ?, ?)");
        $insert_item->bind_param("isssi", $order_id, $p_id, $p_name, $p_image, $user_id);
        $insert_item->execute();
    }

    // 7. Insert payment record
    $transaction_id = 'TXN-' . time() . '-' . $order_id;
    $insert_payment = $con->prepare("INSERT INTO payments (order_id, user_id, transaction_id) VALUES (?, ?, ?)");
    $insert_payment->bind_param("iis", $order_id, $user_id, $transaction_id);
    $insert_payment->execute();

    // 8. Fetch order details for payment page
    $get_order = $con->prepare("SELECT * FROM orders WHERE order_id = ?");
    $get_order->bind_param("i", $order_id);
    $get_order->execute();
    $order = $get_order->get_result()->fetch_assoc();

    // 9. Fetch order items for payment page
    $get_items = $con->prepare("SELECT * FROM order_items WHERE order_id = ?");
    $get_items->bind_param("i", $order_id);
    $get_items->execute();
    $order_items = $get_items->get_result();

    // 10. Store order info in session for payment page
    $_SESSION['order_id']       = $order_id;
    $_SESSION['order_cost']     = $order_cost;
    $_SESSION['order_status']   = $order_status;
    $_SESSION['transaction_id'] = $transaction_id;
    $_SESSION['user_name']      = $name;
    $_SESSION['user_email']     = $email;
    $_SESSION['user_phone']     = $phone;
    $_SESSION['user_city']      = $city;
    $_SESSION['user_address']   = $address;

    // 11. Clear cart session
    unset($_SESSION['cart']);
    unset($_SESSION['total']);

    // 12. Redirect to payment page
    header('location: payment.php');
    exit;

} else {
    header('location: index.php');
    exit;
}
?>