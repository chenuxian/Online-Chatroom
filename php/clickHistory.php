<?php 
    session_start();
    include "./config.php";
    $user_ID = $_POST['user_ID'];
    $chatroom_ID = $_POST['chatroom_ID'];

// update friend's table's newData (user's) to 0
    $query = "SELECT chatroom_ID, newData FROM friend WHERE user_ID='$user_ID'";
    $result = mysql_query($query);
    $result2 = mysql_fetch_row($result);
    // result2[0] is chatroom, result2[1] is newData
    $each_chatroom = explode(",", $result2[0]);
    $each_newData = explode(",", $result2[1]);
    $room_count = count($each_chatroom);
    // get the corresponding index
    $new_newData = "";
    for($i = 0; $i < $room_count; $i++) {
        if ($each_chatroom[$i] != $chatroom_ID) {
            if($new_newData == "") {
                $new_newData = $new_newData.$each_newData[$i];
            } else {
                $new_newData = $new_newData.",".$each_newData[$i];
            }
        } else {
            if($new_newData == "") {
                $new_newData = $new_newData."0";
            } else {
                $new_newData = $new_newData.",0";
            }
        }
    }
    $update = "UPDATE friend SET newData='$new_newData' WHERE user_ID='$user_ID'";
    mysql_query($update);

 ?>