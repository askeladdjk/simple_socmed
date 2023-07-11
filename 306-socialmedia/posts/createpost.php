<?php
session_start();
require(__DIR__ . '/../php/database.php');

if (!isset($_SESSION["user"])) {
    header("location: ../user-login/login.php");
    exit();
}

$user = $_SESSION["user"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["content"]) && !empty(trim($_POST["content"]))) {
        $content = $_POST["content"];
        
        $statement = $connection->prepare("INSERT INTO posts (user_id, content, created_at) VALUES (?, ?, NOW())");
        $statement->bind_param("is", $user["id"], $content);
        
        if ($statement->execute()) {
            header("location: ../userview/userhome.php");
            exit();
        } else {
            $error_message = "Failed to create post.";
        }
    } else {
        $error_message = "Post content cannot be blank.";
    }
}
?>
