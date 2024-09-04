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

if (isset($_POST['qname']) && isset($_POST['difficulty']) && isset($_POST['question']) && isset($_POST['answers']) && isset($_POST['correct'])) {
    $qname = $_POST['qname'];
    $difficulty = $_POST['difficulty'];
    $question = $_POST['question'];
    $answers = $_POST['answers'];
    $correct = $_POST['correct'];
} else {
    header("Location: quest-list.php?message=Eksik bilgi girdiniz.");
    exit();
}
