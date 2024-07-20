<?php
$servername = "sql312.infinityfree.com";
$username = "if0_36939361";
$password = "LI6jzVOTCMBq3pj";
$dbname = "if0_36939361_school_oftechie";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("connection failed:" . mysqli_connect_error());
    //echo "Not connect";
} else {
    //echo "conenct";
}
