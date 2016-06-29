<?php 
    session_start();
    include "./config.php";
    $user_ID = $_POST["user_ID"];
    $friend_ID = $_POST["friend_ID"];

// check if exist the chat room
    $if_empty = true;
    $if_find = false;
    $chatroom_count = 0;
    $chatroom_ID = "";
    $query = "SELECT * FROM chatroom";
    $result = mysql_query($query);

    while ($row = mysql_fetch_row($result)) {
        $if_empty = false;
        $chatroom_count++;
        // chatroom table is not empty, so check if chatroom belong to user and friend(2 guys only)
        // row[0] is chatroom_ID, row[1] is member
        $each_member = explode(",", $row[1]);
        $member_count = count($each_member);
        // because this is "single" chat room, so only check 2 person's room
        if($member_count == 2) {
            if ($each_member[0] == $user_ID && $each_member[1] == $friend_ID) {
                $if_find = true;
                $chatroom_ID = $row[0];
            } else if ($each_member[1] == $user_ID && $each_member[0] == $friend_ID) {
                $if_find = true;
                $chatroom_ID = $row[0];
            }
        }
        if($if_find) {
            break;
        }

    }

// chatroom table is empty (initial)
    if ($if_empty) {
        // insert chatroom table first
        $chatroom_ID = "1";
        $member = $user_ID.",".$friend_ID;
        $add = "INSERT INTO chatroom (chatroom_ID, member) VALUES ('$chatroom_ID','$member')";
        mysql_query($add);

        // update friend table's chatroom ID and new data(both user and friend)
        $update = "UPDATE friend SET chatroom_ID='1', newData='0' WHERE user_ID='$user_ID'";
        mysql_query($update);
        $update = "UPDATE friend SET chatroom_ID='1', newData='0' WHERE user_ID='$friend_ID'";
        mysql_query($update);

        // make a new table
        $chatroom_name = "chatroom_1";
        $new_table="CREATE table $chatroom_name
                (content varchar(250),
                sender varchar(250),
                sendtime varchar(250)
                )";
        mysql_query($new_table);

    } else {
        // chatroom not emptymatch chatroom 
        if ($if_find) {
            echo $chatroom_ID;
        } else {
            //not match
            // insert chatroom table first
            $chatroom_ID = $chatroom_count + 1;
            echo $chatroom_ID;
            $member = $user_ID.",".$friend_ID;
            $add = "INSERT INTO chatroom (chatroom_ID, member) VALUES ('$chatroom_ID','$member')";
            mysql_query($add);

            // update friend table's chatroom ID and new data
            // user's
            $query = "SELECT chatroom_ID, newData FROM friend WHERE user_ID='$user_ID'";
            $result = mysql_query($query);
            $chat = mysql_fetch_row($result);
            $temp_count = $chatroom_count + 1;
            if($chat[0]) {
                $new_chatroom_ID = $chat[0].",".$temp_count;
                $new_newData = $chat[1].",0";
                $update = "UPDATE friend SET chatroom_ID='$new_chatroom_ID', newData='$new_newData' WHERE user_ID='$user_ID'";
                mysql_query($update);
            } else {
                $update = "UPDATE friend SET chatroom_ID='$temp_count', newData='0' WHERE user_ID='$user_ID'";
                mysql_query($update);
            }
            //friend's
            $query = "SELECT chatroom_ID, newData FROM friend WHERE user_ID='$friend_ID'";
            $result = mysql_query($query);
            $chat = mysql_fetch_row($result);
            $temp_count = $chatroom_count + 1;
            if($chat[0]) {
                $new_chatroom_ID = $chat[0].",".$temp_count;
                $new_newData = $chat[1].",0";
                $update = "UPDATE friend SET chatroom_ID='$new_chatroom_ID', newData='$new_newData' WHERE user_ID='$friend_ID'";
                mysql_query($update);
            } else {
                $update = "UPDATE friend SET chatroom_ID='$temp_count', newData='0' WHERE user_ID='$friend_ID'";
                mysql_query($update);
            }

            // make a new table
            $chatroom_name = "chatroom_".($chatroom_count + 1);
            $new_table="CREATE table $chatroom_name
                    (content varchar(250),
                    sender varchar(250),
                    sendtime varchar(250)
                    )";
            mysql_query($new_table);
        }
    }


 ?>