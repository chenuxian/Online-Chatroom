<?php 
    $friend_ID = $_POST["friend_ID"];
    include "./config.php";
    $each_friend = explode(",", $friend_ID);
    $member_count = count($each_friend);

    $return = "";
    for ($i = 0; $i < $member_count; $i++) {
        $query = "SELECT name, email FROM self_info WHERE id='$each_friend[$i]'";
        $result = mysql_query($query);
        $username = mysql_fetch_row($result);
        // username[0] is name, username[1] is email
        if ($return == "") {
            $return = "<a target='_blank' style='text-decoration:none' href='../self_info/info_search.php?inputEmail=".$username[1]."'>".$username[0]."</a>";
        } else {
            $return = $return.","."<a target='_blank' style='text-decoration:none' href='../self_info/info_search.php?inputEmail=".$username[1]."'>".$username[0]."</a>";
        }
    }
    echo $return;
 ?>