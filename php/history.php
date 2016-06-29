<?php 
    session_start();
    include "./config.php";
    $user_ID = $_POST['user_ID'];
    $now_chatroom_ID = $_POST['now_chatroom_ID'];
    $query = "SELECT chatroom_ID FROM friend WHERE user_ID='$user_ID'";
    $result = mysql_query($query);
    $result2 = mysql_fetch_row($result);
    $each_chatroom_ID = explode(",", $result2[0]);
    $room_count = count($each_chatroom_ID);

    // find every chatroom's last send time
    for($i = 0; $i < $room_count; $i++) {
        $true_chatroom = "chatroom_".$each_chatroom_ID[$i];
        $query2 = "SELECT sendtime FROM $true_chatroom ORDER BY sendtime DESC LIMIT 1";
        $result3 = mysql_query($query2);
        $if_table_empty = mysql_num_rows($result3);
        $each_last_sendtime = mysql_fetch_row($result3); 
        $query3 = "SELECT sender FROM $true_chatroom ORDER BY sendtime DESC LIMIT 1";
        $result4 = mysql_query($query3);
        $each_last_sender = mysql_fetch_row($result4); 
        $sort_time[$i] = $each_last_sendtime[0];
        $total_chatroom[$i] = $each_chatroom_ID[$i].",".$each_last_sendtime[0].",".$each_last_sender[0].",".$if_table_empty;
    }

    // sort record to last send time and store the chatroom ID by result (last to early)
    // sort_time, sort_chatroom, sort_sender, sort_if_table_empty(0 is empty)
    rsort($sort_time); 
    for ($i = 0; $i < $room_count; $i++) {
        for ($j = 0; $j < $room_count; $j++) {
            $temp = explode(",", $total_chatroom[$j]);
            if($sort_time[$i] == $temp[1]) {
                $sort_chatroom[$i] = $temp[0];
                $sort_sender[$i] = $temp[2];
                $sort_if_table_empty[$i] = $temp[3];
                $total_chatroom[$j] = "0,0";
                break;
            }
        }
    }

    // find if new data
    $query4 = "SELECT chatroom_ID, newData FROM friend WHERE user_ID='$user_ID'";
    $result5 = mysql_query($query4);
    $result6 = mysql_fetch_row($result5);
    // result6[0] is chatroom, result6[1] is newData
    $each_chatroom = explode(",", $result6[0]);
    $each_newData = explode(",", $result6[1]);
    $room_count = count($each_chatroom);
    // get the corresponding index
    $new_data_room_ID = "";
    for ($i = 0; $i < $room_count; $i++) {
        if ($each_newData[$i] == 1) {
            if ($new_data_room_ID == "") {
                $new_data_room_ID = $each_chatroom[$i];
            } else {
                $new_data_room_ID = $new_data_room_ID.",".$each_chatroom[$i];
            }
        }
    }
    $each_new_data_chatroom_ID = explode(",", $new_data_room_ID);
    $new_data_room_count = count($each_new_data_chatroom_ID);

    $return = "";
    for($i = 0; $i < $room_count; $i++) {
        $whether_new_data = false;
        $whether_new_data2 = false;
        if($sort_if_table_empty[$i] != 0) {

            // check if new data, if has, then change color
            for($k = 0; $k < $new_data_room_count; $k++) {
                if($each_new_data_chatroom_ID[$k] == $sort_chatroom[$i]) {
                    $whether_new_data = true;
                    if($each_new_data_chatroom_ID[$k] == $now_chatroom_ID) {
                        $whether_new_data2 = true;
                    }
                    break;
                }
            }
            if ($whether_new_data) {
                if ($whether_new_data2) {
                    $return = $return."<div id='history_".$sort_chatroom[$i]."' onclick='showHistory(".$sort_chatroom[$i];
                } else {
                    $return = $return."<div style='background-color:#595959; color:white;' id='history_".$sort_chatroom[$i]."' onclick='showHistory(".$sort_chatroom[$i];
                }
            } else {
                $return = $return."<div id='history_".$sort_chatroom[$i]."' onclick='showHistory(".$sort_chatroom[$i];
            }

            $query = "SELECT member FROM chatroom WHERE chatroom_ID='$sort_chatroom[$i]'";
            $result = mysql_query($query);
            $member = mysql_fetch_row($result);
            $each_member = explode(",", $member[0]);
            $member_count = count($each_member);
            $member_name = "";
            $total_member = "";
            for ($j = 0; $j < $member_count; $j++) {
                if ($each_member[$j] != $user_ID) {
                    $query2 = "SELECT name FROM self_info WHERE id='$each_member[$j]'";
                    $result2 = mysql_query($query2);
                    $true_name = mysql_fetch_row($result2);
                    if ($member_name == "") {
                        $member_name = $true_name[0];
                    } else {
                        if($j >= 2) {
                            if($member_count == 3) {
                                $member_name = $member_name.",".$true_name[0];    
                            } else {
                                if ($j == 2) {
                                    $last_member = $member_count - 2;
                                    $member_name = $member_name."及其他".$last_member."人";
                                }
                            }
                        } else {
                            $member_name = $member_name.",".$true_name[0];
                        }
                    }

                    if($total_member == "") {
                        $total_member = $each_member[$j];
                    } else {
                        $total_member = $total_member.",".$each_member[$j];
                    }
                }
            }
            $return = $return.",\"".$total_member."\")'>";
            $return = $return."<div style='color:#248f24; font-size:25px; line-height:28px; text-align:center;'>【member】<br> ".$member_name."</div><br>";
            date_default_timezone_set("Asia/Taipei");
            $true_time = (date("m/d h:i:sa", $sort_time[$i]));
            $query3 = "SELECT name FROM self_info WHERE id='$sort_sender[$i]'";
            $result3 = mysql_query($query3);
            $true_name = mysql_fetch_row($result3);
            $return = $return."<div style='text-align:center; font-size:13px; line-height:8px;'>".$true_name[0]." sended at ".$true_time."</div>";
            $return = $return."</div>";
        }
    }
    echo $return;
 ?>