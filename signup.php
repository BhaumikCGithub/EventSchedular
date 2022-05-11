<?php include "utils/init.php" ?>


<?php

if(!(!isset($_SESSION["loggedIn"]) ||  !$_SESSION["loggedIn"])) {
  header('Location: ./dashboard/main_page.php');
  exit;
}

$sql = "select * from college";
$result = mysqli_query($connection, $sql);
$option = '';
while($row = mysqli_fetch_assoc($result))
{
  $option .= '<option value = "'.$row['college_id'].'">'.$row['college_name'].'</option>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
  $firstname = $_POST["firstname"];
  $lastname = $_POST["lastname"];
  $username = $_POST["username"];
  $email = $_POST["email"];
  $phoneno = $_POST["phoneno"];
  $college = $_POST["college"];
  $pass = $_POST["pass"];

  $sql = "select username from users where username='$username'";
  $result = mysqli_query($connection, $sql);
  $num = mysqli_num_rows($result);

  if($num==1) {
    echo("<div class='alert alert-danger' role='alert'>
          <h4>Username Already Exists.</h4>
          </div>");
  }
  else {
    User::signup_user($firstname, $lastname, $username, $email, $phoneno, $college, $pass);
  }
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


  <!-- Font Icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" />

  <!-- Main css -->
  <link rel="stylesheet" href="./css/style.css" />

  <title>Sign Up</title>

</head>

<body>
<h1 style="color: #0b59a1;position:absolute;margin-left: 880px;margin-top:120px ">Event Scheduler</h1>

  <div style="margin-top:40px;">
    <section class="signup">
      <div class="container">
        <div class="signup-content">
          <div class="signup-form" >
            <h1 class="form-title" style="color:#075197;">Sign Up</h1>
            
            <form action="./signup.php" method="POST" class="register-form" id="register-form" onsubmit="return validate()">
              
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="zmdi zmdi-account material-icons-name"></i></span>
                <input class="form-control" type="text" name="firstname" id="firstname" placeholder="First Name"  required />
              </div>
              
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="zmdi zmdi-account material-icons-name"></i></span>
                <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Last Name" required />
              </div>

              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="zmdi zmdi-account material-icons-name"></i></span>
                <input class="form-control" type="text" name="username" id="username" placeholder="User Name" pattern=".{6,}" title="Must contain at least 6 or more characters" required />
              </div>
              
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="zmdi zmdi-email"></i></span>
                <input class="form-control" type="email" name="email" id="email" placeholder="Email Address" required />
              </div>

              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1"><i class="zmdi zmdi-phone-in-talk"></i></span>
                <input class="form-control" type="text" name="phoneno" id="phoneno" placeholder="Phone Number" pattern="[7-9]{1}[0-9]{9}" required>
              </div>

              <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1"><i class="zmdi zmdi-graduation-cap"></i></span>
                <select class="form-select" name="college" aria-label="Default select example" required>
                  <option value="" selected disabled hidden>College Name</option>
                  <?php echo($option); ?>
                </select>
              </div>
              
              <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1"><i class="zmdi zmdi-lock"></i></span>
                <input class="form-control" type="password" name="pass" id="pass" placeholder="Password" pattern=".{6,}" title="Must contain at least 6 or more characters" required />
              </div>
              
              <div class="input-group mb-3">
              <span class="input-group-text" id="basic-addon1"><i class="zmdi zmdi-lock-outline"></i></span>
                <input class="form-control" type="password" name="rpass" id="re_pass" placeholder="Confirm Password" pattern=".{6,}" title="Must contain at least 6 or more characters" required />
              </div>
              <span style="color:brown; font-size:large;" id="message"></span>
              
              <div class="form-group form-button">
                <input type="submit" name="signup" id="signup" class="form-submit" value="Sign Up" />
              </div>

            </form>
          </div>
          <div class="signup-image">
            <figure>
              <img src="./images/2.jpg" alt="sing up image" style="height: 300;" />
            </figure>
            <br><br><br><br>
            <h5>
              <small class="form-text text-center ml-1">&nbsp; &nbsp; Already Member? &nbsp;
                <a href="signin.php">Sign In Here</a>
              </small>
            </h5>
          </div>
        </div>
      </div>
    </section>
  </div>

  <script>
    function validate() {
      var password1=document.getElementById("pass");
      var password2=document.getElementById("re_pass");
      if (password1.value != password2.value) {
        document.getElementById('message').textContent = "Password is not Matching.";
        return false;
      }
      else {
        return true;
      }
    }
  </script>

  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script> -->

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script> -->
   
</body>

</html>