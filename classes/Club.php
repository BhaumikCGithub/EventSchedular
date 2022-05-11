<?php include "classInit.php"; ?>
<?php 
    class Club  {
        
        function __construct($club_id) {
            $this->club_id = $club_id;
        }

        function __destruct() {
            
        }

        public static function create_club($club_name, $club_description, $club_email, $club_website, $college_id) {
            global $connection;
            $sql = "select * from clubs where club_name='$club_name'";
            $char="a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,";
            $num1=rand(1,10);
            $s='';
            $x=explode(',',$char);
            for($i=0;$i<$num1;$i++)
            {
                $s.=$x[$i];
            }
            str_shuffle($s);
            $secure_number=$s;
            
            $result = mysqli_query($connection, $sql);
            $num = mysqli_num_rows($result);

            if($num==0) {
                $sql = "INSERT INTO `clubs` (`club_name`, `description`, `email`, `website`, `college_id`,`secure_number`) VALUES ('$club_name', '$club_description', '$club_email', '$club_website', '$college_id','$s');";
                $result = mysqli_query($connection, $sql);   
                $get_club_id = "SELECT club_id from clubs where club_name = '$club_name'";
                $result = mysqli_query($connection, $get_club_id);   
                $club_id = "";
                while($row = mysqli_fetch_assoc($result)){
                    $club_id = $row['club_id'];
                }
                $make_president = "INSERT INTO club_members (`club_id`,`user_id`,`role_id`) VALUES ($club_id,{$_SESSION['user_id']},1)";
                $result = mysqli_query($connection, $make_president);   
            
                if ($result) {
                    header('Location: main_page.php');
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

        public static function join_club($secure_number){
            global $connection;            
            $sql = "SELECT * from club_members where club_id=(SELECT club_id FROM clubs WHERE secure_number='$secure_number') AND user_id=$_SESSION[user_id];";
            $result = mysqli_query($connection, $sql);
            $num = mysqli_num_rows($result);

            if($num==0) {
                // $sql = "INSERT INTO `club_members` (`club_id`, `user_id`, `role_id`) VALUES ((SELECT club_id FROM clubs WHERE secure_number=".$secure_number."), ".$_SESSION['user_id'].", 1);";
                $sql = "INSERT INTO `club_members` (`club_id`, `user_id`, `role_id`) VALUES ((SELECT club_id FROM clubs WHERE secure_number='$secure_number'), $_SESSION[user_id], 1)";
                $result = mysqli_query($connection, $sql);   
                
                if ($result) {                    
                    header('Location: main_page.php');
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

        // public function get_club_fests(){
        //     global $connection;
        //     $get_all_fests = "SELECT club.club_name FROM clubs JOIN club_members JOIN user ON (users.user_id = {$SESSION['user_id']} AND clubs.club_id = $this->club_id AND users.user_id = club_members.user_id AND clubs.club_id = club_members.club_id)";
        //     $get_all_fests_result = mysqli_query($connection,$get_all_fests);
        //     $is_member_of_club = mysqli_num_rows($get_all_fests_result);
        //     if($is_member_of_club){
                
        //     }
        //     else{
        //         header('Location:main_page.php');
        //     }
        // }
        
    }
?>