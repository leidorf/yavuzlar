<?php
require_once "../scripts/functions.php";

function UpdateProfile($name, $surname, $username)
{
    global $pdo;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
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

function AddBalance($amount)
{
    global $pdo;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        include "../config/db.php";
        $id = $_SESSION['user_id'];
        $amount = htmlclean($amount);
        $query = "UPDATE users SET balance = balance+ :amount WHERE id = :id";
        $statement = $pdo->prepare($query);
        $statement->execute(['amount' => $amount, 'id' => $id]);
        $_SESSION['balance'] += $amount;
    }
}

function UpdatePassword($current_password, $new_password)
{
    global $pdo;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        require_once "auth-controller.php";
        $user = FindUser($_SESSION['username']);
        if (password_verify($current_password, $user['password'])) {
            $id = $_SESSION['user_id'];
            $encrypted_password = password_hash($new_password, PASSWORD_ARGON2ID);
            $query = "UPDATE users SET password = :encrypted_password WHERE id = :id";
            $statement = $pdo->prepare($query);
            $statement->execute(['encrypted_password' => $encrypted_password, 'id' => $id]);
        } else {
            header("Location: ../view/profile.php?message=Lütfen mevcut şifrenizi doğru giriniz.");
            exit();
        }
    }
}

function GetFoods()
{
    global $pdo;
    $query = "SELECT * FROM food";
    $statement = $pdo->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function AddtoBasket($user_id, $food_id)
{
    global $pdo;
    $user_id = htmlclean($user_id);
    $food_id = htmlclean($food_id);
    $created_at = (new DateTime())->format('Y-m-d H:i:s');
    $result = CheckQuantity($user_id, $food_id);
    if ($result) {
        $query = "UPDATE basket SET quantity = quantity+1 WHERE user_id = :user_id AND food_id = :food_id";
        $statement = $pdo->prepare($query);
        $statement->execute(["user_id" => $user_id, "food_id" => $food_id]);
    } else {
        $query = "INSERT INTO basket(user_id, food_id, note, quantity, created_at) VALUES(:user_id, :food_id, :note, :quantity, :created_at)";
        $statement = $pdo->prepare($query);
        $statement->execute(["user_id" => $user_id, "food_id" => $food_id, "note" => "test", "quantity" => 1, "created_at" => $created_at]);
    }
}

function CheckQuantity($user_id, $food_id)
{
    global $pdo;
    $query = "SELECT quantity FROM basket WHERE user_id = :user_id AND food_id = :food_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["user_id" => $user_id, "food_id" => $food_id]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function GetBasket($user_id)
{
    global $pdo;
    $user_id = htmlclean($user_id);
    $query = "SELECT
    food.id AS food_id,
    food.restaurant_id AS food_restaurant_id,
    food.name AS food_name,
    food.description AS food_description,
    food.image_path AS food_image_path,
    food.price AS food_price,
    food.discount AS food_discount,
    basket.id AS basket_id,
    basket.user_id AS basket_user_id,
    basket.food_id AS basket_food_id,
    basket.note AS basket_note,
    basket.quantity AS basket_quantity FROM food INNER JOIN basket ON food.id = basket.food_id WHERE user_id = :user_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["user_id" => $user_id]);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function DeleteFromBasket($basket_id)
{
    global $pdo;
    $basket_id = htmlclean($basket_id);
    $query = "DELETE FROM basket WHERE id = :basket_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["basket_id" => $basket_id]);
}
