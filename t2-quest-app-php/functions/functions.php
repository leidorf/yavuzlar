<?php

function htmlclean($text){
    $text = preg_replace("'<script[^>]*>.*?</script>'si", '', $text );
    $text = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is', '\2 (\1)', $text );
    $text = preg_replace('/<!--.+?-->/', '', $text ); 
    $text = preg_replace('/{.+?}/', '', $text ); 
    $text = preg_replace('/&nbsp;/', ' ', $text );
    $text = preg_replace('/&amp;/', ' ', $text ); 
    $text = preg_replace('/&quot;/', ' ', $text );
    $text = strip_tags($text);
    $text = htmlspecialchars($text); 

    return $text;
}
function Login($username, $password)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include "db.php";

        $query = "SELECT *,COUNT(*) as count FROM users WHERE username = :username AND password = :password";

        $statement = $pdo->prepare($query);

        $statement->execute(['username' => htmlclean($username), 'password' => htmlclean($password)]);

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

function GetQuestionById($id){
    include "db.php";
    $query = "SELECT * FROM questions WHERE id=$id";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $question = $statement->fetch(PDO::FETCH_ASSOC);
    $question['answers'] = json_decode($question['answers'],true);
    return $question;
}

function AddQuestion($qname, $difficulty, $question, $answers, $correct){
    include "db.php";
    $answersJson = json_encode($answers);
    $query = "INSERT INTO questions(qname,difficulty,question,answers,correct) VALUES('$qname','$difficulty','$question','$answersJson','$correct')";
    $statement = $pdo->prepare($query);
    $statement->execute();
}

function DeleteQuestion($id){
    include "db.php";
    $query="DELETE FROM questions WHERE id=$id";
    $statement=$pdo->prepare($query);
    $statement->execute();
}

function EditQuestion($id, $qname, $difficulty, $question, $answers, $correct){
    include "db.php";
    $answersJson = json_encode($answers);
    $query = "UPDATE questions SET qname='$qname',difficulty='$difficulty',question='$question',answers='$answersJson',correct='$correct' WHERE id='$id'";
    $statement = $pdo->prepare($query);
    $statement->execute();
}

function GetQuestionsForUser($userId) {
    include "db.php";

    $query = "SELECT questionId FROM submissions WHERE userId = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$userId]);
    $solvedQuestions = $statement->fetchAll(PDO::FETCH_COLUMN);

    if (empty($solvedQuestions)) {
        $query = "SELECT * FROM questions";
        $statement = $pdo->prepare($query);
        $statement->execute();
    } else {
        $placeholders = str_repeat('?,', count($solvedQuestions) - 1) . '?';
        $query = "SELECT * FROM questions WHERE id NOT IN ($placeholders)";
        $statement = $pdo->prepare($query);
        $statement->execute($solvedQuestions);
    }

    $result = $statement->fetchAll();
    return $result;
}
