<?php
include "../config/db.php";
function GetUsers()
{
    global $pdo;
    $query = "SELECT
        users.id AS user_id,
        users.company_id AS user_company_id,
        users.name AS user_name,
        users.surname AS user_surname,
        users.username AS user_username,
        users.balance AS user_balance,
        users.created_at AS user_created_at,
        users.deleted_at AS user_deleted_at,
        company.name AS company_name,
        `order`.id AS order_id,
        `order`.total_price AS order_total_price,
        `order`.order_status AS order_status,
        `order`.created_at AS order_created_at FROM users LEFT JOIN company ON users.company_id = company_id LEFT JOIN `order` ON users.id = `order`.user_id";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    return $result;
}

function BanUser($user_id)
{
    global $pdo;
    $user_id = htmlclean($user_id);
    $deleted_at = (new DateTime())->format('Y-m-d H:i:s');
    $query = "UPDATE users SET deleted_at = :deleted_at WHERE id = :user_id";
    $statement = $pdo->prepare($query);
    $statement->execute(['deleted_at' => $deleted_at, 'user_id' => $user_id]);
}

function GetCompanies()
{
    global $pdo;
    $query = "SELECT * FROM company";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    return $result;
}

function AddCompany($name, $description, $logo_path)
{
    global $pdo;
    $name = htmlclean($name);
    $description = htmlclean($description);
    $logo_path = htmlclean($logo_path);
    $query = "INSERT INTO company(name, description, logo_path) VALUES(:name, :description, :logo_path)";
    $statement = $pdo->prepare($query);
    $statement->execute(["name" => $name, "description" => $description, "logo_path" => $logo_path]);
}

function BanCompany($company_id)
{
    global $pdo;
    $company_id = htmlclean($company_id);
    $deleted_at = (new DateTime())->format('Y-m-d H:i:s');
    $query = "UPDATE company SET deleted_at = :deleted_at WHERE id = :company_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["deleted_at" => $deleted_at, "company_id" => $company_id]);
}

function GetCompanyFoods($company_id)
{
    global $pdo;
    $company_id = htmlclean($company_id);
    $query = "SELECT
    restaurant.id AS restaurant_id,
    restaurant.company_id AS restaurant_company_id,
    restaurant.name AS restaurant_name,
    restaurant.description AS restaurant_description,
    restaurant.image_path AS restaurant_image_path,
    restaurant.created_at AS restaurant_created_at,
    food.id AS food_id,
    food.name AS food_name,
    food.description AS food_description,
    food.image_path AS food_image_path,
    food.price AS food_price,
    food.discount AS food_discount,
    food.deleted_at AS food_deleted_at,
    food.created_at AS food_created_at FROM restaurant LEFT JOIN food ON restaurant.id = food.restaurant_id WHERE company_id = :company_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["company_id" => $company_id]);
    $result = $statement->fetchAll();
    return $result;
}

function GetCupons()
{
    global $pdo;
    $query = "SELECT * FROM cupon";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    return $result;
}

function DeleteCupon($cupon_id)
{
    global $pdo;
    $cupon_id = htmlclean($cupon_id);
    $query = "DELETE FROM cupon WHERE id = :cupon_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["cupon_id" => $cupon_id]);
}

function GetRestaurants()
{
    global $pdo;
    $query = "SELECT * FROM restaurant";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    return $result;
}

function AddCupon($restaurant_id, $name, $discount)
{
    global $pdo;
    $name = htmlclean($name);
    $discount = htmlclean($discount);
    $created_at = (new DateTime())->format('Y-m-d H:i:s');
    $query = "INSERT INTO cupon(restaurant_id, name, discount, created_at) VALUES(:restaurant_id, :name, :discount, :created_at)";
    $statement = $pdo->prepare($query);
    $statement->execute(["restaurant_id" => $restaurant_id, "name" => $name, "discount" => $discount, "created_at" => $created_at]);
}

function GetCompanyById($company_id)
{
    global $pdo;
    $company_id = htmlclean($company_id);
    $query = "SELECT * FROM company WHERE id = :company_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["company_id" => $company_id]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function UpdateCompany($company_id, $name, $description, $logo_path)
{
    global $pdo;
    $company_id = htmlclean($company_id);
    $name = htmlclean($name);
    $description = htmlclean($description);
    $logo_path = htmlclean($logo_path);
    $query = "UPDATE company SET name = :name, description = :description, logo_path = :logo_path WHERE id = :company_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["name" => $name, "description" => $description, "logo_path" => $logo_path, "company_id" => $company_id]);
}

function MakeEmployee($user_id, $company_id)
{
    global $pdo;
    $user_id = htmlclean($user_id);
    $company_id = htmlclean($company_id);
    $query = "UPDATE users SET company_id = :company_id, role = 1 WHERE id = :user_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["company_id" => $company_id, "user_id" => $user_id]);
}

function GetCuponById($cupon_id)
{
    global $pdo;
    $cupon_id = htmlclean($cupon_id);
    $query = "SELECT * FROM cupon WHERE id = :cupon_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["cupon_id" => $cupon_id]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function UpdateCupon($cupon_id, $restaurant_id, $name, $discount)
{
    global $pdo;
    $cupon_id = htmlclean($cupon_id);
    $restaurant_id = htmlclean($restaurant_id);
    $name = htmlclean($name);
    $discount = htmlclean($discount);
    $query = "UPDATE cupon SET restaurant_id = :restaurant_id, name = :name, discount = :discount WHERE id = :cupon_id ";
    $statement = $pdo->prepare($query);
    $statement->execute(["restaurant_id" => $restaurant_id, "name" => $name, "discount" => $discount, "cupon_id" => $cupon_id]);
}
function GetUserOrders($user_id)
{
    global $pdo;
    $user_id= htmlclean($user_id);
    $query = "SELECT
            restaurant.id AS restaurant_id,
            restaurant.company_id AS restaurant_company_id,
            food.id AS food_id,
            food.restaurant_id AS food_restaurant_id,
            food.name AS food_name,
            food.description AS food_description,
            food.image_path AS food_image_path,
            food.price AS food_price,
            food.discount AS food_discount,
            food.created_at AS food_created_at,
            food.deleted_at AS food_deleted_at,
            order_items.id AS order_items_id,
            order_items.food_id AS order_items_food_id,
            order_items.order_id AS order_items_order_id,
            order_items.quantity AS order_items_quantity,
            order_items.price AS order_items_price,
            `order`.id AS order_id,
            `order`.user_id AS order_user_id,
            `order`.order_status AS order_order_status,
            users.id AS users_id,
            users.username AS users_username 
            FROM order_items ON food.id = order_items.food_id 
        INNER JOIN `order` ON order_items.order_id = `order`.id 
        INNER JOIN users ON `order`.user_id = users.id
        WHERE users.id = :user_id";
    $statement = $pdo->prepare($query);
    $statement->execute(["user_id" => $user_id]);
    return $statement->fetchAll();
}
