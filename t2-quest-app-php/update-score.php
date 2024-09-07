<?php
session_start();
if (!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header("Location: login.php?message=You are not logged in!");
    die();
} 
include "functions/functions.php";
$data = json_decode(file_get_contents('php://input'), true);
$userId = $_SESSION['id'];
$questionId = $data['questionId'];
$isCorrect = $data['isCorrect'] ? 1 : 0;

$stmt = $pdo->prepare("INSERT INTO submissions (userId, questionId, isCorrect) VALUES (?, ?, ?)");
$stmt->execute([$userId, $questionId, $isCorrect]);

if ($isCorrect) {
    $stmt = $pdo->prepare("UPDATE users SET score = score + 1 WHERE id = ?");
    $stmt->execute([$userId]);
}
header("Location:index.php");
