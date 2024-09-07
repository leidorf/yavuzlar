<?php
session_start();
if (!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header("Location: login.php?message=You are not logged in!");
    die();
}
include "functions/functions.php";
include "functions/db.php";

$userId = $_SESSION['id'];
$questionId = $_POST['questionId'];
$qname = $_POST['qname'];
$isCorrect = $_POST['isCorrect'] ? 1 : 0;
$query = "INSERT INTO submissions (userId, questionId, qname, isCorrect) VALUES (?, ?, ?, ?)";
$statement = $pdo->prepare($query);
$statement->execute([$userId, $questionId, $qname, $isCorrect]);

if ($isCorrect) {
    $query = "UPDATE users SET score = score + 1 WHERE id = ?";
    $statement = $pdo->prepare($query);
    $statement->execute([$userId]);
}
header("Location:quiz.php");
exit();
