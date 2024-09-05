<?php
session_start();
if (!isset($_SESSION['id']) && !isset($_SESSION['username'])) {
    header('Location: ./login.php?message=You are not logged in!');
    exit();
  } else if (!$_SESSION['isAdmin']) {
    header("Location: index.php?message=You are not admin!");
    exit();
  } else {
    include "functions/functions.php";
    $questionId = $_GET["id"];
    DeleteQuestion($questionId);
    header("Location:quest-list.php");
    exit();
}
?>