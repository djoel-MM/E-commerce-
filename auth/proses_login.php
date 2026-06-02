<?php
session_start();




$conn = mysqli_connect("localhost", "root", "", "ecommerce_db");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}



if (isset($_POST['login'])) {
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user  = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id'    => $user['id'],
            'name'  => $user['name'],
            'email' => $user['email']
        ];
        header("Location: ../user.php");
        exit;
    } else {
        echo "Login gagal";
    }
}

$_SESSION ['user'] = $userdata;
session_regenerate_id(true);
header("Location: ../user.php");
exit;