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

function AddtoBasket($user_id, $food_id, $note)
{
    global $pdo;
    $user_id = htmlclean($user_id);
    $food_id = htmlclean($food_id);
    $note = htmlclean($note);
    $created_at = (new DateTime())->format('Y-m-d H:i:s');
    $result = CheckQuantity($user_id, $food_id);
    if ($result) {
        $query = "UPDATE basket SET quantity = quantity+1 WHERE user_id = :user_id AND food_id = :food_id";
        $statement = $pdo->prepare($query);
        $statement->execute(["user_id" => $user_id, "food_id" => $food_id]);
    } else {
        $query = "INSERT INTO basket(user_id, food_id, note, quantity, created_at) VALUES(:user_id, :food_id, :note, :quantity, :created_at)";
        $statement = $pdo->prepare($query);
        $statement->execute(["user_id" => $user_id, "food_id" => $food_id, "note" => "$note", "quantity" => 1, "created_at" => $created_at]);
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

function EditQuantity($basket_id, $value)
{
    global $pdo;
    $basket_id = htmlclean($basket_id);
    $value = htmlclean($value);
    $query = "UPDATE basket SET quantity = quantity +:value WHERE id = :basket_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["value" => $value, "basket_id" => $basket_id]);
    $food_quantity = CheckQuantityByID($basket_id);
    if ($food_quantity['quantity'] <= 0) {
        DeleteFromBasket($basket_id);
    }
}

function CheckQuantityByID($basket_id)
{
    global $pdo;
    $basket_id = htmlclean($basket_id);
    $query = "SELECT quantity FROM basket WHERE id = :basket_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["basket_id" => $basket_id]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function EditNote($basket_id, $note)
{
    global $pdo;
    $basket_id = htmlclean($basket_id);
    $note = htmlclean($note);
    $query = "UPDATE basket SET note = :note WHERE id = :basket_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["note" => $note, "basket_id" => $basket_id]);
}

function GetComments($restaurant_id)
{
    global $pdo;
    $restaurant_id = htmlclean($restaurant_id);
    $query = "SELECT
    comments.id AS comments_id,
    comments.user_id AS comments_user_id,
    comments.restaurant_id AS comments_restaurant_id,
    comments.username AS comments_username,
    comments.title AS comments_title,
    comments.description AS comments_description,
    comments.score AS comments_score,
    comments.created_at AS comments_created_at,
    comments.updated_at AS comments_updated_at,
    restaurant.name AS restaurant_name,
    restaurant.description AS restaurant_description,
    restaurant.image_path AS restaurant_image_path,
    restaurant.created_at AS restaurant_created_at FROM comments INNER JOIN restaurant ON comments.restaurant_id = restaurant.id WHERE comments.restaurant_id = :restaurant_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["restaurant_id" => $restaurant_id]);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function AddComment($restaurant_id, $title, $description, $score)
{
    global $pdo;
    $user_id = htmlclean($_SESSION['user_id']);
    $username = htmlclean($_SESSION['username']);
    $restaurant_id = htmlclean($restaurant_id);
    $title = htmlclean($title);
    $description = htmlclean($description);
    $score = htmlclean($score);
    $created_at = (new DateTime())->format('Y-m-d H:i:s');

    $query = "INSERT INTO comments(user_id, restaurant_id, username, title, description, score, created_at, updated_at) VALUES(:user_id, :restaurant_id, :username, :title, :description, :score, :created_at, :updated_at)";
    $statement = $pdo->prepare($query);
    $statement->execute(["user_id"=>$user_id, "restaurant_id"=>$restaurant_id, "username"=>$username, "title"=>$title, "description"=>$description, "score"=>$score, "created_at"=>$created_at, "updated_at"=>$created_at]);
}

function GetAvgScore($restaurant_id){
    global $pdo;
    $restaurant_id = htmlclean($restaurant_id);
    $query = "SELECT AVG(score) FROM comments WHERE restaurant_id = :restaurant_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["restaurant_id"=>$restaurant_id]);
    return $statement->fetchColumn();
}