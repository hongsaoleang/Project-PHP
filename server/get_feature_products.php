<?php
include('connection.php');
$stmt = $con ->prepare("SELECT * FROM products LIMIT 4");
$stmt->execute();
$feature_products = $stmt->get_result();
?>