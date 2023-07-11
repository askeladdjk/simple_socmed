<?php
session_start();

if (!isset($_SESSION["user"])) {
  header("location: ../login.php");
  exit();
}

require(__DIR__ . '/../php/database.php');

if (!isset($_GET["id"])) {
  header("location: ../userview/userhome.php");
  exit();
}

$commentId = $_GET["id"];
$userId = $_SESSION["user"]["id"];

$statement = $connection->prepare("SELECT * FROM comments WHERE id = ? AND user_id = ?");
$statement->bind_param("ii", $commentId, $userId);
$statement->execute();

$results = $statement->get_result();
$comment = $results->fetch_assoc();

if (!$comment) {
  header("location: ../userview/userhome.php");
  exit();
}

$deleteStatement = $connection->prepare("DELETE FROM comments WHERE id = ?");
$deleteStatement->bind_param("i", $commentId);
$deleteStatement->execute();

header("location: ../posts/readpost.php");
exit();
?>
