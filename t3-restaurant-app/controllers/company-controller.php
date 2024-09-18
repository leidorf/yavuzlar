<?php
include "../config/db.php";

function GetRestaurantByCId($company_id)
{
    global $pdo;
    $query = "SELECT * FROM restaurant WHERE company_id = :company_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["company_id" => $company_id]);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function AddRestaurant($company_id, $name, $description, $image_path)
{
    global $pdo;
    $company_id = htmlclean($company_id);
    $name = htmlclean($name);
    $description = htmlclean($description);
    $image_path = htmlclean($image_path);
    $created_at = (new DateTime())->format('Y-m-d H:i:s');

    $query = "INSERT INTO restaurant(company_id, name, description, image_path, created_at) VALUES(:company_id, :name, :description, :image_path, :created_at)";
    $statement = $pdo->prepare($query);
    $statement->execute(["company_id"=>$company_id, "name" => $name, "description" => $description, "image_path" => $image_path, "created_at"=>$created_at]);
}

function AddFood($restaurant_id, $name, $description, $image_path, $price, $discount){
    global $pdo;
    $restaurant_id = htmlclean($restaurant_id);
    $name = htmlclean($name);
    $description = htmlclean($description);
    $image_path = htmlclean($image_path);
    $price = htmlclean($price);
    $discount = htmlclean($discount);
    $created_at = (new DateTime())->format('Y-m-d H:i:s');

    $query = "INSERT INTO food(restaurant_id, name, description, image_path, price, discount, created_at) VALUES(:restaurant_id, :name, :description, :image_path, :price, :discount, :created_at)";
    $statement = $pdo->prepare($query);
    $statement->execute(["restaurant_id"=>$restaurant_id, "name"=>$name, "description"=>$description, "image_path"=>$image_path, "price"=>$price, "discount"=>$discount, "created_at"=>$created_at]);
}

function DeleteFood($food_id){
    global $pdo;
    $food_id = htmlclean($food_id);
    $deleted_at = (new DateTime())->format('Y-m-d H:i:s');
    $query="UPDATE food SET deleted_at = :deleted_at WHERE id = :food_id";
    $statement=$pdo->prepare($query);
    $statement->execute(["deleted_at"=>$deleted_at, "food_id"=>$food_id]);
}

function GetFoodById($food_id){
    global $pdo;
    $query = "SELECT * FROM food WHERE id = :food_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["food_id"=>$food_id]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function UpdateFood($food_id, $restaurant_id, $name, $description, $image_path, $price, $discount){
    global $pdo;
    $food_id = htmlclean($food_id);
    $restaurant_id = htmlclean($restaurant_id);
    $name = htmlclean($name);
    $description = htmlclean($description);
    $image_path = htmlclean($image_path);
    $price = htmlclean($price);
    $discount = htmlclean($discount);
    $created_at = (new DateTime())->format('Y-m-d H:i:s');

    $query = "UPDATE food SET restaurant_id = :restaurant_id, name = :name, description = :description, image_path = :image_path, price = :price, discount = :discount, created_at = :created_at WHERE id = :food_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["restaurant_id"=>$restaurant_id, "name"=>$name, "description"=>$description, "image_path"=>$image_path, "price"=>$price, "discount"=>$discount, "created_at"=>$created_at, "food_id" => $food_id]);
}

function GetRestaurantById($restaurant_id){
    global $pdo;
    $restaurant_id = htmlclean($restaurant_id);
    $query = "SELECT * FROM restaurant WHERE id = :restaurant_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["restaurant_id"=>$restaurant_id]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function UpdateRestaurant($restaurant_id, $name, $description, $image_path){
    global $pdo;
    $restaurant_id = htmlclean($restaurant_id);
    $name = htmlclean($name);
    $description = htmlclean($description);
    $image_path = htmlclean($image_path);

    $query = "UPDATE restaurant SET name = :name, description = :description, image_path = :image_path WHERE id = :restaurant_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["name"=>$name, "description"=>$description, "image_path"=>$image_path, "restaurant_id"=>$restaurant_id]);
}

function DeleteRestaurant($restaurant_id){
    global $pdo;
    $restaurant_id = htmlclean($restaurant_id);
    $query="DELETE FROM restaurant WHERE id = :restaurant_id";
    $statement=$pdo->prepare($query);
    $statement->execute(["restaurant_id"=>$restaurant_id]);
}