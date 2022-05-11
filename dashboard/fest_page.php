<?php include "../utils/init.php"; ?>

<?php

if(!isset($_SESSION["loggedIn"]) ||  !$_SESSION["loggedIn"]) {
  header('Location: ../signin.php');
  exit;
}
if(isset($_GET['fest']))
  $fest_id=$_GET['fest'];

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_name = $_POST["event_name"];   
    $price = $_POST["price"];
    $date=$_POST["date"];
    $descript=$_POST["description"];

    
    $event = new Event();
    $event->create_event($event_name, $fest_id, $price ,$_GET["club"],$date,$descript);
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
      <a href="index.html" class="navbar-brand">EventScheduler</a>
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav">
          <li class="nav-item px-2">
            <a href="index.html" class="nav-link active">Dashboard</a>
          </li>
          <li class="nav-item px-2">
            <a href="posts.html" class="nav-link">Clubs</a>
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
              <a href="profile.html" class="dropdown-item">
                <i class="fas fa-user-circle"></i> Profile
              </a>
              <a href="settings.html" class="dropdown-item">
                <i class="fas fa-cog"></i> Settings
              </a>
            </div>
          </li>
          <li class="nav-item">
            <a href="login.html" class="nav-link">
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
              $sql = "SELECT * FROM fests WHERE fest_id=" . $_GET['fest'];
              $result = mysqli_query($connection, $sql);
              if(!$result) echo(mysqli_error($connection));
              $count = 1;
              while($row = mysqli_fetch_assoc($result)){
                echo $row['fest_name'];
              }
            ?> </h1>
        </div>
      </div>
    </div>
  </header>

  <!-- ACTIONS -->
  <section id="actions" class="py-4 mb-4 bg-light">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <?php 
            echo ('<a href="club_page.php?club=' . $_GET["club"] . '" class="btn btn-light btn-block">');
          ?>
            <i class="fas fa-arrow-left"></i> Back
          </a>
        </div>
        <div class="col-md-3">
          <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#addPostModal">
            <i class="fas fa-plus"></i> Create Event
          </a>
        </div>
    </div>
  </section>

  <!-- POSTS -->
  <section id="posts">
    <div class="container">
      <div class="row">
        <div class="col-md-9">
          <div class="card">
            <div class="card-header">
              <h4>Events</h4>
            </div>
            <table class="table table-striped">
              <thead class="thead-dark">
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Price</th>
                  <th>Date</th>
                  <th>Description</th>
                  
                  <th></th>
                </tr>
              </thead>
              <tbody>
              <?php 
                  $sql = "SELECT * FROM events WHERE fest_id=" . $_GET['fest'];
                  $result = mysqli_query($connection, $sql);
                  if(!$result) echo(mysqli_error($connection));
                  $count = 1;
                  
                  while($row = mysqli_fetch_assoc($result))
                  {
                    echo('<tr>
                          <td>'. $count .'</td>
                          <td>'. $row["event_name"] .'</td>                          
                          <td>'. $row["price"] .'</td> 
                          <td>'. $row["date"].'</td>
                          <td>'. $row["description"].'</td>                            
                          <td>
                          <a href="event_page.php?club=' . $_GET['club'] .  '&fest=' . $_GET["fest"] .  '&event=' . $row["event_id"] . '" class="btn btn-secondary">                            
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
              <h4>Participants</h4>
            </div>
            <table class="table table-striped">
              <thead class="thead-dark">
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>email</th>
                  <th>Event Name</th>
                  <th>College Name</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
              <?php 
                  $sql = "SELECT * FROM college NATURAL JOIN (SELECT * FROM users INNER JOIN (SELECT * FROM events NATURAL JOIN event_participants WHERE events.fest_id=" . $_GET['fest'] . ")  AS user_data ON user_data.participant_id = users.user_id) AS userData";
                  $result = mysqli_query($connection, $sql);
                  if(!$result) echo(mysqli_error($connection));
                  $count = 1;
                  while($row = mysqli_fetch_assoc($result))
                  {
                    echo('<tr>
                        <td>'. $count .'</td>
                        <td>'. $row["first_name"] .'</td>                          
                        <td>'. $row["email"] .'</td>
                        <td>'. $row["event_name"] .'</td>
                        <td>'. $row["college_name"] .'</td>
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

  <!-- ADD EVENT MODAL -->
  <div class="modal fade" id="addPostModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Create Event</h5>
          <button class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="POST">
            <div class="form-group">
              <label for="title">Name</label>
              <input type="text" class="form-control" name="event_name">
            </div>
            <div class="form-group">
              <label for="title">Event Date</label>
              <input type="date" class="form-control" name="date">
            </div>     
            <div class="form-group">
              <label for="title">Registration Price</label>
              <input type="text" class="form-control" name="price">
            </div>   

            <div class="form-group">
              <label for="title">Description</label>
              <input type="text" class="form-control" name="description">
            </div>   
            <div class="modal-footer">
              <button class="btn btn-primary">Create</button>
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