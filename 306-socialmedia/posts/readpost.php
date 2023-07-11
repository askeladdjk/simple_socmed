<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("location: ../user-login/login.php");
    exit();
}

require(__DIR__ . '/../php/database.php');

if (!isset($_GET["id"])) {
    header("location: ../userview/userhome.php");
    exit();
}

$postId = $_GET["id"];

$statement = $connection->prepare("SELECT * FROM posts WHERE id = ?");
$statement->bind_param("i", $postId);
$statement->execute();

$results = $statement->get_result();
$post = $results->fetch_assoc();

if (!$post) {
    header("location: ../userview/userhome.php");
    exit();
}

$commentStatement = $connection->prepare("SELECT comments.*, users.fname, users.lname FROM comments INNER JOIN users ON comments.user_id = users.id WHERE post_id = ?");
$commentStatement->bind_param("i", $postId);
$commentStatement->execute();

$commentResults = $commentStatement->get_result();
$comments = $commentResults->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Post</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
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

        .container{        
            justify-content: center;
            align-items: center;
            height: 60vh;        
            margin-top: 60px;
            
        }
        
        .card-box .card-body {
        padding: 20px;
        box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px, rgb(51, 51, 51) 0px 0px 0px 3px;  
        justify-content: center;
        max-height: 400px;
        }

        button{
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            padding: 20px;
        }
        textarea
        {
            box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px, rgb(51, 51, 51) 0px 0px 0px 3px;
        }

        body
        {  
            background-image: url('../imagesrc/d11f7cc143822554caf1a04ccfcd5592.gif');
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="../userview/userhome.php">Octagram</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="../userview/userhome.php">News Feed</a>
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

        <section>
        <div class="container">
            <div class="card-box">
                <div class="card">
                    <div class="card-body">
                        <h1>Read Post</h1>
                        <textarea rows="4" cols="50" readonly class="form-control"><?php echo $post['content']; ?></textarea>
                        <br>
                        <a href="../userview/userhome.php" class="btn btn-primary">Return</a>
                    </div>
                </div>
            </div>

    <div class="card-box">
    <div class="card">
        <div class="card-body" style="height: 200px; overflow: auto;">
            <h2>Comments</h2>
            <hr>
            <?php if (!empty($comments)) { ?>
                <ul>
                    <?php foreach ($comments as $comment) { ?>
                        
                        <li>
                            <strong><?php echo $comment['fname'] . ' ' . $comment['lname']; ?>:</strong>
                            <?php echo $comment['content']; ?>
                            <?php if ($_SESSION["user"]["id"] === $comment["user_id"]) { ?>
                                <button onclick="window.location.href='../comments/editcomment.php?id=<?php echo $comment["id"]; ?>'" class="btn btn-secondary">Edit</button>
                                <button onclick="window.location.href='../comments/deletecomment.php?id=<?php echo $comment["id"]; ?>'" class="btn btn-danger">Delete</button>
                            <?php } ?>
                            <hr>
                        </li>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <p>No comments found.</p>
            <?php } ?>
        </div>
    </div>
</div>


            <div class="card-box">
                <div class="card">
                    <div class="card-body">
                        <h2>Add Comment</h2>
                        <form method="POST" action="../comments/addcomment.php">
                            <textarea name="content" rows="4" cols="50" placeholder="Enter your comment" class="form-control"></textarea>
                            <input type="hidden" name="post_id" value="<?php echo $postId; ?>">
                            <br>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
