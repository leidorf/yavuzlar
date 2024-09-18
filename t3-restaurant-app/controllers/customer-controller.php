<?php
require_once "../scripts/functions.php";

function UpdateProfile($name,$surname,$username){
    global $pdo;
    if($_SERVER['REQUEST_METHOD']=="POST"){
        include "../config/db.php";
        $id = $_SESSION['user_id'];
        $name = htmlclean($_POST['name']);
        $surname = htmlclean($_POST['surname']);
        $username = htmlclean($_POST['username']);
        $query = "UPDATE users SET name = :name, surname = :surname, username = :username WHERE id = :id";
        $statement = $pdo->prepare($query);
        $statement->execute(['name' => $name, 'surname' => $surname, 'username' => $username, 'id' => $id]);
        $_SESSION['name'] = $name;
        $_SESSION['surname'] = $surname;
        $_SESSION['username'] = $username;
    }
}

function AddBalance($amount){
    global $pdo;
    if($_SERVER['REQUEST_METHOD']=="POST"){
        include "../config/db.php";
        $id = $_SESSION['user_id'];
        $amount = htmlclean($amount);
        $query = "UPDATE users SET balance = balance+ :amount WHERE id = :id";
        $statement = $pdo->prepare($query);
        $statement->execute(['amount'=>$amount, 'id'=>$id]);
        $_SESSION['balance'] += $amount;
    }
}

function UpdatePassword($current_password, $new_password){
    global $pdo;
    if($_SERVER['REQUEST_METHOD']=="POST"){
        require_once "auth-controller.php";
        $user = FindUser($_SESSION['username']);
        if (password_verify($current_password, $user['password'])) {
            $id = $_SESSION['user_id'];
            $encrypted_password = password_hash($new_password, PASSWORD_ARGON2ID);
            $query = "UPDATE users SET password = :encrypted_password WHERE id = :id";
            $statement = $pdo->prepare($query);
            $statement->execute(['encrypted_password'=>$encrypted_password, 'id'=>$id]);
        }else{
            header ("Location: ../view/profile.php?message=Lütfen mevcut şifrenizi doğru giriniz.");
            exit();
        }
    }
}

function GetFoods(){
    global $pdo;
    $query = "SELECT * FROM food";
    $statement=$pdo->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}