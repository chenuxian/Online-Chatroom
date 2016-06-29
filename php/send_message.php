<?php 
    session_start();
    include "./config.php";
    $user_ID = $_POST['user_ID'];
    $message_content = $_POST['message_content'];
    $chatroom_ID = $_POST['chatroom_ID'];
    $chat_friend_ID = $_POST['chat_friend_ID'];

// update friend's table's newData (friend's) to 1
    $each_chat_friend_ID = explode(",", $chat_friend_ID);
    $chat_friend_count = count($each_chat_friend_ID);

    for ($k = 0; $k < $chat_friend_count; $k++) {
        $query = "SELECT chatroom_ID, newData FROM friend WHERE user_ID='$each_chat_friend_ID[$k]'";
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
                    $new_newData = $new_newData."1";
                } else {
                    $new_newData = $new_newData.",1";
                }
            }
        }
        $update = "UPDATE friend SET newData='$new_newData' WHERE user_ID='$each_chat_friend_ID[$k]'";
        mysql_query($update);
    }

// set chatroom_? table
    date_default_timezone_set("Asia/Taipei");
    $time = time(); // it's seconds
    $true_chatroom = "chatroom_".$chatroom_ID;
    $add = "INSERT INTO $true_chatroom (content, sender, sendtime) VALUES ('$message_content', '$user_ID','$time')";
    mysql_query($add);
    
// get content in chatroom_? and return to show
    $query2 = "SELECT * FROM $true_chatroom";
    $result3 = mysql_query($query2);
    $last_sender = "";
    $last_sendtime = "";
    $all_content = "";
    while ($row = mysql_fetch_row($result3)) {
        // $row[0] is content, [1] is sender, [2] is sendtime
        // find sender's name
        // $row[1] = (int)$row[1];
        $query3 = "SELECT name FROM self_info WHERE id='$row[1]'";
        $result4 = mysql_query($query3);
        $sender_name = mysql_fetch_row($result4);
        $true_time = (date("m/d h:i:sa", $row[2]));

        if ($last_sender == "") {
            $all_content = "<span style='color:#1a1aff'>(".$sender_name[0].")</span> at ".$true_time."&nbsp:<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp".$row[0]."<br>";
            $last_sender = $sender_name;
            $last_sendtime = $row[2];
        } else {
            // exceed 5min then show name and time
            if ($row[2] - $last_sendtime > 300 || $last_sender != $sender_name) {
                $all_content = $all_content."<hr><span style='color:#1a1aff'>(".$sender_name[0].")</span> at ".$true_time."&nbsp:<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp".$row[0]."<br>";;
            } else {
                $all_content = $all_content."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp".$row[0]."<br>";;
            }
            $last_sender = $sender_name;
            $last_sendtime = $row[2];
        }
    }
    echo $all_content;

 ?>