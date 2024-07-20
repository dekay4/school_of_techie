<?php
include("../includes/connection.php");
// echo "hello";

if (isset($_POST['username']) && isset($_POST['email_field']) && isset($_POST['pwd_field'])) {

    $userName = $_POST['username'];
    $email_field = $_POST['email_field'];
    $pwd_field = $_POST['pwd_field'];


    $sqlValidateEmail = "SELECT * FROM `register` WHERE email='$email_field'";

    $resValidateEmail = mysqli_query($conn, $sqlValidateEmail);
    if (mysqli_num_rows($resValidateEmail) == 0) {



        $sqlInsert = "INSERT INTO `register`(`user_id`,`user_name`,`email`,`pwd`) 
                                            VALUES ('','$userName','$email_field','$pwd_field')";

        mysqli_query($conn, $sqlInsert);

        $ID = mysqli_insert_id($conn);

        if (strlen($ID) == 1) {
            $ID = '00' . $ID;
        } elseif (strlen($ID) == 2) {
            $ID = '0' . $ID;
        }

        $users_id = "USI" . ($ID);

        $sqlUpdate = "UPDATE register SET user_id = '$users_id' WHERE id ='$ID'";
        mysqli_query($conn, $sqlUpdate);
        //log

        $json_array['status'] = "success";
        $json_array['msg'] = "Created Successfully !!!";
        $json_response = json_encode($json_array);
        echo $json_response;
    } else {
        //Parameters missing
        $json_array['status'] = "failure";
        $json_array['msg'] = "Email Is Already Exist !!!";
        $json_response = json_encode($json_array);
        echo $json_response;
    }
} else {
    //Parameters missing
    $json_array['status'] = "failure";
    $json_array['msg'] = "Please try after Sometime !!!";
    $json_response = json_encode($json_array);
    echo $json_response;
}
