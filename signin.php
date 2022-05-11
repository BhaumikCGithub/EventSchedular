<?php include "utils/init.php"; ?>


<?php
if(!(!isset($_SESSION["loggedIn"]) ||  !$_SESSION["loggedIn"])) {
  header('Location: ./dashboard/main_page.php');
  exit;
}

if (@$_GET['registered'] == 'true') {
    echo("<script>alert(`You have successfully registered yourself. Please Verify Your Email Address.`);</script>");
}
else if(@$_GET['verified'] == 'true') {
    echo("<script>alert(`You have successfully verified your Email Address.`);</script>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $pass = $_POST["pass"];
    
    User::signin_user($email, $pass, $connection);
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <title>Sign In</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" />

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css" />

</head>

<body>

    <!-- Sign in  Form -->
    <h1 style="color: #0b59a1;position:absolute;margin-left: 460px; ">Event Scheduler</h1>

    <div style="margin-top:60px;">
        <section class="sign-in">
            <div class="container">

                <div class="signin-content">

                    <div class="signin-image">


                        <figure>

                            <img src="images/signin-image.jpg" alt="sing up image" />
                        </figure>
                    </div>
                    <div class="signin-form">
                        <h1 class="form-title" style="color:#075197;">Sign In</h1>
                        <form action="signin.php" method="POST" class="register-form" id="login-form">
                            <div class="input-group mb-4">
                                <span class="input-group-text" id="basic-addon1"><i class="zmdi zmdi-email"></i></span>
                                <input class="form-control" type="text" name="email" id="email" placeholder="Username Or Email Address" required />
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="zmdi zmdi-lock"></i></span>
                                <input class="form-control" type="password" name="pass" id="pass" placeholder="Password" pattern=".{6,}" title="Must contain at least 6 or more characters" required />
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in" />
                                <br><br><br>
                                <h5>
                                    <small class="form-text text-center ml-1">Don't Have an Account? &nbsp;
                                        <a href="signup.php">Sign Up Here</a>
                                    </small>
                                </h5>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    -->
</body>

</html>