<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("location: ../user-login/login.php");
    exit();
}

$user = $_SESSION["user"];

require(__DIR__ . '/../php/database.php');

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["content"])) {
        $content = $_POST["content"];

        if (empty($content)) {
            $error_message = "Post content cannot be empty.";
        } else {

            $statement = $connection->prepare("INSERT INTO posts (user_id, content) VALUES (?, ?)");
            $statement->bind_param("is", $user["id"], $content);
            $statement->execute();

            header("location: userhome.php");
            exit();
        }
    }
}

$statement = $connection->prepare("SELECT * FROM posts");
$statement->execute();

$results = $statement->get_result();
$posts = $results->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USERHOME</title>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">

    <style>
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
        }

        .navbar {
            box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px, rgb(51, 51, 51) 0px 0px 0px 3px;
            background: rgb(2, 0, 36);
            background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(47, 109, 100, 1) 35%, rgba(0, 212, 255, 1) 100%);
            padding: 8px 16px;
            height: 90px;
        }

        .navbar .form-control {
            width: 100%;
            max-width: 500px;
        }

        .navbar-brand {
            color: white;
        }

        .navbar-nav .nav-link {
            color: white;
        }

        .navbar-nav .nav-link:hover {
            color: rgba(255, 255, 255, 0.5);
        }

        .navbar-toggler {
            border-color: white;
        }

        .navbar-toggler-icon {
            background-color: white;
        }

        .navbar .nav-item.active .nav-link {
            font-weight: bold;
        }

        .card-box {            
            display: flex;
            justify-content: center;
            align-items: center;
            height: 60vh;        
        }

        .card-box .card-body {
        padding: 20px;
        }

        .posts-container {
            width: 800px;
            max-height: 400px;
            box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px, rgb(51, 51, 51) 0px 0px 0px 3px;

                
            max-height: 400px;
            overflow-y: auto;
            padding-right: 20px;
            padding-left: 20px; 
            margin-bottom: 10px;
        }
        
        .posts-container button {
        margin-right: 5px;
        }

        .posts-container li {
        margin-bottom: 10px;
        }

        .createpost-container{
            
            box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px, rgb(51, 51, 51) 0px 0px 0px 3px;
        }
        button{
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }
        textarea
        {
            box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px, rgb(51, 51, 51) 0px 0px 0px 3px;
        }

        body
        {  
            background-image: url('../imagesrc/9e639e60f67ad8a878a74d5fb11546e6.gif');
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="userhome.php">Octagram</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="userhome.php">News Feed</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">Friends</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">Settings</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Configurations</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">FAQ</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../php/logout.php">Log Out</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <section class="vh-100">
        <div class="card-box">
            <div class="card">
                <div class="card-body createpost-container">
                    <h2>Create Post</h2>
                    <h3>User: <?php echo $user["fname"] . " " . $user["lname"]; ?></h3>
                    <?php if (!empty($error_message)) : ?>
                        <div class="alert alert-danger">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    <form method="POST" action="userhome.php">
                        <textarea name="content" rows="4" cols="50" placeholder="Enter your post content"></textarea>
                        <br>
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-box">
            <div class="card">
                <div class="card-body posts-container">
                    <h2>Posts</h2>
                    <hr>
                    <?php if (!empty($posts)) : ?>
                        <ul>
                            <?php foreach ($posts as $post) : ?>                                
                                <li>
                                    <?php echo $post["content"]; ?>
                                    <br>
                                    <button onclick="window.location.href='../posts/editpost.php?id=<?php echo $post["id"]; ?>'">Edit</button>
                                    <button onclick="window.location.href='../posts/deletepost.php?id=<?php echo $post["id"]; ?>'">Delete</button>
                                    <button onclick="window.location.href='../posts/readpost.php?id=<?php echo $post["id"]; ?>'">Read</button>
                                </li>
                                <hr>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <p>No posts found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
