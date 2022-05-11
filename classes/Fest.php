<?php include "classInit.php"; ?>
<?php 
    class Fest  {
        
        function __construct() {
        }

        function __destruct() {
            
        }

        public function create_fest($fest_name,$club_id) {
            global $connection;
          $sql = "select * from fests where fest_name='$fest_name'";
          $result = mysqli_query($connection, $sql);
          $num = mysqli_num_rows($result);
          
          echo($num);
            if($num==0) {
                $sql = "INSERT INTO `fests` (`fest_name`, `club_id`) VALUES ('$fest_name','$club_id');";
                $result = mysqli_query($connection, $sql);
                                
                if ($result) {
                    header('Location: club_page.php?club='.$club_id);
                } 
                else {
                    echo(mysqli_error($connection));
                }
            }
            else {              
                echo("<div class='alert alert-danger' role='alert'>
                        <h4>Club Already Exist.</h4>
                        </div>");
            }
            
        }

    }
?>