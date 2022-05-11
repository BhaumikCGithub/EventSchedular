<?php include "utils/init.php"; ?>

<?php 
    if(isset($_GET['token'])) {
        global $connection;
        $token = $_GET['token'];
        $sql = "update users set is_verified = 1 where token = '$token'";
        $result = mysqli_query($connection, $sql);

        if($result) {
            header('Location: signin.php?verified=true');
		
        }
        else {
            echo(mysqli_error($connection));
        }
    }
	echo "Hello";
?>

