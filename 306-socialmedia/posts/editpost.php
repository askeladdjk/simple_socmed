<?php
session_start();

if (!isset($_SESSION["user"])) {
  header("location: ../login.php");
  exit();
}

require(__DIR__ . '/../php/database.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST["edit_post"])) {
    $postId = $_POST["post_id"];
    $content = $_POST["content"];

    $statement = $connection->prepare("UPDATE posts SET content = ? WHERE id = ?");
    $statement->bind_param("si", $content, $postId);
    
    if ($statement->execute()) {

      header("location: ../userview/userhome.php");
      exit();
    } else {
      $error_message = "Failed to update post.";
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
    <title>Edit Post</title>

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
        body{
          background-image: url('../imagesrc/5cb4738123d29388a8d88100c06b715e.gif');
        }

    </style>
</head>
<body>

<div class="card-box d-flex justify-content-center align-items-center">
    <div class="card">
        <div class="card-body text-center">
            <h1>Edit Post</h1>
            <?php if (isset($error_message) && !empty($error_message)) : ?>
                <div class="alert alert-danger">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="../posts/editpost.php">
                <input type="hidden" name="post_id" value="<?php echo isset($post['id']) ? $post['id'] : ''; ?>">
                <textarea name="content" rows="4" cols="50" placeholder="Enter your post content"><?php echo isset($post['content']) ? $post['content'] : ''; ?></textarea>
                <br>
                <button type="submit" name="edit_post" class="btn btn-primary">Update</button>
                <a href="../userview/userhome.php" class="btn btn-secondary">Cancel</a>
              </form> 
            </div>
    </div>
</div>

</body>
</html>
