<?php
session_start();
include "./functions.php";
include "../config/db.php";
if(isset($_POST['username']) && isset($_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    Login($username,$password);
    header("Location: index.php");
    exit();
}else{
    
}