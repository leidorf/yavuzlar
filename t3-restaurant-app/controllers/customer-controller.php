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
    $statement->execute(["user_id" => $user_id, "restaurant_id" => $restaurant_id, "username" => $username, "title" => $title, "description" => $description, "score" => $score, "created_at" => $created_at, "updated_at" => $created_at]);
}

function GetAvgScore($restaurant_id)
{
    global $pdo;
    $restaurant_id = htmlclean($restaurant_id);
    $query = "SELECT AVG(score) FROM comments WHERE restaurant_id = :restaurant_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["restaurant_id" => $restaurant_id]);
    return $statement->fetchColumn();
}

function DeleteComment($comment_id)
{
    global $pdo;
    $comment_id = htmlclean($comment_id);
    $updated_at = (new DateTime())->format('Y-m-d H:i:s');

    $query = "UPDATE comments SET title=:title, description=:description, score=:score, updated_at =:updated_at WHERE id = :comment_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["title" => "[deleted]", "description" => "[deleted]", "score" => null, "updated_at" => $updated_at, "comment_id" => $comment_id]);
}

function GetBasketDatas($user_id)
{
    global $pdo;
    $user_id = htmlclean($user_id);
    $query = "SELECT
    food.id AS food_id,
    food.price AS food_price,
    food.discount AS food_discount,
    basket.id AS basket_id,
    basket.user_id AS basket_user_id,
    basket.food_id AS basket_food_id,
    basket.note AS basket_note,
    basket.quantity AS basket_quantity,
    basket.created_at AS basket_created_at FROM food INNER JOIN basket ON food.id = basket.food_id WHERE basket.user_id = :user_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["user_id" => $user_id]);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function UpdateBalance($user_id, $total_price)
{
    global $pdo;
    $user_id = htmlclean($user_id);
    $total_price = htmlclean($total_price);
    $query = "UPDATE users SET balance = balance + :total_price WHERE id= :user_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["total_price" => -$total_price, "user_id" => $user_id]);
    $_SESSION['balance'] -= $total_price;
}

function AddOrderItems($food_id, $order_id, $quantity, $price)
{
    global $pdo;
    $food_id = htmlclean($food_id);
    $order_id = htmlclean($order_id);
    $quantity = htmlclean($quantity);
    $price = htmlclean($price);
    $query = "INSERT INTO order_items(food_id, order_id, quantity, price) VALUES (:food_id, :order_id, :quantity, :price)";
    $statement = $pdo->prepare($query);
    $statement->execute(["food_id" => $food_id, "order_id" => $order_id, "quantity" => $quantity, "price" => $price]);
}

function ConfirmBasket($user_id)
{
    global $pdo;
    $user_id = htmlclean($user_id);
    $datas = GetBasketDatas($user_id);
    $created_at = (new DateTime())->format('Y-m-d H:i:s');
    $total_price = 0;
    foreach ($datas as $data) {
        $data['food_price'] = is_null(value: $data['food_discount'])?: $data['food_price'] * (100 - $data['food_discount']) / 100;
        $total_price += $data['food_price'] * $data['basket_quantity'];
    }
    $query = "INSERT INTO `order` (user_id, total_price, created_at) VALUES (:user_id, :total_price, :created_at)";
    $statement = $pdo->prepare($query);
    $statement->execute(["user_id" => $user_id, "total_price" => $total_price, "created_at" => $created_at]);

    $order_id = $pdo->lastInsertId();

    foreach ($datas as $data) {
        $data['food_price'] = is_null(value: $data['food_discount'])?: $data['food_price'] * (100 - $data['food_discount']) / 100;
        DeleteFromBasket($data['basket_id']);
        AddOrderItems($data['food_id'], $order_id, $data['basket_quantity'], $data['food_price']);
    }

    UpdateBalance($user_id, $total_price);
}

function GetOrders($user_id)
{
    global $pdo;
    $user_id = htmlclean($user_id);
    $query = "SELECT * FROM `order` WHERE user_id =:user_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["user_id" => $user_id]);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}
