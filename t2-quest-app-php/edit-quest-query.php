<?php
session_start();
include "functions/functions.php";
if (!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header("Location: login.php?message=You are not logged in!");
    die();
} else if (!$_SESSION['isAdmin']) {
    header("Location: index.php?message=You are not admin!");
    exit();
}
$questionId = $_GET['id'];
$clearedAnswers = array_filter($_POST['answers'], fn($item) => !empty($item));
if (isset($_POST['qname']) && isset($_POST['difficulty']) && isset($_POST['question']) && count($clearedAnswers)>=2 && count($clearedAnswers)<=4 && isset($_POST['correct'])) {
    $qname = $_POST['qname'];
    $difficulty = $_POST['difficulty'];
    $question = $_POST['question'];
    $correctIndex = $_POST['correct'];
    $correct = $clearedAnswers[$correctIndex];
    EditQuestion($questionId,$qname,$difficulty,$question,$clearedAnswers,$correct);
    header("Location: quest-list.php");
    exit();
} else {
    print_r($questionId);
    print_r($_POST);
    exit();
}
?>