<!-- <?php
    //$server="localhost";
    //$username="id18880691_event_scheduler";
    //$password="-zVV~Vo8X~=BEFd";
    //$databse="id18880691_eventscheduler";

    //$connection =mysqli_connect($server, $username, $password, $databse);

    //if(!$connection) {
        //die("Databse Error");
    //}
?> -->

<?php
    $server="localhost";
    $username="root";
    $password="";
    $databse="eventcurator";

    $connection =mysqli_connect($server, $username, $password, $databse);

    if(!$connection) {
        die("Databse Error");
    }
?>