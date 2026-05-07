<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="./assests/css/style.css">

</head>

<body>
    <!-- Navbar -->
    <div class="navbar1 d-flex justify-content-between bg-light p-4 text-center shadow">
        <ul class="list-unstyled ms-5 text-dark">
            <img class="rounded-circle" style="width: 50px; height: 50px    ;" src="./assests/img/AUB.png" alt="">
            <li class="fw-bold">Aub Shop</li>
        </ul>
        <ul class="d-flex list-unstyled me-5 gap-5 link text-decoration-none">
            <li><a href="./index.php" class="text-decoration-none text-black ">Home</a></li>
            <li><a href="./Shop.html" class="text-decoration-none text-black ">Shop</a></li>
            <li><a href="" class="text-decoration-none text-black ">Blog</a></li>
            <li><a href="./contact.html" class="text-decoration-none text-black ">Contact Us</a></li>
            <li>
                <a href="./cart.html"><i class="fas fa-shopping-bag">Cart</i></a>
                <a href="./account.html" class=""><i class="fas fa-user">Account</i></a>
            </li>
            <li class="">
                <ul class="list-unstyled fw-bold">
                    <li class="bg-dark ps-3 pt-1 pb-1 pe-3 m-2 rounded-2 text-white" id="changebackgorund">COLOR BLACK</li>
                    <li class="bg-dark ps-3 pt-1 pb-1 pe-3 m-2 rounded-2 text-white" id="backbackground">BACK COLOR</li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- Home -->
    <div id="box1" class="box1" style="height: 736px; width: 100%;">
        <div class="d-flex justify-content-center gap-5 align-items-center h-100 w-100">
            <div class="me-5 mb-5">
                <p>NEW ARRIVALS</p>
                <div class="d-flex">
                    <p class="fw-bold fs-3 me-2 text-warning ">Best Prices </p>
                    <p class="fw-bold fs-3"> This Season</p>
                </div>
                <p>Eshop offers the best products for the most affordable prices</p>
                <div class="btn btnShop bg-dark text-white w-25 text-center p-2 rounded-1">
                    SHOP NOW
                </div>
            </div>
            <div class="">
                <img class="img1" style="width: 300px; height: 450px;"
                    src="./assests/img/young-handsome-man-wearing-jeans-jaket-studio.jpg" alt="">
            </div>
        </div>
    </div>
    <!-- Brand -->
    <div class=" p-5 d-flex justify-content-evenly mt-5 align-items-center" style="height: 450px;">
        <img class=" prime2 rounded-2 opacity-100 shadow" src="./assests/img/image1.png"
            style="width: 300px; height: 300px;" alt="">
        <img class=" prime2 rounded-2 opacity-100 shadow" src="./assests/img/image2.png"
            style="width: 300px; height: 300px;" alt="">
        <img class=" prime2 rounded-2 opacity-100 shadow" src="./assests/img/image6.png"
            style="width:  300px; height: 300px;" alt="">
        <img class=" prime2 rounded-2 opacity-100 shadow" src="./assests/img/image4.png"
            style="width: 300px; height: 300px;" alt="">
    </div>

    <div class=" gap-5 d-flex justify-content-evenly mt-5 bg-light p-4 shadow opacity-75">
        <div class="prime1 d-flex flex-column">
            <img class=" shadow rounded-2" style="height: 400px; width: 350px;" src="./assests/img/image8.png" alt="">
            <button class="btn1 bg-dark text-white border border-none rounded-1"
                style="width: 100px; height:40px   ;">See more...</button>
        </div>
        <div class="prime1 d-flex flex-column">
            <img class="prime1 shadow rounded-2" style="height: 400px; width: 350px;" src="./assests/img/bag1.png"
                alt="">
            <button class="btn1 bg-dark text-white border border-none rounded-1"
                style="width: 100px; height:40px   ;">See more...</button>
        </div>
        <div class="prime1 d-flex flex-column ">
            <img class="prime1 shadow rounded-2" style="height: 400px; width: 350px;" src="./assests/img/watch1.png"
                alt="">
            <button class="btn1 bg-dark text-white border border-none rounded-1"
                style="width: 100px; height:40px   ;">See more...</button>
        </div>
    </div>
    <div class="p-4 w-100 text-center">
        <h3>Our Featured</h3>
        <div class="bg-danger " style="width: 50px; height: 3px;position: relative; left: 49%;"></div>
        <p class="mt-3">Here you can check out our featured products</p>
    </div>
    <div class=" d-flex p-5 w-100 justify-content-evenly">
        <?php include('./server/get_coat.php') ?>

        <?php while ($row = $coats_products->fetch_assoc()) { ?>
            <div class="hking text-center" onclick="window.location.href='SingleProduct.html';">
                <img class="rounded-2 shadow" style="width: 300px; height: 300px;" src="./assests/img/<?php echo $row['product_image']; ?>" alt="">
                <div>
                    <p class="mt-2">&#11088;&#11088;&#11088;&#11088;&#11088;</p>
                    <h5><?php echo $row['product_name']; ?></h5>
                    <h6><?php echo $row['product_price']; ?></h6>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="p-4 w-100 text-center">
        <h3>Our Featured</h3>
        <div class="bg-danger " style="width: 50px; height: 3px;position: relative; left: 49%;"></div>
        <p class="mt-3">Here you can check out our featured products</p>
    </div>
    <div class="d-flex p-5 w-100 justify-content-evenly">
        <div class="hking text-center">
            <img class="rounded-2 shadow" style="width: 300px; height: 300px;" src="./assests/img/image1.png" alt="">
            <div>
                <p class="mt-2">&#11088;&#11088;&#11088;&#11088;&#11088;</p>
                <p>Yellow Shoes</p>
                <h6>$ 200</h6>
            </div>
        </div>
        <div class="hking text-center">
            <img class="rounded-2 shadow" style="width: 300px; height: 300px;" src="./assests/img/image3.png" alt="">
            <div>
                <p class="mt-2">&#11088;&#11088;</p>
                <p>Green Prime</p>
                <h6>$ 200</h6>
            </div>
        </div>
        <div class="hking text-center">
            <img class="rounded-2 shadow" style="width: 300px; height: 300px;" src="./assests/img/image8.png" alt="">
            <div>
                <p class="mt-2"> &#11088;&#11088;&#11088;&#11088;</p>
                <p>King Shoes</p>
                <h6>$ 200</h6>
            </div>
        </div>
        <div class="hking text-center">
            <img class="rounded-2 shadow" style="width: 300px; height: 300px;" src="./assests/img/image4.png" alt="">
            <div>
                <p class="mt-2">&#11088;&#11088;&#11088;</p>
                <p>King Of Pirate</p>
                <h6>$ 200</h6>
            </div>
        </div>
        <div class="hking text-center">
            <img class="rounded-2 shadow" style="width: 300px; height: 300px;" src="./assests/img/image5.png" alt="">
            <div>
                <p class="mt-2">&#11088;&#11088;&#11088;</p>
                <p>lil</p>
                <h6>$ 200</h6>
            </div>
        </div>
    </div>
    <div class="p-4 w-100 text-center">
        <h3>Our Featured</h3>
        <div class="bg-danger " style="width: 50px; height: 3px;position: relative; left: 49%;"></div>
        <p class="mt-3">Here you can check out our featured products</p>
    </div>
    <div class="d-flex p-5 w-100 justify-content-evenly">
        <?php include('./server/get_feature_products.php'); ?>

        <?php while ($row = $feature_products->fetch_assoc()) {
        ?>
            <div class="hking text-center">
                <img class="rounded-2 shadow" style="width: 300px; height: 300px;" src="./assests/img/<?php echo $row['product_image']; ?>" alt="">
                <div>
                    <p class="mt-2">&#11088;&#11088;&#11088;&#11088;&#11088;</p>
                    <h5><?php echo $row['product_name']; ?></h5>
                    <h6><?php echo $row['product_price']; ?></h6>
                    <a href="<?php echo "SingleProduct.php?product_id=". $row['product_id'] ?>">
                        <button class="buy-btn">But Now</button>
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
    <!-- Footer -->
    <div class="bg-dark p-5  d-flex text-white justify-content-evenly " style="width: auto; height: 400px;">
        <div>
            <img class="rounded-circle mb-4" style="width: 50px; height: 50px ;" src="./assests/img/image9.png" alt="">
            <p>We provide the best products for the most</p>
            <p>affordable prices</p>
            <ul class="list-unstyled text-dark">
                <img class="rounded-circle" style="width: 50px; height: 50px    ;" src="./assests/img/AUB.png" alt="">
                <li class="fw-bold">Aub Shop</li>
            </ul>
        </div>
        <div>
            <h2>Featured</h2>
            <p>MEN</p>
            <p>WOMEN</p>
            <b>BOYS</b>
            <p>GIRLS</p>
            <p>NEW ARRIVALS</p>
            <p>CLOTHES</p>
        </div>
        <div class="">
            <h2>Contact Us</h2>
            <h3>Address</h3>
            <p>Phnom penh toul sankea</p>
            <h3>PHONE</h3>
            <p>093779991</p>
            <h3>EMAIL</h3>
            <p>hongsaoleang@gmail.com</p>
        </div>
        <div>
            <h3>Instagram</h3>
            <div>
                <img class="rounded-2" style="height: 50px; width: 50px;" src="./assests/img/image1.png" alt="">
                <img class="rounded-2" style="height: 50px; width: 50px;" src="./assests/img/image1.png" alt="">
                <img class="rounded-2" style="height: 50px; width: 50px;" src="./assests/img/image1.png" alt="">
            </div>
        </div>
    </div>
    <script src="./assests/js/prime.js"></script>
</body>


</html>