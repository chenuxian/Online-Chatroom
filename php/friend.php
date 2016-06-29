<?php
    session_start();
    include "./config.php";
    $user_ID = $_SESSION['id'];

// find friends ID
    $query = "SELECT friends_ID FROM friend WHERE user_ID='$user_ID'";
    $result = mysql_query($query);
    $friends = mysql_fetch_row($result);

    if($friends[0] != "") {
        $each_friend_ID = explode(",", $friends[0]);
        $friend_count = count($each_friend_ID);

        echo "<script>var friend_name = [];</script>";
        echo "<script>var friend_ID = [];</script>";
        for($i = 0; $i < $friend_count; $i++) {
            echo "<script>friend_ID.push('".$each_friend_ID[$i]."');</script>";
            $query = "SELECT name FROM self_info WHERE id='$each_friend_ID[$i]'";
            $result = mysql_query($query);
            $friend_name = mysql_fetch_row($result);            
            echo "<script>friend_name.push('".$friend_name[0]."');</script>";
        }
    }
 ?>