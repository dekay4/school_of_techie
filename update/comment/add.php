<?php
include("../includes/connection.php");
date_default_timezone_set("Asia/Kolkata");

if (isset($_POST['comment_box'])) {

    $userId = $_COOKIE['userId'];
    $comment_box = $_POST['comment_box'];
    $currentDatetime = date("Y-m-d H:i:s");


    $sqlValidateEmail = "SELECT * FROM `register` WHERE user_id='$userId'";

    $resValidateEmail = mysqli_query($conn, $sqlValidateEmail);
    if (mysqli_num_rows($resValidateEmail) > 0) {



        $sqlInsert = "INSERT INTO `comment`(`comment_id`,`user_id`,`comment`,`dateTime`) 
                                            VALUES ('','$userId','$comment_box','$currentDatetime')";

        mysqli_query($conn, $sqlInsert);

        $ID = mysqli_insert_id($conn);

        if (strlen($ID) == 1) {
            $ID = '00' . $ID;
        } elseif (strlen($ID) == 2) {
            $ID = '0' . $ID;
        }

        $comment_id = "C" . ($ID);

        $sqlUpdate = "UPDATE comment SET comment_id ='$comment_id' WHERE id ='$ID'";
        mysqli_query($conn, $sqlUpdate);

        $json_array['status'] = "success";
        $json_array['msg'] = "Added Successfully !!!";
        $json_response = json_encode($json_array);
        echo $json_response;
    } else {
        //Parameters missing
        $json_array['status'] = "failure";
        $json_array['msg'] = "Something Went Wrong, Please logout !!!";
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
