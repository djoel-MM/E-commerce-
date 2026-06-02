<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "ecommerce_db");
if (!$conn) die("Koneksi gagal");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name  = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $cek = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
    if (mysqli_num_rows($cek) > 0) {
        die("Email sudah terdaftar");
    }

    $query = "INSERT INTO users
    (name, email, password, created_at)
    VALUES
    ('$name', '$email', '$password', NOW())";

    mysqli_query($conn, $query) or die(mysqli_error($conn));

    header("Location: login.php");
    exit;
}
