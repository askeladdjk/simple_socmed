<?php
session_start();

if (!isset($_SESSION["user"])) {
  header("location: ../login.php");
  exit();
}

require(__DIR__ . '/../php/database.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["content"]) && isset($_POST["post_id"])) {
        $content = $_POST["content"];
        $postId = $_POST["post_id"];
        $userId = $_SESSION["user"]["id"];

        $statement = $connection->prepare("INSERT INTO comments (user_id, post_id, content, created_at) VALUES (?, ?, ?, NOW())");
        $statement->bind_param("iis", $userId, $postId, $content);
        $statement->execute();

        header("location: ../posts/readpost.php?id=".$postId);
        exit();
    }
}

header("location: ../userview/userhome.php");
exit();
