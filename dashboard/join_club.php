<?php include "../utils/init.php"; ?>

<?php

if(!isset($_SESSION["loggedIn"]) ||  !$_SESSION["loggedIn"]) {
  header('Location: ../signin.php');
  exit;
}

  $secure_number = $_GET["club"];    
  Club::join_club($secure_number);  
?>