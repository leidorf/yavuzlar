<?php
$host = "localhost";
$db = "restaurant-app";
$user = "restaurant-app";
$password = "password";

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (\Throwable $th) {
    echo "Hata: " . $th;
}
