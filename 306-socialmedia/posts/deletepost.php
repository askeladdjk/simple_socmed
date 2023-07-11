<?php
session_start();

if (!isset($_SESSION["user"])) {
  header("location: ../login.php");
  exit();
}

require(__DIR__ . '/../php/database.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST["delete_post"])) {
    $postId = $_POST["post_id"];

    $statement = $connection->prepare("DELETE FROM posts WHERE id = ?");
    $statement->bind_param("i", $postId);
    
    if ($statement->execute()) {

      header("location: ../userview/userhome.php");
      exit();
    } else {
      $error_message = "Failed to delete post.";
    }
  }
} else {
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Post</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
    
    <style>
       * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
        }

        .card-box {            
            display: flex;
            justify-content: center;
            align-items: center;
            height: 60vh;        
          }
        
        .card-box .card-body {
        padding: 20px;
        box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px, rgb(51, 51, 51) 0px 0px 0px 3px;  
      }

        button{
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            padding: 20px;
        }
        textarea
        {
            box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px, rgb(51, 51, 51) 0px 0px 0px 3px;
        }
        </style>
</head>
<body>

<div class="card-box d-flex justify-content-center align-items-center">
    <div class="card">
        <div class="card-body text-center">
            <h1>Delete Post</h1>
            <?php if (isset($error_message) && !empty($error_message)) : ?>
                <div class="alert alert-danger">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <p>Are you sure you want to delete this post?</p>
            <p><?php echo $post['content']; ?></p>
            <form method="POST" action="../posts/deletepost.php">
                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                <button type="submit" name="delete_post" class="btn btn-danger">Delete</button>
                <a href="../userview/userhome.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>


</body>
</html>
