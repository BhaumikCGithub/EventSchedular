<?php include "classInit.php"; ?>

<?php
class User
{



    function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    function __destruct()
    {
    }

    public function getAllClubs()
    {
        global $connection;
        $sql = "SELECT clubs.club_id,clubs.club_name,clubs.email,clubs.website FROM clubs JOIN club_members JOIN users ON (club_members.user_id = users.user_id AND clubs.club_id = club_members.club_id) WHERE users.user_id = {$_SESSION['user_id']}";
        $result = mysqli_query($connection, $sql);
        return $result;
    }

    public static function signin_user($email, $pass)
    {
        global $connection;
        $sql = "select * from users where email='$email' OR username='$email'";
        $result = mysqli_query($connection, $sql);
        $num1 = mysqli_num_rows($result);
        $row = mysqli_fetch_assoc($result);
        if ($num1 == 1) {
            if (password_verify($pass, $row['password'])); {
                $sql = "select user_id, first_name, college_id, is_verified from users where email='$email'";
                $result = mysqli_query($connection, $sql);
                if (!$result) {
                    die('Database Gone!!!!');
                }

                $row = mysqli_fetch_assoc($result);
                if ($row['is_verified'] == false) {
                    echo ("<div class='alert alert-danger' role='alert'>
                            <h4>Please Verify Your Email Address.</h4>
                            </div>");
                } else if ($result) {
                    session_start();
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['username'] = $row['first_name'];
                    $_SESSION['college_id'] = $row['college_id'];

                    header('Location: ./dashboard/main_page.php');
                } else {
                    echo ("Fail");
                }
            }
        } else {
            echo ("<div class='alert alert-danger' role='alert'>
                        <h4>Enter Valid Credentials.</h4>
                        </div>");
        }
    }

    public static function signup_user($firstname, $lastname, $username, $email, $phoneno, $college, $pass)
    {
        global $connection;
        $sql = "select * from users where email='$email'";
        $result = mysqli_query($connection, $sql);
        $num1 = mysqli_num_rows($result);

        if ($num1 == 0) {
            $verified = 0;
            $token = bin2hex(random_bytes(15));
            $pass = password_hash($pass, PASSWORD_BCRYPT, ['cost' => 12]);
            $sql = "INSERT INTO `users` (`first_name`, `last_name`, `username`, `email`, `mobile_number`, `college_id`, `password`, `token`, `is_verified`) VALUES ('$firstname', '$lastname', '$username', '$email', '$phoneno', '$college', '$pass', '$token', '$verified');";
            $result = mysqli_query($connection, $sql);
            // echo($firstname . $lastname . $email . $phoneno . $college . $pass);

            if ($result) {
                require('PHP_Mailer/PHPMailerAutoload.php');
                //use PHPMailer\PHPMailer\PHPMailer;
                //use PHPMailer\PHPMailer\Exception;

                // require 'PHPMailer/src/Exception.php';
                // require 'PHPMailer/src/PHPMailer.php';
                //require 'PHPMailer/src/SMTP.php';
                $mail = new PHPMailer;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'tls';
                $mail->SMTPDebug = 2;
                $mail->Username = 'chaniyarajeel@gmail.com';
                $mail->Password = 'JVC0112045';

                $mail->setFrom('chaniyarajeel@gmail.com', 'EventScheduler');
                $mail->addAddress($email);
                $mail->addReplyTo('chaniyarajeel@gmail.com');

                $mail->isHTML(true);
                $mail->Subject = 'Successfully Registered in EventScheduler';
                $mail->Body = ' <h2> Hi ' . $firstname . ' <h2>
                                    <h2>Thank for registering in EventScheduler. </h2>
                                    <h2>Click Here To Activate Your Account </h2>
                                    <h2>http://localhost/EventScheduler/activate.php?token=' . $token . ' </h2>';

                if (!$mail->send()) echo ("Mail Failed");
                else {
                    header("Refresh:0");
                    header('Location: signin.php?registered=true');
                }
            } else {
                echo (mysqli_error($connection));
            }
        } else {
            echo ("<div class='alert alert-danger' role='alert'>
                        <h4>Account Already Exists.</h4>
                        </div>");
        }
    }
}
?>