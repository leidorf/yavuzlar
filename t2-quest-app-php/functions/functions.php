<?php
function Login($username, $password)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include "db.php";

        $query = "SELECT * FROM users WHERE username = ? AND password = ?";

        $statement = $pdo->prepare($query);

        $statement->execute([$username, $password]);

        $result = $statement->fetch();

        if ($result) {
            $_SESSION['id'] = $result['id'];
            $_SESSION['username'] = $result['username'];
            $_SESSION['isAdmin'] = $result['isAdmin'];
            return true;
        } else {
            return false;
        }
    }
}
?>