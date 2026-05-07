<?php
include('server/connection.php');

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $stmt = $con->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $products = $stmt->get_result();

    if ($products->num_rows == 0) {
        header('location: index.php');
    }
} else {
    header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aub Shop - Single Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assests/css/style.css">
    <style>
        .mainImage {
            width: 100%;
            height: auto;
            border-radius: 8px;
            object-fit: cover;
        }

        .small-img-group {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .small-img-col {
            flex-basis: 24%;
            cursor: pointer;
            transition: 0.3s;
        }

        .small-img-col:hover {
            opacity: 0.7;
        }

        footer {
            margin-top: 50px;
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
            <li>
                <div class="d-flex gap-2">
                    <button class="btn btn-dark btn-sm" id="changebackgorund">DARK</button>
                    <button class="btn btn-outline-dark btn-sm" id="backbackground">LIGHT</button>
                </div>
            </li>
        </ul>
    </nav>

    <section class="container my-5 pt-5">
        <div class="row">
            <?php while ($row = $products->fetch_assoc()) { ?>
                <div class="col-lg-5 col-md-12 col-12">
                    <img class="mainImage img-fluid shadow-sm" src="./assests/img/<?php echo $row['product_image']; ?>" id="MainImg">
                    <div class="small-img-group">
                        <div class="small-img-col">
                            <img src="./assests/img/<?php echo $row['product_image']; ?>" width="100%" class="small-img border rounded">
                        </div>
                        <div class="small-img-col">
                            <img src="./assests/img/<?php echo $row['product_image2']; ?>" width="100%" class="small-img border rounded">
                        </div>
                        <div class="small-img-col">
                            <img src="./assests/img/<?php echo $row['product_image3']; ?>" width="100%" class="small-img border rounded">
                        </div>
                        <div class="small-img-col">
                            <img src="./assests/img/<?php echo $row['product_image4']; ?>" width="100%" class="small-img border rounded">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 col-12 ps-lg-5 mt-4 mt-lg-0">
                    <h6 class="text-muted">Home / <?php echo $row['product_category']; ?></h6>
                    <h2 class="py-2"><?php echo $row['product_name']; ?></h2>
                    <h3 class="text-danger fw-bold">$<?php echo $row['product_price']; ?></h3>

                    <form method="POST" action="cart.php">
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>">

                        <div class="d-flex gap-3 my-4">
                            <input type="number" value="1" name="product_quantity" class="form-control" style="width: 70px;">
                            <button type="submit" name="add_to_cart" class="btn btn-dark px-4 py-2 rounded-2">ADD TO CART</button>
                        </div>

                        <h4 class="mt-5">Product Details</h4>
                        <p class="text-secondary mt-3"><?php echo $row['product_description']; ?></p>
                    </form>
                </div>
            <?php } ?>
        </div>
    </section>

    <footer class="bg-dark p-5 text-white text-center">
        <p>&copy; 2026 Aub Shop. All Rights Reserved.</p>
    </footer>

    <script>
        const mainImg = document.getElementById('MainImg');
        const smallImgs = document.getElementsByClassName('small-img');

        for (let i = 0; i < smallImgs.length; i++) {
            smallImgs[i].onclick = function() {
                mainImg.src = smallImgs[i].src;
            };
        }

        document.getElementById('changebackgorund').onclick = function() {
            document.body.style.backgroundColor = "#1a1a1a";
            document.body.style.color = "white";
        };

        document.getElementById('backbackground').onclick = function() {
            document.body.style.backgroundColor = "white";
            document.body.style.color = "black";
        };
    </script>
</body>

</html>