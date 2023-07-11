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

$statement = $connection->prepare("SELECT * FROM comments WHERE id = ?");
$statement->bind_param("i", $commentId);
$statement->execute();

$results = $statement->get_result();
$comment = $results->fetch_assoc();

if (!$comment) {
  header("location: ../userview/userhome.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST["content"])) {
    $content = $_POST["content"];

    if ($_SESSION["user"]["id"] === $comment["user_id"]) {
  
      $updateStatement = $connection->prepare("UPDATE comments SET content = ? WHERE id = ?");
      $updateStatement->bind_param("si", $content, $commentId);
      $updateStatement->execute();

      header("location: ../userview/userhome.php");
      exit();
    } 
    else {
      header("location: ../posts/readpost.php");
      exit();
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Comment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>
    <style>
      * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
        }

        .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;  
      }

      .card-body {            
            height: 50vh;        
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

<div class="container">
    <div class="card">
        <div class="card-body">
            <h1>Edit Comment</h1>
            <form method="POST" action="">
                <textarea name="content" rows="4" cols="50" class="form-control"><?php echo $comment['content']; ?></textarea>
                <br>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="../posts/readpost.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
