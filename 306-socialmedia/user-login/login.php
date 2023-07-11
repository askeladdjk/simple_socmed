<?php
session_start();
require(__DIR__ .'/../php/database.php');

if (isset($_POST["login"])) {
  $email = htmlspecialchars($_POST["email"]);
  $password = htmlspecialchars($_POST["password"]);

  $statement = $connection->prepare("SELECT * FROM users WHERE users.email = ?");
  $statement->bind_param("s", $email);

  $statement->execute();

  $results = $statement->get_result();

      if ($results->num_rows > 0) {
        while ($row = $results->fetch_assoc()) {
          if (password_verify($password, $row["password"])) {
            $_SESSION["user"] = $row;

            header("location: ../userview/userhome.php");
            exit(); 
          } else {
            $error_message = "Invalid Password";
          }
        }
      } else {
        $error_message = "User Not Found";
      }
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>

  <style>
    * {
      margin: 0px;
      padding: 0px;
    }
    
    section {
      background: rgb(2,0,36);
      background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(47,109,100,1) 35%, rgba(0,212,255,1) 100%);
      background-image: url('../imagesrc/5cb4738123d29388a8d88100c06b715e.gif');
    }
    
  </style>
</head>
<body>
    <section class="vh-100">
      <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-12 col-md-8 col-lg-6 col-xl-5">
            <div class="card bg-dark text-white" style="border-radius: 1rem;">
              <div class="card-body p-5 text-center">
                <div class="mb-md-5 mt-md-4 pb-5">
                
                <h2 class="fw-bold mb-2 text-uppercase">OCTAGRAM</h2>
                
                <p class="text-white-50 mb-5">ENTER YOUR EMAIL AND PASSWORD</p>
                
                <form method="POST" action="">
                
                  <div class="form-outline form-white mb-4">
                
                    <input type="email" id="email" name="email" class="form-control form-control-lg" required/>
                    <label class="form-label" for="email" >Email</label>
                  
                  </div>
                
                  <div class="form-outline form-white mb-4">
                
                    <input type="password" id="password" name="password" class="form-control form-control-lg" required />
                    <label class="form-label" for="password">Password</label>               
                  
                  </div>
                  
                  <?php if (isset($error_message)): ?>
                    <div class="text-danger"><?php echo $error_message; ?></div>
                  <?php endif; ?>
                  
                  <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#!">Forgot Password</a></p>  
                  
                  <button class="btn btn-outline-light btn-lg px-5" type="submit" name="login">Login</button>
                  
                  </form>
                </div>
                <div>
                  <p class="mb-0">Make an Account: <a href="register.php" class="text-white-50 fw-bold"> Sign Up</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</body>
</html>
