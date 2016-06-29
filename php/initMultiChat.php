<?php 
    session_start();
    include "./config.php";
    $user_ID = $_POST["user_ID"];
    $multi_friend_ID = $_POST["multi_friend_ID"];


    $chatroom_count = 0;
    $chatroom_ID = "";
    $query = "SELECT * FROM chatroom";
    $result = mysql_query($query);

    while ($row = mysql_fetch_row($result)) {
        $chatroom_count++;
    }

// chatroom table is empty (initial)
    // insert chatroom table first
    $chatroom_ID = $chatroom_count + 1;
    $member = $user_ID.",".$multi_friend_ID;
    
    $add = "INSERT INTO chatroom (chatroom_ID, member) VALUES ('$chatroom_ID','$member')";
    mysql_query($add);

// update friend table's chatroom ID and new data
    $each_member = explode(",", $member);
    $member_count = count($each_member);

    for($i = 0; $i < $member_count; $i++){
        $query = "SELECT chatroom_ID, newData FROM friend WHERE user_ID='$each_member[$i]'";
        $result = mysql_query($query);
        $chat = mysql_fetch_row($result);
        if($chat[0]) {
            $new_chatroom_ID = $chat[0].",".$chatroom_ID;
            $new_newData = $chat[1].",0";
            $update = "UPDATE friend SET chatroom_ID='$new_chatroom_ID', newData='$new_newData' WHERE user_ID='$each_member[$i]'";
            mysql_query($update);
        } else {
            $update = "UPDATE friend SET chatroom_ID='$chatroom_ID', newData='0' WHERE user_ID='$each_member[$i]'";
            mysql_query($update);
        }
    }
    
    // make a new table
    $chatroom_name = "chatroom_".$chatroom_ID;
    $new_table="CREATE table $chatroom_name
                (content varchar(250),
                 sender varchar(250),
                 sendtime varchar(250)
                 )";
    mysql_query($new_table);
    echo $chatroom_ID;
 ?>