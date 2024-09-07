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

$clearedAnswers = array_filter($_POST['answers'], fn($item) => !empty($item));
if (isset($_POST['qname']) && isset($_POST['difficulty']) && isset($_POST['question']) && count($clearedAnswers)>=2 && count($clearedAnswers)<=4 && isset($_POST['correct'])) {
    $qname = htmlclean($_POST['qname']);
    $difficulty = htmlclean($_POST['difficulty']);
    $question = htmlclean($_POST['question']);
    $correct = htmlclean($_POST['correct']);
    AddQuestion($qname,$difficulty,$question,$clearedAnswers,$correct);
    header("Location: quest-list.php");
    exit();
} else {
    header("Location: quest-list.php?message=Eksik bilgi girdiniz.");
    exit();
}
?>