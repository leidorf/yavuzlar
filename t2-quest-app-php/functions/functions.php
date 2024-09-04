<?php
function Login($username, $password)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include "db.php";

        $query = "SELECT *,COUNT(*) as count FROM users WHERE username = :username AND password = :password";

        $statement = $pdo->prepare($query);

        $statement->execute(['username' => $username, 'password' => $password]);

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

function GetQuestions(){
    include "db.php";
    $query="SELECT * FROM questions";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result=$statement->fetchAll();
    return $result;
}

function AddQuestion($qname, $difficulty, $question, $answers, $correct){
    include "db.php";
    $query = "INSERT INTO questions(qname,difficulty,question,answers,correct) VALUES('$qname','$difficulty','$question','$answers','$correct')";
    $statement = $pdo->prepare($query);
    $statement->execute();
}

function DeleteQuestion($id){
    include "db.php";
    $query="DELETE FROM questions WHERE id=$id";
    $statement=$pdo->prepare($query);
    $statement->execute();
}
?>