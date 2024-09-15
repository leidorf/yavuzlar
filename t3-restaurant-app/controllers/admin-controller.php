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
        `order`.id AS order_id,
        `order`.total_price AS order_total_price,
        `order`.order_status AS order_status,
        `order`.created_at AS order_created_at FROM users LEFT JOIN `order` ON users.id = `order`.user_id";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    return $result;
}

function BanUser($user_id)
{
    global $pdo;
    $deleted_at = (new DateTime())->format('Y-m-d H:i:s');
    $query = "UPDATE users SET deleted_at = :deleted_at WHERE id = :user_id";
    $statement = $pdo->prepare($query);
    $statement->execute(['deleted_at' => $deleted_at, 'user_id' => $user_id]);
}
