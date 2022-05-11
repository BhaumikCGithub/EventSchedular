<?php include "../utils/init.php"; ?>

<?php

if(!isset($_SESSION["loggedIn"]) ||  !$_SESSION["loggedIn"]) {
  header('Location: ../signin.php');
  exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fest_name = $_POST["fest_name"];
    $fest = new Fest();
    $fest->create_fest($fest_name, $_GET["club"]);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
    crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
    crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <title>EventScheduler</title>
</head>

<body>
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark p-0">
    <div class="container">
      <a href="main_page.php" class="navbar-brand">EventScheduler</a>
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav">
          <li class="nav-item px-2">
            <a href="main_page.php" class="nav-link active">Dashboard</a>
          </li>
          <li class="nav-item px-2">
            <a href="club_page.php" class="nav-link">Clubs</a>
          </li>
          <!-- <li class="nav-item px-2">
            <a href="categories.html" class="nav-link">Categories</a>
          </li> -->
          <li class="nav-item px-2">
            <a href="users.html" class="nav-link">Users</a>
          </li>
        </ul>

        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown mr-3">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
              <i class="fas fa-user"></i> Welcome <?php echo $_SESSION['username'] ?>
            </a>
            <div class="dropdown-menu">
              <a href="profile.php" class="dropdown-item">
                <i class="fas fa-user-circle"></i> Profile
              </a>
              <a href="main_page.php" class="dropdown-item">
                <i class="fas fa-cog"></i> Settings
              </a>
            </div>
          </li>
          <li class="nav-item">
            <a href="../signin.php" class="nav-link">
              <i class="fas fa-user-times"></i> Logout
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- HEADER -->
  <header id="main-header" class="py-2 bg-primary text-white">
    <div class="container">
      <div class="row">        
        <div class="col-md-6">
          <h1>
            <i class="fas fa-cog"></i> 
            <?php 
              $sql = "SELECT * FROM clubs WHERE club_id=" . $_GET['club'];
              $result = mysqli_query($connection, $sql);
              if(!$result) echo(mysqli_error($connection));
              $count = 1;
              while($row = mysqli_fetch_assoc($result)){
                echo $row['club_name'];
              }
            ?>
            </h1>
        </div>
      </div>
    </div>
  </header>

  <!-- ACTIONS -->
  <section id="actions" class="py-4 mb-4 bg-light">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <a href="./main_page.php" class="btn btn-light btn-block">
            <i class="fas fa-arrow-left"></i> Back
          </a>
        </div>
        <div class="col-md-3">
          <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#addPostModal">
            <i class="fas fa-plus"></i> Create Fest
          </a>
        </div>
        <?php
              global $connection;
              $sql = "SELECT * FROM clubs WHERE club_id=" . $_GET['club'];
              $result = mysqli_query($connection, $sql);              
              
              while($row = mysqli_fetch_assoc($result)){
                echo "http://localhost/EventScheduler/dashboard/join_club.php?club=" . $row['secure_number'];
              }
          ?>
    </div>
  </section>

  <!-- POSTS -->
  <section id="posts">
    <div class="container">
      <div class="row">
        <div class="col-md-9">
          <div class="card">
            <div class="card-header">
              <h4>Fests</h4>
            </div>
            <table class="table table-striped">
              <thead class="thead-dark">
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
              <?php             
                  $sql = "SELECT * FROM fests WHERE club_id=" . $_GET['club'];                  
                  $result = mysqli_query($connection, $sql);
                  if(!$result) echo(mysqli_error($connection));
                  $count = 1;
                  while($row = mysqli_fetch_assoc($result))
                  {
                    echo('<tr>
                          <td>'. $count .'</td>
                          <td>'. $row["fest_name"] .'</td>                          
                          <td>
                            <a href="fest_page.php?club=' . $_GET['club'] . '&fest=' . $row["fest_id"] . '" class="btn btn-secondary">
                              <i class="fas fa-angle-double-right"></i> Details
                            </a>
                          </td>
                        </tr> ');

                      $count++;
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

  <br>

  <!-- POSTS -->
  <section id="posts">
    <div class="container">
      <div class="row">
        <div class="col-md-9">
          <div class="card">
            <div class="card-header">
              <h4>Members</h4>
            </div>
            <table class="table table-striped">
              <thead class="thead-dark">
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Last Name</th>
                  <th>email</th>
                  <!-- <th>role</th> -->
                </tr>
              </thead>
              <tbody>
              <?php             
                  $sql = "SELECT * FROM users INNER JOIN (SELECT * FROM clubs NATURAL JOIN (SELECT * FROM club_members NATURAL JOIN roles) AS user_roles WHERE clubs.club_id=" . $_GET['club'] . ") AS userData ON users.user_id = userData.user_id";
                  $result = mysqli_query($connection, $sql);
                  if(!$result) echo(mysqli_error($connection));
                  $count = 1;
                  while($row = mysqli_fetch_assoc($result))
                  {
                    echo('<tr>
                          <td>'. $count .'</td>
                          <td>'. $row["first_name"] .'</td>
                          <td>'. $row["last_name"] .'</td>
                          <td>'. $row["email"] .'</td>
                        </tr> ');

                      $count++;
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer id="main-footer" class="bg-dark text-white mt-5 p-5">
    <div class="container">
      <div class="row">
        <div class="col">
          <p class="lead text-center">
          EventScheduler
          </p>
        </div>
      </div>
    </div>
  </footer>


  <!-- MODALS -->

  <!-- ADD FEST MODAL -->
  <div class="modal fade" id="addPostModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Create Fest</h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>          
        </div>
        <div class="modal-body">
          <form action="" method="POST">
            <div class="form-group">
              <label for="title">name</label>
              <input type="text" class="form-control" name="fest_name">
            </div>   
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Create</button>
            </div>         
          </form>
        </div>

      </div>
    </div>
  </div>

  <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
    crossorigin="anonymous"></script>
  <script src="https://cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>

  <script>
    // Get the current year for the copyright
    $('#year').text(new Date().getFullYear());

    CKEDITOR.replace('editor1');
  </script>
</body>

</html>