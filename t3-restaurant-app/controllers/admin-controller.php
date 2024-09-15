<?php
include "../config/db.php";
function GetUsers(){
    global $pdo;
    $query = "SELECT * FROM users";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    return $result;
}

function BanUser($user_id){
    global $pdo;
    $deleted_at = (new DateTime())->format('Y-m-d H:i:s');
    $query = "UPDATE users SET deleted_at = : deleted_at WHERE id = :user_id";
    $statement = $pdo->prepare($query);
    $statement->execute(['deleted_at'=>$deleted_at, 'id'=>$user_id]);
}