<?php
session_start();

// 1. Handle "Add to Cart"
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];

    if (isset($_SESSION['cart'])) {
        $products_array_ids = array_column($_SESSION['cart'], "product_id");

        if (!in_array($product_id, $products_array_ids)) {
            $product_array = array(
                'product_id' => $_POST['product_id'],
                'product_name' => $_POST['product_name'],
                'product_price' => $_POST['product_price'],
                'product_image' => $_POST['product_image'],
                'product_quantity' => $_POST['product_quantity']
            );
            $_SESSION['cart'][$product_id] = $product_array;
        } else {
            echo '<script>alert("Product was already added to cart");</script>';
        }
    } else {
        $product_array = array(
            'product_id' => $_POST['product_id'],
            'product_name' => $_POST['product_name'],
            'product_price' => $_POST['product_price'],
            'product_image' => $_POST['product_image'],
            'product_quantity' => $_POST['product_quantity']
        );
        $_SESSION['cart'][$product_id] = $product_array;
    }
    calculateTotal();

    // 2. Handle "Remove"
} elseif (isset($_GET['remove_id'])) {
    $product_id = $_GET['remove_id'];
    unset($_SESSION['cart'][$product_id]);
    calculateTotal();

    // 3. Handle "Edit Quantity"
} elseif (isset($_POST['edit_quantity'])) {
    $product_id = $_POST['product_id'];
    $product_quantity = $_POST['product_quantity'];
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['product_quantity'] = $product_quantity;
    }
    calculateTotal();
}

function calculateTotal()
{
    $total = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $value) {
            $total += ($value['product_price'] * $value['product_quantity']);
        }
    }
    $_SESSION['total'] = $total;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Aub Shop - Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assests/css/style.css">
</head>

<body>
    <nav class="navbar1 d-flex justify-content-between bg-light p-4 text-center shadow">
        <ul class="list-unstyled ms-5 text-dark d-flex align-items-center gap-2">
            <img class="rounded-circle" style="width: 50px; height: 50px;" src="./assests/img/AUB.png">
            <li class="fw-bold">Aub Shop</li>
        </ul>
        <ul class="d-flex list-unstyled me-5 gap-5 align-items-center">
            <li><a href="index.php" class="text-decoration-none text-black">Home</a></li>
            <li><a href="shop.php" class="text-decoration-none text-black">Shop</a></li>
        </ul>
    </nav>

    <div class="container my-5 pt-5">
        <h2 class="fw-bold">Your Cart</h2>
        <table class="table mt-4">
            <thead class="table-dark">
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { ?>
                    <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-4">
                                    <img src="./assests/img/<?php echo $value['product_image']; ?>" style="width: 100px;">
                                    <div>
                                        <p class="mb-1 fw-bold"><?php echo $value['product_name']; ?></p>
                                        <small>$<?php echo $value['product_price']; ?></small><br>
                                        <a href="cart.php?remove_id=<?php echo $value['product_id']; ?>" class="text-danger small">Remove</a>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <form method="POST" action="cart.php" class="d-flex gap-2">
                                    <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>">
                                    <input type="number" name="product_quantity" value="<?php echo $value['product_quantity']; ?>" class="form-control" style="width: 70px;">
                                    <button type="submit" name="edit_quantity" class="btn btn-sm btn-outline-dark">Update</button>
                                </form>
                            </td>
                            <td class="align-middle fw-bold">
                                $<?php echo number_format($value['product_quantity'] * $value['product_price'], 2); ?>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="3" class="text-center p-5">Your cart is empty.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-end mt-4">
            <div class="border p-4 rounded bg-light" style="width: 300px;">
                <div class="d-flex justify-content-between mb-3 fw-bold border-top pt-2">
                    <span>Total:</span>
                    <span>$<?php echo isset($_SESSION['total']) ? number_format($_SESSION['total'], 2) : '0.00'; ?></span>
                </div>

                <?php
                // Logic: Determine destination based on cart count
                $target_page = (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) ? "checkout.php" : "index.php";
                ?>

                <form method="POST" action="<?php echo $target_page; ?>">
                    <input type="submit" class="btn btn-dark w-100" value="Checkout Now" name="checkout">
                </form>
            </div>
        </div>
    </div>
</body>

</html>