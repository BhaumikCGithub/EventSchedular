<?php include "classInit.php"; ?>

<?php 
    class Event  {
        
        function __construct() {
        }

        function __destruct() {
            
        }

        public function create_event($event_name,$fest_id, $price,$club,$date,$description) {
           global $connection;
            $sql = "select * from events where event_name='$event_name'";
            $result = mysqli_query($connection, $sql);
            $num = mysqli_num_rows($result);

            if($num==0) {
                $sql = "INSERT INTO `events` (`event_name`, `fest_id`, `price`,`date`,`description`) VALUES ('$event_name', '$fest_id', '$price','$date','$description');";
                $result = mysqli_query($connection, $sql);   
            
                if ($result) {
                    header('Location: fest_page.php?club='. $club .'&fest='.$fest_id);
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

        public static function register_event($fest_id, $eventId){
            global $connection;                        
            $userId = $_SESSION['user_id'];
            $sql = "SELECT * FROM event_participants WHERE participant_id='$userId' AND event_id='$eventId';";
            $result = mysqli_query($connection, $sql);
            $num = mysqli_num_rows($result);
                        
            if($num==0) {
                $sql = "INSERT INTO `event_participants` (`participant_id`, `event_id`) VALUES ($userId , $eventId);";
                $result = mysqli_query($connection, $sql);
                header('Location: main_page.php');              
                if (!$result) {
                    //header('Location: festDetails.php?fest='.$fest_id);
                    header('Location: main_page.php'); 
                } 
                else {
                    echo(mysqli_error($connection));
                    //header('Location: festDetails.php?fest='.$fest_id);
                    header('Location: main_page.php'); 
                }
            }
            else {              
                echo("<div class='alert alert-danger' role='alert'>
                        <h4>Already Registered.</h4>
                        </div>");
            }            
            // header('Location: club_page.php?club='.$club_id);
        }
        
        public function make_present($participant_id, $event_id){
            global $connection;
            $userId = $_SESSION['user_id'];
            $sql = "SELECT * FROM event_participants WHERE participant_id='$participant_id' AND event_id='$event_id';";
            $result = mysqli_query($connection, $sql);
            $num = mysqli_num_rows($result);
                        
            if($num==1) {
                $sql = "UPDATE event_participants SET is_present=true WHERE participant_id=" . $participant_id . " AND event_id=" . $event_id . ";";
                $result = mysqli_query($connection, $sql);
                                
                if (!$result) {
                    // header('Location: club_page.php?club='.$club_id);
                } 
                else {
                    echo(mysqli_error($connection));
                }
            }
            else {              
                echo("<div class='alert alert-danger' role='alert'>
                        <h4>User not found.</h4>
                        </div>");
            }            
        }
    }
?>