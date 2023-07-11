<?php
require(__DIR__ .'/../php/database.php');

if (isset($_POST["register_button"])) {
    $fname = $_POST["firstname"];
    $lname = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $repeat_password = $_POST["password_confirmation"];
    $bdate = $_POST["birthday"];
    $phonenumber = $_POST["phonenumber"];
    $gender = $_POST["gender"];

    $check_query = $connection->prepare("SELECT * FROM users WHERE email = ? OR phonenumber = ?");
    $check_query->bind_param("ss", $email, $phonenumber);
    $check_query->execute();
    $result = $check_query->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Email or phone number already exists. Please choose a different one.";
    } else {

        if ($password === $repeat_password) {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $statement = $connection->prepare("INSERT INTO users (fname, lname, email, `password`, bdate, phonenumber, gender) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $statement->bind_param("sssssis", $fname, $lname, $email, $hashed_password, $bdate, $phonenumber, $gender);

            if ($statement->execute()) {
                header("location: ../user-login/login.php");
                exit();
            }
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
    <title>REGISTER</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"></script>

    <style>
        input[type="radio"] {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid black;
            outline: none;
            background-color: transparent;
        }

        input[type="radio"]:checked::before {
            content: "";
            display: block;
            width: 12px;
            height: 12px;
            margin: 3px;
            border-radius: 50%;
            background-color: black;
        }

        input[type="radio"]:checked {
            background-color: blue;
        }
        section {
            background: rgb(2,0,36);
            background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(47,109,100,1) 35%, rgba(0,212,255,1) 100%);
            background-image: url('../imagesrc/aa777f3d182cfcc7c95372e378e14d55.gif');
          }

          *{
            margin: 0px;
            padding:0px;
          }
    </style>
</head>
<body>
            <?php if (!empty($error_message)) : ?>
                <div class="error-message row justify-content-center align-items-center h-100" > 
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            
    <section class="vh-100" style="background-color: black;">
        <div class="container py-5 h-100">
          <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-lg-9 col-xl-7 ">
              <div class="card shadow-2-strong card-registration card bg-dark text-white" style="border-radius: 15px;">
                <div class="card-body p-4 p-md-5">
                  <h3 class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">OCTAGRAM REGISTER FORM</h3>
                  <form method="POST" action="">
                    <div class="row">
                      <div class="col-md-6 mb-4">
                        <div class="form-outline">
                          <input type="text" id="firstname" name="firstname" class="form-control form-control-lg" required/>
                          <label class="form-label" for="firstname">First Name</label>
                          <span class="text-danger"></span>
                        </div>
                      </div>
                      <div class="col-md-6 mb-4">
                        <div class="form-outline">
                          <input type="text" id="lastname" name="lastname" class="form-control form-control-lg" required/>
                          <label class="form-label" for="lastname">Last Name</label>
                          <span class="text-danger"></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 mb-4 d-flex align-items-center">
                        <div class="form-outline datepicker w-100">
                          <input type="date" name="birthday" class="form-control form-control-lg" id="birthdate" required/>
                          <label for="birthdate" class="form-label">Birthday</label>
                          <span class="text-danger"></span>
                        </div>
                      </div>
                      <div class="col-md-6 mb-4">
                        <h6 class="mb-2 pb-1">Gender:</h6>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="female" value="female"/>
                            <label class="form-check-label" for="femaleGender">Female</label>
                            <span class="text-danger"></span>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="maleGender" value="male"/>
                            <label class="form-check-label" for="maleGender">Male</label>
                            <span class="text-danger"></span>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="otherGender" value="other"/>
                            <label class="form-check-label" for="otherGender">Other</label>
                            <span class="text-danger"></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 mb-4 pb-2">
                        <div class="form-outline">
                          <input type="email" id="email" name="email" class="form-control form-control-lg" required/>
                          <label class="form-label" for="email">Email</label>
                          <span class="text-danger"></span>
                        </div>
                      </div>
                      <div class="col-md-6 mb-4 pb-2">
                        <div class="form-outline">
                          <input type="tel" id="phonenumber" name="phonenumber" class="form-control form-control-lg" required/>
                          <label class="form-label" for="phonenumber">Phone Number</label>
                          <span class="text-danger"></span>
                        </div>
                      </div>
                      <div class="col-md-6 mb-4">
                        <div class="form-outline">
                          <input type="password" id="password" name="password" class="form-control form-control-lg" required/>
                          <label class="form-label" for="password">Password</label>
                          <span class="text-danger"></span>
                        </div>
                      </div>
                      <div class="col-md-6 mb-4">
                        <div class="form-outline">
                          <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-lg" required/>
                          <label class="form-label" for="password_confirmation">Verify Password</label>
                        </div>
                      </div>
                    </div>
                    <div class="mt-4 pt-2">
                      <button type="submit" class="btn btn-dark btn-lg" name="register_button" value="Register">Register</button>
                    </div>
                    <div class="form-check d-flex justify-content-center mb-5">
                      <a href="login.php">GO BACK TO LOGIN PAGE</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
</body>
</html>
