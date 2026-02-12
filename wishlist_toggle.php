<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "ecommerce_db");
if (!$conn) {
    exit("Koneksi gagal");
}

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    exit("Harus login");
}

$user_id    = (int) $_SESSION['user']['id'];
$product_id = (int) $_POST['product_id'];

// cek sudah difavoritkan atau belum
$cek = mysqli_query(
    $conn,
    "SELECT id FROM favorite_products
     WHERE user_id=$user_id AND product_id=$product_id"
);

if (mysqli_num_rows($cek) > 0) {
    // sudah ada → hapus
    mysqli_query(
        $conn,
        "DELETE FROM favorite_products
         WHERE user_id=$user_id AND product_id=$product_id"
    );
} else {
    // belum ada → tambah
    mysqli_query(
        $conn,
        "INSERT INTO favorite_products (user_id, product_id)
         VALUES ($user_id, $product_id)"
    );
}

echo json_encode([
    "status" => "success",
    "message" => "Wishlist updated",
    "data" => [
        "product_id" => $product_id
    ]
]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="favorite.php">Go to Favorite Page</a>
</body>
</html>